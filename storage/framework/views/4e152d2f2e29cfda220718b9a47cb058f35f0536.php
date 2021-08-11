<?php $__env->startSection('content'); ?>

<div class="content-body">
<div class="container pd-x-0">
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
<div>
<nav aria-label="breadcrumb">
<ol class="breadcrumb breadcrumb-style1 mg-b-10">
<li class="breadcrumb-item"><a href="#">Offers & Promos</a></li>
<li class="breadcrumb-item active" aria-current="page">Add new Offers</li>
</ol>
</nav>
<h4 class="mg-b-0 tx-spacing--1">Add New Offers & Promos</h4>
</div>
</div>
<form method="post" action="<?php echo e(route('offerprocess')); ?>"enctype="multipart/form-data">
<?php echo csrf_field(); ?>
<input type="hidden" name="sm_id" value="   ">
<div class="row row-xs">
<div class="col-lg-12">
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;"> Add New Offers & Promos</h6>
</div>
<div class="card-body">

<div class="row row-xs">
    <div class="col-lg-6">
    <div class="form-group mg-b-15">
<label> Name/Title<span style="color:red" >*</span></label>
<input type="text" class="form-control" name="offers_name"  required value="<?php echo (isset($resOfferData['offers_name']) && $resOfferData['offers_name']!='')? $resOfferData['offers_name']:''?>">
</div>
</div>
<div class="col-lg-4">
    <div class="form-group mg-b-15">
<label>Coupon Code<span style="color:red">*</span></label>

    <input type="text" class="form-control border-none" name="coupon_code" value="<?php echo (isset($resOfferData['coupon_code']) && $resOfferData['coupon_code']!='')? $resOfferData['coupon_code']:''?>"  id="generated_code">
    
</div>

</div>
<div class="col-lg-2 mt-2">
    <div class="form-group mg-b-15">
<label><span style="color:red"></span></label>

    <input type="button" class=" btn form-control border-none text-white "style="background-color: #777777;" value="Generate" id="generate_code" >
    
</div>

</div>

</div>
<div class="row row-xs">
    <div class="col-lg-6">
    <div class="form-group mg-b-15">
<label>Valid From 
<span style="color:red">*</span></label>
<input type="date" class="form-control" name="offers_valid_from" required  value="<?php echo (isset($resOfferData['offers_valid_from']))?date("Y-m-d",strtotime($resOfferData['offers_valid_from'])):''?>" >
</div>
</div>
<div class="col-lg-6">
    <div class="form-group mg-b-15">
<label> Valid To <span style="color:red">*</span></label>
<input type="date" class="form-control" name="offers_valid_to" required value="<?php echo (isset($resOfferData['offers_valid_to']))?date("Y-m-d",strtotime($resOfferData['offers_valid_from'])):''?>" >
</div>
</div>

</div>
<div class="row row-xs">
    <div class="col-lg-3">
    <div class="form-group mg-b-15">
<label>Discount Type
<span style="color:red">*</span></label>
<select class="form-control" name="offers_discount_type">
    <option>Select</option>
    <option <?php echo (isset($resOfferData['offers_discount_type']) && $resOfferData['offers_discount_type']=='0')?'selected':''?> value="0">Cashback</option>
    <option <?php echo (isset($resOfferData['offers_discount_type']) && $resOfferData['offers_discount_type']=='1')?'selected':''?> value="1">Instant</option>
   
</select>

</div>
</div>


        <div class="col-lg-3">
             <div class="form-group mg-b-15">
<label>Discount In<span style="color:red">*</span></label>
<select class="form-control" name="offers_discount_in">
    <option>Select</option>
    <option <?php echo (isset($resOfferData['offers_discount_in']) && $resOfferData['offers_discount_in']=='0')?'selected':''?> value="0" >Flat</option>
    <option <?php echo (isset($resOfferData['offers_discount_in']) && $resOfferData['offers_discount_in']=='1')?'selected':''?> value="1" >Percentage </option>
   
</select>

</div>

        </div>
<div class="col-lg-3">
             <div class="form-group mg-b-15">
<label>Amount<span style="color:red">*</span></label>
<input type="text" class="form-control" name="offers_amount" required  value="<?php echo (isset($resOfferData['offers_amount']) && $resOfferData['offers_amount']!=0)? $resOfferData['offers_amount']:''?>" >
</div>

</div>
<div class="col-lg-3">
    <div class="form-group mg-b-15">
<label>Max Discount
<span style="color:red">*</span></label>
<input type="text" class="form-control" name="offers_max_amount" required  value="<?php echo (isset($resOfferData['offers_max_amount']) && $resOfferData['offers_max_amount']!=0)? $resOfferData['offers_max_amount']:''?>" >

</div>
</div>



</div>
<div class="row row-xs">
       <div class="col-lg-12">
    <div class="form-group mg-b-15">
<label>Description<span style="color:red" >*</span></label>

<textarea  type="text" class="form-control" name="description"   value="<?php echo (isset($resOfferData['description']) && $resOfferData['description']!='')? $resOfferData['description']:''?>"></textarea>
</div>
</div>
</div>
<div class="row row-xs">
       <div class="col-lg-12">
    <div class="form-group mg-b-15">
<label>Terms & Condition<span style="color:red" >*</span></label>

<textarea  type="text" class="form-control" name="offer_terms_condition"   value="<?php echo (isset($resOfferData['offer_terms_condition']) && $resOfferData['offer_terms_condition']!='')? $resOfferData['offer_terms_condition']:''?>"></textarea>
</div>
</div>
</div>
<div class="row row-xs" >
    <div class="col-lg-4">
            <div class="form-group mg-b-15">
<label> Usage Limit<span style="color:red" >*</span></label>
<input type="text" class="form-control" name="usage_limit"  required value="<?php echo (isset($resOfferData['usage_limit']) && $resOfferData['usage_limit']!='')? $resOfferData['usage_limit']:''?>">
</div>
        
    </div>
     <div class="col-lg-4">
            <div class="form-group mg-b-15">
<label>Usage Per User Limit<span style="color:red" >*</span></label>
<input type="text" class="form-control" name="usage_user_limit"  required value="<?php echo (isset($resOfferData['usage_user_limit']) && $resOfferData['usage_user_limit']!='')? $resOfferData['usage_user_limit']:''?>">
</div>
        
    </div>
     <div class="col-lg-4">
            <div class="form-group mg-b-15">
<label> Minimum Purchase<span style="color:red" >*</span></label>
<input type="text" class="form-control" name="minimum_purchase"  required value="<?php echo (isset($resOfferData['minimum_purchase']) && $resOfferData['minimum_purchase']!='')? $resOfferData['minimum_purchase']:''?>"></div>
        
    </div>
</div>
</div>
<div class="card-footer">
<button type="submit" name="submit"  class="btn btn-success mr-5 ">Save </button>
</div>
</div>
</div>
</div>
</div>
</div>

<script>
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
</script>
<script>
    if($('.ckeditor').length>0){
    CKEDITOR.replace('sm_desc');
    CKEDITOR.config.allowedContent = true;
}
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $('#generate_code').on("click", function(){
    //alert("The paragraph was clicked.");

    var randomChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    var result = '';
    for ( var i = 0; i < 6; i++ ) {
        result += randomChars.charAt(Math.floor(Math.random() * randomChars.length));
    }
    $('#generated_code').val(result);
    //alert(result);




  });
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('Csadmin.Layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\php\xamp\htdocs\coachingzon\resources\views/Csadmin/Offers/addoffers.blade.php ENDPATH**/ ?>