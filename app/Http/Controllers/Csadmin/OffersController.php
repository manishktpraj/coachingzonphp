<?php namespace App\Http\Controllers\Csadmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
use Session;
use App\Http\Model\Csdmin;
use App\Http\Model\Csoffers;
use Validator;

 
class OffersController extends Controller
{
  public function index(Request $request)
  { 
    $user=Session::get("CS_ADMIN");
 
     /***********************Reset Filter Session ************/
        if($request->get('reset')==1)
        {
        Session::forget('FILTER_OFFER');
        return redirect()->route('offers-promos');   
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
            Csoffers::whereIn('offers_id', $aryIds)->delete();
            return redirect()->route('offers-promos')->with('status', 'Entry Deleted Successfully');
        }
        if($intBulkAction==2)
        {
            Csoffers::whereIn('offers_id', $aryIds)->update(['offers_status' => 1]);
            return redirect()->route('offers-promos')->with('status', 'Entry Updated Successfully');
        }
        if($intBulkAction==3)
        {
            Csoffers::whereIn('offers_id',$aryIds)->update(['offers_status' => 0]);
            return redirect()->route('offers-promos')->with('status', 'Entry Updated Successfully');
        }
        endIf;
      /***********************Bulk Action ************/
     
        
           /***********************Apply Condition ************/
   
        if($request->get('filter_keyword')!='')
        {
        Session::put('FILTER_OFFER', $request->get('filter_keyword'));
        Session::save(); 
        }
           /***********************Apply Condition ************/
   
        if(session()->has('FILTER_OFFER')){
        $strFilterKeyword = Session::get('FILTER_OFFER');
        if($user->role_type==0){
          $resOfferLists = Csoffers::where('coupon_code', 'LIKE', "%{$strFilterKeyword}%")->paginate(20);
        }else{
          $resOfferLists = Csoffers::where('coupon_code', 'LIKE', "%{$strFilterKeyword}%")->where('offer_institute','=',$user->user_id)->paginate(20);
          }}else{
              if($user->role_type==0){
                $resOfferLists = Csoffers::leftJoin('cs_institute', function($join) {
                  $join->on('cs_offers.offer_institute', '=', 'cs_institute.ins_id');
                })
                ->paginate();;
              }else{
                $resOfferLists = Csoffers::leftJoin('cs_institute', function($join) {
                  $join->on('cs_offers.offer_institute', '=', 'cs_institute.ins_id');
                })
                ->where('offer_institute','=',$user->user_id)->paginate(20);
  
              }
          }    
            
    $title='Offers';
    return view('Csadmin.Offers.index',compact('title','resOfferLists','user'));
  }
  
    //************************************ Offers Add and update Function *********************************************// 
  
  public function alloffersShow($intid=0)
  {
    $user=Session::get("CS_ADMIN");

       $resOfferData = array();
        if($intid>0){

          if($user->role_type==0){
            $resOfferData = Csoffers::where('offers_id','=',$intid)->first();
        }else{
          $resOfferData = Csoffers::where('offers_id','=',$intid)->where('offer_institute','=',$user->user_id)->first();

            }
        }
        
        
        
       $title='Add New Offer';
    return view('Csadmin.Offers.addoffers',compact('title','resOfferData'));
     
  } 
  //
   
  
    public function offerprocessrequest(Request $request)
    {
      $user=Session::get("CS_ADMIN");
      $a=$user->user_id;
     // print_r($user);die;
        $aryPostData = $request->all();
        if(isset($aryPostData['offers_id'])  &&  $aryPostData['offers_id']>0)
        {
            $data = Csoffers::where('offers_id','=',$aryPostData['offers_id'])->first();   
        }else{
            $data = new Csoffers();   
            $data->offer_institute= $a;

        }
       // echo "<pre>";
        //echo $a;die;
        //$data = new Csoffers();  
       
        $data->offers_name = $request['offers_name'];
        $data->coupon_code = $request['coupon_code'];
        $data->offers_valid_from = $request['offers_valid_from'];
        $data->offers_valid_to = $request['offers_valid_to'];
        $data->offers_discount_type = $request['offers_discount_type'];
        $data->offers_discount_in = $request['offers_discount_in'];
        $data->offers_amount= $request['offers_amount'];
        $data->description=$request['description'];
        $data->usage_limit=$request['usage_limit'];
        $data->usage_user_limit=$request['usage_user_limit'];
        $data->minimum_purchase=$request['minimum_purchase'];
        $data->offer_terms_condition=$request['offer_terms_condition'];
        $data->offers_max_amount=$request['offers_max_amount'];
        
        if($data->save()){
            return redirect(Route('offers-promos'));
        }else{
            return redirect(Route('offers-promos'));
        }
    }
 
  //************************************ Shikha *********************************************// 

     public function offersStatus($offers_id)
    {
        $rowCategoryData = Csoffers::where('offers_id',$offers_id)->first();
       // print_r($rowCategoryData);die;
        if($rowCategoryData->offers_status==1){
            $status = 0;
        }else{
            $status = 1;
        }
        Csoffers::where('offers_id', $offers_id)->update(array('offers_status' => $status));
         return redirect()->route('offers-promos')->with('status', 'Status updated successfully');
    }
    
    
    
     public function deleteoffer($offers_id)
    {
        Csoffers::where('offers_id', $offers_id)->delete();
        return redirect()->route('offers-promos')->with('status', 'Entry Deleted Successfully');
    }
 
  //************************************ Shikha *********************************************// 

}