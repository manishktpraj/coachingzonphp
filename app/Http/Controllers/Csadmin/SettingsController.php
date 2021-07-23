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
    $sess_var = Session::get('CS_ADMIN');
    $account_id=$sess_var->staff_id;
    $resAccountData = CsStaff::where('staff_id', $account_id)->first();
    $title='Account Setting';
    return view('Csadmin.Settings.accountSetting',compact('title','resAccountData'));
  }
  

  function accountProccess(Request $request){
      $aryPostData = $request->all();
        if(isset($aryPostData['staff_id']) && $aryPostData['staff_id']>0)
        {
          CsStaff::where('staff_id', $aryPostData['staff_id'])->update(array('staff_name' => $aryPostData['staff_name'],'staff_email' => $aryPostData['staff_email'],'staff_mobile' => $aryPostData['staff_mobile']));
        }
        return redirect()->route('account-setting'); 
  }
 
 
 function passProccess(Request $request){
      $aryPostData = $request->all();
        if(isset($aryPostData['staff_id']) && $aryPostData['staff_id']>0)
        {
           if(isset($aryPostData['admin_password']) && isset($aryPostData['admin_Confirm_password']) && $aryPostData['admin_Confirm_password']==$aryPostData['admin_password']){
             CsStaff::where('staff_id', $aryPostData['staff_id'])->update(array('staff_password' => $aryPostData['admin_password']));  
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