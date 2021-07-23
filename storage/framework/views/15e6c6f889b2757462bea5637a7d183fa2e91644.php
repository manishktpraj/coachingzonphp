<?php $__env->startSection('content'); ?>
<div class="content-body">
<div class="container pd-x-0">
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
<div>
<nav aria-label="breadcrumb">
<ol class="breadcrumb breadcrumb-style1 mg-b-10">
<li class="breadcrumb-item"><a href="#">Questions</a></li>
<li class="breadcrumb-item active" aria-current="page">All Questions</li>
</ol>
</nav>
<h4 class="mg-b-0 tx-spacing--1">Manage Questions</h4>
</div>
<div class="d-none d-md-block">
<a href="<?php echo e(route('exportQuestion')); ?>" class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="file" class="wd-10 mg-r-5"></i>Export</a>
<a href="<?php echo e(route('importQuestion')); ?>" class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5"><i data-feather="file" class="wd-10 mg-r-5"></i>Import</a>
<a href="<?php echo e(route('add-new-question')); ?>" class="btn btn-sm pd-x-15 btn-primary btn-uppercase  mg-l-5"><i data-feather="plus" class="wd-10 mg-r-5"></i>Add New Question</a>
</div>
</div>
<div class="row row-xs">
<div class="col-lg-12">
<div class="card">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Questions Lists</h6>
<div class="d-flex tx-18">
<a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
</div>
</div>
<div class="card-body">
<form method="post" accept-charset="utf-8" id="bulkaction" class="form-horizontal" action="/codexo/project/dealzdxb/csadmin/product"><div style="display:none;"><input type="hidden" name="_method" value="POST"></div><div class="row">
<div class="col-lg-6">
<div class="d-sm-flex justify-content-start mg-b-0">
<div class="form-group mg-b-0">
<select class="custom-select" name="bulkaction" id="bulkactionSelect">
<option value="">Bulk Action</option> 
<option value="1">Delete</option>
<option value="2">Active</option>
<option value="3">Inactive</option>
</select>
</div>
<div class="mg-sm-l-10">
<button type="submit" id="bulkaction-button" class="btn btn-primary pd-x-20">Apply</button>
</div>
</div>
</div>
<div class="col-lg-6">
<div class="d-sm-flex justify-content-end mg-b-0">
<div class="form-group mg-b-0">
<input type="text" class="form-control wd-150" placeholder="" name="filter_keyword" value="">
</div>
<div class="mg-sm-l-10">
<button type="submit" class="btn btn-primary "><i class="fas fa-search"></i></button>

</div>
</div>
</div>
</div> 
</form></div>
<div class="table-responsive">
<table class="table mg-b-0">
<thead>
<tr>
<th scope="col" style="text-align:center">S.No.</th>
<th scope="col">Question Details</th>
<th scope="col">Subject</th>
<th scope="col">Type</th>
<th scope="col" style="text-align:center">Action</th>
</tr>
</thead>
<tbody>
<tr>
<th scope="row" style="text-align:center">1</th>
<td>
<div class="media align-items-center mg-b-0">
<div class="media-body pd-l-0">
<h6 class="mg-b-0" style=" white-space: nowrap;  overflow: hidden;  text-overflow: ellipsis; width:300px"><a href="#">The Volleyball coach said, “Girls! Girls! do not get abusive, itis just a game and learn to be fair in a game.</a></h6>
</div>
</div>
</td>
<td>English Language & Comprehension</td>
<td><span class="d-block tx-13 tx-color-03">English</span></td>
<td>
<div class="d-flex align-self-center justify-content-center">
<nav class="nav nav-icon-only">
<a href="#" class="btn btn-info btn-icon mg-r-5" title="Copy Listing" style="padding:0px 5px;"><i class="fas fa-copy" style="font-size:11px;"></i></a>
<a href="#" class="btn btn-primary btn-icon mg-r-5" title="Edit" style="padding:0px 5px;"><i class="fas fa-pencil-alt" style="font-size:11px;"></i></a>
<a href="#" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-icon mg-r-5" title="Delete" style="padding:0px 5px;"><i class="fas fa-trash-alt" style="font-size:11px;"></i></a>
</nav>
</div>
</td>
</tr>
</tbody>
</table>
</div>
<div class="card-footer d-flex align-items-center justify-content-between" style="align-items: center;">
<span class="text-muted">Showing 50 to 50 of 371 entries</span>
<ul class="pagination pagination-filled mg-b-0">
 <li class="page-item disabled"><a class="page-link page-link-icon" href="#"><i data-feather="chevron-left"></i></a></li>
    <li class="page-item active"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item"><a class="page-link page-link-icon" href="#"><i data-feather="chevron-right"></i></a></li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('Csadmin.Layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\php\xamp\htdocs\coachingzon\resources\views/Csadmin/Question/index.blade.php ENDPATH**/ ?>