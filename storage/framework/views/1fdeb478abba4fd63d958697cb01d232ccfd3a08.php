
<?php $__env->startSection('content'); ?>
<?php //print_r($resfacultyData);?>
<div class="content-body">
<div class="container pd-x-0">
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
<div>
<nav aria-label="breadcrumb">
<ol class="breadcrumb breadcrumb-style1 mg-b-10">
<li class="breadcrumb-item"><a href="#">Offers & Promos</a></li>
<li class="breadcrumb-item active" aria-current="page">All Offers & Promos</li>
</ol>
</nav>
<h4 class="mg-b-0 tx-spacing--1">Manage Offer & Promos</h4>
</div>
<div class="d-none d-md-block">
<a href="#" class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="file" class="wd-10 mg-r-5"></i>Export</a>
<a href="<?php echo e(route('add-new-offers')); ?>" class="btn btn-sm pd-x-15 btn-primary btn-uppercase  mg-l-5"><i data-feather="plus" class="wd-10 mg-r-5"></i>Add New Offers & Promos</a>
</div>
</div>
<div class="row row-xs">
<div class="col-lg-12">
<div class="card">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Offers Lists</h6>
<div class="d-flex tx-18">
<a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
</div>
</div>
<div class="card-body">
<?php echo $__env->make('Csadmin.bulkaction', ['status' => 'FILTER_OFFER'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<div class="table-responsive">
<table class="table mg-b-0">
<thead>
<tr>
<th scope="col" style="text-align:center;width:10px;"><input type="checkbox" id="selectAll"></th>
<th scope="col" style="text-align:center;width:50px;">S.No.</th>
<th scope="col"> Coupon Name</th>
<th scope="col"> Coupon Code</th>
<?php if($user->staff_role==3){?>
<th scope="col" style="text-align:center;">Published By</th>
<?php } ?>
<th scope="col"> Valid From</th>
<th scope="col"> Valid To</th>
<th>Status</th>
<th scope="col" style="text-align:center">Action</th>
</tr>
</thead>
<tbody>
<?php 
$i=1;if(count($resOfferLists)>0){
foreach($resOfferLists as $offer){?>
<tr>
<td scope="row" style="text-align:center"><input type="checkbox" id="selectAll" class="clsSelectSingle" name="offers_id[]" value="<?php echo $offer->offers_id ?>"></th>
<td scope="row" style="text-align:center"><?php echo $i++;?></td>
<td><?php echo $offer->offers_name?></td>
<td><?php echo $offer->coupon_code?></td>
<?php if($user->staff_role==3){?>
<td style="text-align:center;"><span class="tx-13"><?php echo isset($offer->ins_name)?$offer->ins_name:'Admin';?></span></td>
<?php } ?>
<td><?php echo $offer->offers_valid_from?></td>
<td><?php echo $offer->offers_valid_to?></td>

<td> <?php if($offer->offers_status==1){?>
    <a href="<?php echo e(route('offersStatus',$offer->offers_id)); ?>" onclick="return confirm('Are you sure?')"><span class="badge badge-success">Active</span></a>
    <?php }else{?>
    <a href="<?php echo e(route('offersStatus',$offer->offers_id)); ?>" onclick="return confirm('Are you sure?')"><span class="badge badge-danger">Inactive</span></a>
    <?php }?></td>
<td>
<div class="d-flex align-self-center justify-content-center">
<nav class="nav nav-icon-only">
<a href="<?php echo e(route('add-new-offers',$offer->offers_id )); ?>" class="btn btn-primary btn-icon mg-r-5" title="Edit" style="padding:0px 5px;"><i class="fas fa-pencil-alt" style="font-size:11px;"></i></a>
<a href="<?php echo e(route('deleteoffer',$offer->offers_id )); ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-icon mg-r-5" title="Delete" style="padding:0px 5px;"><i class="fas fa-trash-alt" style="font-size:11px;"></i></a>
</nav>
</div>
</td>
</tr>
<?php }}else{ ?>
    <tr><td colspan="8" class="text-center">No Record Found</td></tr>
<?php } ?>
</tbody>
</table>
</div>
<div class="card-footer d-flex align-items-center justify-content-between" style="align-items: center;">

<span class="text-muted"><?php echo 'Showing '.$resOfferLists->firstItem().' to '.$resOfferLists->lastItem().' of '.$resOfferLists->total().' entries';?></span>
<ul class="pagination pagination-filled mg-b-0"><?php echo e($resOfferLists->links()); ?></ul>
</div>
</div>
</div>
</div>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('Csadmin.Layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\php\xamp\htdocs\coachingzon\resources\views/Csadmin/Offers/index.blade.php ENDPATH**/ ?>