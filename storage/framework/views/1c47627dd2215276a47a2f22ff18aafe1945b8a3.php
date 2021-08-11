
<?php $__env->startSection('content'); ?>
<div class="content-body">
<div class="container pd-x-0">
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
<div>
<nav aria-label="breadcrumb">
<ol class="breadcrumb breadcrumb-style1 mg-b-10">
<li class="breadcrumb-item"><a href="#">Transactions</a></li>
<li class="breadcrumb-item active" aria-current="page">All Transaction</li>
</ol>
</nav>
<h4 class="mg-b-0 tx-spacing--1">All Transaction</h4>
</div>
</div>


<div class="row row-xs">

<div class="col-sm-6 col-lg-3">
<div class="card card-body">
<h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Revenue</h6>
<div class="d-flex d-lg-block d-xl-flex align-items-end">
  <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">₹253363.00</h3>
  <p class="tx-11 tx-color-03 mg-b-0"><span class="tx-medium tx-success">1.2% <i class="icon ion-md-arrow-up"></i></span></p>
</div>
<div class="chart-three">
	<div id="flotChart3" class="flot-chart ht-30"></div>
  </div><!-- chart-three -->
</div>
</div><!-- col -->
<div class="col-sm-6 col-lg-3">
<div class="card card-body">
<h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Number of Purchases</h6>
<div class="d-flex d-lg-block d-xl-flex align-items-end">
  <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">3,137</h3>
  <p class="tx-11 tx-color-03 mg-b-0"><span class="tx-medium tx-danger">0.7% <i class="icon ion-md-arrow-down"></i></span></p>
</div>
<div class="chart-three">
	<div id="flotChart4" class="flot-chart ht-30"></div>
  </div><!-- chart-three -->
</div>
</div><!-- col -->
<div class="col-sm-6 col-lg-3 ">
<div class="card card-body">
<h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">My Share</h6>
<div class="d-flex d-lg-block d-xl-flex align-items-end">
  <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">$306.20</h3>
  <p class="tx-11 tx-color-03 mg-b-0"><span class="tx-medium tx-danger">0.3% <i class="icon ion-md-arrow-down"></i></span></p>
</div>
<div class="chart-three">
	<div id="flotChart5" class="flot-chart ht-30"></div>
  </div><!-- chart-three -->
</div>
</div><!-- col -->
<div class="col-sm-6 col-lg-3">
<div class="card card-body">
<h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Coachingzon Share</h6>
<div class="d-flex d-lg-block d-xl-flex align-items-end">
  <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">1,650</h3>
  <p class="tx-11 tx-color-03 mg-b-0"><span class="tx-medium tx-success">2.1% <i class="icon ion-md-arrow-up"></i></span></p>
</div>
<div class="chart-three">
	<div id="flotChart6" class="flot-chart ht-30"></div>
  </div><!-- chart-three -->
</div>
</div>

<div class="col-lg-12">
<div class="card mg-t-10">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Transaction Lists</h6>
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
<th scope="col" style="text-align:center;width:5%;">S.No.</th>
<th scope="col" style="width:30%;">Transaction Id</th>
<th scope="col" style="width:25%;">Student Detail</th>
<th scope="col" style="text-align:center;width:20%;">Package</th>
<th scope="col" style="text-align:center;width:10%;">Date</th>
<th scope="col" style="text-align:center;width:10%;">Amount</th>
</tr>
</thead>
<tbody>
<tr>
<th scope="row" style="text-align:center">1</th>
<td>
<div class="media align-items-center mg-b-0">
<div class="media-body pd-l-0">
<h6 class="mg-b-0" style=" white-space: nowrap;  overflow: hidden;  text-overflow: ellipsis;"><a href="#">Tpy12345</a></h6>
</div>
</div>
</td>
<td style="">Neon Classes</td>
<td style="text-align:center"><span class="d-block tx-13 tx-color-03">Debit Card</span></td>
<td style="text-align:center"><span class="d-block tx-13 tx-color-03">10 July 21</span></td>
<td style="text-align:center">₹5000</td>
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


<?php echo $__env->make('Csadmin.Layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\php\xamp\htdocs\coachingzon\resources\views/Csadmin/Transaction/index.blade.php ENDPATH**/ ?>