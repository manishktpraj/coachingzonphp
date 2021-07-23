
<?php $__env->startSection('content'); ?>
<?php //print_r($strCategory); echo "shikha";?>

<div class="content-body">
<div class="container pd-x-0">
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
<div>
<nav aria-label="breadcrumb">
<ol class="breadcrumb breadcrumb-style1 mg-b-10">
<li class="breadcrumb-item"><a href="#">Live Classes and Videos</a></li>
<li class="breadcrumb-item active" aria-current="page">Add new Videos</li>
</ol>
</nav>
<h4 class="mg-b-0 tx-spacing--1">Add New Videos</h4>
</div>
</div>
<form method="post" action="<?php echo e(route('videoProccess')); ?>" enctype="multipart/form-data">
<?php echo csrf_field(); ?>
<input type="hidden" name="video_id" value="<?php echo isset($resVideoData->video_id)?$resVideoData->video_id:'0'?>">
<div class="row row-xs">
<div class="col-lg-8">
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Videos Details</h6>
</div>
<div class="card-body">
<div class="form-group mg-b-10">
<label>Videos Name / Title:<span style="color:red">*</span></label>
<input type="text" class="form-control" name="video_name" required="" value="<?php echo isset($resVideoData->video_name)?$resVideoData->video_name:''?>">
</div>
</div>
</div>
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Description</h6>
</div>
<div class="card-body" style="padding:0px;">
<textarea name="video_desc" class="ckeditor"><?php echo isset($resVideoData->video_desc)?$resVideoData->video_desc:''?></textarea>
</div>
</div>

<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Video Configuration</h6>
</div>
<div class="card-body" >
<div class="row row-xs">
<div class="col-lg-6">
<div class="form-group">
<label>Video Type:</label>
<select class="custom-select" name="video_type" required>
<option value="">Select Type</option>
<option value="0" <?php  echo (isset($resVideoData->video_type) && $resVideoData->video_type=="0")?'selected':''?> >Live Video</option>
<option value="1" <?php  echo (isset($resVideoData->video_type) && $resVideoData->video_type=="1")?'selected':''?> >Recorded Video</option>
<option value="2" <?php  echo (isset($resVideoData->video_type) && $resVideoData->video_type=="2")?'selected':''?> >Demo Video</option>

</select>
</div>
</div>   
<div class="col-lg-6">
<div class="form-group">
<label>Server Configuration:</label>
<select class="custom-select" name="video_configuration" required>
<option value="">Select Configuration</option>
<option value="0"<?php  echo (isset($resVideoData->video_configuration) && $resVideoData->video_configuration=="0")?'selected':''?>>Default</option>
<option value="1"<?php  echo (isset($resVideoData->video_configuration) && $resVideoData->video_configuration=="1")?'selected':''?>>Youtube</option>
</select>
</div>
</div>   
</div>
<div class="row row-xs">

<div class="col-lg-12">
<div class="form-group">
<label>Video URL:</label>
<input type="text" class="form-control" name="video_url" value="<?php echo isset($resVideoData->video_url)?$resVideoData->video_url:''?>" required>
</div>
</div>   

</div>
<div class="row row-xs">

<div class="col-lg-12">
<div class="form-group">
<label>Offline Video URL:</label>
<input type="text" class="form-control" name="video_offline_url" value="<?php echo isset($resVideoData->video_offline_url)?$resVideoData->video_offline_url:''?>">
</div>
</div>   

</div>
</div>
</div>
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Other Information</h6>
</div>
<div class="card-body" >
<div class="row row-xs">
<div class="col-lg-6">
<div class="form-group mg-b-10">
<label>Start Date & Time:</label>
<div class="row row-xs">
<div class="col-lg-6">
<input type="date" class="form-control" name="video_start_date" value="<?php echo isset($resVideoData->video_start_date)?$resVideoData->video_start_date:''?>">    
</div>    
<div class="col-lg-6"><input type="time" class="form-control" name="video_start_time" value="<?php echo isset($resVideoData->video_start_time)?$resVideoData->video_start_time:''?>"> </div> 
</div>
</div>
</div>

<div class="col-lg-3">
<div class="form-group mg-b-0">
<label>Video Size:</label>
<input type="text" class="form-control" name="video_size"  value="<?php echo isset($resVideoData->video_size)?$resVideoData->video_size:''?>">
</div>
</div>
<div class="col-lg-3">
<div class="form-group mg-b-0">
<label>Video Duration:</label>
<input type="text" class="form-control" name="video_duration"  value="<?php echo isset($resVideoData->video_duration)?$resVideoData->video_duration:''?>">
</div>
</div>
</div>
</div>

</div>
</div>
<div class="col-lg-4">
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Publish</h6>
</div>
 
<div class="card-footer" style="padding: 0.75rem 1rem;">
<button type="submit" onclick="return checkValidation($(this))" class="btn btn-success">Publish</button>
</div>
</div>
<div class="card  mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Categories</h6>
</div>
<div class="card-body">
<p class="tx-color-03 tx-12">Select category in which you want to display this product. You can also select multiple categories for this product.</p>
<div class="card" style="box-shadow:none">
<div class="card-body" style="padding:15px; height: 250px;overflow-x: hidden;">
<?php echo $strCategoryTreeStructure?>
</div>
</div>
</div>
<div class="card-footer" style="padding: 0.75rem 1rem;">
<a href="<?php echo e(route('video-category')); ?>">+ Add New Category</a>
</div>
</div>
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Featured Image</h6>
</div>
<?php //echo SITE_UPLOAD_URL.SITE_VIDEO_IMAGE.$resVideoData->video_image;?>
<div class="card-body">
<div class="form-group">
<div class="media align-items-center">
<div class="avatar" style="height:60px; width:60px
"><img id="video_image" src="<?php echo (isset($resVideoData->video_image) && $resVideoData->video_image!="")?SITE_UPLOAD_URL.SITE_VIDEO_IMAGE.$resVideoData->video_image:SITE_NO_IMAGE_PATH;?>" class="rounded" alt=""></div>
<div class="media-body pd-l-10">
<div class="custom-file">
<input type="file" name="video_image_" class="custom-file-input" onchange="showPreview('video_image',this)" id="customFile">
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
<span class="tx-11 tx-color-03">Accepted: gif, png, jpg. Max file size 2Mb</span>
</div>
</div>
</div>
</div>
</div>
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Pdf File</h6>
</div>
<div class="card-body">
<div class="form-group">
<div class="media align-items-center">
<div class="media-body">
<div class="custom-file">
<input type="file" name="video_file_" class="custom-file-input" onchange="showPreview('video_file',this)" id="customFile" accept="application/pdf">
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
<span class="tx-11 tx-color-03">Accepted: pdf. Max file size 2Mb</span>
</div>
</div>
</div>
<div class="form-group mg-b-10">
<label>URL:</label>
<input type="text" class="form-control" name="pdf_url" value="<?php echo isset($resVideoData->pdf_url)?$resVideoData->pdf_url:''?>">
</div>
</div>
</div>
</div>
</form>
</div>
</div>
</div>
<script>
    function checkValidation(obj)
    {
         
        if($('.clsSelectSingle:checked').length==0)
        {
            alert('Please select atleast one category.');
            return false;
        } 
    } 
</script>
<script>
    if($('.ckeditor').length>0){
    CKEDITOR.replace('video_desc');
    CKEDITOR.config.allowedContent = true;
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('Csadmin.Layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\php\xamp\htdocs\coachingzon\resources\views/Csadmin/Videos/addNewVideo.blade.php ENDPATH**/ ?>