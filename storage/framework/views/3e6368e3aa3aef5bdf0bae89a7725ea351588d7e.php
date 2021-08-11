<?php $__env->startSection('content'); ?>
<?php //print_r($resPackageData);?>
<div class="content-body">
<div class="container pd-x-0">
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
<div>
<nav aria-label="breadcrumb">
<ol class="breadcrumb breadcrumb-style1 mg-b-10">
<li class="breadcrumb-item"><a href="#">Packages</a></li>
<li class="breadcrumb-item active" aria-current="page">All Packages</li>
</ol>
</nav>
<h4 class="mg-b-0 tx-spacing--1"><?php echo $resPackageData->package_name;?></h4>
</div>
<div class="d-none d-md-block">
</div>
</div>
<div class="row row-xs">
<div class="col-lg-12">

<!----------Video Section-------------->
<?php  if($resPackageData->package_type==3 || $resPackageData->package_type==2|| $resPackageData->package_type==1){?>

<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Videos in this course</h6>
<div class="d-flex">
<a href="#modal1" data-toggle="modal" class="btn btn-xs btn-success vid_id" data-id="<?php echo $id;?>" ><i data-feather="plus" class="mg-r-5"></i>
Add Videos</a>
</div>
</div>
<div class="card-body">
<div class="row row-xs">
<?php foreach($resAssignedData as $video_data){   
 if($video_data->pkd_type==3){
 // echo $video_data->pkd_pack_id;
   //print_r($video_data);
    //echo "where('video_vc_id','=',$video_data->pkd_ref)";
  $orederData = $vidData->where('video_vc_id','=',$video_data->pkd_ref)->count();
//echo $orederData;
 
 ?>  
 <input type="hidden" value="<?php echo $video_data->pkd_pack_id; ?>" name="pack_id"> 
<div class="col-sm-6 col-lg-4 col-xl-3">
<div class="media media-folder">
<i data-feather="folder"></i>
<div class="media-body">
<h6><a href="" class="link-02"><?php echo $video_data->pkd_name;?></a></h6>
<span><?php echo $orederData;?> files</span>
</div>
<div class="dropdown-file">
<a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
<div class="dropdown-menu dropdown-menu-right">
<a href="<?php echo e(route('deletepackagedetail',$video_data->pkd_id,)); ?>" class="dropdown-item delete"><i data-feather="trash"></i>Delete</a>
</div>
</div>
</div>
</div>

<?php }} ?>
</div>
</div>
</div>
<?php }?>
<!----------Video Section-------------->

<!----------Test Section-------------->
<?php  if($resPackageData->package_type==3 || $resPackageData->package_type==2|| $resPackageData->package_type==0){?>

<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Tests in this course</h6>
<div class="d-flex">
<a href="#modal" data-toggle="modal" class="btn btn-xs btn-success vid_id" data-id="<?php echo $id;?>" ><i data-feather="plus" class="mg-r-5"></i>
Add Test</a>
</div>
</div>
<div class="card-body">
<div class="row row-xs">
<?php foreach($resAssignedData as $video_data){   
 if($video_data->pkd_type==2){
   // print_r($vidData);
    //echo "where('video_vc_id','=',$video_data->pkd_ref)";
  $orederData = $testData->where('test_tc_id','=',$video_data->pkd_ref)->count();
//echo $orederData;
 
 ?>   
<div class="col-sm-6 col-lg-4 col-xl-3">
<div class="media media-folder">
<i data-feather="folder"></i>
<div class="media-body">
<h6><a href="" class="link-02"><?php echo $video_data->pkd_name;?></a></h6>
<span><?php echo $orederData;?> files</span>
</div>
<div class="dropdown-file">
<a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
<div class="dropdown-menu dropdown-menu-right">
<a href="<?php echo e(route('deletepackagedetail',$video_data->pkd_id)); ?>" class="dropdown-item delete"><i data-feather="trash"></i>Delete</a>
</div>
</div>
</div>
</div>

<?php }} ?>
</div>
</div>
</div>
<?php } ?>
<!----------Test Section-------------->

<!----------Pdf Section-------------->

<?php  if($resPackageData->package_type==3){?>
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Study Materials in this course</h6>
<div class="d-flex">
<a href="#modal4" data-toggle="modal" class="btn btn-xs btn-success vid_id" data-id="<?php echo $id;?>" ><i data-feather="plus" class="mg-r-5"></i>
Add Study Material</a>
</div>
</div>
<div class="card-body">
<div class="row row-xs">
<?php foreach($resAssignedData as $video_data){   
 if($video_data->pkd_type==4){
   // print_r($vidData);
    //echo "where('video_vc_id','=',$video_data->pkd_ref)";
  $orederData = $respdfcount->where('sm_sc_id','=',$video_data->pkd_ref)->count();
//echo $orederData;
 
 ?>   
<div class="col-sm-6 col-lg-4 col-xl-3">
<div class="media media-folder">
<i data-feather="folder"></i>
<div class="media-body">
<h6><a href="" class="link-02"><?php echo $video_data->pkd_name;?></a></h6>
<span><?php echo $orederData;?> files</span>
</div>
<div class="dropdown-file">
<a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
<div class="dropdown-menu dropdown-menu-right">
<a href="<?php echo e(route('deletepackagedetail',$video_data->pkd_id)); ?>" class="dropdown-item delete"><i data-feather="trash"></i>Delete</a>
</div>
</div>
</div>
</div>

<?php }} ?>
</div>
</div>
</div>
<?php } ?>
<!----------Pdf Section-------------->

<!----------Faculty Section-------------->


<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Faculties in this course</h6>
<div class="d-flex">

<a href="#modal2" class="btn btn-xs btn-success vid_id" data-toggle="modal"><i data-feather="plus" class="mg-r-5"></i>
Add Faculty</a>
</div>
</div>
<div class="card-body">
<div class="row row-xs">
<?php foreach($resAssignedData as $video_data){
if($video_data->pkd_type==1){?>
<div class="col-sm-4 col-md-3 col-lg-4 col-xl-3 mg-b-10">
<div class="card card-profile" style="box-shadow:none">
<div class="card-body tx-13">
<div style="margin-top:0px">
<a href="">
<div class="avatar avatar-lg"><img src="https://via.placeholder.com/500" class="rounded-circle" alt=""></div>
</a>
<h5><a href=""><?php echo $video_data->pkd_name;?></a></h5>
<p class="mg-b-0">Software Engineer</p>
</div>
</div>
</div>
</div>
<?php }} ?>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

<!----------Faculty Section-------------->


<!----------------------------------Faculty modal-------------------------------------->

<div class="modal fade show" id="modal2">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content tx-14">
<div class="modal-header">
<h6 class="modal-title" id="exampleModalLabel2">Add Faculties in this course</h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
<form method="post" action="<?php echo e(route('assignedPackageProccess')); ?>" enctype="multipart/form-data">
<?php echo csrf_field(); ?>
<input type="text" hidden name="package_id" value="<?php echo $id;?>" >
<input type="text" hidden name="pkd_type" value="1" >

<div class="modal-body" style="padding:0px;height: 300px;overflow-x: hidden;overflow-y: auto;">
<div class="table-responsive">
<table class="table mg-b-0">
<thead>

</thead>
<tbody>
<?php if(isset($resFacultyData))
{// echo $resFacultyData;
$cnt =0;
foreach($resFacultyData as $faculty){
    $cnt++;
  //  print_r($resAssignedData);
?>
<tr>
<input type="hidden" value="<?php echo $faculty->staff_name;?>" name="pkd_name[<?php echo $cnt; ?>]">

<td scope="row" ><?php echo $faculty->staff_name;?></td>
<td scope="row" style="text-align:center;width: 50px;"><input type="checkbox" id="selectAll" class="clsSelectSingle" name="pkd_pack_id[<?php echo $cnt; ?>]" style="vertical-align: middle;" value="<?php echo $faculty->staff_id; ?>" <?php foreach($resAssignedData as $data){if($data->pkd_ref==$faculty->staff_id){echo "checked";}}?> ></td></tr>

<?php }
}else{?>  
<tr><td colspan="2" class="text-center">No Record Found</td></tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
<button type="submit" class="btn btn-primary tx-13">Save</button>
</div>
</form>
</div>
</div>
</div>
<!----------------------------------Faculty modal-------------------------------------->

<!----------------------------------Video modal---------------------------------------->

<div class="modal fade show" id="modal1">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content tx-14">
<div class="modal-header">
<h6 class="modal-title" id="exampleModalLabel1">Add Video in this course</h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
<form method="post" action="<?php echo e(route('assignedPackageProccess')); ?>" enctype="multipart/form-data">
<?php echo csrf_field(); ?>
<input type="text" hidden name="package_id" value="<?php echo $id;?>" >
<input type="text" hidden name="pkd_type" value="3" >

<div class="modal-body" style="padding:0px;height: 300px;overflow-x: hidden;overflow-y: auto;">
<div class="table-responsive">
<table class="table mg-b-0">
<thead>
</thead>
<tbody>
<?php if(isset($resVideoData))
{  //  print_r($resVideoData);die;

$cnt =0;
foreach($resVideoData as $video){
    $cnt++;
?>
<tr>
<input type="hidden" value="<?php echo $video->vc_name;?>" name="pkd_name[<?php echo $cnt; ?>]">

<td scope="row"><?php echo $video->vc_name;?></td>
<td scope="row" style="text-align:center;width: 50px;"><input type="checkbox" id="selectAll" class="clsSelectSingle" name="pkd_pack_id[<?php echo $cnt; ?>]" style="vertical-align: middle;" value="<?php echo $video->vc_id; ?>" <?php foreach($resAssignedData as $data){if($data->pkd_ref==$video->vc_id){echo "checked";}}?>></td></tr>
<?php }
}else{?>  
<tr><td colspan="3" class="text-center">No Record Found</td></tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
<button type="submit" class="btn btn-primary tx-13">Save</button>

</div>
</form>
</div>
</div>
</div>
<!----------------------------------Video modal-------------------------------------->

<!----------------------------------Pdf modal---------------------------------------->

<div class="modal fade show" id="modal4">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content tx-14">
<div class="modal-header">
<h6 class="modal-title" id="exampleModalLabel4">Add Video in this course</h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
<form method="post" action="<?php echo e(route('assignedPackageProccess')); ?>" enctype="multipart/form-data">
<?php echo csrf_field(); ?>
<input type="text" hidden name="package_id" value="<?php echo $id;?>" >
<input type="text" hidden name="pkd_type" value="4" >

<div class="modal-body" style="padding:0px;height: 300px;overflow-x: hidden;overflow-y: auto;">
<div class="table-responsive">
<table class="table mg-b-0">
<thead>
</thead>
<tbody>
<?php if(isset($respdfData))
{  //  print_r($resVideoData);die;

$cnt =0;
foreach($respdfData as $pdf){
    $cnt++;
?>
<tr>
<input type="hidden" value="<?php echo $pdf->sc_name;?>" name="pkd_name[<?php echo $cnt; ?>]">

<td scope="row"><?php echo $pdf->sc_name;?></td>
<td scope="row" style="text-align:center;width: 50px;"><input type="checkbox" id="selectAll" class="clsSelectSingle" name="pkd_pack_id[<?php echo $cnt; ?>]" style="vertical-align: middle;" value="<?php echo $pdf->sc_id; ?>" <?php foreach($resAssignedData as $data){if($data->pkd_ref==$pdf->sc_id){echo "checked";}}?>></td></tr>
<?php }
}else{?>  
<tr><td colspan="3" class="text-center">No Record Found</td></tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
<button type="submit" class="btn btn-primary tx-13">Save</button>

</div>
</form>
</div>
</div>
</div>
<!----------------------------------pdf modal-------------------------------------->

<!----------------------------------Test modal-------------------------------------->

<div class="modal fade show" id="modal">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content tx-14">
<div class="modal-header">
<h6 class="modal-title" id="exampleModalLabel">Add Test in this course</h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
<form method="post" action="<?php echo e(route('assignedPackageProccess')); ?>" enctype="multipart/form-data">
<?php echo csrf_field(); ?>
<input type="text" hidden name="package_id" value="<?php echo $id;?>" >
<input type="text" hidden name="pkd_type" value="2" >

<div class="modal-body" style="padding:0px;height: 300px;overflow-x: hidden;overflow-y: auto;">
<div class="table-responsive">
<table class="table mg-b-0">
<thead>

</thead>
<tbody>
<?php if(isset($resTestData))
{//echo $resAssignedData->assigned_v_id; die;
$cnt =0;
foreach($resTestData as $test){
    $cnt++;
?>
<tr>
<input type="hidden" value="<?php echo $test->tc_name;?>" name="pkd_name[<?php echo $cnt; ?>]">
<td scope="row"><?php echo $test->tc_name;?></td>
<td scope="row" style="text-align:center;width: 50px;"><input type="checkbox" id="selectAll" class="clsSelectSingle" name="pkd_pack_id[<?php echo $cnt; ?>]" style="vertical-align: middle;" value="<?php echo $test->tc_id; ?>" <?php foreach($resAssignedData as $data){if($data->pkd_ref==$test->tc_id){echo "checked";}}?>></td></tr>
</tr>
<?php }
}else{?>  
<tr><td colspan="2" class="text-center">No Record Found</td></tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
<button type="submit" class="btn btn-primary tx-13">Save</button>
</div>
</form>
</div>
</div>
</div>
<!----------------------------------Test modal-------------------------------------->


<?php $__env->stopSection(); ?>
<?php echo $__env->make('Csadmin.Layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\php\xamp\htdocs\coachingzon\resources\views/Csadmin/Packages/packageManage.blade.php ENDPATH**/ ?>