<?php namespace App\Http\Controllers\Csadmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
use Session;
use App\Http\Model\CsSubject;
use App\Http\Model\Csdmin;
use Validator;
use Illuminate\Support\Str;


class QuestionController extends Controller
{
  public function index(Request $request)
  {
    $title='Question';
    return view('Csadmin.Question.index')->with('title',$title);
  }
  
  public function addNewQuestion(Request $request)
  {
    $resSubData= CsSubject::get();
     // print_r($resQuesData);
      
    $title='Add New Question';
    return view('Csadmin.Question.addNewQuestion',compact('title','resSubData'));
  }
  
  public function questionSubjects($intCategoryId=0)
  {
      $rowCategoryData=array();
        if($intCategoryId>0)
        {
            $rowCategoryData = CsSubject::where('sc_id',$intCategoryId)->first();
        }
        $resCategoryData = CsSubject::get();
        $tree = $this->buildTree($resCategoryData);
        $strCategoryHtml = $this->getCatgoryChildHtml($tree);
        $resChildCategory = CsSubject::get();
      
    $title='Question Subjects';
     return view('Csadmin.Question.questionSubjects',compact('title','resCategoryData','rowCategoryData','strCategoryHtml','resChildCategory'));
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
                
                $strHtml .='<tr>
                                <td scope="row" style="text-align:center; vertical-align: middle;"><input type="checkbox" id="selectAll" class="clsSelectSingle" name="sc_id[]" value="'.$label['sc_id'].'">
                            </td>';
              
                $strHtml .='<td><p class="mg-b-0 tx-medium">'.$strExtraData.$label['sc_name'].'</p></td>'; 
                
                if($label['sc_status']==0){
                    $strHtml .='<td><a href="'.ADMIN_URL.'changeStatusQCategory/'.$label['sc_id'].'" onclick="return confirm(\'Are you sure?\')"><span class="badge badge-danger">Inactive</span></a></td>';
                }else{
                    $strHtml .='<td><a href="'.ADMIN_URL.'changeStatusQCategory/'.$label['sc_id'].'" onclick="return confirm(\'Are you sure?\')"><span class="badge badge-success">Active</span></a></td>';
                }
                $strHtml .='<td style="text-align:center">0</td>';
                
                $strHtml .='<td>
                                <div class="d-flex align-self-center justify-content-center">
                                    <nav class="nav nav-icon-only">
                                        <a href="'.ADMIN_URL.'editsubject/'.$label['sc_id'].'" onclick="return confirm(\'Are you sure?\')" class="btn btn-primary btn-icon mg-r-5" title="Edit" style="padding:0px 5px;"><i class="fas fa-pencil-alt" style="font-size:11px;"></i></a>
                                        <a href="'.ADMIN_URL.'deletesubject/'.$label['sc_id'].'" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-icon mg-r-5" title="Delete" style="padding:0px 5px;"><i class="fas fa-trash-alt" style="font-size:11px;"></i></a>
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
        
        
       function subjectProccess(Request $request)
        {
        $aryPostData = $request->all();
        //print_r($aryPostData);die;
        if(isset($aryPostData['sc_id']) && $aryPostData['sc_id']>0)
        {
            $postobj = CsSubject::where('sc_id',$aryPostData['sc_id'])->first();
        }else{
            $postobj = new CsSubject;
            $postobj->sc_slug = Str::slug($aryPostData['sc_name'], '-');
        }   
        
        $postobj->sc_status = 1;
        $postobj->sc_name = $aryPostData['sc_name'];
        $postobj->sc_order = $aryPostData['sc_order'];

        
        if($postobj->save())    
        {
            return redirect()->route('question-subjects')->with('status', 'Entry Saved Successfully.');   
        }else{
            return redirect()->route('question-subjects')->with('error', 'Server Not Responed');
        }
    }
    public function changeStatusQCategory($intCategoryId)
    {
        $rowCategoryData = CsSubject::where('sc_id',$intCategoryId)->first();
        if($rowCategoryData->sc_status==0){
            $status = 1;
        }else{
            $status = 0;
        }
        CsSubject::where('sc_id', $intCategoryId)->update(array('sc_status' => $status));
        return redirect()->route('question-subjects')->with('status', 'Entry Edited Successfully');
    }
     public function deletesubject($intCategoryId)
    {
        CsSubject::where('sc_id', $intCategoryId)->delete();
        return redirect()->route('question-subjects')->with('status', 'Entry Deleted Successfully');
    }
     /*   
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
    }*/
    
    public function bulkActionsSubject(Request $request)
    {
        $aryPostData = $request->all();
        //print_r($aryPostData);die;
        unset($aryPostData['_token']);
        $aryPostData =$_POST;
        $intBulkAction = $aryPostData['bulkaction'];
        if($intBulkAction==1)
        {
            CsSubject::whereIn('sc_id', $aryPostData['sc_id'])->delete();
            return redirect()->route('question-subjects')->with('status', 'Entry Deleted Successfully');
        }
        if($intBulkAction==2)
        {
            CsSubject::whereIn('sc_id', $aryPostData['sc_id'])->update(['sc_status' => 1]);
            return redirect()->route('question-subjects')->with('status', 'Entry Deleted Successfully');
        }
        if($intBulkAction==3)
        {
            CsSubject::whereIn('sc_id', $aryPostData['sc_id'])->update(['sc_status' => 0]);
            return redirect()->route('question-subjects')->with('status', 'Entry Deleted Successfully');
        }
         
    }
    
    public function exportQuestion(Request $request){
        
      $title='Export Question';
    return view('Csadmin.Question.exportQuestion')->with('title',$title);  
    }
    
    public function importQuestion(Request $request){
        
      $title='Import Question';
    return view('Csadmin.Question.importQuestion')->with('title',$title);  
    }
    
    
    
    
    
    
}