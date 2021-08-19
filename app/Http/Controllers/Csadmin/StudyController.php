<?php namespace App\Http\Controllers\Csadmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
use Session;
use App\Http\Model\CsScategory;
use App\Http\Model\CsStudyMaterial;
use Validator;
use Illuminate\Support\Str;


class StudyController extends Controller
{
    public function index(Request $request)
    {   
        $user=Session::get("CS_ADMIN");

     /***********************Reset Filter Session ************/
        if($request->get('reset')==1)
        {
        Session::forget('FILTER_STUDY');
        return redirect()->route('all-study-material');   
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
            CsStudyMaterial::whereIn('sm_id', $aryIds)->delete();
            return redirect()->route('all-study-material')->with('status', 'Entry Deleted Successfully');
        }
        if($intBulkAction==2)
        {
            CsStudyMaterial::whereIn('sm_id', $aryIds)->update(['sm_status' => 1]);
            return redirect()->route('all-study-material')->with('status', 'Entry Updated Successfully');
        }
        if($intBulkAction==3)
        {
            CsStudyMaterial::whereIn('sm_id',$aryIds)->update(['sm_status' => 0]);
            return redirect()->route('all-study-material')->with('status', 'Entry Updated Successfully');
        }
        endIf;
      /***********************Bulk Action ************/
     
        
           /***********************Apply Condition ************/
   
        if($request->get('filter_keyword')!='')
        {
        Session::put('FILTER_STUDY', $request->get('filter_keyword'));
        Session::save(); 
        }
           /***********************Apply Condition ************/
   
        if(session()->has('FILTER_STUDY')){
        $strFilterKeyword = Session::get('FILTER_STUDY');
        if($user->role_type==0){
            $resStudyMaterialData = CsStudyMaterial::where('sm_name', 'LIKE', "%{$strFilterKeyword}%")->paginate(20);
        }else{
            $resStudyMaterialData = CsStudyMaterial::where('sm_name', 'LIKE', "%{$strFilterKeyword}%")->where('sm_institute','=',$user->user_id)->paginate(20);
            }}else{
                if($user->role_type==0){
                    $resStudyMaterialData = CsStudyMaterial::leftJoin('cs_institute', function($join) {
                        $join->on('cs_study_material.sm_institute', '=', 'cs_institute.ins_id');
                      })
                      ->paginate();
                }else{
                    $resStudyMaterialData = CsStudyMaterial::leftJoin('cs_institute', function($join) {
                        $join->on('cs_study_material.sm_institute', '=', 'cs_institute.ins_id');
                      })
                      ->where('sm_institute','=',$user->user_id)->paginate(20);
    
                }
            }    



       
        $title='Study';
        return view('Csadmin.Study.index',compact('title','resStudyMaterialData','user'));
    }
    public function addNewStudy($intStudyId=0)
    {
        $user=Session::get("CS_ADMIN");
        $resStudyMaterialData = array();
        if($intStudyId>0){
            if($user->role_type==0){
                $resStudyMaterialData = CsStudyMaterial::where('sm_id','=',$intStudyId)->first();
            }else{
                $resStudyMaterialData = CsStudyMaterial::where('sm_id','=',$intStudyId)->where('sm_institute','=',$user->user_id)->first();
    
                }



        }
        $strCategory =array();
        if(isset($resStudyMaterialData->sm_sc_id))
        {
            $strCategory = explode(',',$resStudyMaterialData->sm_sc_id);
        }
        $resParentCategoryList = CsScategory::get();
        $aryCategoryList = $this->StudyTreeData($resParentCategoryList,0);
        $strCategoryTreeStructure =$this->genrateHtml($aryCategoryList,0,$strCategory);
        $title='Add New Study';
        return view('Csadmin.Study.addNewStudy',compact('title','resStudyMaterialData','strCategoryTreeStructure'));
    }
    
    public function StudyTreeData($ar, $pid = null) 
    {
        $op = array();
        foreach($ar as $item) {
          if ($item->sc_parent == $pid) {
            $op[$item->sc_id] = $item;
            $children = $this->StudyTreeData($ar, $item->sc_id);
            if ($children) {
              $op[$item->sc_id]['children'] = $children;
            }
          }
        }
        return $op;
    }
    
    function genrateHtml($aryCategoryTree,$intLevel=0,$strSelectCategory=array()){
        $strHtml='';
        foreach($aryCategoryTree as $key=>$label){
            if($label->sc_parent==0){
                $intLevel=0;
            }
            $strChecked='';
            $strExtraChecked ='';
            if(in_array($label->sc_id,$strSelectCategory)){
                $strChecked = 'checked="checked"';
                $strExtraChecked ='checked';
            }
            $margin =$intLevel*20;
            $strLevelByMargin = 'margin-left:'.$margin.'px;';
            $strHtml .= '<label class="cch-check" style="'.$strLevelByMargin.'">'.$label->sc_name.'
            <input type="checkbox" name="sm_sc_id_[]" value="'.$label->sc_id.'" '.$strChecked.' class="clsSelectSingle"><span class="checkmark"></span>
            </label>';
            if(isset($label->children)){
                $intLevel++;
                $strHtml .=$this->genrateHtml($label->children,$intLevel,$strSelectCategory);
            }
        }
        return $strHtml;
    }
    
    function studyMaterialProccess(Request $request)
    {
        $user=Session::get("CS_ADMIN");

        $aryPostData = $request->all();
        if(isset($aryPostData['sm_id']) && $aryPostData['sm_id']>0)
        {
            $postobj = CsStudyMaterial::where('sm_id',$aryPostData['sm_id'])->first();
        }else{
            $postobj = new CsStudyMaterial;
            $postobj->sm_slug = Str::slug($aryPostData['sm_name'], '-');
            $postobj->sm_institute = $user->user_id;

        }   
        
        $postobj->sm_status = 1;
        $postobj->sm_name = $aryPostData['sm_name'];
        $postobj->sm_desc = $aryPostData['sm_desc'];
        //$postobj->sm_type = $aryPostData['sm_type'];

        $postobj->sm_file_url = $aryPostData['sm_file_url'];
        if(isset($aryPostData['sm_sc_id_']) && count($aryPostData['sm_sc_id_'])>0)
        {
            $aryPostData['sm_sc_id_'] = array_unique($aryPostData['sm_sc_id_']);
            $postobj->sm_sc_id = implode(',',$aryPostData['sm_sc_id_']);
            $resCategoryName = CsScategory::whereIn('sc_id',$aryPostData['sm_sc_id_'])->get(); 
            $catName = array();
            foreach($resCategoryName as $values){
            $catName[] = $values->sc_name;
        }
            $postobj->sm_sc_name  = implode(', ',$catName);
        }else{
            $postobj->sm_sc_name = '';
            $postobj->sm_sc_id_ = '';
        }
       
        if($request->hasFile('sm_image_'))
        {
            $image = $request->file('sm_image_');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = SITE_UPLOAD_PATH.SITE_STUDY_MATERIAL_IMAGE;
            $image->move($destinationPath, $name);
            $postobj->sm_image = $name;
        } 
        
        if($request->hasFile('sm_file_'))
        {
            $image = $request->file('sm_file_');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = SITE_UPLOAD_PATH.SITE_STUDY_MATERIAL_IMAGE;
            $image->move($destinationPath, $name);
            $postobj->sm_file = $name;
        } 
        
        if($postobj->save())    
        {
            return redirect()->route('all-study-material')->with('status', 'Entry Saved Successfully.');   
        }else{
            return redirect()->route('all-study-material')->with('error', 'Server Not Responed');
        }
    }
    
    public function studyMaterialStatus($intCategoryId)
    {
        $rowCategoryData = CsStudyMaterial::where('sm_id',$intCategoryId)->first();
        if($rowCategoryData->sm_status==1){
            $status = 0;
        }else{
            $status = 1;
        }
        CsStudyMaterial::where('sm_id', $intCategoryId)->update(array('sm_status' => $status));
        return redirect()->route('all-study-material')->with('status', 'Entry Edited Successfully');
    }
 
    public function studyMaterialDelete($intCategoryId)
    {
        CsStudyMaterial::where('sm_id', $intCategoryId)->delete();
        return redirect()->route('all-study-material')->with('status', 'Entry Deleted Successfully');
    }
    
    public function studyCategory(Request $request,$intCategoryId=0)
    {
      
     /***********************Reset Filter Session ************/
     if($request->get('reset')==1)
     {
     Session::forget('FILTER_STUDY_CATEGORY');
     return redirect()->route('study-category');   
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
        CsScategory::whereIn('sc_id', $aryIds)->delete();
         return redirect()->route('study-category')->with('status', 'Entry Deleted Successfully');
     }
     if($intBulkAction==2)
     {
        CsScategory::whereIn('sc_id', $aryIds)->update(['sc_status' => 1]);
         return redirect()->route('study-category')->with('status', 'Entry Updated Successfully');
     }
     if($intBulkAction==3)
     {
        CsScategory::whereIn('sc_id',$aryIds)->update(['sc_status' => 0]);
         return redirect()->route('study-category')->with('status', 'Entry Updated Successfully');
     }
     endIf;
   /***********************Bulk Action ************/
  
     
        /***********************Apply Condition ************/

        if($request->get('filter_keyword')!='')
        {
  
        Session::put('FILTER_STUDY_CATEGORY', $request->get('filter_keyword'));
        Session::save(); 
 
 
        }
        /***********************Apply Condition ************/

     if(session()->has('FILTER_STUDY_CATEGORY')){
     $strFilterKeyword = Session::get('FILTER_STUDY_CATEGORY');
     $resCategoryData = CsScategory::where('sc_name', 'LIKE', "%{$strFilterKeyword}%")->paginate(20);
     }else{
     $resCategoryData = CsScategory::paginate(20);
     }    


        $intSelectParent=0;
        $rowCategoryData=array();
        if($intCategoryId>0)
        {
            $rowCategoryData = CsScategory::where('sc_id',$intCategoryId)->first();
            $intSelectParent = $rowCategoryData->sc_parent;
        }
        $tree = $this->buildTree($resCategoryData);
        $strCategoryHtml = $this->getCatgoryChildHtml($tree);
        $resChildCategory = CsScategory::orderBy('sc_order', 'ASC')->get();
        
        //$intSelectParent = CsScategory::select('sc_parent')->get();
        
        $resCategoryListData =CsScategory::get();
        $tree = $this->buildTree($resCategoryListData);
        $strEntryHtml = $this->getCatgoryEntryChildHtml($tree,'',0,$intSelectParent);
        
        
        $title='Study Category';
        return view('Csadmin.Study.studyCategory',compact('title','resCategoryData','rowCategoryData','strCategoryHtml','resChildCategory','strEntryHtml'));
    }
    
    function buildTree($elements, $parentId = 0) 
    {
        $branch = array();
        foreach ($elements as $element) {
             
            if ($element['sc_parent'] == $parentId) {
                $children = $this->buildTree($elements, $element['sc_id']);
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
                if($label['sc_parent']==0){
                    $intLevel=0;
                }else{
                  $intLevel = self::getcategorylevel($label);
                }
               
                $strExtraData = '';
                
                for($i=0;$i<$intLevel;$i++){
                    $strExtraData .='<i data-feather="minus"></i>';
                }
                $src = ($label['sc_image']!="")?SITE_UPLOAD_URL.SITE_STUDY_MATERIAL_IMAGE.$label['sc_image']:SITE_NO_IMAGE_PATH;
                $strHtml .='<tr>
                                <td scope="row" style="text-align:center;vertical-align: middle;"><input type="checkbox" id="selectAll" class="clsSelectSingle" name="sc_id[]" value="'.$label['sc_id'].'">
                            </td>';
                $strHtml .='<td style="text-align:center">
                                <div class="media align-items-center mg-b-0">
                                    <div class="avatar" style="margin:0 auto;border:1px solid #ddd;">
                                        <img src="'.$src.'" class="rounded" alt="">
                                    </div>
                                </div>
                            </td>';  
                $strHtml .='<td><p class="mg-b-0 tx-medium">'.$strExtraData.$label['sc_name'].'</p></td>'; 
                
                if($label['sc_status']==0){
                    $strHtml .='<td><a href="'.ADMIN_URL.'changestatuscategory/'.$label['sc_id'].'" onclick="return confirm(\'Are you sure?\')"><span class="badge badge-danger">Inactive</span></a></td>';
                }else{
                    $strHtml .='<td><a href="'.ADMIN_URL.'changestatuscategory/'.$label['sc_id'].'" onclick="return confirm(\'Are you sure?\')"><span class="badge badge-success">Active</span></a></td>';
                }
                
                
                $orederData = CsStudyMaterial::where('sm_sc_id','=',$label['sc_id'])->count();

                
                $strHtml .='<td style="text-align:center">'.$orederData.'</td>';
                
                if($label['sc_id']==19)
                {                $strHtml .='<td colspan="1" style="text-align:center"></td>';
}else
                {
                $strHtml .='<td>
                                <div class="d-flex align-self-center justify-content-center">
                                    <nav class="nav nav-icon-only">
                                        <a href="'.ADMIN_URL.'study-category/'.$label['sc_id'].'" onclick="return confirm(\'Are you sure?\')" class="btn btn-primary btn-icon mg-r-5" title="Edit" style="padding:0px 5px;"><i class="fas fa-pencil-alt" style="font-size:11px;"></i></a>
                                        <a href="'.ADMIN_URL.'deletescategory/'.$label['sc_id'].'" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-icon mg-r-5" title="Delete" style="padding:0px 5px;"><i class="fas fa-trash-alt" style="font-size:11px;"></i></a>
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
        if($aryCategory['sc_parent']==0)
        {
            return 0;
        }else{
          $res = CsScategory::where('sc_id','=',$aryCategory['sc_parent'])->first();
            if($res->sc_parent==0)
            {
                return 1;
            }else{
               return 2; 
            }
        }
    }
    
    function studyCategoryProccess(Request $request)
    {
        $aryPostData = $request->all();
        if(isset($aryPostData['sc_id']) && $aryPostData['sc_id']>0)
        {
            $postobj = CsScategory::where('sc_id',$aryPostData['sc_id'])->first();
        }else{
            $postobj = new CsScategory;
            $postobj->sc_slug = Str::slug($aryPostData['sc_name'], '-');
        }   
        if($aryPostData['sc_order']==''){
            
          $max=CsScategory::max('sc_order');
          $postobj->sc_order = $max+1;
            
        }else{
          $postobj->sc_order = $aryPostData['sc_order'];

        }
        $postobj->sc_status = 1;
        $postobj->sc_name = $aryPostData['sc_name'];
        //$postobj->sc_order = $aryPostData['sc_order'];
        $postobj->sc_parent = $aryPostData['sc_parent'];
        if($request->hasFile('sc_image_'))
        {
            $image = $request->file('sc_image_');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = SITE_UPLOAD_PATH.SITE_STUDY_MATERIAL_IMAGE;
            $image->move($destinationPath, $name);
            $postobj->sc_image = $name;
        } 
        
        if($postobj->save())    
        {
            return redirect()->route('study-category')->with('status', 'Entry Saved Successfully.');   
        }else{
            return redirect()->route('study-category')->with('error', 'Server Not Responed');
        }
    }
    
    public function changeStatusCategory($intCategoryId)
    {
        $rowCategoryData = CsScategory::where('sc_id',$intCategoryId)->first();
        if($rowCategoryData->sc_status==0){
            $status = 1;
        }else{
            $status = 0;
        }
        CsScategory::where('sc_id', $intCategoryId)->update(array('sc_status' => $status));
        return redirect()->route('study-category')->with('status', 'Entry Edited Successfully');
    }
 
    public function deleteCategory($intCategoryId)
    {
        CsScategory::where('sc_parent', $intCategoryId)->update(array('sc_parent' => 0));

        CsScategory::where('sc_id', $intCategoryId)->delete();
        return redirect()->route('study-category')->with('status', 'Entry Deleted Successfully');
    }
    
    
     function getCatgoryEntryChildHtml($tree,$strExtraHtml='',$intLevel=0,$intSelectParent)
  {
     $strHtml=$strExtraHtml;
   $intExtraLevel = $intLevel;

          foreach($tree as $key=>$label)
          {
               $strStyle='';
              if($label['sc_parent']!=0)
              {
              $strStyle=' style="background:#eaeaea"';
             
              }
               if($label['sc_parent']==0)
              {
                   $intLevel=0;
              }
              $strExtraData = '';
              for($i=0;$i<$intLevel;$i++)
              {
                   $strExtraData .='-';
              }
             $strselect ='';
             if($label['sc_id']==$intSelectParent)
             {
                 $strselect ='selected="selected"';
             }
            $strHtml .='<option '.$strselect.' value="'.$label['sc_id'].'">'.$strExtraData.$label['sc_name'].'</option>';


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