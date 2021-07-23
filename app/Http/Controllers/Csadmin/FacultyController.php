<?php namespace App\Http\Controllers\Csadmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
use Session;
use App\Http\Model\Csdmin;
use App\Http\Model\CsFaculty;

use Validator;

class FacultyController extends Controller
{
  public function index(Request $request)
  {
    /***********************Reset Filter Session ************/
        if($request->get('reset')==1)
        {
        Session::forget('FILTER_FACULTY');
        return redirect()->route('faculty');   
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
            CsFaculty::whereIn('faculty_id', $aryIds)->delete();
            return redirect()->route('faculty')->with('status', 'Entry Deleted Successfully');
        }
        if($intBulkAction==2)
        {
            CsFaculty::whereIn('faculty_id', $aryIds)->update(['faculty_status' => 1]);
            return redirect()->route('faculty')->with('status', 'Entry Updated Successfully');
        }
        if($intBulkAction==3)
        {
            CsFaculty::whereIn('faculty_id',$aryIds)->update(['faculty_status' => 0]);
            return redirect()->route('faculty')->with('status', 'Entry Updated Successfully');
        }
        endIf;
      /***********************Bulk Action ************/
     
        
           /***********************Apply Condition ************/
   
        if($request->get('filter_keyword')!='')
        {
        Session::put('FILTER_FACULTY', $request->get('filter_keyword'));
        Session::save(); 
        }
           /***********************Apply Condition ************/
   
        if(session()->has('FILTER_FACULTY')){
        $strFilterKeyword = Session::get('FILTER_FACULTY');
        $resfacultyData = CsFaculty::where('faculty_first_name', 'LIKE', "%{$strFilterKeyword}%")->paginate(20);
        //print_r($resVideoData);
        }else{
         $resfacultyData = CsFaculty::paginate(20);
        }    
     
        
      
    $title='Faculty';
    return view('Csadmin.Faculty.index',compact('title','resfacultyData'));
  }
  


  
   
  public function facultyStatus($intCategoryId)
    {
        $rowCategoryData = CsFaculty::where('faculty_id',$intCategoryId)->first();
       // print_r($rowCategoryData);die;
        if($rowCategoryData->faculty_status==1){
            $status = 0;
        }else{
            $status = 1;
        }
        CsFaculty::where('faculty_id', $intCategoryId)->update(array('faculty_status' => $status));
        return redirect()->route('faculty')->with('status', 'Entry Edited Successfully');
    }
  
   function facultyProccess(Request $request)
    {
        $aryPostData = $request->all();
        if(isset($aryPostData['faculty_id']) && $aryPostData['faculty_id']>0)
        {
            $postobj = CsFaculty::where('faculty_id',$aryPostData['faculty_id'])->first();
        }else{
            $postobj = new CsFaculty;
        }   
        
        $postobj->faculty_status = 1;
        $postobj->faculty_first_name = $aryPostData['faculty_first_name'];
        $postobj->faculty_last_name = $aryPostData['faculty_last_name'];
        $postobj->faculty_gender = $aryPostData['faculty_gender'];
        $postobj->faculty_dob = $aryPostData['faculty_dob'];
        $postobj->faculty_email = $aryPostData['faculty_email'];
        $postobj->faculty_about = $aryPostData['faculty_about'];
        
       if(isset($aryPostData['faculty_new_password']) && isset($aryPostData['faculty_confirm_password']) && $aryPostData['faculty_confirm_password']==$aryPostData['faculty_new_password']){
               
             $postobj->faculty_password = $aryPostData['faculty_new_password'];
           } 
        
        $postobj->faculty_phone = $aryPostData['faculty_phone'];
        
        if($request->hasFile('faculty_img'))
        {
            $image = $request->file('faculty_img');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = SITE_UPLOAD_PATH.SITE_FACULTY_IMAGE;
            $image->move($destinationPath, $name);
            $postobj->faculty_img = $name;
        } 

        if($postobj->save())    
        {
            return redirect()->route('faculty')->with('status', 'Entry Saved Successfully.');   
        }else{
            return redirect()->route('faculty')->with('error', 'Server Not Responed');
        }
    }
    
    public function addNewFaculty($intfacultyId=0)
  {
       $resfacultyData = array();
        if($intfacultyId>0){
            $resfacultyData = CsFaculty::where('faculty_id','=',$intfacultyId)->first();
        }
        
    $title='Add New Faculty';
    return view('Csadmin.Faculty.addNewFaculty' ,compact('title','resfacultyData'));
  }
  
   public function facultyDelete($intCategoryId)
    {
        CsFaculty::where('faculty_id', $intCategoryId)->delete();
        return redirect()->route('faculty')->with('status', 'Entry Deleted Successfully');
    }
   public function viewFaculty($intfacultyId=0)
  {
    
    $title='View Faculty';
    return view('Csadmin.Faculty.viewFaculty' ,compact('title'));
  }
}