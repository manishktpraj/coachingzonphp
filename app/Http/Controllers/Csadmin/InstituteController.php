<?php

namespace App\Http\Controllers\Csadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Model\CsInstitute;
use App\Http\Model\CsInstituteCategory;

class InstituteController extends Controller
{
  public function index(Request $request)
  {
     
    /***********************Reset Filter Session ************/
       if($request->get('reset')==1)
       {
       Session::forget('FILTER_INSTITUTE');
       return redirect()->route('manageintitute');   
       }
    /***********************Reset Filter Session ************/
    
    /***********************Bulk Action ************/
      $aryPostData = $request->all();
      print_r($aryPostData);
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
  
       if($request->get('FILTER_INSTITUTE')!='')
       {
       Session::put('FILTER_INSTITUTE', $request->get('filter_keyword'));
       Session::save(); 
       }
          /***********************Apply Condition ************/
  
       if(session()->has('FILTER_INSTITUTE')){
       $strFilterKeyword = Session::get('FILTER_INSTITUTE');
       $resVideoData = CsInstitute::where('ins_name', 'LIKE', "%{$strFilterKeyword}%")->paginate(20);
       //print_r($resVideoData); die;
       }else{
       $resVideoData = CsInstitute::paginate(20);
       }    
    
     
   //$resVideoData = CsVideo::paginate(20);
   $resCategoryData = CsInstituteCategory::get();
   $title='Manage Institute';
   return view('Csadmin.Institute.index',compact('title','resVideoData','resCategoryData'));
 
 }

}
