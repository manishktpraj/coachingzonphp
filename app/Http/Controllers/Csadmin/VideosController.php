<?php namespace App\Http\Controllers\Csadmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
use Session;
use App\Http\Model\CsVcategory;
use App\Http\Model\CsVideo;
use App\Http\Model\CsPackageDetail;

use Validator;
use Illuminate\Support\Str;

class VideosController extends Controller
{
  public function index(Request $request)
  {
    $user=Session::get("CS_ADMIN");

     /***********************Reset Filter Session ************/
        if($request->get('reset')==1)
        {
        Session::forget('FILTER_VIDEO');
        return redirect()->route('all-videos');   
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
            CsVideo::whereIn('video_id', $aryIds)->delete();
            return redirect()->route('all-videos')->with('status', 'Entry Deleted Successfully');
        }
        if($intBulkAction==2)
        {
            CsVideo::whereIn('video_id', $aryIds)->update(['video_status' => 1]);
            return redirect()->route('all-videos')->with('status', 'Entry Updated Successfully');
        }
        if($intBulkAction==3)
        {
            CsVideo::whereIn('video_id',$aryIds)->update(['video_status' => 0]);
            return redirect()->route('all-videos')->with('status', 'Entry Updated Successfully');
        }
        endIf;
      /***********************Bulk Action ************/
     
        
           /***********************Apply Condition ************/
   
        if($request->get('filter_keyword')!='')
        {
        Session::put('FILTER_VIDEO', $request->get('filter_keyword'));
        Session::save(); 
        }
           /***********************Apply Condition ************/
   
        if(session()->has('FILTER_VIDEO')){
        $strFilterKeyword = Session::get('FILTER_VIDEO');
        if($user->role_type==0){
            $resVideoData = CsVideo::where('video_name', 'LIKE', "%{$strFilterKeyword}%")->paginate(20);
        }else{
            $resVideoData = CsVideo::where('video_name', 'LIKE', "%{$strFilterKeyword}%")->where('video_institute','=',$user->user_id)->paginate(20);
            }}else{
                if($user->role_type==0){
                    $resVideoData = CsVideo::leftJoin('cs_institute', function($join) {
                        $join->on('cs_video.video_institute', '=', 'cs_institute.ins_id');
                      })
                      ->paginate();
                }else{
                    $resVideoData = CsVideo::leftJoin('cs_institute', function($join) {
                        $join->on('cs_video.video_institute', '=', 'cs_institute.ins_id');
                      })
                      ->where('video_institute','=',$user->user_id)->paginate(20);
    
                }
            }
    //$resVideoData = CsVideo::paginate(20);
    $resCategoryData = CsVcategory::get();
    $title='Videos';
    return view('Csadmin.Videos.index',compact('title','resVideoData','resCategoryData','user'));
  
  }

   public function addNewVideo($intVideoId=0)
  {
    $user=Session::get("CS_ADMIN");
       $resVideoData = array();
        if($intVideoId>0){
            if($user->role_type==0){
                $resVideoData = CsVideo::where('video_id','=',$intVideoId)->first();
            }else{
                $resVideoData = CsVideo::where('video_id','=',$intVideoId)->where('video_institute','=',$user->user_id)->first();
    
                }
        }
        $strCategory =array();
        if(isset($resVideoData->video_vc_id))
        {
            $strCategory = explode(',',$resVideoData->video_vc_id);
        }
      
      $resCategoryData = CsVcategory::get();
      $aryCategoryList = $this->buildTree($resCategoryData,0);
      
      $strCategoryTreeStructure =$this->genrateHtml($aryCategoryList,0,$strCategory);

    $title='Add New Video';
    return view('Csadmin.Videos.addNewVideo' ,compact('title','resCategoryData','aryCategoryList','strCategoryTreeStructure','strCategory','resVideoData'));
  }
  
  
  
   function videoProccess(Request $request)
    {   
         $user=Session::get("CS_ADMIN");

        $aryPostData = $request->all();
       // print_r($aryPostData);die;
        if(isset($aryPostData['video_id']) && $aryPostData['video_id']>0)
        {
            $postobj = CsVideo::where('video_id',$aryPostData['video_id'])->first();
        }else{
            $postobj = new CsVideo;
            $postobj->video_slug = Str::slug($aryPostData['video_name'], '-');
            $postobj->video_institute=$user->user_id;

        }   
        $postobj->video_status = 1;
        $postobj->video_name = $aryPostData['video_name'];
        $postobj->video_desc = $aryPostData['video_desc'];
        $postobj->video_type = $aryPostData['video_type'];
        $postobj->video_start_date = $aryPostData['video_start_date'];
        $postobj->video_size = $aryPostData['video_size'];
        $postobj->video_duration = $aryPostData['video_duration'];
        $postobj->video_start_time = $aryPostData['video_start_time'];
        $postobj->video_configuration = $aryPostData['video_configuration'];
        $postobj->video_url = $aryPostData['video_url'];
        $postobj->pdf_url = $aryPostData['pdf_url'];
        
        if(isset($aryPostData['video_vc_id_']) && count($aryPostData['video_vc_id_'])>0)
        {
            $aryPostData['video_vc_id_'] = array_unique($aryPostData['video_vc_id_']);
            $postobj->video_vc_id = implode(',',$aryPostData['video_vc_id_']);
            $resCategoryName = CsVcategory::whereIn('vc_id',$aryPostData['video_vc_id_'])->get(); 
            //print_r($resCategoryName);die;
            $catName = array();
            foreach($resCategoryName as $values){
            $catName[] = $values->vc_name;
            }
            $postobj->video_vc_name  = implode(', ',$catName);
            /*echo '<pre>';
            print_r($resCategoryName);die;*/
            //$postobj->sm_sc_name  = implode(', ',$resCategoryName['sc_name']);
        }else{
            $postobj->video_vc_name = '';
            $postobj->video_vc_id = '';
        }
        
        if($request->hasFile('video_image_'))
        {
            $image = $request->file('video_image_');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = SITE_UPLOAD_PATH.SITE_VIDEO_IMAGE;
            $image->move($destinationPath, $name);
            $postobj->video_image = $name;
        } 
        if($request->hasFile('video_file_'))
        {
            $image = $request->file('video_file_');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = SITE_UPLOAD_PATH.SITE_VIDEO_IMAGE;
            $image->move($destinationPath, $name);
            $postobj->video_file = $name;
        } 
        
        
        if($postobj->save())    
        {
            return redirect()->route('all-videos')->with('status', 'Entry Saved Successfully.');   
        }else{
            return redirect()->route('all-videos')->with('error', 'Server Not Responed');
        }
    }
     
    public function videoStatus($intCategoryId)
    {
        $rowCategoryData = CsVideo::where('video_id',$intCategoryId)->first();
       // print_r($rowCategoryData);die;
        if($rowCategoryData->video_status==1){
            $status = 0;
        }else{
            $status = 1;
        }
        CsVideo::where('video_id', $intCategoryId)->update(array('video_status' => $status));
        return redirect()->route('all-videos')->with('status', 'Entry Edited Successfully');
    }
    
    public function videoDelete($intCategoryId)
    {
        CsVideo::where('video_id', $intCategoryId)->delete();
        return redirect()->route('all-videos')->with('status', 'Entry Deleted Successfully');
    }
  
  
  
    public function videoCategory(Request $request,$intCategoryId=0)
    {
         //echo $int;  
     /***********************Reset Filter Session ************/
     if($request->get('reset')==1)
     {
     Session::forget('FILTER_VIDEO_CATEGORY');
     return redirect()->route('video-category');   
     }
  /***********************Reset Filter Session ************/
  
  /***********************Bulk Action ************/
    $aryPostData = $request->all();
    //print_r($aryPostData);
    if(isset($aryPostData['bulkvalue']) && $aryPostData['bulkvalue']!=''):
       $aryPostData =$_POST;
      $aryIds = explode(',',$aryPostData['bulkvalue']);
     $intBulkAction = $aryPostData['bulkaction'];
 
     if($intBulkAction==1)
     {
        CsVcategory::whereIn('vc_id', $aryIds)->delete();
         return redirect()->route('video-category')->with('status', 'Entry Deleted Successfully');
     }
     if($intBulkAction==2)
     {
        CsVcategory::whereIn('vc_id', $aryIds)->update(['vc_status' => 1]);
         return redirect()->route('video-category')->with('status', 'Entry Updated Successfully');
     }
     if($intBulkAction==3)
     {
        CsVcategory::whereIn('vc_id',$aryIds)->update(['vc_status' => 0]);
         return redirect()->route('video-category')->with('status', 'Entry Updated Successfully');
     }
     endIf;
   /***********************Bulk Action ************/
  
     
        /***********************Apply Condition ************/

        if($request->get('filter_keyword')!='')
        {
  
        Session::put('FILTER_VIDEO_CATEGORY', $request->get('filter_keyword'));
        Session::save(); 
 
 
        }
        /***********************Apply Condition ************/

     if(session()->has('FILTER_VIDEO_CATEGORY')){
     $strFilterKeyword = Session::get('FILTER_VIDEO_CATEGORY');
     $resCategoryData = CsVcategory::where('vc_name', 'LIKE', "%{$strFilterKeyword}%")->paginate(20);
     }else{
        $resCategoryData = CsVcategory::orderBy('vc_order', 'ASC')->get();
     }    
        $intSelectParent =0;
        $rowCategoryData=array();
        if($intCategoryId>0)
        {
            $rowCategoryData = CsVcategory::where('vc_id',$intCategoryId)->first();
            $intSelectParent = $rowCategoryData->vc_parent;
        }
        $tree = $this->buildTree($resCategoryData);
        $strCategoryHtml = $this->getCatgoryChildHtml($tree);
        $resChildCategory = CsVcategory::get();
        
        //$resParentCategoryList = CsVcategory::find('all',array('order'=>array('category_id DESC')))->where(['category_parent'=>0]);

        
        //$resParentCategoryList = CsVcategory::select('vc_id')->where('vc_parent', 0)->get();
        //print_r($resParentCategoryList);
        $resCategoryListData =CsVcategory::get();
        $tree = $this->buildTree($resCategoryListData);
        $strEntryHtml = $this->getCatgoryEntryChildHtml($tree,'',0,$intSelectParent);
        
        //print_r($strEntryHtml);
        
        
        $title='Video Category';
        return view('Csadmin.Videos.videoCategory',compact('title','resCategoryData','rowCategoryData','strCategoryHtml','resChildCategory','strEntryHtml'));
    }
    
    function genrateHtml($aryCategoryTree,$intLevel=0,$strSelectCategory=array()){
        $strHtml='';
        foreach($aryCategoryTree as $key=>$label){
            if($label->vc_parent==0){
                $intLevel=0;
            }
            $strChecked='';
            $strExtraChecked ='';
            if(in_array($label->vc_id,$strSelectCategory)){
                $strChecked = 'checked="checked"';
                $strExtraChecked ='checked';
            }
            $margin =$intLevel*20;
            $strLevelByMargin = 'margin-left:'.$margin.'px;';
            $strHtml .= '<label class="cch-check" style="'.$strLevelByMargin.'">'.$label->vc_name.'
            <input type="checkbox" name="video_vc_id_[]" value="'.$label->vc_id.'" '.$strChecked.' class="clsSelectSingle"><span class="checkmark"></span>
            </label>';
            if(isset($label->children)){
                $intLevel++;
                $strHtml .=$this->genrateHtml($label->children,$intLevel,$strSelectCategory);
            }
        }
        //print_r($strHtml);
        return $strHtml;
    }
    
    
    function buildTree($elements, $parentId = 0) 
    {
        $branch = array();
        foreach ($elements as $element) {
             
            if ($element['vc_parent'] == $parentId) {
                $children = $this->buildTree($elements, $element['vc_id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            } 
        }
        return $branch;
    }
    
    
    function getCatgoryChildHtml($tree,$strExtraHtml='',$intLevel=0){
            
            $strHtml=$strExtraHtml;
            if(count($tree)>0){
            foreach($tree as $key=>$label){

                $strStyle ='';
                if($label['vc_parent']==0){
                    $intLevel=0;
                }else{
                  $intLevel = self::getcategorylevel($label);
                }
               
                $strExtraData = '';
                
                for($i=0;$i<$intLevel;$i++){
                    $strExtraData .='<i data-feather="minus"></i>';
                }
                
                $src = ($label['vc_image']!="")?SITE_UPLOAD_URL.SITE_VIDEO_IMAGE.$label['vc_image']:SITE_NO_IMAGE_PATH;
                $strHtml .='<tr>
                                <td scope="row" style="text-align:center;vertical-align: middle;"><input type="checkbox" id="selectAll" class="clsSelectSingle" name="vc_id[]" value="'.$label['vc_id'].'">
                            </td>';
                $strHtml .='<td style="text-align:center">
                                <div class="media align-items-center mg-b-0">
                                    <div class="avatar" style="margin: 0 auto;border:1px solid #ddd;">
                                        <img src="'.$src.'" class="rounded" alt="">
                                    </div>
                                </div>
                            </td>';  
                $strHtml .='<td><p class="mg-b-0 tx-medium">'.$strExtraData.$label['vc_name'].'</p></td>'; 
                //print_r($strExtraData).$label['vc_name'];
                if($label['vc_status']==0){
                    $strHtml .='<td><a href="'.ADMIN_URL.'changeStatusVCategory/'.$label['vc_id'].'" onclick="return confirm(\'Are you sure?\')"><span class="badge badge-danger">Inactive</span></a></td>';
                }else{
                    $strHtml .='<td><a href="'.ADMIN_URL.'changeStatusVCategory/'.$label['vc_id'].'" onclick="return confirm(\'Are you sure?\')"><span class="badge badge-success">Active</span></a></td>';
                }
                $orederData = CsVideo::where('video_vc_id','=',$label['vc_id'])->count();
                
                $strHtml .='<td style="text-align:center">'.$orederData.'</td>';
                if($label['vc_id']==32)
                {                $strHtml .='<td colspan="1" style="text-align:center"></td>';
}else
                {
                $strHtml .='<td>
                                <div class="d-flex align-self-center justify-content-center">
                                    <nav class="nav nav-icon-only">
                                        <a href="'.ADMIN_URL.'video-category/'.$label['vc_id'].'" onclick="return confirm(\'Are you sure?\')" class="btn btn-primary btn-icon mg-r-5" title="Edit" style="padding:0px 5px;"><i class="fas fa-pencil-alt" style="font-size:11px;"></i></a>
                                        <a href="'.ADMIN_URL.'deleteVCategory/'.$label['vc_id'].'" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-icon mg-r-5" title="Delete" style="padding:0px 5px;"><i class="fas fa-trash-alt" style="font-size:11px;"></i></a>
                                    </nav>
                                </div>
                            </td>';}
                if(isset($label->children)){
                    $intLevel++;
                    $strHtml =$this->getCatgoryChildHtml($label->children,$strHtml,$intLevel);
                }
            } } else{
                $strHtml = '<td colspan="6" style="text-align:center">No Result Found</td>';
            } 
            
            return $strHtml;
            exit();     
        }
    
  
    
    function getcategorylevel($aryCategory)
    {
        if($aryCategory['vc_parent']==0)
        {
            return 0;
        }else{
          $res = CsVcategory::where('vc_id','=',$aryCategory['vc_parent'])->first();
            if($res->vc_parent==0)
            {
                return 1;
            }else{
               return 2; 
            }
        }
    }
    
    function videoCategoryProccess(Request $request)
    {
        $aryPostData = $request->all();
        //print_r($aryPostData);die;
        if(isset($aryPostData['vc_id']) && $aryPostData['vc_id']>0)
        {
            $postobj = CsVcategory::where('vc_id',$aryPostData['vc_id'])->first();
        }else{
            $postobj = new CsVcategory;
            $postobj->vc_slug = Str::slug($aryPostData['vc_name'], '-');
        }   
        if($aryPostData['vc_order']==''){
            
          $max=CsVcategory::max('vc_order');
          $postobj->vc_order = $max+1;
            
        }else{
          $postobj->vc_order = $aryPostData['vc_order'];

        }
        $postobj->vc_status = 1;
        $postobj->vc_name = $aryPostData['vc_name'];
       // $postobj->vc_order = $aryPostData['vc_order'];
        $postobj->vc_parent = $aryPostData['vc_parent'];
        if($request->hasFile('vc_image_'))
        {
            $image = $request->file('vc_image_');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = SITE_UPLOAD_PATH.SITE_VIDEO_IMAGE;
            $image->move($destinationPath, $name);
            $postobj->vc_image = $name;
        } 
        
        if($postobj->save())    
        {
            return redirect()->route('video-category')->with('status', 'Entry Saved Successfully.');   
        }else{
            return redirect()->route('video-category')->with('error', 'Server Not Responed');
        }
    }
    
    public function changeStatusVCategory($intCategoryId)
    {
        $rowCategoryData = CsVcategory::where('vc_id',$intCategoryId)->first();
        if($rowCategoryData->vc_status==0){
            $status = 1;
        }else{
            $status = 0;
        }
        CsVcategory::where('vc_id', $intCategoryId)->update(array('vc_status' => $status));
        return redirect()->route('video-category')->with('status', 'Entry Edited Successfully');
    }
 
    public function deleteVCategory($intCategoryId)
    {   CsVcategory::where('vc_parent', $intCategoryId)->update(array('vc_parent' => 0));

        CsVcategory::where('vc_id', $intCategoryId)->delete();
        CsPackageDetail::where('pkd_ref', $intCategoryId)->delete();

        return redirect()->route('video-category')->with('status', 'Entry Deleted Successfully');
    }
    
   
    function genrateCatHtml($aryCategoryTree,$intLevel=0,$strSelectCategory=array()){
        $strHtml='';
        foreach($aryCategoryTree as $key=>$label){
            if($label->vc_parent==0){
                $intLevel=0;
            }
            $strChecked='';
            $strExtraChecked ='';
            $margin =$intLevel*20;
            $strLevelByMargin = 'margin-left:'.$margin.'px;';
            $strHtml .= '
           
            
            <label class="cch-check" style="'.$strLevelByMargin.'">'.$label->vc_name.'
            </label>';
            if(isset($label->children)){
                $intLevel++;
                $strHtml .=$this->genrateHtml($label->children,$intLevel,$strSelectCategory);
            }
        }
        //print_r($strHtml);
        return $strHtml;
    }
   
   
   function getCatgoryEntryChildHtml($tree,$strExtraHtml='',$intLevel=0,$intSelectParent)
  {
     //echo $intSelectParent; die;
     $strHtml=$strExtraHtml;
   $intExtraLevel = $intLevel;

          foreach($tree as $key=>$label)
          {
               $strStyle='';
              if($label['vc_parent']!=0)
              {
              $strStyle=' style="background:#eaeaea"';
             
              }
               if($label['vc_parent']==0)
              {
                   $intLevel=0;
              }
              $strExtraData = '';
              for($i=0;$i<$intLevel;$i++)
              {
                   $strExtraData .='-';
              }
             $strselect ='';
             if($label['vc_id']==$intSelectParent)
             {
                 //echo "hii"; die;
                 $strselect ='selected="selected"';
             }
            $strHtml .='<option '.$strselect.' value="'.$label['vc_id'].'">'.$strExtraData.$label['vc_name'].'</option>';


if(isset($label->children) && $intLevel!=2)
{
    //pr($label->children);
    //pr($label['children']);
$intLevel++;
     $strHtml =$this->getCatgoryEntryChildHtml($label->children,$strHtml,$intLevel,$intSelectParent);
      $intLevel = $intExtraLevel;

}
   }
   
   return $strHtml;
       exit();
  }
  
 
}