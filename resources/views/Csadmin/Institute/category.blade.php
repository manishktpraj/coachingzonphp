@extends('Csadmin.Layout.app')
@section ('content')
<div class="content-body">
<div class="container pd-x-0">
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
<div>
<nav aria-label="breadcrumb">
<ol class="breadcrumb breadcrumb-style1 mg-b-10">
<li class="breadcrumb-item"><a href="#">Institute</a></li>
<li class="breadcrumb-item active" aria-current="page">Categories</li>
</ol>
</nav>
<h4 class="mg-b-0 tx-spacing--1">Manage Institute Categories</h4>
</div>
<div class="d-none d-md-block"></div>
</div>
<div class="row row-xs">
<div class="col-lg-4">
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Add New Institute Category</h6>
</div>
<form method="post" action="{{route('videoCategoryProccess')}}" enctype="multipart/form-data">
@csrf
<input type="hidden" name="icat_id" value="<?php echo isset($rowCategoryData->icat_id)?$rowCategoryData->icat_id:'0'?>">
<div class="card-body">
<div class="form-group">
<label>Institute Name / Title: <span style="color:red">*</span></label>
<input type="text" class="form-control" name="vc_name" required="" value="<?php echo isset($rowCategoryData->vc_name)?$rowCategoryData->vc_name:''?>">
<span class="tx-color-03" style="font-size: 11px;">This name is appears on your site</span>
</div>
<?php //print_r($resCategoryData);
// foreach($resCategoryData as $value){
// echo $value->vc_name;
//  if($value->vc_parent==$value->icat_id){
//   echo $value->vc_name;
//  }  
    
    
// }

//echo "shikha";

?>
<div class="form-group">
<label>Description: <span style="color:red">*</span></label>
<!-- <textarea type="textarea" class="form-control" name="vc_name" required="" value="<?php echo isset($rowCategoryData->vc_name)?$rowCategoryData->vc_name:''?>"></textarea> -->
<textarea rows="3" cols="5" class="form-control" placeholder="Description" name="icat_description"></textarea>
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
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Institute Categories Listings</h6>
</div>
<div class="card-body">
<form method="post" action="{{route('bulkActionVideoCat')}}"  enctype="multipart/form-data">
@csrf
<div class="row">
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

</div>
<div class="table-responsive">
<table class="table mg-b-0">
<thead>
<tr>
<th style="width:5%;text-align:center;width:10px;"><input type="checkbox" id="selectAll" style="vertical-align: middle;"></th>
<th scope="col" style="width:400px;">Category</th>
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
@endsection
