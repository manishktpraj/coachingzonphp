<?php namespace App\Http\Controllers\Csadmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
use Session;
use App\Http\Model\Csdmin;
use App\Http\Model\CsPcategory;
use App\Http\Model\CsStaff;
use App\Http\Model\CsPackage;
use App\Http\Model\CsAssignedPackage;
use App\Http\Model\CsPackageDetail;
use App\Http\Model\CsVcategory;
use App\Http\Model\CsVideo;
use App\Http\Model\CsTest;
use App\Http\Model\CsTcategory;
use App\Http\Model\CsScategory;


use App\Http\Model\CsStudyMaterial;


use Illuminate\Support\Str;
use Validator;

class PackagesController extends Controller
{

  public function index(Request $request)
  {
    $user=Session::get("CS_ADMIN");
   //print_r($user);
      
     /***********************Reset Filter Session ************/
        if($request->get('reset')==1)
        {
        Session::forget('FILTER_PACKAGE');
        return redirect()->route('all-packages');   
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
            CsPackage::whereIn('package_id', $aryIds)->delete();
            return redirect()->route('all-packages')->with('status', 'Entry Deleted Successfully');
        }
        if($intBulkAction==2)
        {
            CsPackage::whereIn('package_id', $aryIds)->update(['package_status' => 1]);
            return redirect()->route('all-packages')->with('status', 'Entry Updated Successfully');
        }
        if($intBulkAction==3)
        {
            CsPackage::whereIn('package_id',$aryIds)->update(['package_status' => 0]);
            return redirect()->route('all-packages')->with('status', 'Entry Updated Successfully');
        }
        endIf;
      /***********************Bulk Action ************/
     
        
           /***********************Apply Condition ************/
   
        if($request->get('filter_keyword')!='')
        {
        Session::put('FILTER_PACKAGE', $request->get('filter_keyword'));
        Session::save(); 
        }
           /***********************Apply Condition ************/
   
        if(session()->has('FILTER_PACKAGE')){
        $strFilterKeyword = Session::get('FILTER_PACKAGE');
            if($user->role_type==0){
                $resPackageData = CsPackage::where('package_name', 'LIKE', "%{$strFilterKeyword}%")->paginate(20);
            }else{

        $resPackageData = CsPackage::where('package_name', 'LIKE', "%{$strFilterKeyword}%")->where('pacakge_ins_id','=',$user->user_id)->paginate(20);
        //print_r($resVideoData);
        }}else{
            if($user->role_type==0){
                $resPackageData = CsPackage::leftJoin('cs_institute', function($join) {
                    $join->on('cs_package.pacakge_ins_id', '=', 'cs_institute.ins_id');
                  })
                  ->paginate();
            }else{
        $resPackageData = CsPackage::leftJoin('cs_institute', function($join) {
            $join->on('cs_package.pacakge_ins_id', '=', 'cs_institute.ins_id');
          })
          ->where('pacakge_ins_id','=',$user->user_id)->paginate(20);
  }}    
     //print_r($resPackageData);
    $resCategoryData = CsPcategory::get(); 
    $title='Packages';
    return view('Csadmin.Packages.index',compact('title','resPackageData','resCategoryData','user'));
  }
  
  public function addNewPackage($intPackageId=0)
  {
    $user=Session::get("CS_ADMIN");

       $resPackageData = array();
        if($intPackageId>0){
            if($user->role_type==0){
            $resPackageData = CsPackage::where('package_id','=',$intPackageId)->first();
            }else{
            $resPackageData = CsPackage::where('package_id','=',$intPackageId)->where('pacakge_ins_id','=',$user->user_id)->first();

            }
        }
        $strCategory =array();
        if(isset($resPackageData->package_pc_id))
        {
            $strCategory = explode(',',$resPackageData->package_pc_id);
        }
      
      $resCategoryData = CsPcategory::get();
      $aryCategoryList = $this->buildTree($resCategoryData,0);
      $strCategoryTreeStructure =$this->genrateHtml($aryCategoryList,0,$strCategory);

    $title='Add New Package';
    return view('Csadmin.Packages.addNewPackage' ,compact('title','resCategoryData','aryCategoryList','strCategoryTreeStructure','strCategory','resPackageData'));
  }
  
  
  function genrateHtml($aryCategoryTree,$intLevel=0,$strSelectCategory=array()){
        $strHtml='';
        foreach($aryCategoryTree as $key=>$label){
            if($label->pc_parent==0){
                $intLevel=0;
            }
            $strChecked='';
            $strExtraChecked ='';
            if(in_array($label->pc_id,$strSelectCategory)){
                $strChecked = 'checked="checked"';
                $strExtraChecked ='checked';
            }
            $margin =$intLevel*20;
            $strLevelByMargin = 'margin-left:'.$margin.'px;';
            $strHtml .= '<label class="cch-check" style="'.$strLevelByMargin.'">'.$label->pc_name.'
            <input type="checkbox" name="package_pc_id_[]" value="'.$label->pc_id.'" '.$strChecked.' class="clsSelectSingle"><span class="checkmark"></span>
            </label>';
            if(isset($label->children)){
                $intLevel++;
                $strHtml .=$this->genrateHtml($label->children,$intLevel,$strSelectCategory);
            }
        }
        //print_r($strHtml);
        return $strHtml;
    }
    function packageProccess(Request $request)
    {
        $user=Session::get("CS_ADMIN");
        
        
        $aryPostData = $request->all();
        // print_r($aryPostData);die;
        if(isset($aryPostData['package_id']) && $aryPostData['package_id']>0)
        {
            $postobj = CsPackage::where('package_id',$aryPostData['package_id'])->first();
        }else{
            $postobj = new CsPackage;
            $postobj->package_slug = Str::slug($aryPostData['package_name'], '-');
            $postobj->pacakge_ins_id = $user['user_id'];
            $postobj->pacakge_ins_name = $user['staff_name'];


        }   
        
        $postobj->package_status = 1;
        $postobj->package_name = $aryPostData['package_name'];
        $postobj->package_sub_title = $aryPostData['package_sub_title'];
        $postobj->package_desc = $aryPostData['package_desc'];
        $postobj->package_type = $aryPostData['package_type'];
        $postobj->package_mrp = $aryPostData['package_mrp'];
        $postobj->package_selling_price = $aryPostData['package_selling_price'];
        $postobj->package_discount = $aryPostData['package_discount'];
        $postobj->package_validity = $aryPostData['package_validity'];

        
        if(isset($aryPostData['package_pc_id_']) && count($aryPostData['package_pc_id_'])>0)
        {
            $aryPostData['package_pc_id_'] = array_unique($aryPostData['package_pc_id_']);
            $postobj->package_pc_id = implode(',',$aryPostData['package_pc_id_']);
            $resCategoryName = CsPcategory::whereIn('pc_id',$aryPostData['package_pc_id_'])->get(); 
            //print_r($resCategoryName);die;
            $catName = array();
            foreach($resCategoryName as $values){
            $catName[] = $values->pc_name;
            }
            $postobj->package_pc_name  = implode(', ',$catName);
            }else{
            $postobj->package_pc_name = '';
            $postobj->package_pc_packageid = '';
        }
        if($request->hasFile('package_image_'))
        {
            $image = $request->file('package_image_');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = SITE_UPLOAD_PATH.SITE_PACKAGE_IMAGE;
            $image->move($destinationPath, $name);
            $postobj->package_image = $name;
        } 
       if($request->hasFile('package_file_'))
        {
            $image = $request->file('package_file_');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = SITE_UPLOAD_PATH.SITE_PACKAGE_IMAGE;
            $image->move($destinationPath, $name);
            $postobj->package_file = $name;
        } 
        
        if($postobj->save())    
        {
            return redirect()->route('all-packages')->with('status', 'Entry Saved Successfully.');   
        }else{
            return redirect()->route('all-packages')->with('error', 'Server Not Responed');
        }
    }
    
    public function packageDelete($intCategoryId)
    {
        CsPackage::where('package_id', $intCategoryId)->delete();
        return redirect()->route('all-packages')->with('status', 'Entry Deleted Successfully');
    }
  
  public function packageStatus($intCategoryId)
    {
        $rowCategoryData = CsPackage::where('package_id',$intCategoryId)->first();
       // print_r($rowCategoryData);die;
        if($rowCategoryData->package_status==1){
            $status = 0;
        }else{
            $status = 1;
        }
        CsPackage::where('package_id', $intCategoryId)->update(array('package_status' => $status));
        return redirect()->route('all-packages')->with('status', 'Entry Edited Successfully');
    }
  
  
public function categoryPackage(Request $request,$intCategoryId=0)
    {
 //echo $int;  
     /***********************Reset Filter Session ************/
     if($request->get('reset')==1)
     {
     Session::forget('FILTER_PACKAGE_CATEGORY');
     return redirect()->route('package-category');   
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
        CsPcategory::whereIn('pc_id', $aryIds)->delete();
         return redirect()->route('package-category')->with('status', 'Entry Deleted Successfully');
     }
     if($intBulkAction==2)
     {
        CsPcategory::whereIn('pc_id', $aryIds)->update(['pc_status' => 1]);
         return redirect()->route('package-category')->with('status', 'Entry Updated Successfully');
     }
     if($intBulkAction==3)
     {
        CsPcategory::whereIn('pc_id',$aryIds)->update(['pc_status' => 0]);
         return redirect()->route('package-category')->with('status', 'Entry Updated Successfully');
     }
     endIf;
   /***********************Bulk Action ************/
  
     
        /***********************Apply Condition ************/

        if($request->get('filter_keyword')!='')
        {
  
        Session::put('FILTER_PACKAGE_CATEGORY', $request->get('filter_keyword'));
        Session::save(); 
 
 
        }
        /***********************Apply Condition ************/

     if(session()->has('FILTER_PACKAGE_CATEGORY')){
     $strFilterKeyword = Session::get('FILTER_PACKAGE_CATEGORY');
     $resCategoryData = CsPcategory::where('pc_name', 'LIKE', "%{$strFilterKeyword}%")->paginate(20);
     }else{
        $resCategoryData = CsPcategory::orderBy('pc_order', 'ASC')->get();
     }    
        $intSelectParent=0;
        $rowCategoryData=array();
        if($intCategoryId>0)
        {
            $rowCategoryData = CsPcategory::where('pc_id',$intCategoryId)->first();
            $intSelectParent = $rowCategoryData->pc_parent;
        }
        $tree = $this->buildTree($resCategoryData);
        $strCategoryHtml = $this->getCatgoryChildHtml($tree);
        $resChildCategory = CsPcategory::get();
        
        
       // $intSelectParent = CsPcategory::select('pc_parent')->get();
        
        $resCategoryListData =CsPcategory::get();
        $tree = $this->buildTree($resCategoryListData);
        $strEntryHtml = $this->getCatgoryEntryChildHtml($tree,'',0,$intSelectParent);
        
        
        
        $title='Package Category';
        return view('Csadmin.Packages.categoryPackage',compact('title','resCategoryData','rowCategoryData','strCategoryHtml','resChildCategory','strEntryHtml'));
    }
    
    function buildTree($elements, $parentId = 0) 
    {
        $branch = array();
        foreach ($elements as $element) {
             
            if ($element['pc_parent'] == $parentId) {
                $children = $this->buildTree($elements, $element['pc_id']);
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
                if($label['pc_parent']==0){
                    $intLevel=0;
                }else{
                  $intLevel = self::getcategorylevel($label);
                }
               
                $strExtraData = '';
                
                for($i=0;$i<$intLevel;$i++){
                    $strExtraData .='<i data-feather="minus"></i>';
                }
                $src = ($label['pc_image']!="")?SITE_UPLOAD_URL.SITE_PACKAGE_IMAGE.$label['pc_image']:SITE_NO_IMAGE_PATH;
                $strHtml .='<tr>
                <td scope="row" style="text-align:center;vertical-align: middle;"><input type="checkbox" id="selectAll" class="clsSelectSingle" name="pc_id[]" value="'.$label['pc_id'].'"></td>';
                $strHtml .='<td style="text-align:center">
                                <div class="media align-items-center mg-b-0">
                                    <div class="avatar" style="margin:0 auto">
                                        <img src="'.$src.'" class="rounded-circle" alt="">
                                    </div>
                                </div>
                            </td>';  
                $strHtml .='<td><p class="mg-b-0 tx-medium">'.$strExtraData.$label['pc_name'].'</p></td>'; 
                
                if($label['pc_status']==0){
                    $strHtml .='<td><a href="'.ADMIN_URL.'changeStatusPCategory/'.$label['pc_id'].'" onclick="return confirm(\'Are you sure?\')"><span class="badge badge-danger">Inactive</span></a></td>';
                }else{
                    $strHtml .='<td><a href="'.ADMIN_URL.'changeStatusPCategory/'.$label['pc_id'].'" onclick="return confirm(\'Are you sure?\')"><span class="badge badge-success">Active</span></a></td>';
                }
                
                $orederData = CsPackage::where('package_pc_id','=',$label['pc_id'])->count();
                
                $strHtml .='<td style="text-align:center">'.$orederData.'</td>';
                if($label['pc_id']==-1)
                {               $strHtml .='<td colspan="1" style="text-align:center"></td>';
}else
                {
                $strHtml .='<td>
                                <div class="d-flex align-self-center justify-content-center">
                                    <nav class="nav nav-icon-only">
                                        <a href="'.ADMIN_URL.'package-category/'.$label['pc_id'].'" onclick="return confirm(\'Are you sure?\')" class="btn btn-primary btn-icon mg-r-5" title="Edit" style="padding:0px 5px;"><i class="fas fa-pencil-alt" style="font-size:11px;"></i></a>
                                        <a href="'.ADMIN_URL.'deletepcategory/'.$label['pc_id'].'" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-icon mg-r-5" title="Delete" style="padding:0px 5px;"><i class="fas fa-trash-alt" style="font-size:11px;"></i></a>
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
        if($aryCategory['pc_parent']==0)
        {
            return 0;
        }else{
          $res = CsPcategory::where('pc_id','=',$aryCategory['pc_parent'])->first();
            if($res->pc_parent==0)
            {
                return 1;
            }else{
               return 2; 
            }
        }
    }
    
    function packageCategoryProccess(Request $request)
    {
        $aryPostData = $request->all();
        //print_r($aryPostData);die;
        if(isset($aryPostData['pc_id']) && $aryPostData['pc_id']>0)
        {
            $postobj = CsPcategory::where('pc_id',$aryPostData['pc_id'])->first();
        }else{
            $postobj = new CsPcategory;
            $postobj->pc_slug = Str::slug($aryPostData['pc_name'], '-');
        }   
        if($aryPostData['pc_order']==''){
            
          $max=CsPcategory::max('pc_order');
          $postobj->pc_order = $max+1;
            
        }else{
          $postobj->pc_order = $aryPostData['pc_order'];

        }
        $postobj->pc_status = 1;
        $postobj->pc_name = $aryPostData['pc_name'];
        //$postobj->pc_order = $aryPostData['pc_order'];
        $postobj->pc_parent = $aryPostData['pc_parent'];
        if($request->hasFile('pc_image_'))
        {
            $image = $request->file('pc_image_');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = SITE_UPLOAD_PATH.SITE_PACKAGE_IMAGE;
            $image->move($destinationPath, $name);
            $postobj->pc_image = $name;
        } 
        
        if($postobj->save())    
        {
            return redirect()->route('package-category')->with('status', 'Entry Saved Successfully.');   
        }else{
            return redirect()->route('package-category')->with('error', 'Server Not Responed');
        }
    }

public function changeStatusPCategory($intCategoryId)
    {
        $rowCategoryData = CsPcategory::where('pc_id',$intCategoryId)->first();
        if($rowCategoryData->pc_status==0){
            $status = 1;
        }else{
            $status = 0;
        }
        CsPcategory::where('pc_id', $intCategoryId)->update(array('pc_status' => $status));
        return redirect()->route('package-category')->with('status', 'Entry Edited Successfully');
    }
    
 public function deletepcategory($intCategoryId)
    {   CsPcategory::where('pc_parent', $intCategoryId)->update(array('pc_parent' => 0));

        CsPcategory::where('pc_id', $intCategoryId)->delete();
        return redirect()->route('package-category')->with('status', 'Entry Deleted Successfully');
    }


public function packageManage($intId)

  { 
    $id=$intId; 
    $resAssignedData = CsPackageDetail::where('pkd_pack_id','=',$id)->get();
    //$vidData = CsVcategory::where('vc_pwhere(where()->get','=',$intId)->
    $vidData = CsVideo::get();

    //print_r($vidData);die;

    //$resAssignedTest = CsPackageDetail::where('pkd_pack_id','=',$id)->get();

    $testData = CsTest::get();

    
    $resTestData = CsTcategory::get();
    $respdfData = CsScategory::get();
    $respdfcount = CsStudyMaterial::get();


    

    $resFacultyData = CsStaff::get();
    $resVideoData = CsVcategory::where('vc_parent','=',0)->get();
    $resPackageData = CsPackage::where('package_id','=',$intId)->first();
    $title='Manage Packages';
    return view('Csadmin.Packages.packageManage',compact('title','resPackageData','resFacultyData','resVideoData','id','resAssignedData','vidData','resTestData','testData','respdfcount','respdfData'));
  }


function getCatgoryEntryChildHtml($tree,$strExtraHtml='',$intLevel=0,$intSelectParent)
  {
     //echo $intSelectParent; die;
     $strHtml=$strExtraHtml;
   $intExtraLevel = $intLevel;

          foreach($tree as $key=>$label)
          {
               $strStyle='';
              if($label['pc_parent']!=0)
              {
              $strStyle=' style="background:#eaeaea"';
             
              }
               if($label['pc_parent']==0)
              {
                   $intLevel=0;
              }
              $strExtraData = '';
              for($i=0;$i<$intLevel;$i++)
              {
                   $strExtraData .='-';
              }
             $strselect ='';
             if($label['pc_id']==$intSelectParent)
             {
                 //echo "hii"; die;
                 $strselect ='selected="selected"';
             }
            $strHtml .='<option '.$strselect.' value="'.$label['pc_id'].'">'.$strExtraData.$label['pc_name'].'</option>';


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


function assignedPackageProccess(Request $request)
    {
        $aryPostData = $request->all();
        
    //  print_r($aryPostData);die;
     CsPackageDetail::where('pkd_pack_id',$aryPostData['package_id'])->where('pkd_type',$aryPostData['pkd_type'])->delete();

        foreach($aryPostData['pkd_pack_id'] as $key=>$label)
        {
        $postobj = new CsPackageDetail;
        $postobj->pkd_type=$aryPostData['pkd_type'];
        $postobj->pkd_ref=$label;
        $postobj->pkd_pack_id=$aryPostData['package_id'];
        $postobj->pkd_name=$aryPostData['pkd_name'][$key];
        $postobj->save();
        }
        return redirect()->route('packageManage', $aryPostData['package_id'])->with('status', 'Entry Saved Successfully.');   
        
    }




    public function deletepackagedetail($intCategoryId)
    {
    $postobj = CsPackageDetail::where('pkd_id',$intCategoryId)->first();
    CsPackageDetail::where('pkd_id', $intCategoryId)->delete();
    return redirect()->route('packageManage',$postobj->pkd_pack_id)->with('status', 'Entry Deleted Successfully');
    }

}