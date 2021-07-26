<?php namespace App\Http\Controllers\Cswebservices;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
use Session;
use App\Http\Model\CsStudent;
use Validator;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        echo 'Here';
    }
    
public static function sendSms($intMobileNumber,$message)
{
    $curl = curl_init();
    $message =urlencode($message);
    $strUrl ="http://trans.masssms.tk/api.php?username=samyak123&password=samyak@123&sender=SAMYNK&sendto=$intMobileNumber&message=$message";
    curl_setopt_array($curl, array(
    CURLOPT_URL =>$strUrl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_SSL_VERIFYHOST => 0,
    CURLOPT_SSL_VERIFYPEER => 0,
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
return true;
}



    function loginwithpassword(Request $request)
    {
        $aryPostData = $request->all();
        //Configure::write('debug', 2);
        $aryResponse =array();
        if ($request->isMethod('post')) 
        {
            $data = (object)$aryPostData;
            $rowUserInfo = CsStudent::where('student_email', '=', $data->student_email)
                                    ->orWhere('student_phone', '=', $data->student_email)
                                    ->where('student_password', '=', $data->student_password)
                                    ->first();
    
            if(isset($rowUserInfo->student_id) && $rowUserInfo->student_id>0)
            {
                $aryResponse['message']='ok';
                $aryResponse['notification']='Login Successfully...';
                $aryResponse['results'] = $rowUserInfo;
    			$strRandom = Str::random(60);
    			CsStudent::where('student_id',$rowUserInfo->student_id)->update(['student_login'=>1,'student_login_token'=>$strRandom]);
            }else{
                $aryResponse['message']='failed';
                $aryResponse['notification']='Invalid Credential';
            }
        }else{
            $aryResponse['message']='failed';
            $aryResponse['notification']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
    }
    
    function loginwithmobile(Request $request)
    {
        $aryResponse =array();
        if ($request->isMethod('post')) 
        {
             
            $data = (object)$request->all();
            $rowUserInfo = CsStudent::where('student_phone', '=', $data->student_phone)
                                    ->first();
           // print_r($rowUserInfo);die;
            if(isset($rowUserInfo->student_id) && $rowUserInfo->student_id>0)
            {
                $aryResponse['message']='ok';
                $strRandomOtp =rand(1000,9999);
                $aryPostData['student_otp'] = $strRandomOtp;
                CsStudent::where('student_id',$rowUserInfo->student_id)->update(['student_otp'=>$strRandomOtp]);
                $rowUserInfo = CsStudent::where('student_phone', '=', $data->student_phone)->first();
                 $strMessage = 'Your one Time Password (OTP) for registration/transaction is '.$strRandomOtp.' .DO NOT SHARE WITH ANYBODY.NEONCS';
                                 $strMessage = 'Forgot Password : Dear Aspirant, your OTP for SAMYAK App is : '.$strRandomOtp;

                 self::sendSms($data->student_phone,$strMessage);
                $aryResponse['notification']='Login Successfully...';
                $aryResponse['results'] = $rowUserInfo;
            }else{
                $postobj = new CsStudent;
                $strRandomOtp =rand(1000,9999);
                $postobj['student_otp'] = $strRandomOtp;
                $postobj['student_created_datetime'] = date('Y-m-d h:i:s');
                $postobj['student_phone'] =$data->student_phone;
                $postobj->save();
                
                $intUserId = $postobj->student_id;
                 $strMessage = 'Your one Time Password (OTP) for registration/transaction is '.$strRandomOtp.' .DO NOT SHARE WITH ANYBODY.NEONCS';
                 $strMessage = 'Forgot Password : Dear Aspirant, your OTP for SAMYAK App is : '.$strRandomOtp;
                 self::sendSms($data->student_phone,$strMessage);
                $aryResponse['message']='ok';
                $aryResponse['notification']='OTP Sent  To Your Register Mobile Number';
                $resUserInfo = CsStudent::where('student_id', '=',$intUserId)->first();
                CsStudent::where('student_id',$resUserInfo->student_id)->update(['student_otp'=>$strRandomOtp]);
                $aryResponse['results'] = $resUserInfo;
            }
        }else{
            $aryResponse['message']='failed';
            $aryResponse['notification']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
    }
    
    function resendotp(Request $request)
    {
        $aryResponse =array();
        if ($request->isMethod('post')) 
        {
            $data = (object)$request->all();
            $rowUserInfo = CsStudent::where('student_id', '=',$data->student_id)->first();
            $strMessage = 'Your one Time Password (OTP) for registration/transaction is '.$rowUserInfo['student_otp'].' .DO NOT SHARE WITH ANYBODY.NEONCS';
            $strMessage = 'Forgot Password : Dear Aspirant, your OTP for SAMYAK App is : '.$rowUserInfo['student_otp'];
            self::sendSms($rowUserInfo['student_phone'],$strMessage);
            $aryResponse['message']='ok';
            $aryResponse['notification']='OTP Resent To Your Register Mobile Number';
        }else{
            $aryResponse['message']='failed';
            $aryResponse['notification']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;     
    }  
    
    function verifyotp(Request $request)
    {
        $aryResponse =array();
        if ($request->isMethod('post')) 
        {
            $data = (object)$request->all();
            if($data->student_id>0 && $data->student_id!='')
            {
                $rowUserInfo = CsStudent::where('student_id','=',$data->student_id)->first();
                if($rowUserInfo->student_id>0 && $rowUserInfo->student_otp==$data->student_otp)
                {
                    $aryResponse['message']='ok';
                    $aryResponse['notification']='OTP Verify Successfully';
                    if($rowUserInfo->student_status==0)
                    {
                        CsStudent::where('student_id',$rowUserInfo->student_id)->update(['student_status'=>1]);
                    } 
                    $rowUserInfo = CsStudent::where('student_id','=',$data->student_id)->first();
                    $aryResponse['results'] = $rowUserInfo;
                }else{
                    $aryResponse['message']='failed';
                    $aryResponse['notification']='OTP does not match';
                }
            }else{
                $aryResponse['message']='failed';
                $aryResponse['notification']='Please Fill All Require Field';
            }
        }else{
            $aryResponse['message']='failed';
            $aryResponse['notification']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;     
    }
    
    function getUserUniqueId()
    { 
        $a=0;
        while($a==0)
        {
            $strCustomeId ='NEON'.rand(10000,100000);
            $rowSelectStudentSetting = CsStudent::where('student_registration_id','=',$strCustomeId)->count();
            if($rowSelectStudentSetting<=0)
            {
                $a=1;
            }
        }
        return $strCustomeId;
    }
    
    public function finalregister(Request $request)
    {
        $aryResponse =array();
        if ($request->isMethod('post')) 
        {
            $aryResponse['message']='ok';
            /*$json = file_get_contents('php://input');
            $data = json_decode($json);*/
            $data = (object)$request->all();
            //print_r($data);die;
            $rowUserInfo = CsStudent::where('student_email', '=', $data->student_email)
                                    ->orWhere('student_phone', '=', $data->student_phone)
                                    ->first();
          //  print_r($rowUserInfo );die;
            if(isset($rowUserInfo->student_id) && $rowUserInfo->student_id>0 && $rowUserInfo->student_status==1)
            {
                $aryResponse['message']='failed';
                $aryResponse['notification']='Email/Mobile Already Registered';
            }else{
                if(!isset($rowUserInfo->student_id))
                {
                    $rowUserInfo = new CsStudent;
                    $rowUserInfo->student_registration_id = self::getUserUniqueId();
                }else{
                    $rowUserInfo = CsStudent::where('student_email', '=', $rowUserInfo->student_id)->first();
                }
                
                if($data->student_ref_id!='')
                {
                    $rowUserRefferdByInfo = CsStudent::where('student_refferal_code', '=', $data->student_ref_id)->first();
                    
                    if(isset($rowUserRefferdByInfo->student_id) && $rowUserRefferdByInfo->student_id>0)
                    {
                        $rowUserInfo->student_ref_id = $rowUserRefferdByInfo->student_id;
                    }else{
                        $rowUserInfo->student_ref_id = '';
                    }
                }
                $rowUserInfo->student_first_name = $data->student_first_name;
                $rowUserInfo->student_last_name = $data->student_last_name;
                $rowUserInfo->student_email = $data->student_email;
                $rowUserInfo->student_phone = $data->student_phone;
                
                $rowUserInfo->student_status = 1;
               // $rowUserInfo = (array)$data;
                $strRandomOtp =rand(1000,9999);
                $rowUserInfo->student_otp = $strRandomOtp;
                if($rowUserInfo->save()) 
                {
                    $rowUserInfo = CsStudent::where('student_phone', '=', $data->student_phone)->first();
                   // $rowUserInfo = $this->OtStudent->find('all')->where(' 1 AND  student_phone=\''.$data->student_phone.'\'')->first();
                   // $strMessage = 'Your one Time Password (OTP) for registration/transaction is '.$strRandomOtp.' .DO NOT SHARE WITH ANYBODY.NEONCS';
                   // SmsHelper::sendSms($data->student_phone,$strMessage);
                    $aryResponse['message']='ok';
                    $aryResponse['notification']=' '.$strRandomOtp.' your otp';
                    $aryResponse['results'] = $rowUserInfo;
                }else{
                    $aryResponse['message']='failed';
                    $aryResponse['notification']='Please Fill All Require Field';
                }
            }
        }else{
            $aryResponse['message']='failed';
            $aryResponse['notification']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;       
    }
    
    function forgot(Request $request)
    {
        $aryResponse =array();
        if ($request->isMethod('post')) 
        {
            $data = (object)$request->all();
            $rowUserInfo = CsStudent::where('student_phone', '=', $data->student_phone)->first();
            if(isset($rowUserInfo->student_id) && $rowUserInfo->student_id>0)
            {
                $aryResponse['message']='ok';
                $strRandomOtp =rand(1000,9999);
                $rowUserInfo->student_otp = $strRandomOtp;
                $rowUserInfo->save();
                $rowUserInfo = CsStudent::where('student_phone', '=', $data->student_phone)->first();
                $strMessage = 'Your one Time Password (OTP) for registration/transaction is '.$strRandomOtp.' .DO NOT SHARE WITH ANYBODY.NEONCS';
                $strMessage = 'Forgot Password : Dear Aspirant, your OTP for SAMYAK App is : '.$strRandomOtp;
                self::sendSms($data->student_phone,$strMessage);
                $aryResponse['notification']='Sms Sent to your registered mobile number';
                $aryResponse['results'] = $rowUserInfo;
            }else{
                $aryResponse['message']='failed';
                $aryResponse['notification']='Mobile number not register yet';
                $resUserInfo = CsStudent::where('student_id', '=', $data->student_id)->first();
                $aryResponse['results'] = $resUserInfo;
            }
        }else{
            $aryResponse['message']='failed';
            $aryResponse['notification']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
    }
    
    
    function changepassword(Request $request)
    {
        $aryResponse =array();
        if ($request->isMethod('post')) 
        { 
            $data = (object)$request->all();
            CsStudent::where('student_id',$data->student_id)->update(['student_password'=>$data->new_password]);
            $aryResponse['message']='ok';
            $aryResponse['notification']='Password Changed Successfully';
        }else{
            $aryResponse['message']='failed';
            $aryResponse['notification']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
    }
    
    function updateuserprofile(Request $request)
    {
        $aryResponse =array();
        if ($request->isMethod('post')) 
        { 
            $data = (object)$request->all();
            $rowUserInfo = CsStudent::where('student_id', '=', $data->student_id)->first();
            if(isset($rowUserInfo->student_id) && $rowUserInfo->student_id>0)
            {
                $aryResponse['message']='ok';
                $aryResponse['notification']='Profile Updated Successfully';
             
                $rowUserInfo->student_first_name = $data->student_first_name;
                $rowUserInfo->student_last_name = $data->student_last_name;
                $rowUserInfo->save();
                $rowUserInfo = CsStudent::where('student_id', '=', $data->student_id)->first();
                $aryResponse['results']=$rowUserInfo;
            }else{
                $aryResponse['message']='failed';
                $aryResponse['notification']='Your Login Session Expire'.$this->request->getdata('user_id');
            }
        }else{
            $aryResponse['message']='failed';
            $aryResponse['notification']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
    }
    
    
    function updatestudentprofileimage(Request $request)
    {
        $aryResponse =array();
        if ($request->isMethod('post')) 
        { 
            $data = (object)$request->all();
            $aryResponse['message']='ok';
            $binary=base64_decode(str_replace('data:application/pdf;base64,','',str_replace('data:image/*;charset=utf-8;base64,','',$aryData['image_data'])));
            $file_name = time().'userprofile.jpg';
            $file = fopen(SITE_UPLOAD_PATH.'student_image/'.$file_name, 'wb');
            fwrite($file, $binary);
            fclose($file);
            $aryResponse['url']  = SITE_UPLOAD_URL.'student_image/'.$file_name;
            $aryResponse['message']='ok';
            $this->OtStudent->updateAll(['student_image'=>$aryResponse['url']],['student_id'=>$aryData['student_id']]);
            $rowUserInfo = $this->OtStudent->find('all')->where(' 1 AND student_id=\''.$this->request->getdata('student_id').'\'')->first();
            $aryResponse['results'] = $rowUserInfo;
        }else{
            $aryResponse['message']='failed';
            $aryResponse['notification']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
    }
 
}
