<?php

namespace App\Http\Controllers\Csadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Model\CsInstituteCategory;
use Session;
use Illuminate\Support\Str;


class InstituteCategoryController extends Controller
{
    //
    public function index(Request $request, $intid=NULL)
  {
  //echo $int;  
     /***********************Reset Filter Session ************/
        if($request->get('reset')==1)
        {
        Session::forget('FILTER_INSTITUTE_CATEGORY');
        return redirect()->route('manageinstitutecategory');   
        }
     /***********************Reset Filter Session ************/
     
     /***********************Bulk Action ************/
       $aryPostData = $request->all();
       //print_r($aryPostData);
       if(isset($aryPostData['bulkvalue']) && $aryPostData['bulkvalue']!=''):
          $aryPostData =$_POST;
         $aryIds = explode(',',$aryPostData['bulkvalue']);
        $intBulkAction = $aryPostData['bulkaction'];
 
        if($intBulkAction==1)
        {
            CsInstituteCategory::whereIn('icat_id', $aryIds)->delete();
            return redirect()->route('manageinstitutecategory')->with('status', 'Entry Deleted Successfully');
        }
        if($intBulkAction==2)
        {
            CsInstituteCategory::whereIn('icat_id', $aryIds)->update(['icat_status' => 1]);
            return redirect()->route('manageinstitutecategory')->with('status', 'Entry Updated Successfully');
        }
        if($intBulkAction==3)
        {
            CsInstituteCategory::whereIn('icat_id',$aryIds)->update(['icat_status' => 0]);
            return redirect()->route('manageinstitutecategory')->with('status', 'Entry Updated Successfully');
        }
        endIf;
      /***********************Bulk Action ************/
     
        
           /***********************Apply Condition ************/
   
           if($request->get('filter_keyword')!='')
           {
     
           Session::put('FILTER_INSTITUTE_CATEGORY', $request->get('filter_keyword'));
           Session::save(); 
    
    
           }
           /***********************Apply Condition ************/
   
        if(session()->has('FILTER_INSTITUTE_CATEGORY')){
        $strFilterKeyword = Session::get('FILTER_INSTITUTE_CATEGORY');
        $resCategoryData = CsInstituteCategory::where('icat_name', 'LIKE', "%{$strFilterKeyword}%")->paginate(20);
        }else{
        $resCategoryData = CsInstituteCategory::paginate(20);
        }    
        $rowCategoryData =array();
        if($intid>0){
            $rowCategoryData = CsInstituteCategory::where('icat_id','=',$intid)->first();
        } 
        //$resVideoData = CsInstituteCategory::paginate(20);
        // $resCategoryData = CsInstituteCategory::orderBy('icat_id', 'ASC')->get();
    $tree = $this->buildTree($resCategoryData);
    $strCategoryHtml = $this->getCatgoryChildHtml($tree);
    $resChildCategory = CsInstituteCategory::get();
   // print_r($tree);

    $title='Manage Intitute Category';
    return view('Csadmin.Institute.category',compact('title','rowCategoryData','resCategoryData','strCategoryHtml','resChildCategory','rowCategoryData'));
  
  }

  function buildTree($elements, $parentId = 0) 
    {
        $branch = array();
        foreach ($elements as $element) {
             
            if ($element['icat_parent'] == $parentId) {
                $children = $this->buildTree($elements, $element['icat_id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            } 
        }
        return $branch;
    }
    
    function getCatgoryChildHtml($tree,$strExtraHtml='',$intLevel=0){
            
      $strHtml=$strExtraHtml;
      if(count($tree)>0){
      foreach($tree as $key=>$label){

          $strStyle ='';
          if($label['icat_parent']==0){
              $intLevel=0;
          }else{
            $intLevel = self::getcategorylevel($label);
          }
         
          $strExtraData = '';
          
          for($i=0;$i<$intLevel;$i++){
              $strExtraData .='<i data-feather="minus"></i>';
          }
          
         // $src = ($label['vc_image']!="")?SITE_UPLOAD_URL.SITE_VIDEO_IMAGE.$label['vc_image']:SITE_NO_IMAGE_PATH;
          $strHtml .='<tr>
                          <td scope="row" style="text-align:center;vertical-align: middle;"><input type="checkbox" id="selectAll" class="clsSelectSingle" name="icat_id[]" value="'.$label['icat_id'].'">
                      </td>';
         /* $strHtml .='<td style="text-align:center">
                          <div class="media align-items-center mg-b-0">
                              <div class="avatar" style="margin: 0 auto">
                                  <img src="'.$src.'" class="rounded-circle" alt="">
                              </div>
                          </div>
                      </td>';  */
          $strHtml .='<td><p class="mg-b-0 tx-medium">'.$strExtraData.$label['icat_name'].'</p></td>'; 
          //print_r($strExtraData).$label['icat_name'];
          if($label['icat_status']==0){
              $strHtml .='<td><a href="'.route('catstatus',$label['icat_id']).'" onclick="return confirm(\'Are you sure?\')"><span class="badge badge-danger">Inactive</span></a></td>';
          }else{
              $strHtml .='<td><a href="'.route('catstatus',$label['icat_id']).'" onclick="return confirm(\'Are you sure?\')"><span class="badge badge-success">Active</span></a></td>';
          }
         // $orederData = CsInstituteCategory::where('icat_id','=',$label['icat_id'])->count();
          
          $strHtml .='<td style="text-align:center">0</td>';
          if($label['icat_id']==16)
          {                $strHtml .='<td colspan="1" style="text-align:center"></td>';
}else
          {
          $strHtml .='<td>
                          <div class="d-flex align-self-center justify-content-center">
                              <nav class="nav nav-icon-only">
                                  <a href="'.route('manageinstitutecategory',$label['icat_id']).'" onclick="return confirm(\'Are you sure?\')" class="btn btn-primary btn-icon mg-r-5" title="Edit" style="padding:0px 5px;"><i class="fas fa-pencil-alt" style="font-size:11px;"></i></a>
                                  <a href="'.route('deleteCat',$label['icat_id']).'" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-icon mg-r-5" title="Delete" style="padding:0px 5px;"><i class="fas fa-trash-alt" style="font-size:11px;"></i></a>
                              </nav>
                          </div>
                      </td>';}
          if(isset($label->children)){
              $intLevel++;
              $strHtml =$this->getCatgoryChildHtml($label->children,$strHtml,$intLevel);
          }
      } } else{
          $strHtml = '<td colspan="6" style="text-align:center">No Result Found</td>';
      } 
      
      return $strHtml;
      exit();     
  }
  public function catstatus($intCategoryId)
    {  
        $rowCategoryData = CsInstituteCategory::where('icat_id',$intCategoryId)->first();
        //print_r($rowCategoryData);die;
        if($rowCategoryData->icat_status==0){
            $status = 1;
        }else{
            $status = 0;
        }
        CsInstituteCategory::where('icat_id', $intCategoryId)->update(array('icat_status' => $status));
        return redirect()->route('manageinstitutecategory')->with('status', 'Entry Edited Successfully');
    }
    public function deleteCat($intCategoryId)
    {   
        CsInstituteCategory::where('icat_id', $intCategoryId)->delete();
        return redirect()->route('manageinstitutecategory')->with('status', 'Entry Deleted Successfully');
    }



    function insCategoryProccess(Request $request)
    {
        $aryPostData = $request->all();
        //print_r($aryPostData);die;
        if(isset($aryPostData['icat_id']) && $aryPostData['icat_id']>0)
        {
            $postobj = CsInstituteCategory::where('icat_id',$aryPostData['icat_id'])->first();
        }else{
            $postobj = new CsInstituteCategory;
            $postobj->icat_slug = Str::slug($aryPostData['icat_name'], '-');
        }   
        $postobj->icat_status = 1;
        $postobj->icat_name = $aryPostData['icat_name'];
        $postobj->icat_parent =0;
        $postobj->icat_description = $aryPostData['icat_description'];
        
        if($postobj->save())    
        {
            return redirect()->route('manageinstitutecategory')->with('status', 'Entry Saved Successfully.');   
        }else{
            return redirect()->route('manageinstitutecategory')->with('error', 'Server Not Responed');
        }
    }

}
