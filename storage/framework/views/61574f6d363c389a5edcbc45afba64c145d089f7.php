
<?php $__env->startSection('content'); ?>
<?php //print_r($strCategory); echo "shikha";?>

<div class="content-body">
<div class="container pd-x-0">
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
<div>
<nav aria-label="breadcrumb">
<ol class="breadcrumb breadcrumb-style1 mg-b-10">
<li class="breadcrumb-item"><a href="#">Test/Exams</a></li>
<li class="breadcrumb-item active" aria-current="page">Add new Test/Exams</li>
</ol>
</nav>
<h4 class="mg-b-0 tx-spacing--1">Add New Test/Exams</h4>
</div>
</div>
<form method="post" action="<?php echo e(route('testProccess')); ?>" enctype="multipart/form-data">
<?php echo csrf_field(); ?>
<input type="hidden" name="test_id" value="<?php echo isset($resTestData->test_id)?$resTestData->test_id:'0'?>">
<div class="row row-xs">
<div class="col-lg-8">
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Test/Exams Details</h6>
</div>
<div class="card-body">
<div class="form-group mg-b-10">
<label>Test/Exams Name / Title:<span style="color:red">*</span></label>
<input type="text" class="form-control" name="test_name" required="" value="<?php echo isset($resTestData->test_name)?$resTestData->test_name:''?>">
</div>
</div>
</div>
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Description</h6>
</div>
<div class="card-body" style="padding:0px;">
<textarea name="test_desc" class="ckeditor"><?php echo isset($resTestData->test_desc)?$resTestData->test_desc:''?></textarea>
</div>
</div>

<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Subjects</h6>
</div>
<div class="card-body" >
<?php //print_r($sub);?>   

<div class="row row-xs">
<div class="col-lg-3">
<div class="form-group">
<label>Subject:</label>
<select class="custom-select" name="test_subject" required>
<option value="">Select Subject</option>
<?php 


foreach($sub as $s){?>

<option value="<?php echo isset($s->sc_name)?$s->sc_name:''?>" <?php echo (isset($resTestData->test_subject) && $resTestData->test_subject==$s->sc_name)?'selected':''?> ><?php echo isset($s->sc_name)?$s->sc_name:''?></option>

<?php } ?>

</select>
</div>
</div>   
<div class="col-lg-3">
<div class="form-group">
<label>Total Questions:</label>
<input type="number" class="form-control" name="test_total_que" value="<?php echo isset($resTestData->test_total_que)?$resTestData->test_total_que:''?>" required>
</div>
</div>   
<div class="col-lg-3">
<div class="form-group">
<label>Marks/Questions:</label>
<input type="number" class="form-control" name="test_marked_marks" value="<?php echo isset($resTestData->test_marked_marks)?$resTestData->test_marked_marks:''?>" required placeholder="Per Question Marks">
</div>
</div> 
<div class="col-lg-3">
<div class="form-group">
<label>Marks/Questions:</label>
<input type="number" class="form-control" name="test_marked_negative_marks" value="<?php echo isset($resTestData->test_marked_negative_marks)?$resTestData->test_marked_negative_marks:''?>" required placeholder="Negative Marks">
</div>
</div> 



</div>

</div>
</div>
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Subject /Other Details</h6>
</div>
<div class="card-body" >
<div class="row row-xs">
<div class="col-lg-4">
<div class="form-group mg-b-0">
<label>Duration:</label>
<input type="number" class="form-control" name="test_duration"  value="<?php echo isset($resTestData->test_duration)?$resTestData->test_duration:''?>">
</div>
</div>
<div class="col-lg-4">
<div class="form-group mg-b-10">
<label>Scheduled date:</label>
<input type="date" class="form-control" name="test_scheduled_date" value="<?php echo isset($resTestData->test_scheduled_date)?$resTestData->test_scheduled_date:''?>">    
</div>
</div>
<div class="col-lg-4">
<div class="form-group mg-b-10">
<label>Result Announcement date:</label>
<input type="date" class="form-control" name="test_announcement_date" value="<?php echo isset($resTestData->test_announcement_date)?$resTestData->test_announcement_date:''?>">    
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
<!--<div class="form-group mg-b-0">
<div class="custom-control custom-radio">
  <input type="radio" id="customRadio1" name="test_type" required onclick="radioValidate(this.value)" class="custom-control-input" value="0" <?php echo (isset($resTestData->test_type) && $resTestData->test_type=="0")?'checked':'checked'?>>
  <label class="custom-control-label" for="customRadio1">Free</label>
</div>
<div class="custom-control custom-radio">
  <input type="radio" id="customRadio2" name="test_type" required onclick="radioValidate(this.value)" class="custom-control-input" value="1" <?php echo (isset($resTestData->test_type) && $resTestData->test_type=="1")?'checked':''?>>
  <label class="custom-control-label" for="customRadio2">Paid</label>
</div>
</div>-->
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
<?php if(in_array('7',$delete_data) || in_array('7',$edit_data) || in_array('7',$view_data)){?>
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
"><img id="test_image" src="<?php echo (isset($resTestData->test_image) && $resTestData->test_image!="")?SITE_UPLOAD_URL.SITE_TEST_IMAGE.$resTestData->test_image:SITE_NO_IMAGE_PATH;?>" class="rounded" alt=""></div>
<div class="media-body pd-l-10">
<div class="custom-file">
<input type="file" name="test_image" class="custom-file-input" onchange="showPreview('test_image',this)" id="customFile">
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
<!-- <script>
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
    CKEDITOR.replace('video_desc');
    CKEDITOR.config.allowedContent = true;
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('Csadmin.Layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\php\xamp\htdocs\coachingzon\resources\views/Csadmin/Tests/addNewTest.blade.php ENDPATH**/ ?>