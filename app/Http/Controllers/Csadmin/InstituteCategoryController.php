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
     
      
    //$resVideoData = CsVideo::paginate(20);
  
    $title='Manage Intitute Category';
    return view('Csadmin.Institute.category',compact('title','resCategoryData'));
  
  }
}
