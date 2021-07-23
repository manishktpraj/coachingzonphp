<?php namespace App\Http\Controllers\Csadmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
use Session;
use App\Http\Model\CsStaff;
use App\Http\Model\Permission;

class LoginController extends Controller
{
  public function AdminLogin(Request $request)
  {
      //echo Hash::make('neonclasses@2444');
     if(Session::has('CS_ADMIN')){
        return redirect()->route('dashboard');    
    }
     return view('Csadmin.Auth.login');
  }
  public function adminLoginCheck(Request $request)
  {	
  	    $email = $request->user_email;
          $password =$request->user_password;
     
        $adminLoginCheck = CsStaff::where('staff_email','=',$email)->first();
        if($adminLoginCheck){
          if (Hash::check($password, $adminLoginCheck->staff_password)) {
            Session::put('CS_ADMIN', $adminLoginCheck);
            Session::save();
            $response = [
                'message' => 'ok'
              ];
          }
          else{
              $response = [
                'message' => 'failed'
              ];
          }
        }else{
            $response = [
                'message' => 'failed'
              ];
        }
        return response()->json($response);
  }
  public function logout(Request $request)
  {	
 	Session::forget('CS_ADMIN');
 	return redirect()->route('adminLogin')->withErrors("logged out.");
  }
}