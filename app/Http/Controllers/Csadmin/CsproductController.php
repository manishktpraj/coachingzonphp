<?php
namespace App\Http\Controllers\Csadmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Http\Model\Csproduct;
use App\Http\Model\CsInstitute;


use App\Http\Model\CsProductCategory;
use Session;
use DB;
class CsproductController extends Controller
{
             
  public function index(Request $request)
  {
    $user=Session::get("CS_ADMIN");
   //print_r($user);
      
     /***********************Reset Filter Session ************/
        if($request->get('reset')==1)
        {
        Session::forget('FILTER_PRODUCT');
        return redirect()->route('all-product');   
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
            Csproduct::whereIn('product_id', $aryIds)->delete();
            return redirect()->route('all-product')->with('status', 'Entry Deleted Successfully');
        }
        if($intBulkAction==2)
        {
            Csproduct::whereIn('product_id', $aryIds)->update(['product_status' => 1]);
            return redirect()->route('all-product')->with('status', 'Entry Updated Successfully');
        }
        if($intBulkAction==3)
        {
            Csproduct::whereIn('product_id',$aryIds)->update(['product_status' => 0]);
            return redirect()->route('all-product')->with('status', 'Entry Updated Successfully');
        }
        endIf;
      /***********************Bulk Action ************/
     
        
           /***********************Apply Condition ************/
   
        if($request->get('filter_keyword')!='')
        {
        Session::put('FILTER_PRODUCT', $request->get('filter_keyword'));
        Session::save(); 
        }
           /***********************Apply Condition ************/
   
        if(session()->has('FILTER_PRODUCT')){
        $strFilterKeyword = Session::get('FILTER_PRODUCT');

        
            if($user->role_type==0){
                $resPackageData = Csproduct::where('product_title', 'LIKE', "%{$strFilterKeyword}%")->paginate(20);
            }else{

        $resPackageData = Csproduct::where('product_title', 'LIKE', "%{$strFilterKeyword}%")->where('product_ins_id','=',$user->user_id)->paginate(20);
        //print_r($resVideoData);
        }}else{
            if($user->role_type==0){
          $resPackageData=  Csproduct::leftJoin('cs_institute', function($join) {
                $join->on('cs_product.product_ins_id', '=', 'cs_institute.ins_id');
              })
              ->paginate();

            }else{
                $resPackageData=  Csproduct::leftJoin('cs_institute', function($join) {
                    $join->on('cs_product.product_ins_id', '=', 'cs_institute.ins_id');
                  })
                  ->where('product_ins_id','=',$user->user_id)
                  ->paginate();
     }}    
    $resCategoryData = CsProductCategory::get(); 
    $title='Manage Product';
    return view('Csadmin.Csproduct.index',compact('title','resPackageData','resCategoryData','user'));
    }
    

    public function addnewproduct($intTestId=0)
    {        
        $user=Session::get("CS_ADMIN");


        $resProductData = array();
         if($intTestId>0){
 
             if($user->role_type==0){
                 $resProductData = Csproduct::where('product_id','=',$intTestId)->first();
             }else{
                 $resProductData = Csproduct::where('product_id','=',$intTestId)->where('product_ins_id','=',$user->user_id)->first();
     
                 }
 
 
         }
         $strCategory =array();
         if(isset($resProductData->product_category_id))
         {
             $strCategory = explode(',',$resProductData->product_category_id);
         }
       
       $resCategoryData = CsProductCategory::get();
       $aryCategoryList = $this->buildTree($resCategoryData,0);
       $strCategoryTreeStructure =$this->genrateHtml($aryCategoryList,0,$strCategory);
 
     $title='Add New Product';
     return view('Csadmin.Csproduct.addnewproduct' ,compact('title','resCategoryData','aryCategoryList','strCategoryTreeStructure','strCategory','resProductData'));

    }

      
    function productCategoryProccess(Request $request)
    {
        $aryPostData = $request->all();
        //print_r($aryPostData);die;
        if(isset($aryPostData['pr_cat_id']) && $aryPostData['pr_cat_id']>0)
        {
            $postobj = CsProductCategory::where('pr_cat_id',$aryPostData['pr_cat_id'])->first();
        }else{
            $postobj = new CsProductCategory;
            $postobj->pr_cat_slug = Str::slug($aryPostData['pr_cat_name'], '-');
        }   
        if($aryPostData['pr_cat_order']==''){
            
          $max=CsProductCategory::max('pr_cat_order');
          $postobj->pr_cat_order = $max+1;
            
        }else{
          $postobj->pr_cat_order = $aryPostData['pr_cat_order'];

        }
        $postobj->pr_cat_status = 1;
        $postobj->pr_cat_parent = $aryPostData['pr_cat_parent'];
      // $postobj->pr_cat_order = $aryPostData['pr_cat_order'];
        $postobj->pr_cat_name = $aryPostData['pr_cat_name'];
        if($request->hasFile('pr_cat_image_'))
        {
            $image = $request->file('pr_cat_image_');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = SITE_UPLOAD_PATH.SITE_PRODUCT_IMAGE;
            $image->move($destinationPath, $name);
            $postobj->pr_cat_image = $name;
        } 
        
        if($postobj->save())    
        {
            return redirect()->route('product-category')->with('status', 'Entry Saved Successfully.');   
        }else{
            return redirect()->route('product-category')->with('error', 'Server Not Responed');
        }
    }
 
    public function productcat(Request $request,$intCategoryId=0)
    {

        /***********************Reset Filter Session ************/
        if($request->get('reset')==1)
        {
        Session::forget('FILTER_PRODUCT_CAT');
        return redirect()->route('product-category');   
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
            CsProductCategory::whereIn('pr_cat_id', $aryIds)->delete();
            return redirect()->route('product-category')->with('status', 'Entry Deleted Successfully');
        }
        if($intBulkAction==2)
        {
            CsProductCategory::whereIn('pr_cat_id', $aryIds)->update(['pr_cat_status' => 1]);
            return redirect()->route('product-category')->with('status', 'Entry Updated Successfully');
        }
        if($intBulkAction==3)
        {
            CsProductCategory::whereIn('pr_cat_id',$aryIds)->update(['pr_cat_status' => 0]);
            return redirect()->route('product-category')->with('status', 'Entry Updated Successfully');
        }
        endIf;
      /***********************Bulk Action ************/
     
        
           /***********************Apply Condition ************/
   
           if($request->get('filter_keyword')!='')
           {
     
           Session::put('FILTER_PRODUCT_CAT', $request->get('filter_keyword'));
           Session::save(); 
    
    
           }
           /***********************Apply Condition ************/
   
        if(session()->has('FILTER_PRODUCT_CAT')){
        $strFilterKeyword = Session::get('FILTER_PRODUCT_CAT');
        $resCategoryData = CsProductCategory::where('pr_cat_name', 'LIKE', "%{$strFilterKeyword}%")->orderBy('pr_cat_order', 'ASC')->paginate(20);
        }else{
        $resCategoryData = CsProductCategory::orderBy('pr_cat_order', 'ASC')->get();
        }    


        $intSelectParent =0;
        $rowCategoryData=array();
        if($intCategoryId>0)
        {
            $rowCategoryData = CsProductCategory::where('pr_cat_id',$intCategoryId)->first();
            $intSelectParent = $rowCategoryData->pr_cat_parent;
        }
        //$resCategoryData = CsProductCategory::orderBy('pr_cat_order', 'ASC')->get();
        $tree = $this->buildTree($resCategoryData);
        $strCategoryHtml = $this->getCatgoryChildHtml($tree);
        $resChildCategory = CsProductCategory::get();
        $resCategoryListData =CsProductCategory::get();
        $tree = $this->buildTree($resCategoryListData);
        $strEntryHtml = $this->getCatgoryEntryChildHtml($tree,'',0,$intSelectParent);
        
        //print_r($strEntryHtml);
        
        
        $title='Product Category';
        return view('Csadmin.Csproduct.productcat',compact('title','resCategoryData','rowCategoryData','strCategoryHtml','resChildCategory','strEntryHtml'));
    }
    
    function genrateHtml($aryCategoryTree,$intLevel=0,$strSelectCategory=array()){
        $strHtml='';
        foreach($aryCategoryTree as $key=>$label){
            if($label->pr_cat_parent==0){
                $intLevel=0;
            }
            $strChecked='';
            $strExtraChecked ='';
            if(in_array($label->pr_cat_id,$strSelectCategory)){
                $strChecked = 'checked="checked"';
                $strExtraChecked ='checked';
            }
            $margin =$intLevel*20;
            $strLevelByMargin = 'margin-left:'.$margin.'px;';
            $strHtml .= '<label class="cch-check" style="'.$strLevelByMargin.'">'.$label->pr_cat_name.'
            <input type="checkbox" name="product_category_id_[]" value="'.$label->pr_cat_id.'" '.$strChecked.' class="clsSelectSingle"><span class="checkmark"></span>
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
             
            if ($element['pr_cat_parent'] == $parentId) {
                $children = $this->buildTree($elements, $element['pr_cat_id']);
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
                if($label['pr_cat_parent']==0){
                    $intLevel=0;
                }else{
                  $intLevel = self::getcategorylevel($label);
                }
               
                $strExtraData = '';
                
                for($i=0;$i<$intLevel;$i++){
                    $strExtraData .='<i data-feather="minus"></i>';
                }
                
                $src = ($label['pr_cat_image']!="")?SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE.$label['pr_cat_image']:SITE_NO_IMAGE_PATH;
                $strHtml .='<tr>
                                <td scope="row" style="text-align:center;vertical-align: middle;"><input type="checkbox" id="selectAll" class="clsSelectSingle" name="pr_cat_id[]" value="'.$label['pr_cat_id'].'">
                            </td>';
                $strHtml .='<td style="text-align:center">
                                <div class="media align-items-center mg-b-0">
                                    <div class="avatar" style="margin: 0 auto;border:1px solid #ddd;">
                                        <img src="'.$src.'" class="rounded" alt="">
                                    </div>
                                </div>
                            </td>';  
                $strHtml .='<td><p class="mg-b-0 tx-medium">'.$strExtraData.$label['pr_cat_name'].'</p></td>'; 
                //print_r($strExtraData).$label['pr_cat_name'];
                if($label['pr_cat_status']==0){
                    $strHtml .='<td><a href="'.route('changeStatusProjectCategory',$label['pr_cat_id']).'" onclick="return confirm(\'Are you sure?\')"><span class="badge badge-danger">Inactive</span></a></td>';
                }else{
                    $strHtml .='<td><a href="'.route('changeStatusProjectCategory',$label['pr_cat_id']).'" onclick="return confirm(\'Are you sure?\')"><span class="badge badge-success">Active</span></a></td>';
                }
                $orederData = Csproduct::where('product_category_id','=',$label['pr_cat_id'])->count();
                
                $strHtml .='<td style="text-align:center">'.$orederData.'</td>';
                if($label['pr_cat_id']==16)
                {                $strHtml .='<td colspan="1" style="text-align:center"></td>';
}else
                {
                $strHtml .='<td>
                                <div class="d-flex align-self-center justify-content-center">
                                    <nav class="nav nav-icon-only">
                                        <a href="'.route('product-category',$label['pr_cat_id']).'" onclick="return confirm(\'Are you sure?\')" class="btn btn-primary btn-icon mg-r-5" title="Edit" style="padding:0px 5px;"><i class="fas fa-pencil-alt" style="font-size:11px;"></i></a>
                                        <a href="'.route('deleteProductCategory',$label['pr_cat_id']).'" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-icon mg-r-5" title="Delete" style="padding:0px 5px;"><i class="fas fa-trash-alt" style="font-size:11px;"></i></a>
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
        if($aryCategory['pr_cat_parent']==0)
        {
            return 0;
        }else{
          $res = CsProductCategory::where('pr_cat_id','=',$aryCategory['pr_cat_parent'])->first();
            if($res->pr_cat_parent==0)
            {
                return 1;
            }else{
               return 2; 
            }
        }
    }
    function getCatgoryEntryChildHtml($tree,$strExtraHtml='',$intLevel=0,$intSelectParent)
    {
       //echo $intSelectParent; die;
       $strHtml=$strExtraHtml;
     $intExtraLevel = $intLevel;
  //print_r($tree);die;
            foreach($tree as $key=>$label)
            {
                 $strStyle='';
                if($label['pr_cat_parent']!=0)
                {
                $strStyle=' style="background:#eaeaea"';
               
                }
                 if($label['pr_cat_parent']==0)
                {
                     $intLevel=0;
                }
                $strExtraData = '';
                for($i=0;$i<$intLevel;$i++)
                {
                     $strExtraData .='-';
                }
               $strselect ='';
               if($label['pr_cat_id']==$intSelectParent)
               {
                //   echo "hii"; die;
                   $strselect ='selected="selected"';
               }
              $strHtml .='<option '.$strselect.' value="'.$label['pr_cat_id'].'">'.$strExtraData.$label['pr_cat_name'].'</option>';
  
  
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

    public function changeStatusProjectCategory($intCategoryId)
    {
        $rowCategoryData = CsProductCategory::where('pr_cat_id',$intCategoryId)->first();
        if($rowCategoryData->pr_cat_status==0){
            $status = 1;
        }else{
            $status = 0;
        }
        CsProductCategory::where('pr_cat_id', $intCategoryId)->update(array('pr_cat_status' => $status));
        return redirect()->route('product-category')->with('status', 'Entry Edited Successfully');
    }
 
    public function deleteProductCategory($intCategoryId)
    {   CsProductCategory::where('pr_cat_parent', $intCategoryId)->update(array('pr_cat_parent' => 0));

        CsProductCategory::where('pr_cat_id', $intCategoryId)->delete();
        return redirect()->route('product-category')->with('status', 'Entry Deleted Successfully');
   }

 

   function productProccess(Request $request)
   {   $user=Session::get("CS_ADMIN");

       $aryPostData = $request->all();
       // print_r($user);die;
       if(isset($aryPostData['product_id']) && $aryPostData['product_id']>0)
       {
           $postobj = Csproduct::where('product_id',$aryPostData['product_id'])->first();
           //print_r($postobj);die;
       }else{
           $postobj = new Csproduct;
           $postobj->product_uniqueid = Str::slug($aryPostData['product_title'], '-');
       }   
       
       $postobj->product_ins_id = $user->user_id;

       $postobj->product_status = 1;
       $postobj->product_title = $aryPostData['product_title'];
       $postobj->product_description = $aryPostData['product_description'];
       if(isset($aryPostData['product_msp'])&& $aryPostData['product_msp']!=''){
       $postobj->product_msp = $aryPostData['product_msp'];
       }else{
        $postobj->product_msp = $aryPostData['product_mrp'];
        }
       $postobj->product_mrp = $aryPostData['product_mrp'];
       $postobj->product_discount = $aryPostData['product_discount'];

       
       if(isset($aryPostData['product_category_id_']) && count($aryPostData['product_category_id_'])>0)
       {
           $aryPostData['product_category_id_'] = array_unique($aryPostData['product_category_id_']);
           $postobj->product_category_id = implode(',',$aryPostData['product_category_id_']);
           $resCategoryName = CsProductCategory::whereIn('pr_cat_id',$aryPostData['product_category_id_'])->get(); 
           //print_r($resCategoryName);die;
           $catName = array();
           foreach($resCategoryName as $values){
           $catName[] = $values->pr_cat_name;
           }
           $postobj->product_category_name  = implode(', ',$catName);
           /*echo '<pre>';
           print_r($resCategoryName);die;*/
           //$postobj->sm_sc_name  = implode(', ',$resCategoryName['sc_name']);
       }else{
           $postobj->product_category_name = '';
           $postobj->product_category_id = '';
       }
       if($request->hasFile('product_image_'))
       {
           $image = $request->file('product_image_');
           $name = time().'.'.$image->getClientOriginalExtension();
           $destinationPath = SITE_UPLOAD_PATH.SITE_PRODUCT_IMAGE;
           $image->move($destinationPath, $name);
           $postobj->product_image = $name;
       } 
       
       
       if($postobj->save())    
       {
           return redirect()->route('all-product')->with('status', 'Entry Saved Successfully.');   
       }else{
           return redirect()->route('all-product')->with('error', 'Server Not Responed');
       }
   }
   


  
   public function productDelete($intCategoryId)
   {
    Csproduct::where('product_id', $intCategoryId)->delete();
       return redirect()->route('all-product')->with('status', 'Entry Deleted Successfully');
   }
 
 public function productStatus($intCategoryId)
   {
       $rowCategoryData = Csproduct::where('product_id',$intCategoryId)->first();
      // print_r($rowCategoryData);die;
       if($rowCategoryData->product_status==1){
           $status = 0;
       }else{
           $status = 1;
       }
       Csproduct::where('product_id', $intCategoryId)->update(array('product_status' => $status));
       return redirect()->route('all-product')->with('status', 'Entry Edited Successfully');
   }












}

