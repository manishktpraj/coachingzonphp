<?php namespace App\Http\Controllers\Cswebservices;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
use Session;
use Validator;
use Illuminate\Support\Str;
use App\Http\Model\CsScategory;
use App\Http\Model\CsInstituteCategory;
use App\Http\Model\CsPcategory;
use App\Http\Model\CsStudent;
use App\Http\Model\CsNotification;
use App\Http\Model\CsPackage;
use App\Http\Model\Csproduct;
use App\Http\Model\CsInstitute;
use App\Http\Model\CsSlider;
use App\Http\Model\CsStudyMaterial;
use App\Http\Model\CsTest;
use App\Http\Model\CsVideo;
use App\Http\Model\CsPackageDetail;

use App\Http\Model\CsVcategory;
use App\Http\Model\CsReview;



class DataController extends Controller
{
    public function index(Request $request)
    {
        exit;
    }
    
    function getpackagesubcategory(Request $request)
    {
        $aryPostData = $request->all();
        $aryResponse =array();
        if ($request->isMethod('post')) 
        {
            $data = (object)$aryPostData;
            $aryResponse['purl'] = SITE_UPLOAD_URL.SITE_PACKAGE_IMAGE;
            $strCurrentData =date("Y-m-d");
            $resPackageCategory= CsPcategory::where(['pc_id'=>$aryPostData['pc_parent']])->first();
            $aryResponse['resultsmain'] =(object) array();
            if($resPackageCategory!=null)
            {
                $aryResponse['resultsmain'] = $resPackageCategory;

            }
            $resPackageCategory= CsPcategory::where(['pc_status'=>1,'pc_parent'=>$aryPostData['pc_parent']])->orderBy('pc_id')->get();
            $aryResponse['message']='ok';
            $aryResponse['notification']='Record Found';
            $aryResponse['results'] = $resPackageCategory;

            
        }else{
            $aryResponse['message']='failed';
            $aryResponse['notification']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
    }
    function createRandomPassword() { 

        $chars = "ABCDEFGHIJKLMNOPQURSTUVWXYZabcdefghijkmnopqrstuvwxyz"; 
        srand((double)microtime()*1000000); 
        $i = 0; 
        $pass = '' ; 
    
        while ($i <= 5) { 
            $num = rand() % 33; 
            $tmp = substr($chars, $num, 1); 
            $pass = $pass . $tmp; 
            $i++; 
        } 
    
        return $pass; 
    
    }
    function sharetextdata(Request $request)
    {
        $aryPostData = $request->all();
        //Configure::write('debug', 2);
        $aryResponse =array();
        if ($request->isMethod('post')) 
        {
            $data = (object)$aryPostData;
            $rowUserInfo = CsStudent::where('student_id', '=', $data->student_id)->first();
    
            if(isset($rowUserInfo->student_id) && $rowUserInfo->student_refferal_code=='')
            {
                $flight = CsStudent::find($rowUserInfo->student_id);
                $flight->student_refferal_code = strtoupper($this->createRandomPassword());
                $flight->save();
            }
            if(isset($rowUserInfo->student_id) && $rowUserInfo->student_id>0)
            {
                $rowUserInfo = CsStudent::where('student_id', '=', $data->student_id)->first();
                $aryResponse['message']='ok';
                $aryResponse['share_code'] = $rowUserInfo->student_refferal_code;
                $aryResponse['text_share_message'] = 'Coachingzon '.$aryResponse['share_code'].' share the code with friend to get money in your wallet. Download the app now 👉 https://play.google.com/store/apps/details?id=codexo.coachingzon';
        
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

    function notification(Request $request) { 

     $aryPostData = $request->all();
     //Configure::write('debug', 2);
     $aryResponse =array();
     if ($request->isMethod('post')) 
     {
         $notificationdata = CsNotification::where('no_student', '=', $aryPostData['student_id'])->get();
         $aryResponse['message']='ok';
         $aryResponse['naurl'] = SITE_NOTIFICATION_IMAGE;

         $aryResponse['results']=$notificationdata;

     }else{
         $aryResponse['message']='failed';
         $aryResponse['notification']='Method Not Allowed';
     }
     echo json_encode($aryResponse);
     exit;
    }

    function course(Request $request) { 

        $aryPostData = $request->all();
        // print_r($aryPostData);
         $aryResponse =array();
        if ($request->isMethod('post')) 
        {
            $aryResponse['packageurl'] = SITE_UPLOAD_URL.SITE_PACKAGE_IMAGE;
   
            $resPackageCategory= CsPcategory::where(['pc_id'=>$aryPostData['cat_id']])->first();
            $intParent =0;
            $intCoachingId=0;
            if(isset($aryPostData['coaching_id']))
            {
                $intCoachingId =   $aryPostData['coaching_id'];
            }


            if(isset( $resPackageCategory->pc_parent) && $resPackageCategory->pc_parent!=0)
            {
                $resPackageCategory= CsPcategory::where(['pc_id'=>$resPackageCategory->pc_parent])->first();
                $intParent =$aryPostData['cat_id'];
            }else if(isset($resPackageCategory->pc_id)){
                $intParent = $resPackageCategory->pc_id;

            }
            $aryResponse['resultsmain'] =(object) array();
            if($resPackageCategory!=null && $intParent>0)
            { 
                $aryResponse['resultsmain'] = $resPackageCategory;

                if($intCoachingId>0)
                {
                    $coursedata = CsPackage::whereRaw(' FIND_IN_SET('.$intParent.',package_pc_id)')->where('pacakge_ins_id',$intCoachingId)->whereRow(' package_status=1')->get();

                }else{
                    $coursedata = CsPackage::whereRaw(' FIND_IN_SET('.$intParent.',package_pc_id)')->whereRaw(' package_status=1')->get();

                }

                $aryResponse['results']=$coursedata;
            }else{
                if($intCoachingId>0)
                {
                $coursedata = CsPackage::whereRaw(' package_status=1')->where('pacakge_ins_id',$intCoachingId)->get();
            }else{
                $coursedata = CsPackage::whereRaw(' package_status=1')->get();
           
            }
                $aryResponse['results'] = $coursedata;

            }

            $aryResponse['message']='ok';


            if(isset($resPackageCategory->pc_parent))
        {
            if($resPackageCategory->pc_parent==0)
            {
                $resPackageCategory= CsPcategory::where(['pc_status'=>1,'pc_parent'=>$resPackageCategory->pc_id])->orderBy('pc_id')->get();
                $aryResponse['resultssubcategory'] = $resPackageCategory;
            }else{
                $resPackageCategory= CsPcategory::where(['pc_status'=>1,'pc_parent'=>$resPackageCategory->pc_parent])->orderBy('pc_id')->get();
                $aryResponse['resultssubcategory'] = $resPackageCategory;
            }
 
        }else{
            $resPackageCategory= CsPcategory::where(['pc_status'=>1,'pc_parent'=>0])->orderBy('pc_id')->get();
            $aryResponse['resultssubcategory'] = $resPackageCategory;
        }
            
            
        }else{
            $aryResponse['message']='failed';
            $aryResponse['course']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
       }

       function ebooknotes(Request $request) { 

        $aryPostData = $request->all();
        // print_r($aryPostData);
        // Configure::write('debug', 2);
        $aryResponse =array();
        if ($request->isMethod('post')) 
        {
            $productdata = Csproduct::get();
            $aryResponse['message']='ok';
            $aryResponse['bookurl'] = SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE;
            $aryResponse['results']=$productdata;
        }else{
            $aryResponse['message']='failed';
            $aryResponse['ebook']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
       }
  

       function getinstitutedetail(Request $request) { 

        $aryPostData = $request->all();
        $aryResponse =array();
        if ($request->isMethod('post')) 
        {
            $aryResponse['insurl'] = SITE_UPLOAD_URL.SITE_INSTITUTE_IMAGE;
            $productdata = CsInstitute::where('ins_id', '=', $aryPostData['institute_id'])->first();
            $aryResponse['message']='ok';
            $aryResponse['results_Institute']=$productdata;
            $productdata = CsPackage::where('pacakge_ins_id', '=', $aryPostData['institute_id'])->get();
            $aryResponse['packageurl'] = SITE_UPLOAD_URL.SITE_PACKAGE_IMAGE;
            $aryResponse['results_package']=$productdata;
            $productdata = CsSlider::where('slider_institute', '=', $aryPostData['institute_id'])->get();
            $aryResponse['sliderurl'] = SITE_UPLOAD_URL.SITE_SLIDER_IMAGE;
            $aryResponse['results_slider']=$productdata;
            $productdata = CsReview::get();
            $aryResponse['results_review']=$productdata;
            $aryResponse['message']='ok';
  
        }else{
            $aryResponse['message']='failed';
            $aryResponse['course']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
       }


       function freestudymaterial(Request $request) { 

        $aryPostData = $request->all();
        $aryResponse =array();
        if ($request->isMethod('post')) 
        {
            $productdata = CsStudyMaterial::where('sm_sc_name', 'like', '%Free Study Materials%')->where('sm_institute', '=', $aryPostData['institute_id'])->get();
            $aryResponse['url'] = SITE_UPLOAD_URL.SITE_STUDY_MATERIAL_IMAGE;
            $aryResponse['message']='ok';
            $aryResponse['results']=$productdata;

        }else{
            $aryResponse['message']='failed';
            $aryResponse['course']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
       }

       
       function studymaterialcat(Request $request) { 

        $aryPostData = $request->all();
        $aryResponse =array();
        if ($request->isMethod('post')) 
        {
        
              $count =   DB::table('cs_scategory')
              ->join('cs_study_material', 'cs_scategory.sc_id', '=', 'cs_study_material.sm_sc_id')
              ->select('cs_scategory.sc_id as id', DB::raw("count(cs_study_material.sm_sc_id) as count"))
              ->groupBy('cs_scategory.sc_id')
              ->get();
              
            $productdata = CsScategory::get();
            $aryResponse['url'] = SITE_UPLOAD_URL.SITE_STUDY_MATERIAL_IMAGE;
            $aryResponse['message']='ok';
            $aryResponse['results']=$productdata;
            $aryResponse['count']=$count;


        }else{
            $aryResponse['message']='failed';
            $aryResponse['course']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
       }



       function institutecategory(Request $request) { 

        $aryPostData = $request->all();
        $aryResponse =array();
        if ($request->isMethod('post')) 
        {
            $productdata = CsInstituteCategory::get();
            $aryResponse['url'] = SITE_UPLOAD_URL.SITE_INSTITUTE_IMAGE;
            $aryResponse['message']='ok';
            $aryResponse['results']=$productdata;
        }else{
            $aryResponse['message']='failed';
            $aryResponse['course']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
       }


       function testseries(Request $request) { 

        $aryPostData = $request->all();
        $aryResponse =array();
        if ($request->isMethod('post')) 
        {
            $institutedata = CsInstitute::where('ins_id', '=', $aryPostData['institute_id'])->first();

            $productdata = CsPackage::where('pacakge_ins_id', '=', $aryPostData['institute_id'])->where('package_type', '=', 0)->get();
            $aryResponse['url'] = SITE_UPLOAD_URL.SITE_INSTITUTE_IMAGE;
            $aryResponse['message']='ok';
           // $aryResponse['institute']=$institutedata;
            $aryResponse['results']=$productdata;

        }else{
            $aryResponse['message']='failed';
            $aryResponse['course']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
       }



       function freetestseries(Request $request) { 

        $aryPostData = $request->all();
        $aryResponse =array();
        if ($request->isMethod('post')) 
        {
            $institutedata = CsInstitute::where('ins_id', '=', $aryPostData['institute_id'])->first();
            $productdata = CsTest::where('test_tc_name', 'like', '%Free Test%')->where('test_institute', '=', $aryPostData['institute_id'])->get();

            $aryResponse['url'] = SITE_UPLOAD_URL.SITE_INSTITUTE_IMAGE;
            $aryResponse['message']='ok';
           // $aryResponse['institute']=$institutedata;
            $aryResponse['results']=$productdata;
        }else{
            $aryResponse['message']='failed';
            $aryResponse['course']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
       }


       function institutes(Request $request) 
       { 
        $aryPostData = $request->all();
        $aryResponse =array();
        if ($request->isMethod('post')) 
        {
            if($aryPostData['category_id']==0)
            {
            $productdata = CsInstitute::get();
            }else{
            $productdata = CsInstitute::whereRaw("FIND_IN_SET('".$aryPostData['category_id']."',ins_cat_id)")->get();
            }
            $aryResponse['url'] = SITE_UPLOAD_URL.SITE_INSTITUTE_IMAGE;
            $aryResponse['message']='ok';
            $aryResponse['results']=$productdata;
        }else{
            $aryResponse['message']='failed';
            $aryResponse['course']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
       }


      
       function packagedetail(Request $request) 
       { 
        $aryPostData = $request->all();
        $aryResponse =array();
        if ($request->isMethod('post')) 
        {
        //    $productdata = CsPackageDetail::where('pkd_pack_id', '=', $aryPostData['course_id'])->where('pkd_type', '=', 1)->get();

            

            $productdata = CsPackageDetail::leftJoin('cs_staff', function($join) {
                $join->on('cs_package_detail.pkd_ref', '=', 'cs_staff.staff_id');
              })
              ->where('pkd_pack_id', '=', $aryPostData['course_id'])->where('pkd_type', '=', 1)->get();


            $aryResponse['faculty_url'] = SITE_UPLOAD_URL.SITE_FACULTY_IMAGE;
            $aryResponse['message']='ok';
            $aryResponse['results_faculty']=$productdata;
           // $productdata = CsPackageDetail::where('pkd_pack_id', '=', $aryPostData['course_id'])->where('pkd_type', '=', 5)->get();
         
         
           $productdata = CsPackageDetail::leftJoin('cs_video', function($join) {
                $join->on('cs_package_detail.pkd_ref', '=', 'cs_video.video_id');
              })
              ->where('pkd_pack_id', '=', $aryPostData['course_id'])->where('pkd_type', '=', 5)->get();
            $aryResponse['video_url'] = SITE_UPLOAD_URL.SITE_VIDEO_IMAGE;
            $aryResponse['results_demo_video']=$productdata;


        }else{
            $aryResponse['message']='failed';
            $aryResponse['course']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
       }

       function videocat(Request $request) 
       { 
        $aryPostData = $request->all();
        $aryResponse =array();
        if ($request->isMethod('post')) 
        {
           $productdata = CsPackageDetail::leftJoin('cs_vcategory', function($join) {
            $join->on('cs_package_detail.pkd_ref', '=', 'cs_vcategory.vc_id');
          })->select('vc_id','vc_name','vc_image', DB::raw(' (SELECT count(*) FROM cs_video  WHERE FIND_IN_SET(cs_vcategory.vc_id,video_vc_id)) as total'))->where('pkd_type','3')->get();

            $aryResponse['url'] = SITE_UPLOAD_URL.SITE_VIDEO_IMAGE;
            $aryResponse['message']='ok';
            $aryResponse['results']=$productdata;
        }else{
            $aryResponse['message']='failed';
            $aryResponse['course']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
       }

       function testcat(Request $request) 
       { 
        $aryPostData = $request->all();
        $aryResponse =array();
        if ($request->isMethod('post')) 
        {
            $productdata = CsPackageDetail::leftJoin('cs_tcategory', function($join) {
                $join->on('cs_package_detail.pkd_ref', '=', 'cs_tcategory.tc_id');
              })->select('tc_id','tc_name','tc_image', DB::raw(' (SELECT count(*) FROM cs_test  WHERE FIND_IN_SET(cs_tcategory.tc_id,test_tc_id)) as total'))->where('pkd_type','2')->get();
    
            $aryResponse['url'] = SITE_UPLOAD_URL.SITE_TEST_IMAGE;
            $aryResponse['message']='ok';
            $aryResponse['results']=$productdata;
        }else{
            $aryResponse['message']='failed';
            $aryResponse['course']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
       }


       function syllabus(Request $request) { 

        $aryPostData = $request->all();
        $aryResponse =array();
        if ($request->isMethod('post')) 
        {
            $productdata = CsPackage::where('package_id', '=', $aryPostData['course_id'])->get();
            $aryResponse['url'] = SITE_UPLOAD_URL.SITE_PACKAGE_IMAGE;
            $aryResponse['message']='ok';
            $aryResponse['results']=$productdata;
        }else{
            $aryResponse['message']='failed';
            $aryResponse['course']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
       }
      
       function dailyquiz(Request $request) { 

        $aryPostData = $request->all();
        $aryResponse =array();
        if ($request->isMethod('post')) 
        {
            $productdata = CsTest::where('test_tc_name', 'like', '%Daily Quiz%')->get();

            $aryResponse['url'] = SITE_UPLOAD_URL.SITE_TEST_IMAGE;
            $aryResponse['message']='ok';
           // $aryResponse['institute']=$institutedata;
            $aryResponse['results']=$productdata;
        }else{
            $aryResponse['message']='failed';
            $aryResponse['dailyquiz']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
       }


       function livevideos(Request $request) { 

        $aryPostData = $request->all();
        $aryResponse =array();
        if ($request->isMethod('post')) 
        {
            if($aryPostData['video_type']==1)
            {
                $aryPostData['video_type'] =0;
                $productdata = CsVideo::where('video_type', '=', $aryPostData['video_type'])->get();
            }else{
                $aryPostData['video_type'] =0;
                $productdata = CsVideo::where('video_type', '=', $aryPostData['video_type'])->whereRaw(' video_start_date>\''.date('Y-m-d').'\' ')->get();
            }


            $aryResponse['url'] = SITE_UPLOAD_URL.SITE_VIDEO_IMAGE;
            $aryResponse['message']='ok';
           // $aryResponse['institute']=$institutedata;
            $aryResponse['results']=$productdata;
        }else{
            $aryResponse['message']='failed';
            $aryResponse['livevideo']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
       }


       function review(Request $request) { 

        $aryPostData = $request->all();
        $aryResponse =array();
        if ($request->isMethod('post')) 
        {
            $productdata = CsReview::where('review_user_id', '=', $aryPostData['student_id'])->first();

            $aryResponse['message']='ok';
            $aryResponse['results']=$productdata;
        }else{
            $aryResponse['message']='failed';
            $aryResponse['dailyquiz']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
       }


    //    public function insreview(Request $request)
    // {
    //     $aryResponse =array();
    //     if ($request->isMethod('post')) 
    //     {
    //         $aryResponse['message']='ok';
    //         $data = (object)$request->all();
    //       //  print_r($data);die;
    //         $rowUserInfo = CsInstitute::where('ins_id', '=', $data->institute_id)->first();
    //         if(isset($rowUserInfo->ins_id) && $rowUserInfo->ins_id>0 && $rowUserInfo->ins_status==1)
    //         {

    //             CsInstitute::where('ins_id',$data->institute_id)->update(['ins_rating'=>$data->ins_rating,'ins_review'=>$data->ins_review]);
    //             $aryResponse['message']='ok';
    //         }else{
    //             $aryResponse['message']='failed';
    //             $aryResponse['review']='Method Not Allowed'; 
                
    //         }
        
    //     }
    //     echo json_encode($aryResponse);
    //     exit;       
    // }

    function insreview(Request $request)
    {
        $aryResponse =array();
        if ($request->isMethod('post')) 
        { 
            $data = (object)$request->all();
            $rowUserInfo = CsReview::where('review_user_id', '=', $data->user_id)->first();
            if(isset($rowUserInfo->review_user_id) && $rowUserInfo->review_user_id>0)
            {             

                $rowUserInfo->review_user_id = $data->user_id;
                $rowUserInfo->review_user_name = $data->user_name;
                $rowUserInfo->review_institute_id = $data->institute_id;
                $rowUserInfo->review_institute_name = $data->institute_name;
                $rowUserInfo->ins_rating = $data->ins_rating;
                $rowUserInfo->ins_review = $data->ins_review;
                $rowUserInfo->save();
                $aryResponse['message']='ok';
                $aryResponse['notification']='Thanks for your review';

            }else{
                $rowUserInfo = new CsReview;
                $rowUserInfo->review_user_id = $data->user_id;
                $rowUserInfo->review_user_name = $data->user_name;
                $rowUserInfo->review_institute_id = $data->institute_id;
                $rowUserInfo->review_institute_name = $data->institute_name;
                $rowUserInfo->ins_rating = $data->ins_rating;
                $rowUserInfo->ins_review = $data->ins_review;
                $rowUserInfo->save();
                $aryResponse['message']='ok';
                $aryResponse['notification']='Thanks for your review';
                
            }
        }else{
            $aryResponse['message']='failed';
            $aryResponse['notification']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
    }
 















    function videocat1(Request $request) 
    { 
        $aryPostData = $request->all();
        $aryResponse =array();
        if ($request->isMethod('post')) 
        {
            $productdata = CsPackageDetail::leftJoin('cs_vcategory', function($join) {
                $join->on('cs_package_detail.pkd_ref', '=', 'cs_vcategory.vc_id');
              })->select('vc_id','vc_name', DB::raw(' (SELECT count(*) FROM cs_video  WHERE FIND_IN_SET(cs_vcategory.vc_id,video_vc_id)) as total'))->where('pkd_type','3')->get();
 
            $aryResponse['url'] = SITE_UPLOAD_URL.SITE_VIDEO_IMAGE;
            $aryResponse['message']='ok';
            $aryResponse['results']=$productdata;
        }else{
            $aryResponse['message']='failed';
            $aryResponse['course']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
       }
       function testing(Request $request) 
       {
       
       
       
       }

       

}  
