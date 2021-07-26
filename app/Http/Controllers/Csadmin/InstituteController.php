<?php

namespace App\Http\Controllers\Csadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Model\CsInstitute;
use App\Http\Model\CsInstituteCategory;
use Session;

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
      print_r($resVideoData); die;
       }else{
       $resVideoData = CsInstitute::paginate(20);
       }    
    
     
   //$resVideoData = CsVideo::paginate(20);
   $resCategoryData = CsInstituteCategory::get();
   $title='Manage Institute';
   return view('Csadmin.Institute.index',compact('title','resVideoData','resCategoryData'));
 
 }
 public function addNew($intVideoId=0)
  {
       $resInstituteData = array();
        if($intVideoId>0){
            $resInstituteData = CsInstitute::where('ins_id','=',$intVideoId)->first();
        }
      //   $strCategory =array();
      //   if(isset($resVideoData->video_vc_id))
      //   {
      //       $strCategory = explode(',',$resVideoData->video_vc_id);
      //   }
      
      // $resCategoryData = CsVcategory::get();
      // $aryCategoryList = $this->buildTree($resCategoryData,0);
      
      // $strCategoryTreeStructure =$this->genrateHtml($aryCategoryList,0,$strCategory);

    $title='Add New Institute';
    return view('Csadmin.Institute.addNew' ,compact('title','resInstituteData'));
   // return view('Csadmin.Institute.addNew' ,compact('title','resCategoryData','aryCategoryList','strCategoryTreeStructure','strCategory','resVideoData'));
}

function insProccess(Request $request)
    {
        $aryPostData = $request->all();
       // print_r($aryPostData);die;
        if(isset($aryPostData['ins_id']) && $aryPostData['ins_id']>0)
        {
            $postobj = CsVideo::where('ins_id',$aryPostData['ins_id'])->first();
        }else{
            $postobj = new CsVideo;
            $postobj->video_slug = Str::slug($aryPostData['ins_name'], '-');
        }   
        
        $postobj->video_status = 1;
        $postobj->ins_name = $aryPostData['ins_name'];
        $postobj->video_desc = $aryPostData['video_desc'];
        $postobj->video_type = $aryPostData['video_type'];
        $postobj->video_start_date = $aryPostData['video_start_date'];
        $postobj->video_size = $aryPostData['video_size'];
        $postobj->video_duration = $aryPostData['video_duration'];
        $postobj->video_start_time = $aryPostData['video_start_time'];
        $postobj->video_configuration = $aryPostData['video_configuration'];
        $postobj->video_url = $aryPostData['video_url'];
        $postobj->pdf_url = $aryPostData['pdf_url'];
        
        if(isset($aryPostData['video_vc_id_']) && count($aryPostData['video_vc_id_'])>0)
        {
            $aryPostData['video_vc_id_'] = array_unique($aryPostData['video_vc_id_']);
            $postobj->video_vc_id = implode(',',$aryPostData['video_vc_id_']);
            $resCategoryName = CsVcategory::whereIn('vc_id',$aryPostData['video_vc_id_'])->get(); 
            //print_r($resCategoryName);die;
            $catName = array();
            foreach($resCategoryName as $values){
            $catName[] = $values->vc_name;
            }
            $postobj->video_vc_name  = implode(', ',$catName);
            /*echo '<pre>';
            print_r($resCategoryName);die;*/
            //$postobj->sm_sc_name  = implode(', ',$resCategoryName['sc_name']);
        }else{
            $postobj->video_vc_name = '';
            $postobj->video_vc_id = '';
        }
        if($request->hasFile('video_image_'))
        {
            $image = $request->file('video_image_');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = SITE_UPLOAD_PATH.SITE_VIDEO_IMAGE;
            $image->move($destinationPath, $name);
            $postobj->video_image = $name;
        } 
               
        if($postobj->save())    
        {
            return redirect()->route('all-videos')->with('status', 'Entry Saved Successfully.');   
        }else{
            return redirect()->route('all-videos')->with('error', 'Server Not Responed');
        }
    }



}
