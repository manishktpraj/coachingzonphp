<?php namespace App\Http\Controllers\Csadmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
use Session;
use App\Http\Model\Csdmin;
use App\Http\Model\CsTransactionsDetail;

use App\Http\Model\CsTransactions;

use Validator;

class OrderController extends Controller
{
  public function index(Request $request)
  {
    $user=Session::get("CS_ADMIN");
    
         /***********************Reset Filter Session ************/
         if($request->get('reset')==1)
         {
         Session::forget('FILTER_ORDER');
         return redirect()->route('order');   
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
            //CsTest::whereIn('test_id', $aryIds)->delete();
             return redirect()->route('order')->with('status', 'Entry Deleted Successfully');
         }
         if($intBulkAction==2)
         {
            // CsTest::whereIn('test_id', $aryIds)->update(['test_status' => 1]);
             return redirect()->route('order')->with('status', 'Entry Updated Successfully');
         }
         if($intBulkAction==3)
         {
           //  CsTest::whereIn('test_id',$aryIds)->update(['test_status' => 0]);
             return redirect()->route('order')->with('status', 'Entry Updated Successfully');
         }
         endIf;
       /***********************Bulk Action ************/
      
         
            /***********************Apply Condition ************/
    
         if($request->get('filter_keyword')!='')
         {
         Session::put('FILTER_ORDER', $request->get('filter_keyword'));
         Session::save(); 
         }
            /***********************Apply Condition ************/
    
         if(session()->has('FILTER_ORDER')){
         $strFilterKeyword = Session::get('FILTER_ORDER');
         if($user->role_type==0){
          $orderdata = DB::table('cs_transactions')
          ->join('cs_transaction_detail', 'cs_transactions.trans_id', '=', 'cs_transaction_detail.td_trans_id')
          ->join('cs_package', 'cs_transaction_detail.td_product_id', '=', 'cs_package.package_id')
          ->where('trans_user_name', 'LIKE', "%{$strFilterKeyword}%")
          ->orwhere('td_name', 'LIKE', "%{$strFilterKeyword}%")
          ->paginate(20);       
          }else{

          $orderdata = DB::table('cs_transactions')
          ->join('cs_transaction_detail', 'cs_transactions.trans_id', '=', 'cs_transaction_detail.td_trans_id')
          ->join('cs_package', 'cs_transaction_detail.td_product_id', '=', 'cs_package.package_id')
          ->where('trans_user_name', 'LIKE', "%{$strFilterKeyword}%")
          ->orwhere('td_name', 'LIKE', "%{$strFilterKeyword}%")
          ->where('pacakge_ins_id','=',$user->user_id)
          ->paginate(20);

         }}else{
             if($user->role_type==0){
         
              $orderdata = DB::table('cs_transactions')
              ->join('cs_transaction_detail', 'cs_transactions.trans_id', '=', 'cs_transaction_detail.td_trans_id')
              ->join('cs_package', 'cs_transaction_detail.td_product_id', '=', 'cs_package.package_id')
              //->select('users.*', 'contacts.phone', 'orders.price')
              ->paginate(20);
             }else{
              $orderdata = DB::table('cs_transactions')
              ->join('cs_transaction_detail', 'cs_transactions.trans_id', '=', 'cs_transaction_detail.td_trans_id')
              ->join('cs_package', 'cs_transaction_detail.td_product_id', '=', 'cs_package.package_id')
              ->where('pacakge_ins_id','=',$user->user_id)
              ->paginate(20);
 
             }
         }    
     

    $title='Order';
    return view('Csadmin.Order.index' , compact('title','orderdata'));
  }
  
 









  public function order_detail(Request $request,$st_id)
  {
    $user=Session::get("CS_ADMIN");

      $orderdata = DB::table('cs_transactions')
      ->join('cs_student', 'cs_transactions.trans_user_id', '=', 'cs_student.student_id')
      ->where('student_id','=',$st_id)
     ->first();
    


// print_r($orderdata);

    $title='Order Detail';
    return view('Csadmin.Order.order_detail' , compact('title','orderdata'));

  }


  
  
}