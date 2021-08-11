
<?php $__env->startSection('content'); ?>
<?php // //print_r($strCategory); //echo "shikha";?>

<div class="content-body">
<div class="container pd-x-0">
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
<div>
<nav aria-label="breadcrumb">
<ol class="breadcrumb breadcrumb-style1 mg-b-10">
<li class="breadcrumb-item"><a href="#">E Books & Notes</a></li>
<li class="breadcrumb-item active" aria-current="page">Add new Product</li>
</ol>
</nav>
<h4 class="mg-b-0 tx-spacing--1">Add New Product</h4>
</div>
</div>
<?php //print_r($resProductData);?>
<form method="post" action="<?php echo e(route('productProccess')); ?>" enctype="multipart/form-data">
<?php echo csrf_field(); ?>
<input type="hidden" name="product_id" value="<?php echo isset($resProductData->product_id)?$resProductData->product_id:'0'?>">
<div class="row row-xs">
<div class="col-lg-8">
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Product Details</h6>
</div>
<div class="card-body">
<div class="row row-xs">
<div class="col-lg-12">
<div class="form-group mg-b-10">
<label>Product Name / Title:<span style="color:red">*</span></label>
<input type="text" class="form-control" name="product_title" required="" value="<?php echo isset($resProductData->product_title)?$resProductData->product_title:''?>">
</div></div>
</div>
</div>
</div>
   
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Description</h6>
</div>
<div class="card-body" style="padding:0px;">
<textarea name="product_description" class="ckeditor"><?php echo isset($resProductData->product_description)?$resProductData->product_description:''?></textarea>
</div>
</div>

<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Pricing & Quantity</h6>
</div>
<div class="card-body" >
<div class="row row-xs">
<div class="col-lg-4">
<div class="form-group">
<label>MRP</label>
<input type="number" class="form-control checkboxforvariant" name="product_mrp" required  onblur="setnormalnetprice($(this))" value="<?php echo isset($resProductData->product_mrp)?$resProductData->product_mrp:''; ?>" placeholder="MRP">
</div>
</div>
<div class="col-lg-4">
<div class="form-group">
<label>Discount </label>
<input type="number" class="form-control checkboxforvariant" name="product_discount"  onblur="setnormalnetprice($(this))" value="<?php echo isset($resProductData->product_discount)?$resProductData->product_discount:''; ?>" placeholder="Discount">
</div>
</div>
<div class="col-lg-4">
<div class="form-group">
<label>Selling Price</label>
<input type="number" class="form-control" readonly name="product_msp" value="<?php echo isset($resProductData->product_msp)?$resProductData->product_msp:''; ?>" placeholder="Net Price">
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
<div class="card-body">
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
<?php if(in_array('12',$delete_data) || in_array('12',$edit_data) || in_array('12',$view_data)){?>
<div class="card-footer" style="padding: 0.75rem 1rem;">
<a href="<?php echo e(route('test-category')); ?>">+ Add New Category</a>
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
"><img id="product_image" src="<?php echo (isset($resProductData->product_image) && $resProductData->product_image!="")?SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE.$resProductData->product_image:SITE_NO_IMAGE_PATH;?>" class="rounded" alt=""></div>
<div class="media-body pd-l-10">
<div class="custom-file">
<input type="file" name="product_image_" class="custom-file-input" onchange="showPreview('product_image',this)" id="customFile">
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



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
function setnormalnetprice(obj)
{
    
    var mrp = $('input[name=product_mrp]').val();
    var discount = $('input[name=product_discount]').val();
    if(mrp!=''){
    $('input[name=product_msp]').val(mrp-discount);
}}
</script>


 




<script>



// function getNetPriceDuplicates(s)
// {
// var discount = $('input[name=product_discount]').val();
// if(discount==null || discount=='')
// {
// discount =0;
// }
// var netprice = parseFloat(parseFloat(s)-parseFloat(discount));
// $('input[name=product_discount]').val(netprice);
// }
// function getNetPrices(s)
// {
// var discount = $('input[name=product_mrp]').val();
// if(discount==null || discount=='')
// {
// discount =0;
// }
// var netprice = parseFloat(parseFloat(discount)-parseFloat(s));
// $('input[name=product_msp]').val(netprice);
// }
// function showName(input,item){
// if (input.files && input.files[0]) {
// var reader = new FileReader();
// item.parents('.uploader').find('.filename').html(input.files[0].name);
// reader.onload = function (e) {

// };
// reader.readAsDataURL(input.files[0]);
// }
// }

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('Csadmin.Layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\php\xamp\htdocs\coachingzon\resources\views/Csadmin/Csproduct/addnewproduct.blade.php ENDPATH**/ ?>