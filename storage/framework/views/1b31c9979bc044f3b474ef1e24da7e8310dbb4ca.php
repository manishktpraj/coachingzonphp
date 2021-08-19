
<?php $__env->startSection('content'); ?>

<div class="content-body">
<div class="container pd-x-0">
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
<div>
<nav aria-label="breadcrumb">
<ol class="breadcrumb breadcrumb-style1 mg-b-10">
<li class="breadcrumb-item"><a href="#"><?php echo $resTestData->test_name."-".$resTestData->test_subject;?></a></li>
<li class="breadcrumb-item active" aria-current="page">Add Questions</li>
</ol>
</nav>
<h4 class="mg-b-0 tx-spacing--1">Add Questions</h4>
</div>
</div>


<div class="row row-xs">
<div class="col-lg-12">
<div class="card">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;"><?php echo $resTestData->test_name."-".$resTestData->test_subject;?></h6>
<div class="d-flex tx-18">
<a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
</div>
</div>

<div class="table-responsive">
<table class="table mg-b-0">
<thead>
<tr>

<th scope="col">Question</th>
<th scope="col" style="width:10px;"><input type="checkbox" id="selectAll" style="
    vertical-align: middle; margin-right:0px;"></th>
</tr>
</thead>
<tbody>

<tr><td colspan="8" class="text-center">No Record Found</td></tr>

</tbody>
</table>
</div>
<div class="card-footer d-flex align-items-center justify-content-between" style="align-items: center;">

<span class="text-muted"><?php //echo 'Showing '.$resTestData->firstItem().' to '.$resTestData->lastItem().' of '.$resTestData->total().' entries';?></span>
<ul class="pagination pagination-filled mg-b-0"></ul>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('Csadmin.Layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\php\xamp\htdocs\coachingzon\resources\views/Csadmin/Tests/addtestQuestion.blade.php ENDPATH**/ ?>