@extends('Csadmin.Layout.app')
@section ('content')
<div class="content-body">
<div class="container pd-x-0">
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
<div>
<nav aria-label="breadcrumb">
<ol class="breadcrumb breadcrumb-style1 mg-b-10">
<li class="breadcrumb-item"><a href="#">Orders</a></li>
<li class="breadcrumb-item active" aria-current="page">All Orders</li>
</ol>
</nav>
<h4 class="mg-b-0 tx-spacing--1">Manage Orders</h4>
</div>
<div class="d-none d-md-block">
<a href="#" class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="file" class="wd-10 mg-r-5"></i>Export</a>
<a href="#" class="btn btn-sm pd-x-15 btn-primary btn-uppercase  mg-l-5"><i data-feather="plus" class="wd-10 mg-r-5"></i>Add New Order</a>
</div>
</div>
<div class="row row-xs">
<div class="col-lg-12">
<div class="card">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Orders Lists</h6>
<div class="d-flex tx-18">
<a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
</div>
</div>
<div class="card-body">
@include('Csadmin.bulkaction', ['status' => 'FILTER_ORDER'])
</div>
<div class="table-responsive">
<table class="table mg-b-0">
<thead>
<tr>
<th style="width:5%;text-align:center;"><input type="checkbox" id="selectAll" style="vertical-align: middle;"></th>

<th scope="col">Order ID</th>
<th scope="col">Order Details</th>
<th scope="col">Customer Details</th>
<th scope="col">Status</th>
<th scope="col">Order Date</th>
<th scope="col" style="text-align:center">Action</th>
</tr>
</thead>
<tbody>
    <?php foreach($orderdata as $order){ ?>
<tr>
<th style="width:5%;text-align:center;"><input type="checkbox" id="selectAll" style="vertical-align: middle;"></th>

<th scope="row"><?php echo $order->trans_order_id;?></th>
<td>
<div class="media align-items-center mg-b-0">

<div class="media-body pd-l-10">
<h6 class="mg-b-3"><a href="#"><?php echo $order->td_name;?></a></h6>

</div>
</div>
</td>
<td>
<div class="media align-items-center mg-b-0">
<div class="media-body pd-l-10">
<h6 class="mg-b-3"><a href="#"><?php echo $order->trans_user_name;?></a></h6>
<span class="d-block tx-13 tx-color-03"><?php echo $order->trans_email;?></span>
</div>
</div>
</td>

<td><a href="#"><span class="badge badge-success">Active</span></a></td>
<td><?php echo date("d M Y",strtotime($order->created_at));?></td>
<td>
<div class="d-flex align-self-center justify-content-center">
<nav class="nav nav-icon-only">
<a href="{{route('order-detail',$order->trans_user_id )}}" class="btn btn-info btn-icon mg-r-5" title="Copy Listing" style="padding:0px 5px;"><i class="fas fa-copy" style="font-size:11px;"></i></a>
<a href="#" class="btn btn-primary btn-icon mg-r-5" title="Edit" style="padding:0px 5px;"><i class="fas fa-pencil-alt" style="font-size:11px;"></i></a>
<a href="#" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-icon mg-r-5" title="Delete" style="padding:0px 5px;"><i class="fas fa-trash-alt" style="font-size:11px;"></i></a>
</nav>
</div>
</td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
<div class="card-footer d-flex align-items-center justify-content-between" style="align-items: center;">

<span class="text-muted"><?php echo 'Showing '.$orderdata->firstItem().' to '.$orderdata->lastItem().' of '.$orderdata->total().' entries';?></span>
<ul class="pagination pagination-filled mg-b-0">{{ $orderdata->links() }}</ul>
</div>
</div>
</div>
</div>
</div>
</div>
@endsection