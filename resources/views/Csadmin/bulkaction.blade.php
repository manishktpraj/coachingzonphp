<div class="row">

<div class="col-lg-6">
<form method="post" action="" enctype="multipart/form-data">
@csrf
<div class="d-sm-flex justify-content-start mg-b-0">
<div class="form-group mg-b-0">
    <input  type="hidden" id="bulkvalue" name="bulkvalue" value="">
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
</form>
</div>


<div class="col-lg-6">
<form method="post" action="" enctype="multipart/form-data">
@csrf
<div class="d-sm-flex justify-content-end mg-b-0">
<div class="form-group mg-b-0">
<input type="text" class="form-control wd-150" placeholder="" name="filter_keyword" value="{{ Session::get($status) }}">
</div>
<div class="mg-sm-l-10">
    <button type="submit" class="btn btn-primary "><i class="fas fa-search"></i></button>
    <?php   
    if(session()->has($status)){
    ?>
    <a href="?reset=1" class="btn btn-danger "><i class="icon ion-md-refresh"></i></a>
    <?php } ?>

</div>
</div>
</form>
</div>


</div>