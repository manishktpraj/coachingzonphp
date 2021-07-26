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

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        echo 'Here';
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
