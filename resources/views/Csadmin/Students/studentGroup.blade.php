@extends('Csadmin.Layout.app')
@section ('content')
<div class="content-body">
<div class="container pd-x-0">
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
<div>
<nav aria-label="breadcrumb">
<ol class="breadcrumb breadcrumb-style1 mg-b-10">
<li class="breadcrumb-item"><a href="#">Questions Bank</a></li>
<li class="breadcrumb-item active" aria-current="page">Student Group</li>
</ol>
</nav>
<h4 class="mg-b-0 tx-spacing--1">Manage Student Group</h4>
</div>
<div class="d-none d-md-block"></div>
</div>
<div class="row row-xs">
<div class="col-lg-4">
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Add New Student Group</h6>
</div>
<form method="post" action="{{route('groupProccess')}}" enctype="multipart/form-data">
@csrf
<input type="hidden" name="sg_id" value="<?php echo isset($rowCategoryData->sg_id)?$rowCategoryData->sg_id:'0'?>">
<div class="card-body">
<div class="form-group">
<label>Student Group Name / Title: <span style="color:red">*</span></label>
<input type="text" class="form-control" name="sg_name" required="" value="<?php echo isset($rowCategoryData->sg_name)?$rowCategoryData->sg_name:''?>">
<span class="tx-color-03" style="font-size: 11px;">This name is appears on your site</span>
</div>
<!--<div class="form-group">
<label>Order:</label>
<input type="text" class="form-control" name="sg_order" value="<?php echo isset($rowCategoryData->sg_order)?$rowCategoryData->sg_order:''?>">
</div>-->


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
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Student Group Listings</h6>
</div>
<!-- <div class="card-body">


@include('Csadmin.bulkaction', ['status' => 'FILTER_GROUP'])
</div> -->
<div class="table-responsive">
<table class="table mg-b-0">
<thead>
<tr>
<th style="width:5%;text-align:center;"><input type="checkbox" id="selectAll" style="vertical-align: middle;"></th>
<th scope="col" style="width:400px;">Group Name</th>
<!--<th scope="col">Status</th>-->
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
@endsection