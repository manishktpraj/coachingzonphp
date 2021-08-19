
<?php $__env->startSection('content'); ?>
<div class="content-body">
<div class="container pd-x-0">
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
<div>
<nav aria-label="breadcrumb">
<ol class="breadcrumb breadcrumb-style1 mg-b-10">
<li class="breadcrumb-item"><a href="#">Orders</a></li>
<li class="breadcrumb-item active" aria-current="page">Order Detail</li>
</ol>
</nav>
<h4 class="mg-b-0 tx-spacing--1">Order Detail</h4>
</div>
<div class="d-none d-md-block">

</div>
</div>


<div class="row row-xs">
<div class="col-lg-6">
<div class="card">

<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Student Detail</h6>
</div>
<div class="table-responsive">
<table class="table mg-b-0">
<thead>
    
<tr>
<th scope="col">Student Id</th>
<td scope="col"><?php echo $orderdata->student_registration_id;?></td>
</tr>
<tr>
<th scope="col">Student Name</th>
<td scope="col"><?php echo $orderdata->student_first_name;?></td>
</tr>
<tr>
<th scope="col">Student Mobile</th>
<td scope="col"><?php echo $orderdata->student_phone;?></td>
</tr>
<tr>
<th scope="col">Student Email</th>
<td scope="col"><?php echo $orderdata->student_email;?></td>
</tr>
<tr>
<th scope="col">Student City</th>
<td scope="col"><?php echo $orderdata->student_city;?></td>
</tr>
<tr>
<th scope="col">Student State</th>
<td scope="col"><?php echo $orderdata->student_state;?></td>
</tr>
</thead>
</table>
</div>
</div>
</div>
<div class="col-lg-6">
<div class="card">

<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Order Detail</h6>
</div>
<div class="table-responsive">
<table class="table mg-b-0">
<thead>
    
<tr>
<th scope="col">Order Id</th>
<td scope="col"><?php echo $orderdata->trans_order_id;?></td>
</tr>
<tr>
<th scope="col">User  Name</th>
<td scope="col"><?php echo $orderdata->trans_user_name;?></td>
</tr>
<tr>
<th scope="col">User Mobile</th>
<td scope="col"><?php echo $orderdata->trans_mobile_number;?></td>
</tr>
<tr>
<th scope="col">User Email</th>
<td scope="col"><?php echo $orderdata->trans_email;?></td>
</tr>
<tr>
<th scope="col">Order Amount</th>
<td scope="col"><?php echo $orderdata->trans_amt;?></td>
</tr>
</thead>
</table>
</div>
</div>
</div>




</div>








<?php $__env->stopSection(); ?>
<?php echo $__env->make('Csadmin.Layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\php\xamp\htdocs\coachingzon\resources\views/Csadmin/Order/order_detail.blade.php ENDPATH**/ ?>