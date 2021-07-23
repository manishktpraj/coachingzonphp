@extends('Csadmin.Layout.app')
@section ('content')
<?php //print_r($rowStoreData); echo "shikha";?>
<div class="content-body">
<div class="container pd-x-0">
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
<div>
<nav aria-label="breadcrumb">
<ol class="breadcrumb breadcrumb-style1 mg-b-10">
<li class="breadcrumb-item"><a href="#">Setting</a></li>
<li class="breadcrumb-item active" aria-current="page">Store Setting</li>
</ol>
</nav>
<h4 class="mg-b-0 tx-spacing--1">Store Setting</h4>
</div>
</div>
<form method="post" action="{{route('storeProccess')}}" enctype="multipart/form-data">
@csrf
<input type="hidden" name="theme_id" value="<?php echo isset($rowStoreData->theme_id)?$rowStoreData->theme_id:'0'?>">
<div class="row row-xs">
<div class="col-lg-12">
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Store Details</h6>
</div>
<div class="card-body">
<div class="form-group mg-b-10">
<!--<input type="hidden" name="store_id" value="<?php echo isset($rowStoreData->store_id)?$rowStoreData->store_id:'0'?>">-->
<fieldset class="form-fieldset" style="margin-bottom:15px">
<legend style="font-size:13px">Store Information</legend>
<div class="row row-xs">
<div class="col-lg-6">
<div class="form-group" style="margin-bottom:15px">
<label>Store Name:</label>
<input type="text" class="form-control" placeholder="" name="theme_store_name" value="<?php echo isset($rowStoreData->theme_store_name)?$rowStoreData->theme_store_name:''?>">
</div>
</div>
<div class="col-lg-6">
<div class="form-group" style="margin-bottom:15px">
<label>Email Id:</label>
<input type="text" class="form-control" placeholder="" name="theme_email" value="<?php  echo isset($rowStoreData->theme_email)?$rowStoreData->theme_email:''?>">
</div>
</div>

<div class="col-lg-3">
<div class="form-group" style="margin-bottom:15px">
<label>Country:</label>
<select class="custom-select"  name="theme_country">
<option value="">Select</option>
<option value="101" selected>India</option>
</select>
</div>
</div>
<div class="col-lg-3">
<div class="form-group" style="margin-bottom:15px">
<label>State:</label>
<select class="custom-select" id="ad_ac_year" onchange="getCourses(this.value)" name="theme_state">
<option value="">Select</option>
<?php foreach($resstate as $value){?>
<option <?php echo (isset($rowStoreData->theme_state) && $rowStoreData->theme_state==$value->id)?'selected="selected"':''?> value="<?php echo $value->id;?>"><?php echo $value->name;?></option>
<?php }?>
</select>
</div>
</div>
<div class="col-lg-3">
<div class="form-group" style="margin-bottom:15px">
<label>City:</label>
<select class="custom-select" id="ad_course" name="theme_city">
<option value="">Select</option>
<?php foreach($rescity as $value){?>
<option <?php echo (isset($rowStoreData->theme_city) && $rowStoreData->theme_city==$value->id)?'selected="selected"':''?> value="<?php echo $value->id;?>"><?php echo $value->name;?></option>
<?php }?>
</select>
</select>
</div>
</div>
<div class="col-lg-3" style="margin-bottom:15px">
<div class="form-group">
<label>Postcode:</label>
<input type="text" class="form-control" placeholder="" name="theme_postcode" value="<?php echo isset($rowStoreData->theme_postcode)?$rowStoreData->theme_postcode:''?>">
</div>
</div>

<div class="col-lg-6">
<div class="form-group">
<label>Logo:</label>
<div class="media align-items-center">
<div class="avatar" style="height:60px; width:60px
"><img id="theme_logo" src="<?php echo (isset($rowStoreData->theme_logo) && $rowStoreData->theme_logo!="")?SITE_UPLOAD_URL.SITE_THEME_IMAGE.$rowStoreData->theme_logo:SITE_NO_IMAGE_PATH;?>" class="rounded" alt=""></div>
<div class="media-body pd-l-10">
<div class="custom-file">
<input type="file" name="theme_logo" class="custom-file-input" onchange="showPreview('theme_logo',this)" id="customFile">
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
<span class="tx-11 tx-color-03">Accepted: gif, png, jpg. Max file size 2Mb</span>
</div>
</div>
</div>
</div>
<div class="col-lg-6">
<div class="form-group">
<label>Favicon:</label>
<div class="media align-items-center">
<div class="avatar" style="height:60px; width:60px
"><img id="theme_favicon" src="<?php echo (isset($rowStoreData->theme_favicon) && $rowStoreData->theme_favicon!="")?SITE_UPLOAD_URL.SITE_THEME_IMAGE.$rowStoreData->theme_favicon:SITE_NO_IMAGE_PATH;?>" class="rounded" alt=""></div>
<div class="media-body pd-l-10">
<div class="custom-file">
<input type="file" name="theme_favicon" class="custom-file-input" onchange="showPreview('theme_favicon',this)" id="customFile">
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
<span class="tx-11 tx-color-03">Accepted: gif, png, jpg. Max file size 2Mb</span>
</div>
</div>
</div>
</div>


</div>
</fieldset>




<fieldset class="form-fieldset">
<legend style="font-size:13px">Tax Options</legend>
<div class="row row-xs">
<div class="col-lg-12">
<div class="form-group">
<label>If the checkbox below is selected all taxes will be calculated using this formula: Tax = ((GST inclusive Price) / (100 + Tax Rate))*Tax Rate Example Rs 2.00 at 5% VAT will be Rs 0.10 (rounded).</label>
<input type="checkbox" name="theme_tax_option" value="1"  <?php echo (isset($rowStoreData->theme_tax_option) && $rowStoreData->theme_tax_option==1)?'checked':''?> >
If price are all inclusive of taxes
</div>
</div>
</div>
</fieldset>

</div>
</div>
<div class="card-footer" style="padding: 0.75rem 1rem;">
<button type="submit" class="btn btn-success">Save</button>
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
<?php echo (isset($rowStoreData->store_state_id))?'<script>getCourses('.$rowStoreData->store_state_id.')</script>':''?>
</script>

@endsection