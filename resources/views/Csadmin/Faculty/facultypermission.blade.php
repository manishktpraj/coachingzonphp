@extends('Csadmin.Layout.app')
@section ('content')
<div class="content-body">
<div class="container pd-x-0">
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
<div>
<nav aria-label="breadcrumb">
<ol class="breadcrumb breadcrumb-style1 mg-b-10">
<li class="breadcrumb-item"><a href="#">Faculty</a></li>
<li class="breadcrumb-item active" aria-current="page">Manage Permission</li>
</ol>
</nav>
<h4 class="mg-b-0 tx-spacing--1">Manage Permission</h4>
</div>
</div>
<div class="row row-xs">
<div class="col-lg-12">
<div class="card">
<form method="post" action="{{route('permissionProccess')}}" enctype="multipart/form-data">
@csrf
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Manage Permission For Uploader</h6>
<div class="d-flex tx-18">
<button type="submit" name="submit" class="btn btn-success"> Save</button>
</div>
</div>
<input type="hidden" value="<?php echo $intCategoryId; ?>" name="rp_role_id" >
<!-- <input type="hidden" value="<?php echo $intCategoryId; ?>" name="pr_role_id" > -->

<div class="table-responsive">
<table class="table mg-b-0">
<thead>
<tr>
     <th>Permission Name</th>
     <th><input type="checkbox" id="selectAll">Entry </th>
     <th><input type="checkbox" id="selectAll1">Delete</th>
     <th><input type="checkbox" id="selectAll2">View</th>
</tr>
</thead>
<tbody>
  <?php  foreach($permissionData as $permission){
         $rowPermissionChecked = $rowPermission->where('rp_permission_id', $permission->permission_id)->first(); 
     ?>
<tr>
	  <td><?php echo $permission->permission_name;?></td>
	  <td><input type="checkbox" <?php if(isset($rowPermissionChecked->rp_entry_status) && $rowPermissionChecked->rp_entry_status==1) { echo 'checked'; } ?> name="permission[<?php echo $permission->permission_id; ?>][]" value="1" id="selectAll" class="clsSelectSingle" ></td>
      <td><input type="checkbox" <?php if(isset($rowPermissionChecked->rp_delete_status) && $rowPermissionChecked->rp_delete_status==1) { echo 'checked'; } ?> name="permission[<?php echo $permission->permission_id; ?>][]" value="2" id="selectAll1" class="clsSelectSingle1" ></td>
      <td><input type="checkbox" <?php if(isset($rowPermissionChecked->rp_view_status) && $rowPermissionChecked->rp_view_status==1) { echo 'checked'; } ?> name="permission[<?php echo $permission->permission_id; ?>][]" value="3" id="selectAll2" class="clsSelectSingle2" ></td>
    </tr>
<?php  } ?>
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