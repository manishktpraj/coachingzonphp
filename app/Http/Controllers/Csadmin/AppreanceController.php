<?php namespace App\Http\Controllers\Csadmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
use Session;
use App\Http\Model\Csdmin;

use App\Http\Model\CsSlider;
use Illuminate\Support\Str;
use Validator;

class AppreanceController extends Controller
{
  public function index()
  {
    $user=Session::get("CS_ADMIN");

    // if($user->role_type==0){
         $resSliderData = CsSlider::paginate(20);
    //         }else{
           //     $resSliderData = CsSlider::where('test_institute','=',$user->user_id)->paginate(20);

          //  }
         // print_r($resSliderData);
    $title='Slider';
    return view('Csadmin.Appreance.index',compact('title','resSliderData'));
  }
  public function addnewslider($sliderid=0)
  {
    

    $resSliderData = array();
    if($sliderid>0){
        $resSliderData = CsSlider::where('slider_id','=',$sliderid)->first();
    }
    

    $title='Add New Slider';
    return view('Csadmin.Appreance.addnewslider',compact('title','resSliderData'));
 }


 function sliderProccess(Request $request)
 {
     $user=Session::get("CS_ADMIN");
     
     
     $aryPostData = $request->all();
    // print_r($aryPostData);die;
     if(isset($aryPostData['slider_id']) && $aryPostData['slider_id']>0)
     {
         $postobj = CsSlider::where('slider_id',$aryPostData['slider_id'])->first();
     }else{
         $postobj = new CsSlider;
     }   
     
     $postobj->slider_order = 1;
     $postobj->slider_link = $aryPostData['slider_link'];
     $postobj->slider_status = 1;
     $postobj->slider_title = $aryPostData['slider_title'];
     $postobj->slider_type = $aryPostData['slider_type'];
     $postobj->slider_institute = $user->user_id;

    
     if($request->hasFile('slider_image'))
     {
         $image = $request->file('slider_image');
         $name = time().'.'.$image->getClientOriginalExtension();
         $destinationPath = SITE_UPLOAD_PATH.SITE_SLIDER_IMAGE;
         $image->move($destinationPath, $name);
         $postobj->slider_image = $name;
     } 
     
     if($postobj->save())    
     {
         return redirect()->route('slider')->with('status', 'Entry Saved Successfully.');   
     }else{
         return redirect()->route('slider')->with('error', 'Server Not Responed');
     }
 }
 public function sliderDelete($intCategoryId)
 {
    CsSlider::where('slider_id', $intCategoryId)->delete();
     return redirect()->route('slider')->with('status', 'Entry Deleted Successfully');
 }
 public function sliderStatus($intCategoryId)
 {
     $rowCategoryData = CsSlider::where('slider_id',$intCategoryId)->first();
    // print_r($rowCategoryData);die;
     if($rowCategoryData->slider_status==1){
         $status = 0;
     }else{
         $status = 1;
     }
     CsSlider::where('slider_id', $intCategoryId)->update(array('slider_status' => $status));
     return redirect()->route('slider')->with('status', 'Entry Edited Successfully');
 }
}


