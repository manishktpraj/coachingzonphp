
<?php $__env->startSection('content'); ?>

<div class="content-body">
<div class="container pd-x-0">
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
<div>
<nav aria-label="breadcrumb">
<ol class="breadcrumb breadcrumb-style1 mg-b-10">
<li class="breadcrumb-item"><a href="#"><?php echo $resTestData->test_name;?></a></li>
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
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Test/Exams Lists</h6>
<div class="d-flex tx-18">
<a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
</div>
</div>
<div class="card-body">
<?php echo $__env->make('Csadmin.bulkaction', ['status' => 'FILTER_TEST'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<div class="table-responsive">
<table class="table mg-b-0">
<thead>
<tr>
<th scope="col" style="text-align:center;width:10px;"><input type="checkbox" id="selectAll" style="
    vertical-align: middle;"></th>
<th scope="col" style="text-align:center;width:50px;">S.No.</th>
<th scope="col">Subject Name</th>


<th scope="col" style="text-align:center">No. Of Qs.</th>
<th scope="col" style="text-align:center">Marks/Questions:</th>
<th scope="col" style="text-align:center">Negative Marks/Questions:
</th>
<th scope="col" style="text-align:center">Action</th>
</tr>
</thead>
<tbody>
<?php $i=1;

if($resTestData!=''){ ?>
<tr>
<th scope="row" style="text-align:center;vertical-align: middle;"><input type="checkbox" id="selectAll" class="clsSelectSingle" name="test_id[]" value="<?php echo $resTestData->test_id ?>" style="
    vertical-align: middle;"></th>
<td scope="row" style="text-align:center"><?php echo $i++;?></td>
<td scope="row" ><?php echo $resTestData->test_subject;?></td>
<td scope="row" style="text-align:center"><?php echo $resTestData->test_total_que;?></td>
<td scope="row" style="text-align:center"><?php echo $resTestData->test_marked_marks;?></td>
<td scope="row" style="text-align:center"><?php echo $resTestData->test_marked_negative_marks;?></td>
<td>
<div class="d-flex align-self-center justify-content-center">
<nav class="nav nav-icon-only">
<a href="<?php echo e(route('addtestQuestion',$resTestData->test_id )); ?>" class="btn btn-info btn-icon mg-r-5" title="Questiion" style="padding:0px 5px;"><i class="fas fa-copy" style="font-size:11px;"> +</i></a>
</nav>
</div>
</td>

<?php }else{ ?>
<tr><td colspan="8" class="text-center">No Record Found</td></tr>
<?php } ?>  
</tbody>
</table>
</div>
<div class="card-footer d-flex align-items-center justify-content-between" style="align-items: center;">

<span class="text-muted"><?php //echo 'Showing '.$resTestData->firstItem().' to '.$resTestData->lastItem().' of '.$resTestData->total().' entries';?></span>
<ul class="pagination pagination-filled mg-b-0"></ul>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('Csadmin.Layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\php\xamp\htdocs\coachingzon\resources\views/Csadmin/Tests/testQuestion.blade.php ENDPATH**/ ?>