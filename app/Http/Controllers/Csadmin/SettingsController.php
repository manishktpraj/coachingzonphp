<?php namespace App\Http\Controllers\Csadmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
use Session;
use App\Http\Model\Csdmin;
use App\Http\Model\CsStaff;
use App\Http\Model\CsCountries;
use App\Http\Model\CsCities;
use App\Http\Model\CsStates;
use App\Http\Model\CsTheme;
use App\Http\Model\CsInstitute;



use Validator;


class SettingsController extends Controller
{
  public function index(Request $request)
  {
    $rescountry = CsCountries::get();
    $rowStoreData= CsTheme::first();
   // print($rowStoreData);die;
    $resstate = CsStates::where('country_id', '101')->get();
    $rescity = CsCities::where('state_id','=',$rowStoreData->theme_state)->get();
    //print_r($rescity);die;
    $title='Settings';
    return view('Csadmin.Settings.index',compact('title','rescountry','resstate','rescity','rowStoreData'));
  }
  
  public function accountSetting(Request $request)
  {

    $rescountry = CsCountries::get();
    $rowStoreData= CsTheme::first();
   // print($rowStoreData);die;
    $resstate = CsStates::where('country_id', '101')->get();
    $rescity = CsCities::where('state_id','=',$rowStoreData->theme_state)->get();





    $sess_var = Session::get('CS_ADMIN');
//print_r($sess_var);

    $user_role=$sess_var->role_type;
    $account_id=$sess_var->user_id;
    if($user_role==0){
    $resAccountData = CsStaff::where('staff_institute_id', $account_id)->first();
    }else{
    $resAccountData = CsInstitute::where('ins_id', $account_id)->first();

    }
    $title='Account Setting';
    return view('Csadmin.Settings.accountSetting',compact('title','resAccountData','rescountry','resstate','resstate','rescity','account_id','user_role'));
  }
  


  function accountProccess(Request $request){
    $sess_var = Session::get('CS_ADMIN');
    //print_r($sess_var);die;
    $user_role=$sess_var->role_type;
    $account_id=$sess_var->user_id;
//echo $user_role;die;
    $aryPostData = $request->all();
            if($user_role==0){

            if(isset($aryPostData['staff_id']) && $aryPostData['staff_id']>0)
            {
                $postobj = CsStaff::where('staff_id',$aryPostData['staff_id'])->first();
                // if($user_role!=0){
                //   CsInstitute::where('ins_id', $account_id)->update(array('ins_name' => $aryPostData['staff_name'],'ins_email' => $aryPostData['staff_email'],'ins_phone' => $aryPostData['staff_mobile'],'ins_logo' => $aryPostData['staff_logo'],'ins_cover_image' => $aryPostData['staff_cover_image']));
                // }
            }else{
            $postobj = new CsStaff;
            $postobj->staff_institute_id = $account_id;

            }
           // echo $account_id; die;
            $postobj->staff_default_status = 1;
            $postobj->staff_role = $user_role;
            
            $postobj->staff_mobile = $aryPostData['staff_mobile'];
            $postobj->staff_name = $aryPostData['staff_name'];
            $postobj->staff_email = $aryPostData['staff_email'];
            $postobj->staff_country = $aryPostData['staff_country'];
            $postobj->staff_state = $aryPostData['staff_state'];
            $postobj->staff_city = $aryPostData['staff_city'];
            $postobj->staff_postcode = $aryPostData['staff_postcode'];
            if($request->hasFile('staff_logo'))
            { 
                $image = $request->file('staff_logo');
                $name = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = SITE_UPLOAD_PATH.SITE_STAFF_IMAGE; 
                $image->move($destinationPath, $name);
                $postobj->staff_logo = $name;
            } 
            if($request->hasFile('staff_cover_image'))
            {
                $image = $request->file('staff_cover_image');
                $name = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = SITE_UPLOAD_PATH.SITE_STAFF_IMAGE;
                $image->move($destinationPath, $name);
                $postobj->staff_favicon = $name;
            }
          }else{
//print_r($aryPostData);die;
            $postobj = CsInstitute::where('ins_id',$account_id)->first();

            $postobj->ins_phone = $aryPostData['staff_mobile'];
            $postobj->ins_name = $aryPostData['staff_name'];
            $postobj->ins_email = $aryPostData['staff_email'];
          //  $postobj->staff_country = $aryPostData['staff_country'];
            $postobj->ins_state = $aryPostData['staff_state'];
            $postobj->ins_city = $aryPostData['staff_city'];
            $postobj->ins_postcode = $aryPostData['staff_postcode'];
            if($request->hasFile('staff_logo'))
            {
                $image = $request->file('staff_logo');
                $name = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = SITE_UPLOAD_PATH.SITE_INSTITUTE_IMAGE; 
                $image->move($destinationPath, $name);
                $postobj->ins_logo = $name;
            } 
            if($request->hasFile('staff_cover_image'))
            {
                $image = $request->file('staff_cover_image');
                $name = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = SITE_UPLOAD_PATH.SITE_INSTITUTE_IMAGE;
                $image->move($destinationPath, $name);
                $postobj->ins_cover_image = $name;
            }
 









          }
            if($postobj->save())    
            {
                return redirect()->route('account-setting')->with('status', 'Entry Saved Successfully.');   
            }else{
                return redirect()->route('account-setting')->with('error', 'Server Not Responed');
            }
        }
 
 
 function passProccess(Request $request){
      $aryPostData = $request->all();
        if(isset($aryPostData['staff_id']) && $aryPostData['staff_id']>0)
        {
           if(isset($aryPostData['admin_password']) && isset($aryPostData['admin_Confirm_password']) && $aryPostData['admin_Confirm_password']==$aryPostData['admin_password']){
            
            $pass=Hash::make($aryPostData['admin_password']);
 
             CsStaff::where('staff_id', $aryPostData['staff_id'])->update(array('staff_password' => $pass));  
           } 
        }
        return redirect()->route('account-setting'); 
  }
    
     
    function getcityajax(Request $request)
   {
       echo '<option value="">Select</option>';
        $aryPostData = $request->all();
         $ay_row = CsCities::where('state_id', $aryPostData['state_id'])->get();
           foreach($ay_row as $value)
           {
               echo '<option value="'.$value->id.'">'.$value->name.'</option>';
           }
           exit;
   }
   
 
    function storeProccess(Request $request)
    {

      $aryPostData = $request->all();
//print_r($aryPostData);die;

      // if(isset($aryPostData['student_id']) && $aryPostData['student_id']>0)
      // {
      //     $postobj = CsStudent::where('student_id',$aryPostData['student_id'])->first();
      // }else{
      //     $postobj = new CsStudent;
      // }   





        $aryPostData = $request->all();
        if(isset($aryPostData['theme_id']) && $aryPostData['theme_id']>0)
        {
            $postobj = CsTheme::where('theme_id',$aryPostData['theme_id'])->first();
        } 
        $postobj->theme_store_name = $aryPostData['theme_store_name'];
        $postobj->theme_email = $aryPostData['theme_email'];
        $postobj->theme_country = $aryPostData['theme_country'];
        $postobj->theme_state = $aryPostData['theme_state'];
        $postobj->theme_city = $aryPostData['theme_city'];
        $postobj->theme_postcode = $aryPostData['theme_postcode'];
        $postobj->theme_tax_option = $aryPostData['theme_tax_option'];
        if($request->hasFile('theme_logo'))
        {
            $image = $request->file('theme_logo');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = SITE_UPLOAD_PATH.SITE_THEME_IMAGE; 
            $image->move($destinationPath, $name);
            $postobj->theme_logo = $name;
        } 
        if($request->hasFile('theme_favicon'))
        {
            $image = $request->file('theme_favicon');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = SITE_UPLOAD_PATH.SITE_THEME_IMAGE;
            $image->move($destinationPath, $name);
            $postobj->theme_favicon = $name;
        } 
        if($postobj->save())    
        {
            return redirect()->route('store-setting')->with('status', 'Entry Saved Successfully.');   
        }else{
            return redirect()->route('store-setting')->with('error', 'Server Not Responed');
        }
    }
   
   
}