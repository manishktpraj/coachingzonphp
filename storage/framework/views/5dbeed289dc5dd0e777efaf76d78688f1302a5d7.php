
<?php $__env->startSection('content'); ?>
<div class="content-body">
<div class="container pd-x-0">
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
<div>
<nav aria-label="breadcrumb">
<ol class="breadcrumb breadcrumb-style1 mg-b-10">
<li class="breadcrumb-item"><a href="#">Study Materials</a></li>
<li class="breadcrumb-item active" aria-current="page">All Study Materials</li>
</ol>
</nav>
<h4 class="mg-b-0 tx-spacing--1">Manage Study Materials</h4>
</div>
<div class="d-none d-md-block">
<a href="<?php echo e(route('add-new-study')); ?>" class="btn btn-sm pd-x-15 btn-primary btn-uppercase  mg-l-5"><i data-feather="plus" class="wd-10 mg-r-5"></i>Add New Study Materials</a>
</div>
</div>
<div class="row row-xs">
<div class="col-lg-12">
<div class="card">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Study Materials Lists</h6>
<div class="d-flex tx-18">
<a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
</div>
</div>
<div class="card-body">
<?php echo $__env->make('Csadmin.bulkaction', ['status' => 'FILTER_STUDY'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<div class="table-responsive">
<table class="table mg-b-0">
<thead>
<tr>
<th scope="col" style="text-align:center;width:10px;"><input type="checkbox" id="selectAll"></th>
<th scope="col" style="text-align:center;width:50px;">S.No.</th>
<th scope="col">Study Materials Details</th>
<th scope="col">Type</th>
<th scope="col">Status</th>
<th scope="col">Date</th>
<th scope="col" style="text-align:center">Action</th>
</tr>
</thead>
<tbody>
<?php if(count($resStudyMaterialData)>0){
$i=1;
foreach($resStudyMaterialData as $value){?>
<tr>
<th scope="row" style="text-align:center;vertical-align: middle;"><input type="checkbox" id="selectAll" class="clsSelectSingle" name="sm_id[]" value="<?php echo $value->sm_id ?>"></th>
<th scope="row" style="text-align:center"><?php echo $i++;?></th>
<td>
<div class="media align-items-center mg-b-0">
<div class="avatar"><img src="<?php echo (isset($value->sm_image) && $value->sm_image!="")?SITE_UPLOAD_URL.SITE_STUDY_MATERIAL_IMAGE.$value->sm_image:SITE_NO_IMAGE_PATH;?>" class="rounded-circle" alt=""></div>
<div class="media-body pd-l-10">
<h6 class="mg-b-3"><a href="#"><?php echo $value->sm_name?></a></h6>
<span class="d-block tx-13 tx-color-03"><?php echo $value->sm_sc_name?></span>
</div>
</div>
</td>
<td><?php echo (isset($value->sm_type) && $value->sm_type=="0")?'Free':'Paid'?></td>
<td>
    <?php if($value->sm_status==0){?>
    <a href="<?php echo e(route('studyMaterialStatus',$value->sm_id)); ?>"><span class="badge badge-danger">Inactive</span></a>
    <?php }else{?>
    <a href="<?php echo e(route('studyMaterialStatus',$value->sm_id)); ?>"><span class="badge badge-success">Active</span></a>
    <?php }?>
</td>
<td><?php echo date("d M Y",strtotime($value->created_at))?></td>
<td>
<div class="d-flex align-self-center justify-content-center">
<nav class="nav nav-icon-only">
<!--<a href="#" class="btn btn-info btn-icon mg-r-5" title="Copy Listing" style="padding:0px 5px;"><i class="fas fa-copy" style="font-size:11px;"></i></a>
--><a href="<?php echo e(route('add-new-study',$value->sm_id)); ?>" class="btn btn-primary btn-icon mg-r-5" title="Edit" style="padding:0px 5px;"><i class="fas fa-pencil-alt" style="font-size:11px;"></i></a>
<a href="<?php echo e(route('studyMaterialDelete',$value->sm_id)); ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-icon mg-r-5" title="Delete" style="padding:0px 5px;"><i class="fas fa-trash-alt" style="font-size:11px;"></i></a>
</nav>
</div>
</td>
</tr>
<?php }}else{ ?>
<tr><td colspan="6" class="text-center">No Record Found</td></tr>
<?php }?>
</tbody>
</table>
</div>
<div class="card-footer d-flex align-items-center justify-content-between" style="align-items: center;">

<span class="text-muted"><?php echo 'Showing '.$resStudyMaterialData->firstItem().' to '.$resStudyMaterialData->lastItem().' of '.$resStudyMaterialData->total().' entries';?></span>
<ul class="pagination pagination-filled mg-b-0"><?php echo e($resStudyMaterialData->links()); ?></ul>
</div>
</div>
</div>
</div>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('Csadmin.Layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\php\xamp\htdocs\coachingzon\resources\views/Csadmin/Study/index.blade.php ENDPATH**/ ?>