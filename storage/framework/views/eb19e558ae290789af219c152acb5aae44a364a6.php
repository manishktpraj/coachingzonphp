
<?php $__env->startSection('content'); ?>
<div class="content-body">
<div class="container pd-x-0">
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
<div>
<nav aria-label="breadcrumb">
<ol class="breadcrumb breadcrumb-style1 mg-b-10">
<li class="breadcrumb-item"><a href="#">Questions Bank</a></li>
<li class="breadcrumb-item active" aria-current="page">Subjects</li>
</ol>
</nav>
<h4 class="mg-b-0 tx-spacing--1">Manage Subjects</h4>
</div>
<div class="d-none d-md-block"></div>
</div>
<div class="row row-xs">
<div class="col-lg-4">
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Add New Subject</h6>
</div>
<form method="post" action="<?php echo e(route('subjectProccess')); ?>" enctype="multipart/form-data">
<?php echo csrf_field(); ?>
<input type="hidden" name="sc_id" value="<?php echo isset($rowCategoryData->sc_id)?$rowCategoryData->sc_id:'0'?>">
<div class="card-body">
<div class="form-group">
<label>Subject Name / Title: <span style="color:red">*</span></label>
<input type="text" class="form-control" name="sc_name" required="" value="<?php echo isset($rowCategoryData->sc_name)?$rowCategoryData->sc_name:''?>">
<span class="tx-color-03" style="font-size: 11px;">This name is appears on your site</span>
</div>
<!--<div class="form-group">
<label>Parent Category:</label>
<select class="custom-select" name="sc_parent">
<option value="0">Select Parent Category</option>
<?php foreach($resCategoryData as $value){?>
<option <?php echo (isset($rowCategoryData->sc_parent) && $rowCategoryData->sc_parent==$value->sc_id)?'selected="selected"':''?> value="<?php echo $value->sc_id?>"><?php echo $value->sc_name?></option>
<?php }?>
</select>
<span class="tx-color-03" style="font-size: 11px;line-height: 20px;">Assign a parent term to create a hierarchy. The term Jazz, for example, would be the parent of Bebop and Big Band.</span>
</div>-->
<div class="form-group">
<label>Order:</label>
<input type="text" class="form-control" name="sc_order" value="<?php echo isset($rowCategoryData->sc_order)?$rowCategoryData->sc_order:''?>">
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
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Subject Listings</h6>
</div>
<div class="card-body">
<?php echo $__env->make('Csadmin.bulkaction', ['status' => 'FILTER_SUBJECT_CATEGORY'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<div class="table-responsive">
<table class="table mg-b-0">
<thead>
<tr>
<th style="width:5%;text-align:center;"><input type="checkbox" id="selectAll" style="vertical-align: middle;"></th>
<th scope="col" style="width:400px;">Subject</th>
<th scope="col">Status</th>
<th scope="col" style="text-align:center">Count</th>
<th scope="col" style="text-align:center; width:100px">Action</th>
</tr>
</thead>
<tbody>
<?php echo $strCategoryHtml?>
</tbody>
</table>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('Csadmin.Layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\php\xamp\htdocs\coachingzon\resources\views/Csadmin/Question/questionSubjects.blade.php ENDPATH**/ ?>