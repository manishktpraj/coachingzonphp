<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="Responsive Bootstrap 4 Dashboard Template">
<meta name="author" content="ThemePixels">
<link rel="shortcut icon" type="image/x-icon" href="<?php echo ADMIN_ASSETS_URL?>assets/img/favicon.png">
<title>CoachingZon</title>
<link href="<?php echo ADMIN_ASSETS_URL?>lib/fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
<link href="<?php echo ADMIN_ASSETS_URL?>lib/ionicons/css/ionicons.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo ADMIN_ASSETS_URL?>assets/css/dashforge.css">
<link rel="stylesheet" href="<?php echo ADMIN_ASSETS_URL?>assets/css/dashforge.auth.css">
</head>
<body>

<div class="content content-fixed content-auth">
<div class="container">
<div class="media align-items-stretch justify-content-center ht-100p pos-relative">
<div class="media-body align-items-center d-none d-lg-flex">
<div class="mx-wd-600">
<img src="<?php echo ADMIN_ASSETS_URL?>assets/img/img15.png" class="img-fluid" alt="">
</div>
</div>
<div class="sign-wrapper mg-lg-l-50 mg-xl-l-60">
<div class="wd-100p">
<form action="javascript:void(0);" id="login-form" method="post">
<input type="hidden" name="_token" id="token" value="<?php echo e(csrf_token()); ?>">
<h3 class="tx-color-01 mg-b-5">Sign In</h3>
<p class="tx-color-03 tx-16 mg-b-40">Welcome back! Please signin to continue.</p>
<span class="badge badge-success" style="display:none;height: 35px;padding: 12px;width: 100%;font-size: 13px;margin-bottom: 10px;" id="login-success">Login Successful! Redirecting...</span>
<span class="badge badge-danger" style="display:none;height: 35px;padding: 12px;width: 100%;font-size: 13px;margin-bottom: 10px;" id="login-error">Username and password are incorrect.</span>
<div class="form-group">
<label>Email address</label>
<input type="email" class="form-control" name="user_email" id="user_gmail" placeholder="yourname@yourmail.com" style="height:45px; padding:15px;">
</div>
<div class="form-group">
<div class="d-flex justify-content-between mg-b-5">
<label class="mg-b-0-f">Password</label>
<a href="" class="tx-13">Forgot password?</a>
</div>
<input type="password" class="form-control" id="user_password" name="user_password" placeholder="Enter your password" style="height:45px; padding:15px;">
</div>
<button class="btn btn-brand-02 btn-block" type="submit" onclick="return LoginAdminProcess($(this))" style="height:45px;"><span id="loadername">Sign In</span> <i class="fas fa-spinner fa-spin" id="spinner" style="display:none"></i></button>
</form>
</div>

</div>
</div>
</div>
</div>
<script>
    var base_url = '<?php echo ADMIN_URL?>';
</script>
<script src="<?php echo ADMIN_ASSETS_URL?>lib/jquery/jquery.min.js"></script>
<script src="<?php echo ADMIN_ASSETS_URL?>lib/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo ADMIN_ASSETS_URL?>lib/feather-icons/feather.min.js"></script>
<script src="<?php echo ADMIN_ASSETS_URL?>lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="<?php echo ADMIN_ASSETS_URL?>assets/js/dashforge.js"></script>
<script src="<?php echo ADMIN_ASSETS_URL?>lib/js-cookie/js.cookie.js"></script>
<script src="<?php echo ADMIN_ASSETS_URL?>assets/js/dashforge.settings.js"></script>
<script src="<?php echo ADMIN_ASSETS_URL?>assets/js/login.js"></script>
<script>
$(function(){
'use script'

window.darkMode = function(){
$('.btn-white').addClass('btn-dark').removeClass('btn-white');
}

window.lightMode = function() {
$('.btn-dark').addClass('btn-white').removeClass('btn-dark');
}

var hasMode = Cookies.get('df-mode');
if(hasMode === 'dark') {
darkMode();
} else {
lightMode();
}
})
</script>
</body>
</html>
<?php /**PATH D:\php\xamp\htdocs\coachingzon\resources\views/Csadmin/Auth/login.blade.php ENDPATH**/ ?>