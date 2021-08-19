<?php namespace App\Http\Controllers\Csadmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
use Session;
use App\Http\Model\CsAdmin;
use Validator;
use App\Http\Model\CsTransactions;
use App\Http\Model\CsTransactionsDetail;


class DashboardController extends Controller
{
  public function index(Request $request)
  {
        $user=Session::get("CS_ADMIN");



        if($user->role_type==0){
         
          $all_trans_data = DB::table('cs_transactions')
          ->join('cs_transaction_detail', 'cs_transactions.trans_id', '=', 'cs_transaction_detail.td_trans_id')
          ->join('cs_package', 'cs_transaction_detail.td_product_id', '=', 'cs_package.package_id')
          ->get();
         }else{
          $all_trans_data = DB::table('cs_transactions')
          ->join('cs_transaction_detail', 'cs_transactions.trans_id', '=', 'cs_transaction_detail.td_trans_id')
          ->join('cs_package', 'cs_transaction_detail.td_product_id', '=', 'cs_package.package_id')
          ->where('pacakge_ins_id','=',$user->user_id)
          ->get();

         }











  //  $all_trans_data =CsTransactions::get();
//echo count($all_trans_data);


    $title='Dashboard';
    return view('Csadmin.dashboard', compact('title','all_trans_data'));
  }
  public function notification(Request $request)
  {
    $title='Notification';
    return view('Csadmin.notification')->with('title',$title);
  }
 
} 
