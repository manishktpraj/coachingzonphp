<?php namespace App\Http\Controllers\Cswebservices;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
use Session;
use App\Http\Model\CsStudent;
use App\Http\Model\Csoffers;
use App\Http\Model\CsWalletTransaction;
use Validator;
use Illuminate\Support\Str;
use App\Http\Model\CsPcategory;
use App\Http\Model\CsSlider;
use App\Http\Model\CsPackage;
use App\Http\Model\CsInstitute;
use App\Http\Model\Csproduct;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $aryPostData = $request->all();
        //Configure::write('debug', 2);
        
        $aryResponse =array();
        if ($request->isMethod('post')) 
        {
            $data = (object)$aryPostData;
            $resPackageCategory= CsPcategory::where(['pc_status'=>1,'pc_parent'=>0])->orderBy('pc_id')->get();
            $aryResponse['message']='ok';
            $aryResponse['notification']='Record Found';
            $aryResponse['purl'] = SITE_UPLOAD_URL.SITE_PACKAGE_IMAGE;
            $aryResponse['paurl'] = SITE_UPLOAD_URL.SITE_PACKAGE_IMAGE;
            $aryResponse['surl'] = SITE_UPLOAD_URL.SITE_SLIDER_IMAGE;
            $aryResponse['insurl'] = SITE_UPLOAD_URL.SITE_INSTITUTE_IMAGE;
    
            $aryResponse['pcategory'] = $resPackageCategory;
            $resPackageCategory= CsSlider::where(['slider_status'=>1])->orderBy('slider_id')->get();
            $aryResponse['slider'] = $resPackageCategory;
            $resPackageCategory= CsPackage::where(['package_status'=>1])->orderBy('package_id')->get();
            $aryResponse['package'] = $resPackageCategory;

            $resPackageCategory= CsPackage::where(['package_status'=>1])->orderBy('package_id')->get();
            $aryResponse['video_package'] = $resPackageCategory;

            
            $resPackageCategory= CsPackage::where(['package_status'=>1])->orderBy('package_id')->get();
            $aryResponse['testseries_package'] = $resPackageCategory;
            $resPackageCategory= CsInstitute::where(['ins_status'=>1])->orderBy('ins_id')->get();
            $aryResponse['institutew'] = $resPackageCategory;
            $resPackageCategory= Csproduct::where(['product_status'=>1])->orderBy('product_id')->get();
            $aryResponse['product'] = $resPackageCategory;


        }else{
            $aryResponse['message']='failed';
            $aryResponse['notification']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
    }
    
    function getoffer(Request $request)
    {
        $aryPostData = $request->all();
        //Configure::write('debug', 2);
        $aryResponse =array();
        if ($request->isMethod('post')) 
        {
            $data = (object)$aryPostData;
            $strCurrentData =date("Y-m-d");
            $resOfferLists= DB::table('cs_offers')->whereRaw('"'.$strCurrentData.'" between `offers_valid_from` and `offers_valid_to`') ->get();
            $aryResponse['message']='ok';
            $aryResponse['notification']='Record Found';
            $aryResponse['results'] = $resOfferLists;
        }else{
            $aryResponse['message']='failed';
            $aryResponse['notification']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
    }


    function wallethistory(Request $request)
    {
        $aryPostData = $request->all();
        //Configure::write('debug', 2);
        $aryResponse =array();
        if ($request->isMethod('post')) 
        {
            $data = (object)$aryPostData;
            $strCurrentData =date("Y-m-d");
            $intUserId = 103314;
            $resOfferLists = CsWalletTransaction::where('wtrans_user_id','=',$intUserId)->paginate(40);
            $aryResponse['message']='ok';
            $aryResponse['notification']='Record Found';
            $aryResponse['results'] = $resOfferLists;
        }else{
            $aryResponse['message']='failed';
            $aryResponse['notification']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
    }
    
    function getbalance(Request $request)
    {
        $aryPostData = $request->all();
        //Configure::write('debug', 2);
        $aryResponse =array();
        if ($request->isMethod('post')) 
        {
            $data = (object)$aryPostData;
            $strCurrentData =date("Y-m-d");
            $intUserId = 103314;
            $resOfferLists = CsWalletTransaction::where('wtrans_user_id','=',$intUserId) ->select(DB::raw('IFNULL(SUM(wtrans_amt),0) as total_sales'))->first();
            $aryResponse['message']='ok';
            $aryResponse['notification']='Record Found';
            $aryResponse['results'] = $resOfferLists->total_sales;
        }else{
            $aryResponse['message']='failed';
            $aryResponse['notification']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
    }
 
}
