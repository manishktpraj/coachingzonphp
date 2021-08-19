<?php namespace App\Http\Controllers\Csadmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
use Session;
use App\Http\Model\Csdmin;
use App\Http\Model\CsTcategory;
use App\Http\Model\CsSubject;

use App\Http\Model\CsTest;
use Illuminate\Support\Str;
use Validator;

class TestsController extends Controller
{
  public function index(Request $request)
  {
    $user=Session::get("CS_ADMIN");
     
     /***********************Reset Filter Session ************/
        if($request->get('reset')==1)
        {
        Session::forget('FILTER_TEST');
        return redirect()->route('tests');   
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
            CsTest::whereIn('test_id', $aryIds)->delete();
            return redirect()->route('tests')->with('status', 'Entry Deleted Successfully');
        }
        if($intBulkAction==2)
        {
            CsTest::whereIn('test_id', $aryIds)->update(['test_status' => 1]);
            return redirect()->route('tests')->with('status', 'Entry Updated Successfully');
        }
        if($intBulkAction==3)
        {
            CsTest::whereIn('test_id',$aryIds)->update(['test_status' => 0]);
            return redirect()->route('tests')->with('status', 'Entry Updated Successfully');
        }
        endIf;
      /***********************Bulk Action ************/
     
        
           /***********************Apply Condition ************/
   
        if($request->get('filter_keyword')!='')
        {
        Session::put('FILTER_TEST', $request->get('filter_keyword'));
        Session::save(); 
        }
           /***********************Apply Condition ************/
   
        if(session()->has('FILTER_TEST')){
        $strFilterKeyword = Session::get('FILTER_TEST');
        if($user->role_type==0){
        $resTestData = CsTest::where('test_name', 'LIKE', "%{$strFilterKeyword}%")->paginate(20);
        }else{
        $resTestData = CsTest::where('test_name', 'LIKE', "%{$strFilterKeyword}%")->where('test_institute','=',$user->user_id)->paginate(20);
        }}else{
            if($user->role_type==0){
        $resTestData = CsTest::leftJoin('cs_institute', function($join) {
            $join->on('cs_institute.ins_id', '=', 'cs_test.test_institute');
          })
          ->paginate();
            }else{
                $resTestData = CsTest::leftJoin('cs_institute', function($join) {
                    $join->on('cs_test.test_institute', '=', 'cs_institute.ins_id');
                  })
                  ->where('test_institute','=',$user->user_id)
                  ->paginate(20);

            }
        }    
    
    $resCategoryData = CsTcategory::get();
    $title='Tests';
    return view('Csadmin.Tests.index',compact('title','resTestData','resCategoryData','user'));
  }
  
  
   public function addNewTest($intTestId=0)
  {
    $user=Session::get("CS_ADMIN");

       $resTestData = array();
        if($intTestId>0){

            if($user->role_type==0){
                $resTestData = CsTest::where('test_id','=',$intTestId)->first();
            }else{
                $resTestData = CsTest::where('test_id','=',$intTestId)->where('test_institute','=',$user->user_id)->first();
    
                }


        }
        $strCategory =array();
        if(isset($resTestData->test_tc_id))
        {
            $strCategory = explode(',',$resTestData->test_tc_id);
        }
      
      $resCategoryData = CsTcategory::get();
      $aryCategoryList = $this->buildTree($resCategoryData,0);
      $strCategoryTreeStructure =$this->genrateHtml($aryCategoryList,0,$strCategory);

      $sub = CsSubject::get();
    $title='Add New Test';
    return view('Csadmin.Tests.addNewTest' ,compact('title','resCategoryData','aryCategoryList','strCategoryTreeStructure','strCategory','resTestData','sub'));
  }
  
   public function testStatus($intCategoryId)
    {
        $rowCategoryData = CsTest::where('test_id',$intCategoryId)->first();
        if($rowCategoryData->test_status==1){
            $status = 0;
        }else{
            $status = 1;
        }
        CsTest::where('test_id', $intCategoryId)->update(array('test_status' => $status));
        return redirect()->route('tests')->with('status', 'Entry Edited Successfully');
    }
    
   function testProccess(Request $request)
    {   $user=Session::get("CS_ADMIN");

        $aryPostData = $request->all();
        if(isset($aryPostData['test_id']) && $aryPostData['test_id']>0)
        {
            $postobj = CsTest::where('test_id',$aryPostData['test_id'])->first();
        }else{
            $postobj = new CsTest;
            $postobj->test_slug = Str::slug($aryPostData['test_name'], '-');
            $postobj->test_institute = $user->user_id;
            $postobj->test_institute_name = $user->staff_name;
            

        }   
        

        $postobj->test_status = 1;
        $postobj->test_name = $aryPostData['test_name'];
        $postobj->test_desc = $aryPostData['test_desc'];
       // $postobj->test_type = $aryPostData['test_type'];
        $postobj->test_subject = $aryPostData['test_subject'];
        $postobj->test_marked_marks = $aryPostData['test_marked_marks'];
        $postobj->test_marked_negative_marks = $aryPostData['test_marked_negative_marks'];
        $postobj->test_total_que = $aryPostData['test_total_que'];
        $postobj->test_duration = $aryPostData['test_duration'];
        $postobj->test_scheduled_date = $aryPostData['test_scheduled_date'];
        $postobj->test_announcement_date = $aryPostData['test_announcement_date'];

        
        if(isset($aryPostData['test_tc_id_']) && count($aryPostData['test_tc_id_'])>0)
        {
            $aryPostData['test_tc_id_'] = array_unique($aryPostData['test_tc_id_']);
            $postobj->test_tc_id = implode(',',$aryPostData['test_tc_id_']);
            $resCategoryName = CsTcategory::whereIn('tc_id',$aryPostData['test_tc_id_'])->get(); 
            $catName = array();
            foreach($resCategoryName as $values){
            $catName[] = $values->tc_name;
            }
            $postobj->test_tc_name  = implode(', ',$catName);
            
        }else{
            $postobj->test_tc_name = '';
            $postobj->test_tc_id = '';
        }
        if($request->hasFile('test_image'))
        {
            $image = $request->file('test_image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = SITE_UPLOAD_PATH.SITE_TEST_IMAGE;
            $image->move($destinationPath, $name);
            $postobj->test_image = $name;
        } 
        
        
        if($postobj->save())    
        {
            return redirect()->route('tests')->with('status', 'Entry Saved Successfully.');   
        }else{
            return redirect()->route('tests')->with('error', 'Server Not Responed');
        }
    }
    
 public function testCategory(Request $request,$intCategoryId=0)
    {/***********************Reset Filter Session ************/
        if($request->get('reset')==1)
        {
        Session::forget('FILTER_TEST_CATEGORY');
        return redirect()->route('test-category');   
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
           CsTcategory::whereIn('tc_id', $aryIds)->delete();
            return redirect()->route('test-category')->with('status', 'Entry Deleted Successfully');
        }
        if($intBulkAction==2)
        {
           CsTcategory::whereIn('tc_id', $aryIds)->update(['tc_status' => 1]);
            return redirect()->route('test-category')->with('status', 'Entry Updated Successfully');
        }
        if($intBulkAction==3)
        {
           CsTcategory::whereIn('tc_id',$aryIds)->update(['tc_status' => 0]);
            return redirect()->route('test-category')->with('status', 'Entry Updated Successfully');
        }
        endIf;
      /***********************Bulk Action ************/
     
        
           /***********************Apply Condition ************/
   
           if($request->get('filter_keyword')!='')
           {
     
           Session::put('FILTER_TEST_CATEGORY', $request->get('filter_keyword'));
           Session::save(); 
    
    
           }
           /***********************Apply Condition ************/
   
        if(session()->has('FILTER_TEST_CATEGORY')){
        $strFilterKeyword = Session::get('FILTER_TEST_CATEGORY');
        $resCategoryData = CsTcategory::where('tc_name', 'LIKE', "%{$strFilterKeyword}%")->paginate(20);
        }else{
            $resCategoryData = CsTcategory::orderBy('tc_order', 'ASC')->get();
        }    

        $intSelectParent=0;
        $rowCategoryData=array();
        if($intCategoryId>0)
        {
            $rowCategoryData = CsTcategory::where('tc_id',$intCategoryId)->first();
            $intSelectParent = $rowCategoryData->tc_parent;

        }
        $tree = $this->buildTree($resCategoryData);
        $strCategoryHtml = $this->getCatgoryChildHtml($tree);
                   
        $resCategoryListData =CsTcategory::get();
        $tree = $this->buildTree($resCategoryListData);
        $strEntryHtml = $this->getCatgoryEntryChildHtml($tree,'',0,$intSelectParent);
       
        $title='Test Category';
        return view('Csadmin.Tests.testCategory',compact('title','resCategoryData','rowCategoryData','strCategoryHtml','strEntryHtml'));
    }
    
    function buildTree($elements, $parentId = 0) 
    {
        $branch = array();
        foreach ($elements as $element) {
             
            if ($element['tc_parent'] == $parentId) {
                $children = $this->buildTree($elements, $element['tc_id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            } 
        }
        return $branch;
    }
    
     function genrateHtml($aryCategoryTree,$intLevel=0,$strSelectCategory=array()){
        $strHtml='';
        foreach($aryCategoryTree as $key=>$label){
            if($label->tc_parent==0){
                $intLevel=0;
            }
            $strChecked='';
            $strExtraChecked ='';
            if(in_array($label->tc_id,$strSelectCategory)){
                $strChecked = 'checked="checked"';
                $strExtraChecked ='checked';
            }
            $margin =$intLevel*20;
            $strLevelByMargin = 'margin-left:'.$margin.'px;';
            $strHtml .= '<label class="cch-check" style="'.$strLevelByMargin.'">'.$label->tc_name.'
            <input type="checkbox" name="test_tc_id_[]" value="'.$label->tc_id.'" '.$strChecked.' class="clsSelectSingle"><span class="checkmark"></span>
            </label>';
            if(isset($label->children)){
                $intLevel++;
                $strHtml .=$this->genrateHtml($label->children,$intLevel,$strSelectCategory);
            }
        }
        return $strHtml;
    }
     
    function getCatgoryChildHtml($tree,$strExtraHtml='',$intLevel=0){
            

            $strHtml=$strExtraHtml;
            if(count($tree)>0){
            foreach($tree as $key=>$label){

                $strStyle ='';
                if($label['tc_parent']==0){
                    $intLevel=0;
                }else{
                  $intLevel = self::getcategorylevel($label);
                }
               
                $strExtraData = '';
                
                for($i=0;$i<$intLevel;$i++){
                    $strExtraData .='<i data-feather="minus"></i>';
                }
                $src = ($label['tc_image']!="")?SITE_UPLOAD_URL.SITE_TEST_IMAGE.$label['tc_image']:SITE_NO_IMAGE_PATH;
                $strHtml .='<tr>
                                <td scope="row" style="text-align:center;vertical-align: middle;"><input type="checkbox" id="selectAll" class="clsSelectSingle" name="tc_id[]" value="'.$label['tc_id'].'"></td>';
                $strHtml .='<td style="text-align:center">
                                <div class="media align-items-center mg-b-0">
                                    <div class="avatar" style="margin:0 auto;border:1px solid #ddd;">
                                        <img src="'.$src.'" class="rounded" alt="" accept="image/*">
                                    </div>
                                </div>
                            </td>';  
                $strHtml .='<td><p class="mg-b-0 tx-medium">'.$strExtraData.$label['tc_name'].'</p></td>'; 
                
                if($label['tc_status']==0){
                    $strHtml .='<td><a href="'.ADMIN_URL.'changeStatusTCategory/'.$label['tc_id'].'" onclick="return confirm(\'Are you sure?\')"><span class="badge badge-danger">Inactive</span></a></td>';
                }else{
                    $strHtml .='<td><a href="'.ADMIN_URL.'changeStatusTCategory/'.$label['tc_id'].'" onclick="return confirm(\'Are you sure?\')"><span class="badge badge-success">Active</span></a></td>';
                }
                $orderData = CsTest::where('test_tc_id','=',$label['tc_id'])->count();
                
                
                $strHtml .='<td style="text-align:center">'.$orderData.'</td>';
                
                if($label['tc_id']==10 || $label['tc_id']==13){
                $strHtml .='<td colspan="1" style="text-align:center"></td>';
                }else{
                $strHtml .='<td>
                                <div class="d-flex align-self-center justify-content-center">
                                    <nav class="nav nav-icon-only">
                                        <a href="'.ADMIN_URL.'test-category/'.$label['tc_id'].'" onclick="return confirm(\'Are you sure?\')" class="btn btn-primary btn-icon mg-r-5" title="Edit" style="padding:0px 5px;"><i class="fas fa-pencil-alt" style="font-size:11px;"></i></a>
                                        <a href="'.ADMIN_URL.'testCatDelete/'.$label['tc_id'].'" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-icon mg-r-5" title="Delete" style="padding:0px 5px;"><i class="fas fa-trash-alt" style="font-size:11px;"></i></a>
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
        if($aryCategory['tc_parent']==0)
        {
            return 0;
        }else{
          $res = CsTcategory::where('tc_id','=',$aryCategory['tc_parent'])->first();
            if($res->tc_parent==0)
            {
                return 1;
            }else{
               return 2; 
            }
        }
    }
    
    function testCategoryProccess(Request $request)
    {
        $aryPostData = $request->all();

        if(isset($aryPostData['tc_id']) && $aryPostData['tc_id']>0)
        {
            $postobj = CsTcategory::where('tc_id',$aryPostData['tc_id'])->first();
        }else{
            $postobj = new CsTcategory;
            $postobj->tc_slug = Str::slug($aryPostData['tc_name'], '-');
        }   
        if($aryPostData['tc_order']==''){
            
          $max=CsTcategory::max('tc_order');
          $postobj->tc_order = $max+1;
            
        }else{
          $postobj->tc_order = $aryPostData['tc_order'];

        }
        $postobj->tc_status = 1;
        $postobj->tc_name = $aryPostData['tc_name'];
        $postobj->tc_parent = $aryPostData['tc_parent'];
        if($request->hasFile('tc_image_'))
        {
            $image = $request->file('tc_image_');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = SITE_UPLOAD_PATH.SITE_TEST_IMAGE;
            $image->move($destinationPath, $name);
            $postobj->tc_image = $name;
        } 
       
        if($postobj->save())    
        {
            return redirect()->route('test-category')->with('status', 'Entry Saved Successfully.');   
        }else{
            return redirect()->route('test-category')->with('error', 'Server Not Responed');
        }
    }

public function changeStatusTCategory($intCategoryId)
    {
        $rowCategoryData = CsTcategory::where('tc_id',$intCategoryId)->first();
        if($rowCategoryData->tc_status==0){
            $status = 1;
        }else{
            $status = 0;
        }
        CsTcategory::where('tc_id', $intCategoryId)->update(array('tc_status' => $status));
        return redirect()->route('test-category')->with('status', 'Entry Edited Successfully');
    }

 public function testDelete($intCategoryId)
    {
        CsTest::where('test_id', $intCategoryId)->delete();
        return redirect()->route('tests')->with('status', 'Entry Deleted Successfully');
    }
    
    public function testCatDelete($intCategoryId)
    {
       CsTcategory::where('tc_parent', $intCategoryId)->update(array('tc_parent' => 0));

        CsTcategory::where('tc_id', $intCategoryId)->delete();
        return redirect()->route('test-category')->with('status', 'Entry Deleted Successfully');
    }

    function getCatgoryEntryChildHtml($tree,$strExtraHtml='',$intLevel=0,$intSelectParent)
  {
     $strHtml=$strExtraHtml;
   $intExtraLevel = $intLevel;

          foreach($tree as $key=>$label)
          {
               $strStyle='';
              if($label['tc_parent']!=0)
              {
              $strStyle=' style="background:#eaeaea"';
             
              }
               if($label['tc_parent']==0)
              {
                   $intLevel=0;
              }
              $strExtraData = '';
              for($i=0;$i<$intLevel;$i++)
              {
                   $strExtraData .='-';
              }
             $strselect ='';
             if($label['tc_id']==$intSelectParent)
             {
                 $strselect ='selected="selected"';
             }
            $strHtml .='<option '.$strselect.' value="'.$label['tc_id'].'">'.$strExtraData.$label['tc_name'].'</option>';


if(isset($label->children) && $intLevel!=2)
{
  
$intLevel++;
     $strHtml =$this->getCatgoryEntryChildHtml($label->children,$strHtml,$intLevel,$intSelectParent);
      $intLevel = $intExtraLevel;

}
   }
   
   return $strHtml;
       exit();
  }
  

  public function testQuestion($intTestId=0)
  {
    $user=Session::get("CS_ADMIN");
    
    $resTestData = CsTest::where('test_id','=',$intTestId)->first();
    
    $title='Add Questions';
    return view('Csadmin.Tests.testQuestion' ,compact('title','resTestData'));
  }
  
  public function addtestQuestion($intTestId=0)
  {
    $user=Session::get("CS_ADMIN");
    
    $resTestData = CsTest::where('test_id','=',$intTestId)->first();
    
    $title='Add Questions';
    return view('Csadmin.Tests.addtestQuestion' ,compact('title','resTestData'));
  }
  
  

}