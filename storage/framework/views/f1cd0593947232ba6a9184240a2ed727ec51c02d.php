
<?php $__env->startSection('content'); ?>
<?php //print_r($strCategory); echo "shikha";?>

<div class="content-body">
<div class="container pd-x-0">
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
<div>
<nav aria-label="breadcrumb">
<ol class="breadcrumb breadcrumb-style1 mg-b-10">
<li class="breadcrumb-item"><a href="#">Institute</a></li>
<li class="breadcrumb-item active" aria-current="page">Add new Institute</li>
</ol>
</nav>
<h4 class="mg-b-0 tx-spacing--1">Add New Institute</h4>
</div>
</div>
<form method="post" action="<?php echo e(route('insProccess')); ?>" enctype="multipart/form-data">
<?php echo csrf_field(); ?>
<input type="hidden" name="ins_id" value="<?php echo isset($resInstituteData->ins_id)?$resInstituteData->ins_id:'0'?>">
<div class="row row-xs">
<div class="col-lg-8">
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Institute Details</h6>
</div>
<div class="card-body">
<div class="form-group mg-b-10">
<label>Institute Name / Title:<span style="color:red">*</span></label>
<input type="text" class="form-control" name="ins_name" required="" value="<?php echo isset($resInstituteData->ins_name)?$resInstituteData->ins_name:''?>">
</div>
<div class="row row-xs">
<div class="col-lg-4">
<div class="form-group">
<label>Email:</label>
<input type="text" class="form-control" name="ins_email" required="" value="<?php echo isset($resInstituteData->ins_email)?$resInstituteData->ins_email:''?>">
</div>
</div> 
<div class="col-lg-4">
<div class="form-group">
<label>Phone:</label>
<input type="text" class="form-control" name="ins_phone" required="" value="<?php echo isset($resInstituteData->ins_phone)?$resInstituteData->ins_phone:''?>">
</div>
</div>
<div class="col-lg-4">
<div class="form-group">
<label>Password:</label>
<input type="password" class="form-control" name="ins_password_" <?php echo ($intInsId==0)?'required':'';?> value="">
</div>
</div>
</div>

</div>
</div>
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">About</h6>
</div>
<div class="card-body" style="padding:0px;">
<textarea name="ins_desc" class="ckeditor"><?php echo isset($resInstituteData->ins_desc)?$resInstituteData->ins_desc:''?></textarea>
</div>
</div>

<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Address Details</h6>
</div>
<div class="card-body" >

<div class="row row-xs">
<div class="col-lg-12">
<div class="form-group">
<label>Address:</label>
<input type="text" class="form-control" name="ins_address" required="" value="<?php echo isset($resInstituteData->ins_address)?$resInstituteData->ins_address:''?>">
</div>
</div>
<div class="col-lg-4">
<div class="form-group">
<label>State:</label>
<select class="custom-select" name="ins_state" required>
<option value="">Select State</option>
<?php foreach($resStateData as $states){?>
<option value="<?php echo $states->name;?>" <?php if(isset($resInstituteData->ins_state) && $resInstituteData->ins_state==$states->name){echo "selected";}?>><?php echo $states->name;?></option>
<?php }?>
</select>
<!--<input type="text" class="form-control" name="ins_state" required="" value="<?php echo isset($resInstituteData->ins_state)?$resInstituteData->ins_state:''?>">-->
</div>
</div>
<div class="col-lg-4">
<div class="form-group">
<label>City:</label>
<input type="text" class="form-control" name="ins_city" required="" value="<?php echo isset($resInstituteData->ins_city)?$resInstituteData->ins_city:''?>">
</div>
</div>
<div class="col-lg-4">
<div class="form-group">
<label>Postcode:</label>
<input type="text" class="form-control" name="ins_postcode" required="" value="<?php echo isset($resInstituteData->ins_postcode)?$resInstituteData->ins_postcode:''?>">
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
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Institute Logo</h6>
</div>
<?php //echo SITE_UPLOAD_URL.SITE_VIDEO_IMAGE.$resInstituteData->video_image;?>
<div class="card-body">
<div class="form-group">
<div class="media align-items-center">
<div class="avatar" style="height:60px; width:60px
"><img id="ins_logo" src="<?php echo (isset($resInstituteData->ins_logo) && $resInstituteData->ins_logo!="")?SITE_UPLOAD_URL.SITE_INSTITUTE_IMAGE.$resInstituteData->ins_logo:SITE_NO_IMAGE_PATH;?>" class="rounded" alt=""></div>
<div class="media-body pd-l-10">
<div class="custom-file">
<input type="file" name="ins_logo_" class="custom-file-input" onchange="showPreview('ins_logo',this)" id="customFile">
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
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Institute Cover Image</h6>
</div>
<?php //echo SITE_UPLOAD_URL.SITE_VIDEO_IMAGE.$resInstituteData->video_image;?>
<div class="card-body">
<div class="form-group">
<div class="media align-items-center">
<div class="avatar" style="height:60px; width:60px
"><img id="ins_cover_image" src="<?php echo (isset($resInstituteData->ins_cover_image) && $resInstituteData->ins_cover_image!="")?SITE_UPLOAD_URL.SITE_INSTITUTE_IMAGE.$resInstituteData->ins_cover_image:SITE_NO_IMAGE_PATH;?>" class="rounded" alt=""></div>
<div class="media-body pd-l-10">
<div class="custom-file">
<input type="file" name="ins_cover_image_" class="custom-file-input" onchange="showPreview('ins_cover_image',this)" id="customFile">
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
<span class="tx-11 tx-color-03">Accepted: gif, png, jpg. Max file size 2Mb</span>
</div>
</div>
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
<?php echo $__env->make('Csadmin.Layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\php\xamp\htdocs\coachingzon\resources\views/Csadmin/Institute/addNew.blade.php ENDPATH**/ ?>