@extends('Csadmin.Layout.app')
@section ('content')
<?php //print_r($strCategory); echo "shikha";?>

<div class="content-body">
<div class="container pd-x-0">
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
<div>
<nav aria-label="breadcrumb">
<ol class="breadcrumb breadcrumb-style1 mg-b-10">
<li class="breadcrumb-item"><a href="#">Packages</a></li>
<li class="breadcrumb-item active" aria-current="page">Add new Package</li>
</ol>
</nav>
<h4 class="mg-b-0 tx-spacing--1">Add New Package</h4>
</div>
</div>
<form method="post" action="{{route('packageProccess')}}" enctype="multipart/form-data">
@csrf
<input type="hidden" name="package_id" value="<?php echo isset($resPackageData->package_id)?$resPackageData->package_id:'0'?>">
<div class="row row-xs">
<div class="col-lg-8">
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Package Details</h6>
</div>
<div class="card-body">
<div class="form-group mg-b-10">
<label>Package Name / Title:<span style="color:red">*</span></label>
<input type="text" class="form-control" name="package_name" required="" value="<?php echo isset($resPackageData->package_name)?$resPackageData->package_name:''?>">
</div>
<div class="form-group mg-b-10">
<label>Package Sub Title:</label>
<input type="text" class="form-control" name="package_sub_title" value="<?php echo isset($resPackageData->package_sub_title)?$resPackageData->package_sub_title:''?>">
</div>
<div class="row row-xs">
<div class="col-lg-6">
<div class="form-group">
<label>Package Type:</label>
<select class="custom-select" name="package_type" required>
<option value="">Select Type</option>
<option value="0" <?php  echo (isset($resPackageData->package_type) && $resPackageData->package_type=="0")?'selected':''?> >Test</option>
<option value="1" <?php  echo (isset($resPackageData->package_type) && $resPackageData->package_type=="1")?'selected':''?> >Video</option>
<option value="2" <?php  echo (isset($resPackageData->package_type) && $resPackageData->package_type=="2")?'selected':''?> >Test + Video</option>
<option value="3" <?php  echo (isset($resPackageData->package_type) && $resPackageData->package_type=="3")?'selected':''?> >Test + Video + Pdf</option>
</select>
</div>
</div> 
<div class="col-lg-6">
<div class="form-group">
<label>Validity(Days):</label>
<input type="number" class="form-control" name="package_validity" required="" value="<?php echo isset($resPackageData->package_validity)?$resPackageData->package_validity:''?>">
</div>
</div>   

</div>

</div>
</div>
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Description</h6>
</div>
<div class="card-body" style="padding:0px;">
<textarea name="package_desc" class="ckeditor"><?php echo isset($resPackageData->package_desc)?$resPackageData->package_desc:''?></textarea>
</div>
</div>

<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Price & Other Details</h6>
</div>
<div class="card-body" >
<div class="row row-xs">

<div class="col-lg-4">
<div class="form-group">
<label>MRP</label>
<input type="number" class="form-control checkboxforvariant" name="package_mrp"  onblur="setnormalnetprice($(this))" value="<?php echo isset($resPackageData->package_mrp)?$resPackageData->package_mrp:''; ?>" placeholder="MRP">
</div>
</div>
<div class="col-lg-4">
<div class="form-group">
<label>Selling Price</label>
<input type="number" class="form-control checkboxforvariant" name="package_selling_price" onblur="setnormalnetprice($(this))" value="<?php echo isset($resPackageData->package_selling_price)?$resPackageData->package_selling_price:''; ?>" placeholder="Discount">
</div>
</div>
<div class="col-lg-4">
<div class="form-group">
<label>Discount</label>
<input type="number" class="form-control" readonly name="package_discount" value="<?php echo isset($resPackageData->package_discount)?$resPackageData->package_discount:''; ?>" placeholder="Net Price">
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
<a href="#">+ Add New Category</a>
</div>
</div>
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Featured Image</h6>
</div>
<div class="card-body">
<div class="form-group">
<div class="media align-items-center">
<div class="avatar" style="height:60px; width:60px
"><img id="package_image" src="<?php echo (isset($resPackageData->package_image) && $resPackageData->package_image!="")?SITE_UPLOAD_URL.SITE_PACKAGE_IMAGE.$resPackageData->package_image:SITE_NO_IMAGE_PATH;?>" class="rounded" alt=""></div>
<div class="media-body pd-l-10">
<div class="custom-file">
<input type="file" name="package_image_" class="custom-file-input" onchange="showPreview('package_image',this)" id="customFile">
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
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Upload Syllabus File</h6>
</div>
<div class="card-body">
<div class="form-group">
<div class="media align-items-center">
<div class="media-body">
<div class="custom-file">
<input type="file" name="package_file_" class="custom-file-input" onchange="showPreview('package_file_',this)" id="customFile" accept="application/pdf">
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
<span class="tx-11 tx-color-03">Accepted: pdf. Max file size 2Mb</span>
</div>
</div>
</div>
<div class="form-group mg-b-10">
<label>URL:</label>
<input type="text" class="form-control" name="package_file_url" value="<?php echo isset($resStudyMaterialData->package_file_url)?$resStudyMaterialData->package_file_url:''?>">
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
    CKEDITOR.replace('Package_desc');
    CKEDITOR.config.allowedContent = true;
}
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
function setnormalnetprice(obj)
{
    var mrp = $('input[name=package_mrp]').val();
    var discount = $('input[name=package_selling_price]').val();
    
    $('input[name=package_discount]').val(mrp-discount);
}
</script>


@endsection