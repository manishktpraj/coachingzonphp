
<?php $__env->startSection('content'); ?>
<div class="content-body">
<div class="container pd-x-0">
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
<div>
<nav aria-label="breadcrumb">
<ol class="breadcrumb breadcrumb-style1 mg-b-10">
<li class="breadcrumb-item"><a href="#">Live Classes & Videos</a></li>
<li class="breadcrumb-item active" aria-current="page">Categories</li>
</ol>
</nav>
<h4 class="mg-b-0 tx-spacing--1">Manage Video Categories</h4>
</div>
<div class="d-none d-md-block"></div>
</div>
<div class="row row-xs">
<div class="col-lg-4">
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Add New Video Category</h6>
</div>
<form method="post" action="<?php echo e(route('videoCategoryProccess')); ?>" enctype="multipart/form-data">
<?php echo csrf_field(); ?>
<input type="hidden" name="vc_id" value="<?php echo isset($rowCategoryData->vc_id)?$rowCategoryData->vc_id:'0'?>">
<div class="card-body">
<div class="form-group">
<label>Category Name / Title: <span style="color:red">*</span></label>
<input type="text" class="form-control" name="vc_name" required="" value="<?php echo isset($rowCategoryData->vc_name)?$rowCategoryData->vc_name:''?>">
<span class="tx-color-03" style="font-size: 11px;">This name is appears on your site</span>
</div>
<div class="form-group">
<label>Parent Category:</label>
<select class="custom-select" name="vc_parent">
<option value="0">Select Parent Category</option>
<?php echo $strEntryHtml;?>
<!--<?php foreach($resCategoryData as $value){?>-->
<!--<option <?php echo (isset($rowCategoryData->vc_parent) && $rowCategoryData->vc_parent==$value->vc_id)?'selected="selected"':''?> value="<?php echo $value->vc_id?>"><?php echo $value->vc_name;?></option>-->
<!--<?php }?>-->
</select>
<span class="tx-color-03" style="font-size: 11px;line-height: 20px;">Assign a parent term to create a hierarchy. The term Jazz, for example, would be the parent of Bebop and Big Band.</span>
</div>
<div class="form-group">
<label>Order:</label>
<input type="text" class="form-control" name="vc_order" value="<?php echo isset($rowCategoryData->vc_order)?$rowCategoryData->vc_order:''?>">
</div>
<div class="form-group">
<label>Image:</label>
<div class="media align-items-center">
<div class="avatar" style="height:60px; width:60px
"><img id="vc_image" src="<?php echo (isset($rowCategoryData->vc_image) && $rowCategoryData->vc_image!="")?SITE_UPLOAD_URL.SITE_VIDEO_IMAGE.$rowCategoryData->vc_image:SITE_NO_IMAGE_PATH;?>" class="rounded" alt=""></div>
<div class="media-body pd-l-10">
<div class="custom-file">
<input type="file" name="vc_image_" class="custom-file-input" onchange="showPreview('vc_image',this)" id="customFile">
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
<span class="tx-11 tx-color-03">Accepted: gif, png, jpg. Max file size 2Mb</span>
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
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Video Categories Listings</h6>
</div>
<div class="card-body">
<?php echo $__env->make('Csadmin.bulkaction', ['status' => 'FILTER_VIDEO_CATEGORY'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Csadmin.Layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\php\xamp\htdocs\coachingzon\resources\views/Csadmin/Videos/videoCategory.blade.php ENDPATH**/ ?>