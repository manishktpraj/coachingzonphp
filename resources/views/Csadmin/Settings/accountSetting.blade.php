@extends('Csadmin.Layout.app')
@section ('content')


<div class="content-body">
<div class="container pd-x-0">
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
<div>
<nav aria-label="breadcrumb">
<ol class="breadcrumb breadcrumb-style1 mg-b-10">
<li class="breadcrumb-item"><a href="#">Setting</a></li>
<li class="breadcrumb-item active" aria-current="page">Account Settings</li>
</ol>
</nav>
<h4 class="mg-b-0 tx-spacing--1">Account Settings</h4>
</div>
</div>
<?php //print_r($resAccountData);?>
<form method="post" action="{{route('accountProccess')}}" enctype="multipart/form-data">
@csrf
<!-- <input type="hidden" name="staff_id" value="<?php echo isset($account_id)?$account_id:''?>"> -->
<div class="row row-xs">
<div class="col-lg-12">
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Account Details</h6>
</div>
<div class="card-body">
<div class="form-group mg-b-10">
<input type="hidden" name="staff_id" value="<?php echo isset($resAccountData->staff_id)?$resAccountData->staff_id:'0'?>">

<div class="row row-xs">
<div class="col-lg-12">
<div class="form-group" style="margin-bottom:15px">
<label>Name:</label>
<input type="text" class="form-control" required name="staff_name" value="<?php if($user_role==0){echo isset($resAccountData->staff_name)?$resAccountData->staff_name:'';}else{echo isset($resAccountData->ins_name)?$resAccountData->ins_name:'';}?>">
</div>
</div>


<div class="col-lg-6">
<div class="form-group" style="margin-bottom:15px">
<label>Email Id:</label>
<input type="text" class="form-control" required name="staff_email" value="<?php if($user_role==0){echo isset($resAccountData->staff_email)?$resAccountData->staff_email:'';}else{echo isset($resAccountData->ins_email)?$resAccountData->ins_email:'';}?>">
</div>
</div>
<div class="col-lg-6">
<div class="form-group" style="margin-bottom:15px">
<label>Mobile:</label>
<input type="text" class="form-control" required name="staff_mobile" value="<?php if($user_role==0){echo isset($resAccountData->staff_mobile)?$resAccountData->staff_mobile:'';}else{echo isset($resAccountData->ins_phone)?$resAccountData->ins_phone:'';}?>">
</div>
</div>
  

<div class="col-lg-3">
<div class="form-group" style="margin-bottom:15px">
<label>Country:</label>
<select class="custom-select"  name="staff_country">
<option value="">Select</option>
<option value="101" selected>India</option>
</select>
</div>
</div>
<div class="col-lg-3">
<div class="form-group" style="margin-bottom:15px">
<label>State:</label>
<select class="custom-select" id="ad_ac_year" onchange="getCourses(this.value)" name="staff_state">
<option value="">Select</option>
<?php foreach($resstate as $value){?>
<option <?php  if($user_role==0){echo (isset($resAccountData->staff_state) && $resAccountData->staff_state==$value->id)?'selected="selected"':'';}else{echo (isset($resAccountData->ins_state) && $resAccountData->ins_state==$value->name)?'selected="selected"':'';}?> value="<?php if($user_role==0){echo $value->id;}else{echo $value->name;};?>"><?php echo $value->name;?></option>
<?php }?>
</select>
</div>
</div>
<div class="col-lg-3">
<div class="form-group" style="margin-bottom:15px">
<label>City:</label>
<select class="custom-select" id="ad_course" name="staff_city">
<option value="">Select</option>
<?php foreach($rescity as $value){?>
<option <?php if($user_role==0){echo (isset($resAccountData->staff_city) && $resAccountData->staff_city==$value->id)?'selected="selected"':'';}else{echo (isset($resAccountData->ins_city) && $resAccountData->ins_city==$value->name)?'selected="selected"':'';}?> value="<?php if($user_role==0){echo $value->id;}else{echo $value->name;};?>"><?php echo $value->name;?></option>
<?php }?>
</select>
</select>
</div>
</div>
<div class="col-lg-3" style="margin-bottom:15px">
<div class="form-group">
<label>Postcode:</label>
<input type="text" class="form-control" placeholder="" name="staff_postcode" value="<?php if($user_role==0){echo isset($resAccountData->staff_postcode)?$resAccountData->staff_postcode:'';}else{echo isset($resAccountData->ins_postcode)?$resAccountData->ins_postcode:'';}?>">
</div>
</div>

<div class="col-lg-6">
<div class="form-group">
<label>Logo:</label>
<div class="media align-items-center">
<div class="avatar" style="height:60px; width:60px
"><img id="staff_logo" src="<?php if($user_role==0){echo (isset($resAccountData->staff_logo) && $resAccountData->staff_logo!="")?SITE_UPLOAD_URL.SITE_STAFF_IMAGE.$resAccountData->staff_logo:SITE_NO_IMAGE_PATH;}else{echo (isset($resAccountData->ins_logo) && $resAccountData->ins_logo!="")?SITE_UPLOAD_URL.SITE_INSTITUTE_IMAGE.$resAccountData->ins_logo:SITE_NO_IMAGE_PATH;}?>" class="rounded" alt=""></div>
<div class="media-body pd-l-10">
<div class="custom-file">
<input type="file" name="staff_logo" class="custom-file-input" onchange="showPreview('staff_logo',this)" id="customFile">
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
<span class="tx-11 tx-color-03">Accepted: gif, png, jpg. Max file size 2Mb</span>
</div>
</div>
</div>
</div>
<div class="col-lg-6">
<div class="form-group">
<label>Cover Image:</label>
<div class="media align-items-center">
<div class="avatar" style="height:60px; width:60px
"><img id="staff_favicon" src="<?php if($user_role==0){echo (isset($resAccountData->staff_favicon) && $resAccountData->staff_favicon!="")?SITE_UPLOAD_URL.SITE_STAFF_IMAGE.$resAccountData->staff_favicon:SITE_NO_IMAGE_PATH;}else{echo (isset($resAccountData->ins_cover_image) && $resAccountData->ins_cover_image!="")?SITE_UPLOAD_URL.SITE_INSTITUTE_IMAGE.$resAccountData->ins_cover_image:SITE_NO_IMAGE_PATH;}?>" class="rounded" alt=""></div>
<div class="media-body pd-l-10">
<div class="custom-file">
<input type="file" name="staff_cover_image" class="custom-file-input" onchange="showPreview('staff_favicon',this)" id="customFile">
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
<span class="tx-11 tx-color-03">Accepted: gif, png, jpg. Max file size 2Mb</span>
</div>
</div>
</div>
</div>



</div>




</div>
</div>
<div class="card-footer" style="padding: 0.75rem 1rem;">
<button type="submit" class="btn btn-success">Save</button>
</div>
</div>
</div>



</div>
</form>




<form method="post" action="{{route('passProccess')}}" enctype="multipart/form-data">
@csrf
<input type="hidden" name="staff_id" value="<?php echo isset($resAccountData->staff_id)?$resAccountData->staff_id:''?>">
<div class="row row-xs">
<div class="col-lg-12">
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Change Password</h6>
</div>
<div class="card-body">
<div class="form-group mg-b-10">
<input type="hidden" name="store_id" value="<?php //echo isset($resAccountData->store_id)?$resAccountData->store_id:'0'?>">

<div class="row row-xs">
<div class="col-lg-6">
<div class="form-group" style="margin-bottom:15px">
<label>New Password:</label>
<input type="password" class="form-control" name="admin_password" id="txtPassword" value="">
</div>
</div>
<div class="col-lg-6">
<div class="form-group" style="margin-bottom:15px">
<label>Confirm Password:</label>
<input type="password" class="form-control" name="admin_Confirm_password" id="txtConfirmPassword" value="">
</div>
</div>
</div>


</div>
</div>
<div class="card-footer" style="padding: 0.75rem 1rem;">
<button type="submit" class="btn btn-success">Save</button>
</div>
</div>
</div>







</div>
</form>



</div>
</div>
</div>
<script>var token = '<?php echo csrf_token(); ?>';</script>
<script>
function getCourses(state_id) {
var datastring = 'state_id=' + state_id+'&_token='+token;
$.post('<?php echo ADMIN_URL; ?>getcityajax', datastring, function(response) {
$('#ad_course').html(response);
});
}
<?php echo (isset($resAccountData->store_state_id))?'<script>getCourses('.$resAccountData->store_state_id.')</script>':''?>
</script>
@endsection