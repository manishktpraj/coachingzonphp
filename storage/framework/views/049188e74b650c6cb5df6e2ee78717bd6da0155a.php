<?php $__env->startSection('content'); ?>
<div class="content-body">
<div class="container pd-x-0">
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
<div>
<nav aria-label="breadcrumb">
<ol class="breadcrumb breadcrumb-style1 mg-b-10">
<li class="breadcrumb-item"><a href="#">Questions</a></li>
<li class="breadcrumb-item active" aria-current="page">Add New Questions</li>
</ol>
</nav>
<h4 class="mg-b-0 tx-spacing--1">Add New Questions</h4>
</div>
</div>
<div class="row row-xs">
<div class="col-lg-12">
<div class="card mg-b-15">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Question Entry Options</h6>
</div>
<div class="card-body">
<div class="row row-xs">
<div class="col-lg-4">
<div class="form-group mg-b-0">
<label>Subject:</label>
<select class="custom-select" name="category_parent" id="selected_sub">
<option value="">Select Subject</option>
<?php foreach($resSubData as $subject){ ?>
<option value="<?php echo $subject->sc_id?>"><?php echo $subject->sc_name?></option>
<?php } ?>
</select>
</div>
</div>
<div class="col-lg-4">
<div class="form-group mg-b-0">
<label>Question Type:</label>
<select class="custom-select multiple" name="category_parent">
<option value="0">Select Question Type</option>
<option value="1">Multiple Choice</option>
<option value="2">True & False</option>
<option value="3">Multiple Response</option>
</select>
</div>
</div>
<div class="col-lg-4">
<div class="form-group mg-b-0">
<label>Language:</label>
<select class="custom-select" name="category_parent">
<option value="">Select Language</option>
<option value="0">Hindi</option>
<option value="1">English</option>

</select>
</div>
</div>
</div>

</div>
</div>
<div class="card">
<div class="card-header d-flex align-items-center justify-content-between">
<h6 class="mg-b-0" style="font-size: 1rem;font-weight: 600;">Question Details</h6>
</div>
<div class="card-body">
<h6 class="text-center sel" >Select category and question type.</h6>
<div class="form-group category_show">
<label>Type Your Question:</label>
<textarea  type="text" class="ckeditor" name="question"   value=""></textarea>
</div>
<div class="form-group mg-b-0 category_show ">
<label style="width:100%">
Correct Answer & Question Options:
<div class="check-box-editior">Ʃ Text Editor <input type="checkbox" id="text_editor" onclick="seteditor($(this))"></div>
</label>
<div class="mc-question-box">
<div class="mcq-q">
<div class="mcq-q-n">A</div>
<div class="radio-box"><input name="tla_correct_option[]" required="required" value="0" type="radio"></div>
</div>
<div class="mcq-a">
<textarea class="form-control" name="tla_options_text[]" required="required" style="display: block;"> </textarea>
</div>
</div>
<div class="mc-question-box">
<div class="mcq-q">
<div class="mcq-q-n">B</div>
<div class="radio-box"><input name="tla_correct_option[]" required="required" value="0" type="radio"></div>
</div>
<div class="mcq-a">
<textarea class="form-control" name="tla_options_text[]" required="required" style="display: block;"> </textarea>
</div>
<a href="javascript:void(0);" class="mcq-d text-danger-600 remove_field" onclick="removecode($(this))" style="display: flex;border: 1px solid #c0ccda; align-items: center;justify-content: center;margin-left: 5px;color: #e53935;border-radius: 0.25rem; width:50px"><i class="fas fa-trash-alt" style="font-size:18px;"></i></a>
</div>
<button type="submit" class="btn btn-lg btn-info" style="float: right;"><i data-feather="plus" class="wd-10 mg-r-5"></i> Add New Options </button>
</div>


</div>
<div class="card-footer category_show" style="padding: 0.75rem 1rem;">
<button type="submit" class="btn btn-lg btn-success">Save</button>
<button type="submit" class="btn btn-lg btn-light">Cancel</button>
</div>
</div>
</div>
</div>
</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

$(document).ready(function(){
    $('.category_show').hide();
    $('.multiple').on('change', function() {
     var selected = $('#selected_sub').find(":selected").val();
  if(selected!=''){
      if ( this.value == 1)
      {
        $('.sel').hide();
        $(".category_show").show();
      }
      else
      {
     $('.sel').show();

    $('.category_show').hide();
      }
  }else{
      alert("Please Select Subject First")
  }
    });
});
</script>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('Csadmin.Layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\php\xamp\htdocs\coachingzon\resources\views/Csadmin/Question/addNewQuestion.blade.php ENDPATH**/ ?>