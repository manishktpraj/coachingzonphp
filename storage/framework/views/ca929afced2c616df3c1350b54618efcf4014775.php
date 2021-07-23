
<?php $__env->startSection('content'); ?>


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
<form method="post" action="<?php echo e(route('accountProccess')); ?>" enctype="multipart/form-data">
<?php echo csrf_field(); ?>
<input type="hidden" name="staff_id" value="<?php echo isset($resAccountData->staff_id)?$resAccountData->staff_id:''?>">
<div class="row row-xs">
<div class="col-lg-12">
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Account Details</h6>
</div>
<div class="card-body">
<div class="form-group mg-b-10">
<input type="hidden" name="store_id" value="<?php //echo isset($rowStoreData->store_id)?$rowStoreData->store_id:'0'?>">

<div class="row row-xs">
<div class="col-lg-12">
<div class="form-group" style="margin-bottom:15px">
<label>Name:</label>
<input type="text" class="form-control" required name="staff_name" value="<?php echo isset($resAccountData->staff_name)?$resAccountData->staff_name:''?>">
</div>
</div>


<div class="col-lg-6">
<div class="form-group" style="margin-bottom:15px">
<label>Email Id:</label>
<input type="text" class="form-control" required name="staff_email" value="<?php echo isset($resAccountData->staff_email)?$resAccountData->staff_email:''?>">
</div>
</div>
<div class="col-lg-6">
<div class="form-group" style="margin-bottom:15px">
<label>Mobile:</label>
<input type="text" class="form-control" required name="staff_mobile" value="<?php echo isset($resAccountData->staff_mobile)?$resAccountData->staff_mobile:''?>">
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




<form method="post" action="<?php echo e(route('passProccess')); ?>" enctype="multipart/form-data">
<?php echo csrf_field(); ?>
<input type="hidden" name="staff_id" value="<?php echo isset($resAccountData->staff_id)?$resAccountData->staff_id:''?>">
<div class="row row-xs">
<div class="col-lg-12">
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Change Password</h6>
</div>
<div class="card-body">
<div class="form-group mg-b-10">
<input type="hidden" name="store_id" value="<?php //echo isset($rowStoreData->store_id)?$rowStoreData->store_id:'0'?>">

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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('Csadmin.Layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\php\xamp\htdocs\coachingzon\resources\views/Csadmin/Settings/accountSetting.blade.php ENDPATH**/ ?>