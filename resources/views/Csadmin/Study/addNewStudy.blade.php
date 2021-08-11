@extends('Csadmin.Layout.app')
@section ('content')
<div class="content-body">
<div class="container pd-x-0">
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
<div>
<nav aria-label="breadcrumb">
<ol class="breadcrumb breadcrumb-style1 mg-b-10">
<li class="breadcrumb-item"><a href="#">Study Materials</a></li>
<li class="breadcrumb-item active" aria-current="page">Add new Study Materials</li>
</ol>
</nav>
<h4 class="mg-b-0 tx-spacing--1">Add New Study Materials</h4>
</div>
</div>
<form method="post" action="{{route('studyMaterialProccess')}}" enctype="multipart/form-data">
@csrf
<input type="hidden" name="sm_id" value="<?php echo isset($resStudyMaterialData->sm_id)?$resStudyMaterialData->sm_id:'0'?>">
<div class="row row-xs">
<div class="col-lg-8">
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Study Materials Details</h6>
</div>
<div class="card-body">
<div class="form-group mg-b-10">
<label>Study Materials Name / Title:<span style="color:red">*</span></label>
<input type="text" class="form-control" name="sm_name" required="" value="<?php echo isset($resStudyMaterialData->sm_name)?$resStudyMaterialData->sm_name:''?>">
</div>
</div>
</div>
<div class="card">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Description</h6>
</div>
<div class="card-body" style="padding: 0px;">
<textarea name="sm_desc" class="ckeditor"><?php echo isset($resStudyMaterialData->sm_desc)?$resStudyMaterialData->sm_desc:''?></textarea>
</div>
</div>
</div>
<div class="col-lg-4">
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Publish</h6>
</div>
<div class="card-body">
<!--<div class="form-group mg-b-0">
<div class="custom-control custom-radio">
  <input type="radio" id="customRadio1" name="sm_type" required onclick="radioValidate(this.value)" class="custom-control-input" value="0" <?php echo (isset($resStudyMaterialData->sm_type) && $resStudyMaterialData->sm_type=="0")?'checked':'checked'?>>
  <label class="custom-control-label" for="customRadio1">Free</label>
</div>
<div class="custom-control custom-radio">
  <input type="radio" id="customRadio2" name="sm_type" required onclick="radioValidate(this.value)" class="custom-control-input" value="1" <?php echo (isset($resStudyMaterialData->sm_type) && $resStudyMaterialData->sm_type=="1")?'checked':''?>>
  <label class="custom-control-label" for="customRadio2">Paid</label>
</div>
</div>-->
</div>
<div class="card-footer" style="padding: 0.75rem 1rem;">
<button type="submit" onclick="return checkValidation($(this))"class="btn btn-success">Publish</button>
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
<?php if(in_array('14',$delete_data) || in_array('14',$edit_data) || in_array('14',$view_data)){?>
<div class="card-footer" style="padding: 0.75rem 1rem;">
<a href="{{route('study-category')}}">+ Add New Category</a>
</div>
<?php } ?>
</div>

<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Featured Image</h6>
</div>
<div class="card-body">
<div class="form-group">
<div class="media align-items-center">
<div class="avatar" style="height:60px; width:60px
"><img id="sm_image" src="<?php echo (isset($resStudyMaterialData->sm_image) && $resStudyMaterialData->sm_image!="")?SITE_UPLOAD_URL.SITE_STUDY_MATERIAL_IMAGE.$resStudyMaterialData->sm_image:SITE_NO_IMAGE_PATH;?>" class="rounded" alt=""></div>
<div class="media-body pd-l-10">
<div class="custom-file">
<input type="file" name="sm_image_" class="custom-file-input" onchange="showPreview('sm_image',this)" id="customFile">
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
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Upload File</h6>
</div>
<div class="card-body">
<div class="form-group">
<?php if(isset($resStudyMaterialData->sm_file)&& $resStudyMaterialData->sm_file!=''){ ?>
<a href="<?php echo SITE_UPLOAD_URL.SITE_STUDY_MATERIAL_IMAGE.$resStudyMaterialData->sm_file?>"><span style="display:none"><?php echo SITE_UPLOAD_URL.SITE_STUDY_MATERIAL_IMAGE;?></span><?php echo $resStudyMaterialData->sm_file;?></a>
<?php } ?>
<div class="media align-items-center">
<div class="media-body">
<div class="custom-file">
<input type="file" name="sm_file_" class="custom-file-input" onchange="showPreview('sm_file',this)" id="customFile" accept="application/pdf">
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
<span class="tx-11 tx-color-03">Accepted: pdf. Max file size 2Mb</span>
</div>
</div>
</div>
<div class="form-group mg-b-10">
<label>URL:</label>
<input type="text" class="form-control" name="sm_file_url" value="<?php echo isset($resStudyMaterialData->sm_file_url)?$resStudyMaterialData->sm_file_url:''?>">
</div>
</div>
</div>
</div>
</form>
</div>
</div>
</div>
<!--<script>
    function checkValidation(obj){
        if($('#customRadio1').is(':checked') || $('#customRadio2').is(':checked')){
            return true;
        }else{
            alert('Please select type');
            return false;
        }
    }
    function radioValidate(value)
    {
        if(value==1 || value==0){
            $("#customRadio1").removeAttr('required');
            $("#customRadio2").removeAttr('required');
        }else{
            alert('Please select type');
            return false
        }
    }
</script>-->
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
    CKEDITOR.replace('sm_desc');
    CKEDITOR.config.allowedContent = true;
}
</script>
@endsection