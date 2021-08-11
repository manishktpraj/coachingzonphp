
<?php $__env->startSection('content'); ?>
<?php //print_r($strCategory); echo "shikha";?>

<div class="content-body">
<div class="container pd-x-0">
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
<div>
<nav aria-label="breadcrumb">
<ol class="breadcrumb breadcrumb-style1 mg-b-10">
<li class="breadcrumb-item"><a href="#">Appreance</a></li>
<li class="breadcrumb-item active" aria-current="page">Add new Slider</li>
</ol>
</nav>
<h4 class="mg-b-0 tx-spacing--1">Add New Slider</h4>
</div>
</div>
<form method="post" action="<?php echo e(route('sliderProccess')); ?>" enctype="multipart/form-data">
<?php echo csrf_field(); ?>
<input type="hidden" name="slider_id" value="<?php echo isset($resSliderData->slider_id)?$resSliderData->slider_id:'0'?>">
<div class="row row-xs">
<div class="col-lg-12">
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Slider Details</h6>
</div>


<div class="card-body">
<div class="row row-xs">
<div class="col-lg-6">
<div class="form-group mg-b-10">
<label>Slider Name / Title:<span style="color:red">*</span></label>
<input type="text" class="form-control" name="slider_title" required="" value="<?php echo isset($resSliderData->slider_title)?$resSliderData->slider_title:''?>">
</div>
</div>


<div class="col-lg-6">
<div class="form-group mg-b-10">
<label>Slider Type:<span style="color:red"> </span></label>
<select class="custom-select" name="slider_type" required>
<option value="">Select Slider Type</option>
<option value="0" <?php echo (isset($resSliderData->slider_type)&& $resSliderData->slider_type==0)?"selected":'';?> >Home Top Banner</option>
<option value="1" <?php echo (isset($resSliderData->slider_type)&& $resSliderData->slider_type==1)?"selected":'';?> >Home Middle Banner</option>
</select>

</div>
</div>


<div class="col-lg-6">
<div class="form-group mg-b-10">
<label>Slider Link:<span style="color:red"> </span></label>
<input type="text" class="form-control" name="slider_link"  value="<?php echo isset($resSliderData->slider_link)?$resSliderData->slider_link:''?>">
</div>
</div>
<div class="col-lg-6">
    
<div class="form-group mg-b-10">
<label>Slider Image:<span style="color:red"> </span></label>
<div class="media align-items-center">
<div class="avatar" style="height:60px; width:60px
"><img id="slider_image" src="<?php echo (isset($resSliderData->slider_image) && $resSliderData->slider_image!="")?SITE_UPLOAD_URL.SITE_SLIDER_IMAGE.$resSliderData->slider_image:SITE_NO_IMAGE_PATH;?>" class="rounded" alt=""></div>

<div class="media-body pd-l-10">
<div class="custom-file">
<input type="file" name="slider_image" class="custom-file-input" onchange="showPreview('slider_image',this)" id="customFile">
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
<span class="tx-11 tx-color-03">Accepted: gif, png, jpg. Max file size 2Mb</span>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="card-footer" style="padding: 0.75rem 1rem;">
<button type="submit" class="btn btn-success">Publish</button>
</div>
</div>
</div>
</div>


</div>
</form>
</div>
</div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('Csadmin.Layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\php\xamp\htdocs\coachingzon\resources\views/Csadmin/Appreance/addnewslider.blade.php ENDPATH**/ ?>