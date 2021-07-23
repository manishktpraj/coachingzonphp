
<?php $__env->startSection('content'); ?>
<?php //print_r($resStudentData);?>
<div class="content-body">
<div class="container pd-x-0">
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
<div>
<nav aria-label="breadcrumb">
<ol class="breadcrumb breadcrumb-style1 mg-b-10">
<li class="breadcrumb-item"><a href="#">Students</a></li>
<li class="breadcrumb-item active" aria-current="page">All Students</li>
</ol>
</nav>
<h4 class="mg-b-0 tx-spacing--1">Manage Students</h4>
</div>
<div class="d-none d-md-block">
<a href="#" class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="file" class="wd-10 mg-r-5"></i>Export</a>
<a href="<?php echo e(route('add-new-student')); ?>" class="btn btn-sm pd-x-15 btn-primary btn-uppercase  mg-l-5"><i data-feather="plus" class="wd-10 mg-r-5"></i>Add New Student</a>
</div>
</div>
<div class="row row-xs">
<div class="col-lg-12">
<div class="card">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Students Lists</h6>
<div class="d-flex tx-18">
<a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
</div>
</div>
<div class="card-body">
<?php echo $__env->make('Csadmin.bulkaction', ['status' => 'FILTER_STUDENT'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<div class="table-responsive">
<table class="table mg-b-0">
<thead>
<tr>
<th scope="col" style="text-align:center;width:10px;"><input type="checkbox" id="selectAll"></th>
<th scope="col" style="text-align:center;width:50px;">S.No.</th>
<th scope="col">Student ID</th>
<th scope="col">Student Details</th>
<th scope="col">Mobile Number</th>
<th scope="col">Status</th>
<th scope="col">Last Login</th>
<th scope="col">Date</th>
<th scope="col" style="text-align:center">Action</th>
</tr>
</thead>
<tbody>
<?php 
$i=1;if(count($resStudentData)>0){
foreach($resStudentData as $students){?>
<tr>
<td scope="row" style="text-align:center"><input type="checkbox" id="selectAll" class="clsSelectSingle" name="student_id[]" value="<?php echo $students->student_id ?>"></th>
<td scope="row" style="text-align:center"><?php echo $i++;?></td>
<td scope="row"><?php echo $students->student_registration_id?></td>
<td>
<div class="media align-items-center mg-b-0">
<div class="avatar avatar-online"><img src="https://via.placeholder.com/500" class="rounded-circle" alt=""></div>
<div class="media-body pd-l-10">
<h6 class="mg-b-3"><a href="<?php echo e(route('viewstudent',$students->student_id)); ?>"><?php echo $students->student_first_name.$students->student_last_name ?></a></h6>
<span class="d-block tx-13 tx-color-03"><?php echo $students->student_email?></span>
</div>
</div>
</td>
<td><?php echo $students->student_phone?></td>
<td> <?php if($students->student_status==1){?>
    <a href="<?php echo e(route('studentStatus',$students->student_id)); ?>" onclick="return confirm('Are you sure?')"><span class="badge badge-success">Active</span></a>
    <?php }else{?>
    <a href="<?php echo e(route('studentStatus',$students->student_id)); ?>" onclick="return confirm('Are you sure?')"><span class="badge badge-danger">Inactive</span></a>
    <?php }?></td>
<td><span class="d-none d-sm-block tx-13 tx-color-03 align-self-start">5 hours ago</span></td>
<td><?php echo date("d M Y",strtotime($students->created_at));?></td>
<td>
<div class="d-flex align-self-center justify-content-center">
<nav class="nav nav-icon-only">
<a href="<?php echo e(route('add-new-student',$students->student_id )); ?>" class="btn btn-info btn-icon mg-r-5" title="Assign Package" style="padding:0px 5px;"><i class="fas fa-copy" style="font-size:11px;"></i></a>
<a href="<?php echo e(route('add-new-student',$students->student_id )); ?>" class="btn btn-primary btn-icon mg-r-5" title="Edit" style="padding:0px 5px;"><i class="fas fa-pencil-alt" style="font-size:11px;"></i></a>
<a href="<?php echo e(route('studentDelete',$students->student_id )); ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-icon mg-r-5" title="Delete" style="padding:0px 5px;"><i class="fas fa-trash-alt" style="font-size:11px;"></i></a>
</nav>
</div>
</td>
</tr>
<?php }} ?>
</tbody>
</table>
</div>
<div class="card-footer d-flex align-items-center justify-content-between" style="align-items: center;">
<span class="text-muted"><?php echo 'Showing '.$resStudentData->firstItem().' to '.$resStudentData->lastItem().' of '.$resStudentData->total().' entries';?></span>
<ul class="pagination pagination-filled mg-b-0"><?php echo e($resStudentData->links()); ?></ul>
</div>
</div>
</div>
</div>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('Csadmin.Layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/coachingzon.com/httpdocs/portal/resources/views/Csadmin/Students/index.blade.php ENDPATH**/ ?>