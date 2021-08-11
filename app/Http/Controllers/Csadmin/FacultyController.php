<?php namespace App\Http\Controllers\Csadmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
use Session;
use App\Http\Model\Csdmin;
use App\Http\Model\CsStaff;
use App\Http\Model\CsFacultyRole;
use App\Http\Model\CsPermission;
use App\Http\Model\CsRolePermissions;



use Validator;

class FacultyController extends Controller
{
  public function index(Request $request)
  {
    $user=Session::get("CS_ADMIN");

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
            CsStaff::whereIn('staff_id', $aryIds)->delete();
            return redirect()->route('faculty')->with('status', 'Entry Deleted Successfully');
        }
        if($intBulkAction==2)
        {
            CsStaff::whereIn('staff_id', $aryIds)->update(['staff_status' => 1]);
            return redirect()->route('faculty')->with('status', 'Entry Updated Successfully');
        }
        if($intBulkAction==3)
        {
            CsStaff::whereIn('staff_id',$aryIds)->update(['staff_status' => 0]);
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
        if($user->role_type==0){
            $resfacultyData = CsStaff::where('staff_name', 'LIKE', "%{$strFilterKeyword}%")->paginate(20);
        }else{
            $resfacultyData = CsStaff::where('staff_name', 'LIKE', "%{$strFilterKeyword}%")->where('staff_institute_id','=',$user->user_id)->paginate(20);
            }}else{
                if($user->role_type==0){
                    $resfacultyData = CsStaff::paginate(20);
                }else{
                    $resfacultyData = CsStaff::where('staff_institute_id','=',$user->user_id)->paginate(20);
    
                }
            }   
               
      
    $title='Faculty';
    return view('Csadmin.Faculty.index',compact('title','resfacultyData'));
  }
  


  
   
  public function facultyStatus($intCategoryId)
    {
        $rowCategoryData = CsStaff::where('staff_id',$intCategoryId)->first();
       // print_r($rowCategoryData);die;
        if($rowCategoryData->staff_status==1){
            $status = 0;
        }else{
            $status = 1;
        }
        CsStaff::where('staff_id', $intCategoryId)->update(array('staff_status' => $status));
        return redirect()->route('faculty')->with('status', 'Entry Edited Successfully');
    }
  
   function facultyProccess(Request $request)
    {    $user=Session::get("CS_ADMIN");


        $aryPostData = $request->all();
        //print_r($aryPostData);die;
        if(isset($aryPostData['staff_id']) && $aryPostData['staff_id']>0)
        {
            $postobj = CsStaff::where('staff_id',$aryPostData['staff_id'])->first();
        }else{
            $postobj = new CsStaff;
            $postobj->staff_institute_id = $user->user_id;

        }   
        
        
        $postobj->staff_default_status = 1;

        $postobj->staff_role = $aryPostData['faculty_role'];
        
        $postobj->staff_status = 1;
        $postobj->staff_name = $aryPostData['faculty_name'];
        $postobj->staff_gender = $aryPostData['faculty_gender'];
        $postobj->staff_dob = $aryPostData['faculty_dob'];
        $postobj->staff_email = $aryPostData['faculty_email'];
        $postobj->staff_about = $aryPostData['faculty_about'];
        
       if(isset($aryPostData['faculty_new_password']) && isset($aryPostData['faculty_confirm_password']) && $aryPostData['faculty_confirm_password']==$aryPostData['faculty_new_password']){
               
             $postobj->staff_password =  Hash::make($aryPostData['faculty_new_password']);
           } 
        
        $postobj->staff_mobile = $aryPostData['faculty_phone'];
        
        if($request->hasFile('faculty_img'))
        {
            $image = $request->file('faculty_img');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = SITE_UPLOAD_PATH.SITE_FACULTY_IMAGE;
            $image->move($destinationPath, $name);
            $postobj->staff_logo = $name;
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
    $user=Session::get("CS_ADMIN");

    $resroleData = CsFacultyRole::where('role_ins_id','=',$user->user_id)->get();
//print_r($resroleData);
       $resfacultyData = array();
        if($intfacultyId>0){
            if($user->role_type==0){
                $resfacultyData = CsStaff::where('staff_id','=',$intfacultyId)->first();
            }else{
                $resfacultyData = CsStaff::where('staff_id','=',$intfacultyId)->where('staff_institute','=',$user->user_id)->first();
    
                }
            }


        
    $title='Add New Faculty';
    return view('Csadmin.Faculty.addNewFaculty' ,compact('title','resfacultyData','resroleData'));
  }
  
   public function facultyDelete($intCategoryId)
    {
        CsStaff::where('staff_id', $intCategoryId)->delete();
        return redirect()->route('faculty')->with('status', 'Entry Deleted Successfully');
    }
   public function viewFaculty($intfacultyId=0)
  {
    
    $title='View Faculty';
    return view('Csadmin.Faculty.viewFaculty' ,compact('title'));
  }
  public function facultyrole(Request $request, $intid=0){

/***********************Reset Filter Session ************/
if($request->get('reset')==1)
{
Session::forget('FILTER_ROLE');
return redirect()->route('faculty-role');   
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
    CsFacultyRole::whereIn('role_id', $aryIds)->delete();
    return redirect()->route('faculty-role')->with('status', 'Entry Deleted Successfully');
}
if($intBulkAction==2)
{
    CsFacultyRole::whereIn('role_id', $aryIds)->update(['role_status' => 1]);
    return redirect()->route('faculty-role')->with('status', 'Entry Updated Successfully');
}
if($intBulkAction==3)
{
    CsFacultyRole::whereIn('role_id',$aryIds)->update(['role_status' => 0]);
    return redirect()->route('faculty-role')->with('status', 'Entry Updated Successfully');
}
endIf;
/***********************Bulk Action ************/


   /***********************Apply Condition ************/

   if($request->get('filter_keyword')!='')
   {

   Session::put('FILTER_ROLE', $request->get('filter_keyword'));
   Session::save(); 


   }
   /***********************Apply Condition ************/

if(session()->has('FILTER_ROLE')){
$strFilterKeyword = Session::get('FILTER_ROLE');
$resroleData = CsFacultyRole::where('role_name', 'LIKE', "%{$strFilterKeyword}%")->paginate(20);
}else{
    $resroleData = CsFacultyRole::paginate(20);
}    
    $resfacroleData ='';
    if($intid>0){
        $resfacroleData = CsFacultyRole::where('role_id','=',$intid)->first();
    }
//print_r($resroleData);die;


  $title='Manage Roles';
  return view('Csadmin.Faculty.facultyrole' ,compact('title','resroleData','resfacroleData'));
  }
  
  public function roleproccess(Request $request){
    
    $user=Session::get("CS_ADMIN");
    $aryPostData = $request->all();
    if(isset($aryPostData['role_id']) && $aryPostData['role_id']>0)
    {
        $postobj = CsFacultyRole::where('role_id',$aryPostData['role_id'])->first();
    }else{
        $postobj = new CsFacultyRole;
    }   
    $postobj->role_ins_id = $user->user_id;
    $postobj->role_status = 1;
    $postobj->role_name = $aryPostData['role_name'];
    
    if($postobj->save())    
        {
            return redirect()->route('faculty-role')->with('status', 'Entry Saved Successfully.');   
        }else{
            return redirect()->route('faculty-role')->with('error', 'Server Not Responed');
        }
    
    }

    public function roleStatus($intCategoryId)
    {
        $rowCategoryData = CsFacultyRole::where('role_id',$intCategoryId)->first();
       // print_r($rowCategoryData);die;
        if($rowCategoryData->role_status==1){
            $status = 0;
        }else{
            $status = 1;
        }
        CsFacultyRole::where('role_id', $intCategoryId)->update(array('role_status' => $status));
        return redirect()->route('faculty-role')->with('status', 'Entry Edited Successfully');
    }
  
    public function facultypermission($intCategoryId)
    {

     $permissionData=   CsPermission::get();
     $rowPermission=   CsRolePermissions::where('rp_role_id', $intCategoryId)->get();

// print_r($rowPermissionChecked);

        $title='Permission';
    return view('Csadmin.Faculty.facultypermission' ,compact('title','permissionData','intCategoryId','rowPermission'));
    }

    public function permissionProccess(Request $request)
    {
        $aryPostData = $request->all();
        //   print_r($aryPostData);die;;
        
    
        $id=$aryPostData['rp_role_id'];

        CsRolePermissions::where('rp_role_id', $id)->delete();

        foreach($aryPostData['permission'] as $key=>$label)
        {
           // print_r($aryPostData);
           $postobj = new CsRolePermissions;

            $postobj->rp_role_id=$id;
 
      $postobj->rp_permission_id =$key;
      $postobj->rp_edit_status =0;
      $postobj->rp_aprrove_status =0;

      
      if(in_array(1,$label))
      {
       $postobj->rp_entry_status =1;
      }else{
          $postobj->rp_entry_status =0;
      }
      if(in_array(2,$label))
      {
       $postobj->rp_delete_status =1;
      }else{
          $postobj->rp_delete_status =0;
      }
      if(in_array(3,$label))
      {
       $postobj->rp_view_status =1;
      }else{
          $postobj->rp_view_status =0;
      }
      $postobj->save();
      //print_r($postobj);
        }
       
         return redirect()->route('faculty-role')->with('status', 'Entry Saved Successfully.');   
       
     

    }

  
}