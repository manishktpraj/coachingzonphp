<?php

namespace App\Http\Controllers\Csadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Model\CsInstitute;
use App\Http\Model\CsStates;

use App\Http\Model\CsInstituteCategory;
use Session;
use Hash;

use Illuminate\Support\Str;

class InstituteController extends Controller
{
  public function index(Request $request)
  {
     
    /***********************Reset Filter Session ************/
       if($request->get('reset')==1)
       {
       Session::forget('FILTER_INSTITUTE');
       return redirect()->route('manageinstitute');   
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
        CsInstitute::whereIn('ins_id', $aryIds)->delete();
           return redirect()->route('manageinstitute')->with('status', 'Entry Deleted Successfully');
       }
       if($intBulkAction==2)
       {
        CsInstitute::whereIn('ins_id', $aryIds)->update(['ins_status' => 1]);
           return redirect()->route('manageinstitute')->with('status', 'Entry Updated Successfully');
       }
       if($intBulkAction==3)
       {
        CsInstitute::whereIn('ins_id',$aryIds)->update(['ins_status' => 0]);
           return redirect()->route('manageinstitute')->with('status', 'Entry Updated Successfully');
       }
       endIf;
     /***********************Bulk Action ************/
    
       
          /***********************Apply Condition ************/
  
       if($request->get('filter_keyword')!='')
       {
 
       Session::put('FILTER_INSTITUTE', $request->get('filter_keyword'));
       Session::save(); 


       }
          /***********************Apply Condition ************/
  
       if(session()->has('FILTER_INSTITUTE')){
       $strFilterKeyword = Session::get('FILTER_INSTITUTE');
      // $strFilterKeyword;
       $resVideoData = CsInstitute::where('ins_name', 'LIKE', "%{$strFilterKeyword}%")->paginate(20);
      //print_r($resVideoData); die;
       }else{
       $resVideoData = CsInstitute::paginate(20);
       }    
      

       
   //$resVideoData = CsInstitute::paginate(20);
   $resCategoryData = CsInstituteCategory::get();
   $title='Manage Institute';
   return view('Csadmin.Institute.index',compact('title','resVideoData','resCategoryData'));
 
 }
 public function addNew($intInsId=0)
  {
       $resInstituteData = array();
        if($intInsId>0){
            $resInstituteData = CsInstitute::where('ins_id','=',$intInsId)->first();
        }
        $strCategory =array();
        if(isset($resInstituteData->ins_cat_id))
        {
            $strCategory = explode(',',$resInstituteData->ins_cat_id);
        }
      
      $resStateData = CsStates::where('country_id','=',101)->get();
      //print_r($resStateData);die;
      $resCategoryData = CsInstituteCategory::get();
      $aryCategoryList = $this->buildTree($resCategoryData,0);
      
       $strCategoryTreeStructure =$this->genrateHtml($aryCategoryList,0,$strCategory);

    $title='Add New Institute';
    return view('Csadmin.Institute.addNew' ,compact('title','resCategoryData','aryCategoryList','strCategoryTreeStructure','strCategory','resInstituteData','resStateData','intInsId'));
}

function insProccess(Request $request)
    {
        $aryPostData = $request->all();
       // print_r($aryPostData);die;
        if(isset($aryPostData['ins_id']) && $aryPostData['ins_id']>0)
        {
            $postobj = CsInstitute::where('ins_id',$aryPostData['ins_id'])->first();
        }else{
            $postobj = new CsInstitute;
            $postobj->ins_slug = Str::slug($aryPostData['ins_name'], '-');
            $lastOrder = CsInstitute::orderBy('ins_uniqueId', 'desc')->first();
            $ido= $lastOrder->ins_uniqueId;
            $number = substr($ido, 3);
            $uniqueid= 'CZI' . sprintf('%03d', intval($number) + 1);
            $postobj->ins_uniqueId = $uniqueid;
        }  
                
        $postobj->ins_name = $aryPostData['ins_name'];
        $postobj->ins_phone = $aryPostData['ins_phone'];
        $postobj->ins_email = $aryPostData['ins_email'];
        
        $postobj->ins_status = 1;
        $postobj->ins_address = $aryPostData['ins_address'];
        $postobj->ins_short_desc = '';
        $postobj->ins_desc = $aryPostData['ins_desc'];
        $postobj->ins_state = $aryPostData['ins_state'];
        $postobj->ins_city = $aryPostData['ins_city'];
        $postobj->ins_postcode = $aryPostData['ins_postcode'];

//print_r($aryPostData);die;
        
        if(isset($aryPostData['ins_icat_id_']) && count($aryPostData['ins_icat_id_'])>0)
        {
            $aryPostData['ins_icat_id_'] = array_unique($aryPostData['ins_icat_id_']);
            $postobj->ins_cat_id = implode(',',$aryPostData['ins_icat_id_']);
            $resCategoryName = CsInstituteCategory::whereIn('icat_id',$aryPostData['ins_icat_id_'])->get(); 
            //print_r($resCategoryName);die;
            $catName = array();
            foreach($resCategoryName as $values){
            $catName[] = $values->icat_name;
            }
            $postobj->ins_cat_name  = implode(', ',$catName);
            /*echo '<pre>';
            print_r($resCategoryName);die;*/
            //$postobj->sm_sc_name  = implode(', ',$resCategoryName['sc_name']);
        }else{
            $postobj->ins_cat_name = '';
            $postobj->ins_cat_id = '';
        }
        if(isset($aryPostData['ins_password_'])&& $aryPostData['ins_password_']!=='')
        {
            $postobj->login_pass = $aryPostData['ins_password_'];
            $postobj->ins_password = Hash::make($aryPostData['ins_password_']);
        }

        
        if($request->hasFile('ins_logo_'))
        {
            $image = $request->file('ins_logo_');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = SITE_UPLOAD_PATH.SITE_INSTITUTE_IMAGE;
            $image->move($destinationPath, $name);
            $postobj->ins_logo = $name;
        } 
        if($request->hasFile('ins_cover_image_'))
        {
            $image = $request->file('ins_cover_image_');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = SITE_UPLOAD_PATH.SITE_INSTITUTE_IMAGE;
            $image->move($destinationPath, $name);
            $postobj->ins_cover_image = $name;
        } 


                     
        if($postobj->save())    
        {
            return redirect()->route('manageinstitute')->with('status', 'Entry Saved Successfully.');   
        }else{
            return redirect()->route('manageinstitute')->with('error', 'Server Not Responed');
        }
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
    function genrateHtml($aryCategoryTree,$intLevel=0,$strSelectCategory=array()){
        $strHtml='';
        //print_r($aryCategoryTree);
        foreach($aryCategoryTree as $key=>$label){
            if($label->icat_parent==0){
                
                $intLevel=0;
            }
            $strChecked='';
            $strExtraChecked ='';
           // print_r($strSelectCategory);
            if(in_array($label->icat_id,$strSelectCategory)){
                $strChecked = 'checked="checked"';
                $strExtraChecked ='checked';
            }
            $margin =$intLevel*20;
            $strLevelByMargin = 'margin-left:'.$margin.'px;';
            $strHtml .= '<label class="cch-check" style="'.$strLevelByMargin.'">'.$label->icat_name.'
            <input type="checkbox" name="ins_icat_id_[]" value="'.$label->icat_id.'" '.$strChecked.' class="clsSelectSingle"><span class="checkmark"></span>
            </label>';
            if(isset($label->children)){
                $intLevel++;
                $strHtml .=$this->genrateHtml($label->children,$intLevel,$strSelectCategory);
            }
        }
        //print_r($strHtml);
        return $strHtml;
    }
    public function insDelete($ins_id)
    {
        CsInstitute::where('ins_id', $ins_id)->delete();
        return redirect()->route('manageinstitute')->with('status', 'Entry Deleted Successfully');
    }
    public function insStatus($ins_id)
    {
        $rowCategoryData = CsInstitute::where('ins_id',$ins_id)->first();
        //print_r($rowCategoryData);die;
        if($rowCategoryData->ins_status==1){
            $status = 0;
        }else{
            $status = 1;
        }
        CsInstitute::where('ins_id', $ins_id)->update(array('ins_status' => $status));
         return redirect()->route('manageinstitute')->with('status', 'Status updated successfully');
    }

}
