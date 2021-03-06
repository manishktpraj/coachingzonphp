
<?php $__env->startSection('content'); ?>
<?php //echo '<pre>';print_r($resCategoryData);
//echo $resCategoryData->vc_id;?>
<div class="content-body">
<div class="container pd-x-0">
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
<div>
<nav aria-label="breadcrumb">
<ol class="breadcrumb breadcrumb-style1 mg-b-10">
<li class="breadcrumb-item"><a href="#">Test/Exams</a></li>
<li class="breadcrumb-item active" aria-current="page">All Test/Exams</li>
</ol>
</nav>
<h4 class="mg-b-0 tx-spacing--1">Manage Test/Exams</h4>
</div>
<div class="d-none d-md-block">
<a href="#" class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="file" class="wd-10 mg-r-5"></i>Export</a>
<a href="<?php echo e(route('addnewtest')); ?>" class="btn btn-sm pd-x-15 btn-primary btn-uppercase  mg-l-5"><i data-feather="plus" class="wd-10 mg-r-5"></i>Add New Test/Exams</a>
</div>
</div>
<div class="row row-xs">
<div class="col-lg-12">
<div class="card">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Test/Exams Lists</h6>
<div class="d-flex tx-18">
<a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
</div>
</div>
<div class="card-body">
<?php echo $__env->make('Csadmin.bulkaction', ['status' => 'FILTER_TEST'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<div class="table-responsive">
<table class="table mg-b-0">
<thead>
<tr>
<th scope="col" style="text-align:center;width:10px;"><input type="checkbox" id="selectAll"></th>
<th scope="col" style="text-align:center;width:50px;">S.No.</th>
<th scope="col">Test Details</th>
<?php if($user->staff_role==3){?>
<th scope="col" style="text-align:center;">Published By</th>
<?php } ?>
<th scope="col">Type</th>
<th scope="col">Status</th>
<th scope="col">Published Date</th>
<th scope="col" style="text-align:center">Action</th>
</tr>
</thead>
<tbody>
<?php  
$i=1;if(count($resTestData)>0){
 //print_r($resTestData);
foreach($resTestData as $test)
{
    //$resData = $resCategoryData::where
?>
<tr>
<th scope="row" style="text-align:center;vertical-align: middle;"><input type="checkbox" id="selectAll" class="clsSelectSingle" name="test_id[]" value="<?php echo $test->test_id ?>"></th>
<th scope="row" style="text-align:center"><?php echo $i++;?></th>
<td>
<div class="media align-items-center mg-b-0">
<div class="avatar" style="border:1px solid #ddd;"><img src="<?php echo (isset($test->test_image) && $test->test_image!="")?SITE_UPLOAD_URL.SITE_TEST_IMAGE.$test->test_image:SITE_NO_IMAGE_PATH;?>" class="rounded" alt=""></div>
<div class="media-body pd-l-10">
<h6 class="mg-b-3"  style="text-overflow: ellipsis;white-space: nowrap;overflow: hidden;width: 200px;"><a href="#"><?php echo $test->test_name;?></a></h6>
<span class="d-block tx-13 tx-color-03"><?php echo $test->test_tc_name?></span>
</div>
</div>
</td>
<?php if($user->staff_role==3){?>
<td style="text-align:center;"><span class="tx-13"><?php echo isset($test->ins_name)?$test->ins_name:'Admin';?></span></td>
<?php } ?>
<td><?php echo $test->test_subject;?></td>
<td>
    <?php if($test->test_status==1){?>
    <a href="<?php echo e(route('testStatus',$test->test_id)); ?>"><span class="badge badge-success">Active</span></a>
    <?php }else{?>
    <a href="<?php echo e(route('testStatus',$test->test_id)); ?>"><span class="badge badge-danger">Inactive</span></a>
    <?php }?>
</td>
<td><?php echo date("d M Y",strtotime($test->created_at));?></td>
<td>
<div class="d-flex align-self-center justify-content-center">
<nav class="nav nav-icon-only">
<a href="<?php echo e(route('testQuestion',$test->test_id )); ?>" class="btn btn-info btn-icon mg-r-5" title="Questiion" style="padding:0px 5px;"><i class="fas fa-copy" style="font-size:11px;"> +</i></a>

<a href="<?php echo e(route('addnewtest',$test->test_id )); ?>" class="btn btn-primary btn-icon mg-r-5" title="Edit" style="padding:0px 5px;"><i class="fas fa-pencil-alt" style="font-size:11px;"></i></a>
<a href="<?php echo e(route('testDelete',$test->test_id )); ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-icon mg-r-5" title="Delete" style="padding:0px 5px;"><i class="fas fa-trash-alt" style="font-size:11px;"></i></a>
</nav>
</div>
</td>
</tr>    
<?php }}else{ ?>
<tr><td colspan="8" class="text-center">No Record Found</td></tr>
<?php } ?>    
</tbody>
</table>
</div>
<div class="card-footer d-flex align-items-center justify-content-between" style="align-items: center;">

<span class="text-muted"><?php echo 'Showing '.$resTestData->firstItem().' to '.$resTestData->lastItem().' of '.$resTestData->total().' entries';?></span>
<ul class="pagination pagination-filled mg-b-0"><?php echo e($resTestData->links()); ?></ul>
</div>
</div>
</div>
</div>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('Csadmin.Layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\php\xamp\htdocs\coachingzon\resources\views/Csadmin/Tests/index.blade.php ENDPATH**/ ?>