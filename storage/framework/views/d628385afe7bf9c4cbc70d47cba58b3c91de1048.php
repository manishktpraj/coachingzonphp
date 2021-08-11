
<?php $__env->startSection('content'); ?>
<?php //echo '<pre>';print_r($resCategoryData);
//echo $resCategoryData->vc_id;?>
<div class="content-body">
<div class="container pd-x-0">
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
<div>
<nav aria-label="breadcrumb">
<ol class="breadcrumb breadcrumb-style1 mg-b-10">
<li class="breadcrumb-item"><a href="#">Videos</a></li>
<li class="breadcrumb-item active" aria-current="page">All Video</li>
</ol>
</nav>
<h4 class="mg-b-0 tx-spacing--1">Manage Video</h4>
</div>
<div class="d-none d-md-block">
<a href="#" class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="file" class="wd-10 mg-r-5"></i>Export</a>
<a href="<?php echo e(route('add-new-video')); ?>" class="btn btn-sm pd-x-15 btn-primary btn-uppercase  mg-l-5"><i data-feather="plus" class="wd-10 mg-r-5"></i>Add New Video</a>
</div>

</div>
<div class="row row-xs">
<div class="col-lg-12">
<div class="card">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Video Lists</h6>
<div class="d-flex tx-18">
<a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
</div>
</div>
<div class="card-body">
<?php echo $__env->make('Csadmin.bulkaction', ['status' => 'FILTER_VIDEO'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
 

</div>
<div class="table-responsive">
<table class="table mg-b-0">
<thead>
<tr>
<th scope="col" style="text-align:center;width:10px;"><input type="checkbox" id="selectAll"></th>
<th scope="col" style="text-align:center;width:50px;">S.No.</th>
<th scope="col">Video Details</th>
<?php if($user->staff_role==3){?>
<th scope="col" style="text-align:center;">Published By</th>
<?php } ?>
<th scope="col">Type</th>
<th scope="col">Status</th>
<th scope="col">Date</th>
<th scope="col" style="text-align:center">Action</th>
</tr>
</thead>
<tbody>
<?php 
$i=1;if(count($resVideoData)>0){
foreach($resVideoData as $video)
{
    //$resData = $resCategoryData::where
?>
<tr>
<th scope="row" style="text-align:center"><input type="checkbox" id="selectAll" class="clsSelectSingle" name="video_id[]" value="<?php echo $video->video_id ?>"></th>
<th scope="row" style="text-align:center"><?php echo $i++;?></th>
<td>
<div class="media align-items-center mg-b-0">
<div class="avatar" style="border:1px solid #ddd;"><img src="<?php echo (isset($video->video_image) && $video->video_image!="")?SITE_UPLOAD_URL.SITE_VIDEO_IMAGE.$video->video_image:SITE_NO_IMAGE_PATH;?>" class="rounded" alt=""></div>
<div class="media-body pd-l-10">
<h6 class="mg-b-3"  style="text-overflow: ellipsis;white-space: nowrap;overflow: hidden;width: 200px;"><a href="<?php echo(isset($video->video_file) && $video->video_file!="")? SITE_UPLOAD_URL.SITE_VIDEO_IMAGE.$video->video_file:'' ?>" <?php if(isset($video->video_file) && $video->video_file!=""){echo "target='_blank'";}?> ><?php echo $video->video_name;?></a></h6>
<span class="d-block tx-13 tx-color-03"><?php echo $video->video_vc_name?></span>
</div>
</div> 
</td>
<?php if($user->staff_role==3){?>
<td style="text-align:center;"><span class="tx-13"><?php echo isset($video->ins_name)?$video->ins_name:'Admin';?></span></td>
<?php } ?>
<td><?php if($video->video_type==0){echo "Live";}elseif($video->video_type==1){echo "Recorded";}else{echo "Demo";}?></td>
<td>
    <?php if($video->video_status==1){?>
    <a href="<?php echo e(route('videoStatus',$video->video_id)); ?>"><span class="badge badge-success">Active</span></a>
    <?php }else{?>
    <a href="<?php echo e(route('videoStatus',$video->video_id)); ?>"><span class="badge badge-danger">Inactive</span></a>
    <?php }?>
    
</td>
<td><?php echo date("d M Y",strtotime($video->created_at));?></td>
<td>
<div class="d-flex align-self-center justify-content-center">
<nav class="nav nav-icon-only">
<a href="<?php echo e(route('add-new-video',$video->video_id )); ?>" class="btn btn-primary btn-icon mg-r-5" title="Edit" style="padding:0px 5px;"><i class="fas fa-pencil-alt" style="font-size:11px;"></i></a>
<a href="<?php echo e(route('videoDelete',$video->video_id )); ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-icon mg-r-5" title="Delete" style="padding:0px 5px;"><i class="fas fa-trash-alt" style="font-size:11px;"></i></a>
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

<span class="text-muted"><?php echo 'Showing '.$resVideoData->firstItem().' to '.$resVideoData->lastItem().' of '.$resVideoData->total().' entries';?></span>
<ul class="pagination pagination-filled mg-b-0"><?php echo e($resVideoData->links()); ?></ul>
</div>
</div>
</div>
</div>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('Csadmin.Layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\php\xamp\htdocs\coachingzon\resources\views/Csadmin/Videos/index.blade.php ENDPATH**/ ?>