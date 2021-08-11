
<?php $__env->startSection('content'); ?>
<div class="content-body">
<div class="container pd-x-0">
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
<div>
<nav aria-label="breadcrumb">
<ol class="breadcrumb breadcrumb-style1 mg-b-10">
<li class="breadcrumb-item"><a href="#">Faculty</a></li>
<li class="breadcrumb-item active" aria-current="page">Faculty Role</li>
</ol>
</nav>
<h4 class="mg-b-0 tx-spacing--1">Manage Faculty Role</h4>
</div>
<div class="d-none d-md-block"></div>
</div>
<div class="row row-xs">
<div class="col-lg-4">
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Add New Faculty Role</h6>
</div>
<form method="post" action="<?php echo e(route('roleproccess')); ?>" enctype="multipart/form-data">
<?php echo csrf_field(); ?>
<input type="hidden" name="role_id" value="<?php echo isset($resfacroleData->role_id)?$resfacroleData->role_id:'0'?>">
<div class="card-body">
<div class="form-group">
<label>Role Name / Title: <span style="color:red">*</span></label>
<input type="text" class="form-control" name="role_name" required="" value="<?php echo isset($resfacroleData->role_name)?$resfacroleData->role_name:''?>">
<span class="tx-color-03" style="font-size: 11px;">This name is appears on your site</span>
</div>


</div>
<div class="card-footer" style="padding: 0.75rem 1rem;">
<button type="submit" class="btn btn-lg btn-success btn-block">Save</button>
</div>
</form>
</div>
</div>
<div class="col-lg-8">
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Faculty Role Listings</h6>
</div>
<div class="card-body">
<?php echo $__env->make('Csadmin.bulkaction', ['status' => 'FILTER_ROLE'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


</div>
<div class="table-responsive">
<table class="table mg-b-0">
<thead>
<tr>
<th style="width:5%;text-align:center;width:10px;"><input type="checkbox" id="selectAll" style="vertical-align: middle;"></th>
<th scope="col" style="width:400px;">Role</th>
<th scope="col">Status</th>
<th scope="col" style="text-align:center; width:100px">Action</th>
</tr>
</thead>
<tbody>
<?php if(count($resroleData)>0){
    foreach($resroleData as $role){?> 
<tr>
<td scope="row" style="text-align:center;vertical-align: middle;"><input type="checkbox" id="selectAll" class="clsSelectSingle" name="role_id[]" value="<?php echo $role->role_id;?>">
<td scope="col" style="width:400px;"><?php echo $role->role_name;?></td>

<td> <?php if($role->role_status==1){?>
    <a href="<?php echo e(route('roleStatus',$role->role_id)); ?>" onclick="return confirm('Are you sure?')"><span class="badge badge-success">Active</span></a>
    <?php }else{?>
    <a href="<?php echo e(route('roleStatus',$role->role_id)); ?>" onclick="return confirm('Are you sure?')"><span class="badge badge-danger">Inactive</span></a>
    <?php }?></td>
<td scope="col" style="text-align:center; width:100px"><div class="d-flex align-self-center justify-content-center">
<nav class="nav nav-icon-only">
<a href="<?php echo e(route('permission',$role->role_id )); ?>" class="btn btn-info btn-icon mg-r-5" title="Permission" style="padding:0px 5px;"><i class="fas fa-copy" style="font-size:11px;"></i></a>
<a href="<?php echo e(route('faculty-role',$role->role_id )); ?>" class="btn btn-primary btn-icon mg-r-5" title="Edit" style="padding:0px 5px;"><i class="fas fa-pencil-alt" style="font-size:11px;"></i></a>
</nav>
</div></td>
</tr>
<?php }}else{?>
    <tr>
    <td colspan="6" style="text-align:center">No Result Found</td>
    </tr>
    <?php }?>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('Csadmin.Layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\php\xamp\htdocs\coachingzon\resources\views/Csadmin/Faculty/facultyrole.blade.php ENDPATH**/ ?>