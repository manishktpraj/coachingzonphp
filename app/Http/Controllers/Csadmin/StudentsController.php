<?php namespace App\Http\Controllers\Csadmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
use Session;
use App\Http\Model\Csdmin;
use App\Http\Model\CsStudent;
use App\Http\Model\CsStudentGroup;
use Validator;

class StudentsController extends Controller
{
  public function index(Request $request)
  {
       /***********************Reset Filter Session ************/
        if($request->get('reset')==1)
        {
        Session::forget('FILTER_STUDENT');
        return redirect()->route('all-students');   
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
            CsStudent::whereIn('student_id', $aryIds)->delete();
            return redirect()->route('all-students')->with('status', 'Entry Deleted Successfully');
        }
        if($intBulkAction==2)
        {
            CsStudent::whereIn('student_id', $aryIds)->update(['student_status' => 1]);
            return redirect()->route('all-students')->with('status', 'Entry Updated Successfully');
        }
        if($intBulkAction==3)
        {
            CsStudent::whereIn('student_id',$aryIds)->update(['student_status' => 0]);
            return redirect()->route('all-students')->with('status', 'Entry Updated Successfully');
        }
        endIf;
      /***********************Bulk Action ************/
     
        
           /***********************Apply Condition ************/
   
        if($request->get('filter_keyword')!='')
        {
        Session::put('FILTER_STUDENT', $request->get('filter_keyword'));
        Session::save(); 
        }
           /***********************Apply Condition ************/
   
        if(session()->has('FILTER_STUDENT')){
        $strFilterKeyword = Session::get('FILTER_STUDENT');
        $resStudentData = CsStudent::where('student_first_name', 'LIKE', "%{$strFilterKeyword}%")->paginate(20);
        //print_r($resVideoData);
        }else{
         $resStudentData = CsStudent::paginate(20);
        }    
     
      
   

    $title='Students';
    return view('Csadmin.Students.index',compact('title','resStudentData'));
  }
  
  public function studentStatus($intCategoryId)
    {
        $rowCategoryData = CsStudent::where('student_id',$intCategoryId)->first();
       // print_r($rowCategoryData);die;
        if($rowCategoryData->student_status==1){
            $status = 0;
        }else{
            $status = 1;
        }
        CsStudent::where('student_id', $intCategoryId)->update(array('student_status' => $status));
        return redirect()->route('all-students')->with('status', 'Entry Edited Successfully');
    }
  
   function studentProccess(Request $request)
    {
        $aryPostData = $request->all();
        if(isset($aryPostData['student_id']) && $aryPostData['student_id']>0)
        {
            $postobj = CsStudent::where('student_id',$aryPostData['student_id'])->first();
        }else{
            $postobj = new CsStudent;
        }   
        
        $postobj->student_status = 1;
        $postobj->student_first_name = $aryPostData['student_first_name'];
        $postobj->student_last_name = $aryPostData['student_last_name'];
        $postobj->student_gender = $aryPostData['student_gender'];
        $postobj->student_dob = $aryPostData['student_dob'];
        $postobj->student_email = $aryPostData['student_email'];
        $postobj->studentg_name = $aryPostData['studentg_name'];
        
       if(isset($aryPostData['student_new_password']) && isset($aryPostData['student_confirm_password']) && $aryPostData['student_confirm_password']==$aryPostData['student_new_password']){
               
             $postobj->student_password = $aryPostData['student_new_password'];
           } 
        
        $postobj->student_phone = $aryPostData['student_phone'];
        

        $postobj->student_registration_id = 'NEON'.rand(10000,100000);


        
        if($postobj->save())    
        {
            return redirect()->route('all-students')->with('status', 'Entry Saved Successfully.');   
        }else{
            return redirect()->route('all-students')->with('error', 'Server Not Responed');
        }
    }
    
    public function addNewStudent($intstudentId=0)
  {
       $resStudentData = array();
        if($intstudentId>0){
            $resStudentData = CsStudent::where('student_id','=',$intstudentId)->first();
        }
        $resStudentgroupData = CsStudentGroup::get();
        
    $title='Add New Student';
    return view('Csadmin.Students.addNewStudent' ,compact('title','resStudentData','resStudentgroupData'));
  }
  

  public function studentGroup($intCategoryId=0)
  {
      $rowCategoryData=array();
        if($intCategoryId>0)
        {
            $rowCategoryData = CsStudentGroup::where('sg_id',$intCategoryId)->first();
            //print_r($rowCategoryData);die;
        }
        $resCategoryData = CsStudentGroup::get();
        $tree = $this->buildTree($resCategoryData);
        $strCategoryHtml = $this->getCatgoryChildHtml($tree);
        $resChildCategory = CsStudentGroup::get();
      
        $title='Student Group';
        return view('Csadmin.Students.studentGroup',compact('title','resCategoryData','rowCategoryData','strCategoryHtml','resChildCategory'));
  }
  
  
  function buildTree($elements, $parentId = 0) 
    {
        $branch = array();
        foreach ($elements as $element) {
             
            if ($element['sg_parent'] == $parentId) {
                $children = $this->buildTree($elements, $element['sg_id']);
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
                
                $strHtml .='<tr>
                                <td scope="row" style="text-align:center; vertical-align: middle;"><input type="checkbox" id="selectAll" class="clsSelectSingle" name="sg_id[]" value="'.$label['sg_id'].'">
                            </td>';
              
                $strHtml .='<td><p class="mg-b-0 tx-medium">'.$strExtraData.$label['sg_name'].'</p></td>'; 
                
                // if($label['sg_status']==0){
                //     $strHtml .='<td><a href="'.ADMIN_URL.'changeStatusgroupCategory/'.$label['sg_id'].'" onclick="return confirm(\'Are you sure?\')"><span class="badge badge-danger">Inactive</span></a></td>';
                // }else{
                //     $strHtml .='<td><a href="'.ADMIN_URL.'changeStatusgroupCategory/'.$label['sg_id'].'" onclick="return confirm(\'Are you sure?\')"><span class="badge badge-success">Active</span></a></td>';
                // }
                $orederData = CsStudent::where('studentg_name','=',$label['sg_name'])->count();
                $strHtml .='<td style="text-align:center">'.$orederData.'</td>';
                
                $strHtml .='<td>
                                <div class="d-flex align-self-center justify-content-center">
                                    <nav class="nav nav-icon-only">
                                        <a href="'.ADMIN_URL.'student-group/'.$label['sg_id'].'" onclick="return confirm(\'Are you sure?\')" class="btn btn-primary btn-icon mg-r-5" title="Edit" style="padding:0px 5px;"><i class="fas fa-pencil-alt" style="font-size:11px;"></i></a>
                                        <a href="'.ADMIN_URL.'deletegroup/'.$label['sg_id'].'" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-icon mg-r-5" title="Delete" style="padding:0px 5px;"><i class="fas fa-trash-alt" style="font-size:11px;"></i></a>
                                    </nav>
                                </div>
                            </td>';
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
        
  
       function groupProccess(Request $request)
        {
        $aryPostData = $request->all();
        //print_r($aryPostData);die;
        if(isset($aryPostData['sg_id']) && $aryPostData['sg_id']>0)
        {
            $postobj = CsStudentGroup::where('sg_id',$aryPostData['sg_id'])->first();
        }else{
            $postobj = new CsStudentGroup;
            $postobj->sg_slug = Str::slug($aryPostData['sg_name'], '-');
        }   
        
        $postobj->sg_status = 1;
        $postobj->sg_name = $aryPostData['sg_name'];
        //  if($aryPostData['sg_order']==''){
            
        //   $max=CsStudentGroup::max('sg_order');
        //   $postobj->sg_order = $max+1;
            
        // }else{
        //   $postobj->sg_order = $aryPostData['sg_order'];

        // }
        
        if($postobj->save())    
        {
            return redirect()->route('student-group')->with('status', 'Entry Saved Successfully.');   
        }else{
            return redirect()->route('student-group')->with('error', 'Server Not Responed');
        }
    }
    public function changeStatusgroupCategory($intCategoryId)
    {
        $rowCategoryData = CsStudentGroup::where('sg_id',$intCategoryId)->first();
        if($rowCategoryData->sg_status==0){
            $status = 1;
        }else{
            $status = 0;
        }
        CsStudentGroup::where('sg_id', $intCategoryId)->update(array('sg_status' => $status));
        return redirect()->route('student-group')->with('status', 'Entry Edited Successfully');
    }
    
     public function deletegroup($intCategoryId)
    {
        CsStudentGroup::where('sg_id', $intCategoryId)->delete();
        return redirect()->route('student-group')->with('status', 'Entry Deleted Successfully');
    }
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
   public function viewstudent(Request $request)
  {
    $title='View Student';
    return view('Csadmin.Students.viewstudent')->with('title',$title);
  }
  public function studentDelete($intCategoryId)
    {
        CsStudent::where('student_id', $intCategoryId)->delete();
        return redirect()->route('all-students')->with('status', 'Entry Deleted Successfully');
    }
  
  
}