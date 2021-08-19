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
use App\Http\Model\CsTransactions;
use App\Http\Model\CsTransactionsDetail;

class CartController extends Controller
{
    public function applypromo (Request $request)
    {
        $aryPostData = $request->all();
        //Configure::write('debug', 2);
        $aryResponse =array();
        if ($request->isMethod('post')) 
        {
            $data = $aryPostData;
            ///print_r($data);
            $strCurrentData =date("Y-m-d");
            $resOfferLists= DB::table('cs_offers')->whereRaw('coupon_code=\''.$data['promo_code'].'\' AND "'.$strCurrentData.'" between `offers_valid_from` and `offers_valid_to` AND offers_status=1') ->first();
            if(isset($resOfferLists->offers_id))
            {

              
                if($resOfferLists->offers_discount_type==0)
                {
                    if($resOfferLists->offers_discount_in==0)
                    {
                        
                        $aryResponse['cashback']=$resOfferLists->offers_amount;
                        $aryResponse['discount']=0;
                    }else{

                        $intPercentage = ($resOfferLists->offers_amount*$data['grandtotal'])/100;
                        $aryResponse['cashback']=$intPercentage;
                        $aryResponse['discount']=0;
                    }
                  
                }else{
                    if($resOfferLists->offers_discount_in==0)
                    {
                        
                        $aryResponse['cashback']=0;
                        $aryResponse['discount']=$resOfferLists->offers_amount;
                    }else{

                        $intPercentage = ($resOfferLists->offers_amount*$data['grandtotal'])/100;
                        $aryResponse['cashback']=0;
                        $aryResponse['discount']=$intPercentage;
                    }
                  
                }

                $aryResponse['coupon_code']=$resOfferLists->coupon_code;       
                $aryResponse['title']=$resOfferLists->offers_name;       
            $aryResponse['message']='ok';
            $aryResponse['notification']='Record Found';
            $aryResponse['results'] = $resOfferLists;

            }else{

                $aryResponse['message']='failed';
                $aryResponse['notification']='Invalid Promocode';
             }
        }else{
            $aryResponse['message']='failed';
            $aryResponse['notification']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
    }
    

    public function completetransaction(Request $request)
    {
        $aryPostData = $request->all();

   ////      Configure::write('debug', 2);
 
 
   $aryResponse =array();
        if ($request->isMethod('post')) 
        {
            $data = $aryPostData;
            $Plan=new CsTransactions;
            $Plan['trans_amt'] =$data['grand_total'];
           $Plan['trans_user_id'] =$data['student_id'];
           $Plan['trans_cashback'] =$data['cashback_amount'];
           $Plan['trans_couponcode'] =$data['coupon_code'];
           $Plan['trans_discount'] =$data['discount_amount'];
           $Plan['trans_product_discount'] =0;
           $Plan['trans_user_name'] =$data['student_first_name'];
           $Plan['trans_mobile_number'] =$data['student_phone'];
           $Plan['trans_email'] =$data['student_email'];
           $Plan['trans_payment_ref'] =$data['payment_refference'];
            $Plan->save();

        $intTtransactionId = $Plan->trans_id;
        $catrarray = json_decode($aryPostData['cart_array'],true);

 
         if(isset($catrarray))
        {
        foreach($catrarray as $key=>$label)
        {
        $data = $aryPostData;
              $Plans=new CsTransactionsDetail;

                 $Plans['td_name'] =$label['cart_title'];
                $Plans['td_product_id'] =$label['cart_id'];
                $Plans['td_image'] =$label['cart_image'];
                $Plans['td_net_price'] =$label['cart_net_price'];
                $Plans['td_selling_price'] =$label['cart_net_price'];
                $Plans['td_discount'] =$data['grand_total'];
                $Plans['td_qty'] =1;
                $Plans['td_total_amt'] =$label['cart_net_price'];
                $Plans['td_trans_id'] =$intTtransactionId;
                $Plans['td_type'] =$label['cart_type'];
                ///    $aryChildTransaction['td_activation'] =$data['grand_total'];
              ////  $aryChildTransaction['td_expiry'] =$data['grand_total'];
              $Plans->save();


        }

    } 
        $aryResponse['message']='ok';
        $aryResponse['notification']='Transaction Successfull';

        }else{
            $aryResponse['message']='failed';
            $aryResponse['notification']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
    }
    public function mypurchase (Request $request)
    {
        $aryPostData = $request->all();
        //Configure::write('debug', 2);
        $aryResponse =array();
        if ($request->isMethod('post')) 
        {
            $data = $aryPostData;
            ///print_r($data);
            $strCurrentData =date("Y-m-d");
            $resTransactionLIst = CsTransactions::where(['trans_user_id'=>$aryPostData['student_id']])->select([DB::raw('group_concat(trans_id) as total')])->first();
            if($resTransactionLIst->total!='')
            {
                $resOfferLists= CsTransactionsDetail::whereIn('td_trans_id',explode(',',$resTransactionLIst->total))->join('cs_transactions', 'td_trans_id', '=', 'trans_id')
                ->get();                   
                $aryResponse['message']='ok';
                $aryResponse['notification']='Record Found';
                $aryResponse['results'] = $resOfferLists;
                
            }else{
                $aryResponse['message']='failed';
                $aryResponse['notification']='Method Not Allowed';
            }
      
        }else{
            $aryResponse['message']='failed';
            $aryResponse['notification']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
    }
    public function myLibrary (Request $request)
    {
        $aryPostData = $request->all();
        //Configure::write('debug', 2);
        $aryResponse =array();
        if ($request->isMethod('post')) 
        {
            $data = $aryPostData;
            ///print_r($data);
            $strCurrentData =date("Y-m-d");
            $resTransactionLIst = CsTransactions::where(['trans_user_id'=>$aryPostData['student_id']])->select([DB::raw('group_concat(trans_id) as total')])->first();
            if($resTransactionLIst->total!='')
            {
                $resOfferLists= CsTransactionsDetail::whereIn('td_trans_id',explode(',',$resTransactionLIst->total))->join('cs_transactions', 'td_trans_id', '=', 'trans_id')
                ->get();     
                                $aryResponse['message']='ok';
                $aryResponse['notification']='Record Found';
                $aryResponse['results'] = $resOfferLists;
                
            }else{
                $aryResponse['message']='failed';
                $aryResponse['notification']='Method Not Allowed';
            }
      
        }else{
            $aryResponse['message']='failed';
            $aryResponse['notification']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
    }

}
