@extends('Csadmin.Layout.app')
@section ('content')
<div class="content-body">
<div class="container pd-x-0">
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
<div>
<nav aria-label="breadcrumb">
<ol class="breadcrumb breadcrumb-style1 mg-b-10">
<li class="breadcrumb-item"><a href="#">Test/Exams</a></li>
<li class="breadcrumb-item active" aria-current="page">Test/Exams Categories</li>
</ol>
</nav>
<h4 class="mg-b-0 tx-spacing--1">Manage Test/Exams Categories</h4>
</div>
<div class="d-none d-md-block"></div>
</div>
<div class="row row-xs">
<div class="col-lg-4">
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Add New Test/Exams Category</h6>
</div>
<form method="post" action="{{route('testCategoryProccess')}}" enctype="multipart/form-data">
@csrf
<input type="hidden" name="tc_id" value="<?php echo isset($rowCategoryData->tc_id)?$rowCategoryData->tc_id:'0'?>">
<div class="card-body">
<div class="form-group">
<label>Category Name / Title: <span style="color:red">*</span></label>
<input type="text" class="form-control" name="tc_name" required="" value="<?php echo isset($rowCategoryData->tc_name)?$rowCategoryData->tc_name:''?>">
<span class="tx-color-03" style="font-size: 11px;">This name is appears on your site</span>
</div>
<div class="form-group">
<label>Parent Category:</label>
<select class="custom-select" name="tc_parent">
<option value="0">Select Parent Category</option>
<?php echo $strEntryHtml;?>









}?>
</select>



<span class="tx-color-03" style="font-size: 11px;line-height: 20px;">Assign a parent term to create a hierarchy. The term Jazz, for example, would be the parent of Bebop and Big Band.</span>
</div>
<div class="form-group">
<label>Order:</label>
<input type="text" class="form-control" name="tc_order" value="<?php echo isset($rowCategoryData->tc_order)?$rowCategoryData->tc_order:''?>">
</div>
<div class="form-group">
<label>Image:</label>
<div class="media align-items-center">
<div class="avatar" style="height:60px; width:60px
"><img id="tc_image" src="<?php echo (isset($rowCategoryData->tc_image) && $rowCategoryData->tc_image!="")?SITE_UPLOAD_URL.SITE_TEST_IMAGE.$rowCategoryData->tc_image:SITE_NO_IMAGE_PATH;?>" class="rounded" alt="" accept="image/*"></div>
<div class="media-body pd-l-10">
<div class="custom-file">
<input type="file" name="tc_image_" class="custom-file-input" onchange="showPreview('tc_image',this)" id="customFile" accept="image/*">
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
<span class="tx-11 tx-color-03">Accepted: gif, png, svg, jpg. Max file size 2Mb</span>
</div>
</div>
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
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Test/Exams Categories Listings</h6>
</div>
<div class="card-body">
<form method="post" action="{{route('bulkActionTestCat')}}" enctype="multipart/form-data">
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
<th style="text-align:center; width:50px">Image</th>
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