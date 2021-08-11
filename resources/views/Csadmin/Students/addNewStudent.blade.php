@extends('Csadmin.Layout.app')
@section ('content')
<div class="content-body">
<div class="container pd-x-0">
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
<div>
<nav aria-label="breadcrumb">
<ol class="breadcrumb breadcrumb-style1 mg-b-10">
<li class="breadcrumb-item"><a href="#">Students</a></li>
<li class="breadcrumb-item active" aria-current="page">Add New Students</li>
</ol>
</nav>
<h4 class="mg-b-0 tx-spacing--1">Add New Student</h4>
</div>
</div>
<form method="post" action="{{route('studentProccess')}}" enctype="multipart/form-data">
@csrf
<input type="hidden" name="student_id" value="<?php echo isset($resStudentData->student_id)?$resStudentData->student_id:''?>">
<input type="hidden" name="student_ins_id" value="<?php echo isset($ins_id)?$ins_id:''?>">


<div class="row row-xs">
<div class="col-lg-12">
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Student Details</h6>
</div>
<div class="card-body">
<div class="form-group mg-b-10">
<div class="row row-xs">
    
<div class="col-lg-12">
<div class="form-group" style="margin-bottom:15px">
<label>Student Group:</label>
<select class="custom-select" name="studentg_name" required="">
<option value="">Select Student Group</option>
<?php foreach($resStudentgroupData as $group){ ?>
<option value="<?php echo $group->sg_name;?>" <?php echo (isset($resStudentData->studentg_name) && ($resStudentData->studentg_name ==$group->sg_name))?'selected':''?>><?php echo $group->sg_name;?></option>
<?php } ?>
</select>
</div>
</div> 
 
<div class="col-lg-6">
<div class="form-group" style="margin-bottom:15px">
<label>First Name:</label>
<input type="text" class="form-control" required name="student_first_name" value="<?php echo isset($resStudentData->student_first_name)?$resStudentData->student_first_name:''?>">
</div>
</div>
<div class="col-lg-6">
<div class="form-group" style="margin-bottom:15px">
<label>Last Name:</label>
<input type="text" class="form-control" required name="student_last_name" value="<?php echo isset($resStudentData->student_last_name)?$resStudentData->student_last_name:''?>">
</div>
</div>
<div class="col-lg-6">
<div class="form-group" style="margin-bottom:15px">
<label>Date of Birth:</label>
<input type="date" class="form-control" required name="student_dob" value="<?php echo isset($resStudentData->student_dob)?$resStudentData->student_dob:''?>">
</div>
</div>
<div class="col-lg-6">
<div class="form-group" style="margin-bottom:15px">
<label>Gender:</label>
<select class="custom-select" name="student_gender" required="">
<option value="male">Male</option>
<option value="female">Female</option>
<option value="other">Other</option>
</select>
</div>
</div>
<div class="col-lg-6">
<div class="form-group" style="margin-bottom:15px">
<label>Email Id:</label>
<input type="text" class="form-control" required name="student_email" value="<?php echo isset($resStudentData->student_email)?$resStudentData->student_email:''?>">
</div>
</div>
<div class="col-lg-6">
<div class="form-group" style="margin-bottom:15px">
<label>Mobile:</label>
<input type="text" class="form-control" required name="student_phone" value="<?php echo isset($resStudentData->student_phone)?$resStudentData->student_phone:''?>">
</div>
</div>
<div class="col-lg-6">
<div class="form-group" style="margin-bottom:15px">
<label>New Password:</label>
<input type="password" class="form-control" name="student_new_password" id="txtPassword" value="">
</div>
</div>
<div class="col-lg-6">
<div class="form-group" style="margin-bottom:15px">
<label>Confirm Password:</label>
<input type="password" class="form-control" name="student_confirm_password" id="txtConfirmPassword" value="">
</div>
</div>
</div>

</div>
</div>
<div class="card-footer" style="padding: 0.75rem 1rem;">
<button type="submit" class="btn btn-success">Save</button>
</div>
</div>
</div>



</div>
</form>




</div>
</div>
</div>

@endsection