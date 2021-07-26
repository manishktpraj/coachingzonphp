<?php

namespace App\Http\Controllers\Csadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Model\CsInstituteCategory;


class InstituteCategoryController extends Controller
{
    //
    public function index(Request $request)
  {
     
     /***********************Reset Filter Session ************/
        if($request->get('reset')==1)
        {
        Session::forget('FILTER_INSTITUTE_CATEGORY');
        return redirect()->route('manageintitutecategory');   
        }
     /***********************Reset Filter Session ************/
     
     /***********************Bulk Action ************/
       $aryPostData = $request->all();
       if(isset($aryPostData['bulkvalue']) && $aryPostData['bulkvalue']!=''):
          $aryPostData =$_POST;
         $aryIds = explode(',',$aryPostData['bulkvalue']);
        $intBulkAction = $aryPostData['bulkaction'];
 
        if($intBulkAction==1)
        {
            CsInstituteCategory::whereIn('icat_id', $aryIds)->delete();
            return redirect()->route('manageintitute')->with('status', 'Entry Deleted Successfully');
        }
        if($intBulkAction==2)
        {
            CsInstituteCategory::whereIn('icat_id', $aryIds)->update(['icat_status' => 1]);
            return redirect()->route('manageintitute')->with('status', 'Entry Updated Successfully');
        }
        if($intBulkAction==3)
        {
            CsInstituteCategory::whereIn('icat_id',$aryIds)->update(['icat_status' => 0]);
            return redirect()->route('manageintitute')->with('status', 'Entry Updated Successfully');
        }
        endIf;
      /***********************Bulk Action ************/
     
        
           /***********************Apply Condition ************/
   
        if($request->get('FILTER_INSTITUTE_CATEGORY')!='')
        {
        Session::put('FILTER_INSTITUTE_CATEGORY', $request->get('filter_keyword'));
        Session::save(); 
        }
           /***********************Apply Condition ************/
   
        if(session()->has('FILTER_INSTITUTE_CATEGORY')){
        $strFilterKeyword = Session::get('FILTER_INSTITUTE_CATEGORY');
        $resCategoryData = CsInstituteCategory::where('icat_name', 'LIKE', "%{$strFilterKeyword}%")->paginate(20);
        //print_r($resVideoData);
        }else{
        $resCategoryData = CsInstituteCategory::paginate(20);
        }    
     
      
    //$resVideoData = CsInstituteCategory::paginate(20);
    $resCategoryData = CsInstituteCategory::orderBy('icat_id', 'ASC')->get();
    $tree = $this->buildTree($resCategoryData);
    $strCategoryHtml = $this->getCatgoryChildHtml($tree);
    $resChildCategory = CsInstituteCategory::get();

    $title='Manage Intitute Category';
    return view('Csadmin.Institute.category',compact('title','resCategoryData','resCategoryData','strCategoryHtml','resChildCategory'));
  
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
          //print_r($strExtraData).$label['vc_name'];
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
                                  <a href="'.ADMIN_URL.'video-category/'.$label['icat_id'].'" onclick="return confirm(\'Are you sure?\')" class="btn btn-primary btn-icon mg-r-5" title="Edit" style="padding:0px 5px;"><i class="fas fa-pencil-alt" style="font-size:11px;"></i></a>
                                  <a href="'.ADMIN_URL.'deleteVCategory/'.$label['icat_id'].'" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-icon mg-r-5" title="Delete" style="padding:0px 5px;"><i class="fas fa-trash-alt" style="font-size:11px;"></i></a>
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
 
}
