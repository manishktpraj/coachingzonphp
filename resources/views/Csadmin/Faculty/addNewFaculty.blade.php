@extends('Csadmin.Layout.app')
@section ('content')
<?php //print_r($strCategory); echo "shikha";?>
<div class="content-body">
<div class="container pd-x-0">
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
<div>
<nav aria-label="breadcrumb">
<ol class="breadcrumb breadcrumb-style1 mg-b-10">
<li class="breadcrumb-item"><a href="#">Faculties</a></li>
<li class="breadcrumb-item active" aria-current="page">Add New Faculties</li>
</ol>
</nav>
<h4 class="mg-b-0 tx-spacing--1">Add New Faculty</h4>
</div>
</div>
<form method="post" action="{{route('facultyProccess')}}" enctype="multipart/form-data">
@csrf
<input type="hidden" name="faculty_id" value="<?php echo isset($resfacultyData->faculty_id)?$resfacultyData->faculty_id:''?>">
<div class="row row-xs">
<div class="col-lg-8">
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Faculty Details</h6>
</div>
<div class="card-body">
<div class="row row-xs">
<div class="col-lg-6">
<div class="form-group" style="margin-bottom:15px">
<label>First Name:</label>
<input type="text" class="form-control" required name="faculty_first_name" value="<?php echo isset($resfacultyData->faculty_first_name)?$resfacultyData->faculty_first_name:''?>">
</div>
</div>
<div class="col-lg-6">
<div class="form-group" style="margin-bottom:15px">
<label>Last Name:</label>
<input type="text" class="form-control" required name="faculty_last_name" value="<?php echo isset($resfacultyData->faculty_last_name)?$resfacultyData->faculty_last_name:''?>">
</div>
</div>
<div class="col-lg-6">
<div class="form-group" style="margin-bottom:15px">
<label>Date of Birth:</label>
<input type="date" class="form-control" required name="faculty_dob" value="<?php echo isset($resfacultyData->faculty_dob)?$resfacultyData->faculty_dob:''?>">
</div>
</div>
<div class="col-lg-6">
<div class="form-group" style="margin-bottom:15px">
<label>Gender:</label>
<select class="custom-select" name="faculty_gender" required="">
<option value="male">Male</option>
<option value="female">Female</option>
<option value="other">Other</option>
</select>
</div>
</div>
<div class="col-lg-6">
<div class="form-group" style="margin-bottom:15px">
<label>Email Id:</label>
<input type="text" class="form-control" required name="faculty_email" value="<?php echo isset($resfacultyData->faculty_email)?$resfacultyData->faculty_email:''?>">
</div>
</div>
<div class="col-lg-6">
<div class="form-group" style="margin-bottom:15px">
<label>Mobile:</label>
<input type="text" class="form-control" required name="faculty_phone" value="<?php echo isset($resfacultyData->faculty_phone)?$resfacultyData->faculty_phone:''?>">
</div>
</div>
<div class="col-lg-6">
<div class="form-group" style="margin-bottom:15px">
<label>New Password:</label>
<input type="password" class="form-control" name="faculty_new_password" id="txtPassword" value="">
</div>
</div>
<div class="col-lg-6">
<div class="form-group" style="margin-bottom:15px">
<label>Confirm Password:</label>
<input type="password" class="form-control" name="faculty_confirm_password" id="txtConfirmPassword" value="">
</div>
</div>
</div>
</div>
</div>
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">About Us</h6>
</div>
<div class="card-body" style="padding:0px;">
<textarea name="faculty_about" class="ckeditor"><?php echo isset($resfacultyData->faculty_about)?$resfacultyData->faculty_about:''?></textarea>
</div>
</div>


</div>
<div class="col-lg-4">
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Publish</h6>
</div>
<div class="card-body">

</div> 
<div class="card-footer" style="padding: 0.75rem 1rem;">
<button type="submit" onclick="return checkValidation($(this))" class="btn btn-success">Publish</button>
</div>
</div>

<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Faculty Image</h6>
</div>
<div class="card-body">
<div class="form-group">
<div class="media align-items-center">
<div class="avatar" style="height:60px; width:60px
"><img id="faculty_img" src="<?php echo (isset($resfacultyData->faculty_img) && $resfacultyData->faculty_img!="")?SITE_UPLOAD_URL.SITE_FACULTY_IMAGE.$resfacultyData->faculty_img:SITE_NO_IMAGE_PATH;?>" class="rounded" alt=""></div>
<div class="media-body pd-l-10">
<div class="custom-file">
<input type="file" name="faculty_img" class="custom-file-input" onchange="showPreview('faculty_img',this)" id="customFile">
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
    if($('.ckeditor').length>0){
    CKEDITOR.replace('video_desc');
    CKEDITOR.config.allowedContent = true;
}
</script>
@endsection