<?php //print_r($resuserData);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="shortcut icon" type="image/x-icon" href="<?php echo (isset($resthemeData->theme_favicon) && $resthemeData->theme_favicon!="")?SITE_UPLOAD_URL.SITE_THEME_IMAGE.$resthemeData->theme_favicon:SITE_NO_IMAGE_PATH;?>">
<title><?php echo $title;?></title>
<link href="<?php echo ADMIN_ASSETS_URL?>lib/fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
<link href="<?php echo ADMIN_ASSETS_URL?>lib/ionicons/css/ionicons.min.css" rel="stylesheet">
<link href="<?php echo ADMIN_ASSETS_URL?>lib/jqvmap/jqvmap.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo ADMIN_ASSETS_URL?>assets/css/dashforge.css">
<link rel="stylesheet" href="<?php echo ADMIN_ASSETS_URL?>assets/css/dashforge.filemgr.css">
<link rel="stylesheet" href="<?php echo ADMIN_ASSETS_URL?>assets/css/dashforge.dashboard.css">
<link rel="stylesheet" href="<?php echo ADMIN_ASSETS_URL?>assets/css/skin.light.css">
</head>
<body>
<aside class="aside aside-fixed">
<div class="aside-header">
<a href="<?php ADMIN_URL; ?>dashboard" class="aside-logo"><?php echo $resthemeData->theme_store_name;?></a>
<a href="" class="aside-menu-link">
<i data-feather="menu"></i>
<i data-feather="x"></i>
</a>
</div>
<div class="aside-body">
<div class="aside-loggedin">
<div class="d-flex align-items-center justify-content-start">
<a href="" class="avatar"><img src="<?php echo (isset($resthemeData->theme_logo) && $resthemeData->theme_logo!="")?SITE_UPLOAD_URL.SITE_THEME_IMAGE.$resthemeData->theme_logo:SITE_NO_IMAGE_PATH;?>" class="rounded-circle" alt=""></a>
<div class="aside-alert-link">
<a href="" class="new" data-toggle="tooltip" title="You have 2 unread messages"><i data-feather="message-square"></i></a>
<a href="{{route('notification')}}" class="new" data-toggle="tooltip" title="You have 4 new notifications"><i data-feather="bell"></i></a>
<a href="{{route('adminLogout')}}" onclick="return confirm('Are you sure you want to logout?')" data-toggle="tooltip" title="Sign out"><i data-feather="log-out"></i></a>
</div>
</div>
<div class="aside-loggedin-user">
<a href="#loggedinMenu" class="d-flex align-items-center justify-content-between mg-b-2" data-toggle="collapse">
<h6 class="tx-semibold mg-b-0"><?php echo $resuserData->staff_name;?></h6>
<i data-feather="chevron-down"></i>
</a>
<p class="tx-color-03 tx-12 mg-b-0">Administrator</p>
</div>
<div class="collapse" id="loggedinMenu">
<ul class="nav nav-aside mg-b-0">
<li class="nav-item"><a href="{{route('account-setting')}}" class="nav-link"><i data-feather="settings"></i> <span>Account Settings</span></a></li>
<li class="nav-item"><a href="" class="nav-link"><i data-feather="help-circle"></i> <span>Help Center</span></a></li>
<li class="nav-item"><a href="{{route('adminLogout')}}" onclick="return confirm('Are you sure you want to logout?')" class="nav-link"><i data-feather="log-out"></i> <span>Sign Out</span></a></li>
</ul>
</div>
</div><!-- aside-loggedin -->
<ul class="nav nav-aside">
    
<li class="nav-item <?php echo (isset($title) && $title == 'Dashboard')?'active':''; ?>"><a href="https://neonclasses.co.in/portal/csadmin/dashboard" class="nav-link"><i data-feather="airplay"></i> <span>Dashboard</span></a></li>

<li class="nav-item with-sub <?php echo (isset($title) && $title == 'Question' || $title == 'Add New Question' || $title == 'Question Subjects')?'active show':''; ?>">
<a href="" class="nav-link"><i data-feather="help-circle"></i> <span>Question Bank</span></a>
<ul>
<li class="<?php echo (isset($title) && $title == 'Question')?'active':''; ?>"><a href="{{route('all-question')}}">All Question</a></li>
<li class="<?php echo (isset($title) && $title == 'Add New Question')?'active':''; ?>"><a href="{{route('add-new-question')}}">Add New Question</a></li>
<li class="<?php echo (isset($title) && $title == 'Question Subjects')?'active':''; ?>"><a href="{{route('question-subjects')}}">Subjects</a></li>
</ul>
</li>

<li class="nav-item with-sub <?php echo (isset($title) && $title == 'Tests' || $title == 'Add New Test' || $title == 'Test Category')?'active show':''; ?>">
<a href="" class="nav-link"><i data-feather="file-text"></i> <span>Tests/Exams</span></a>
<ul>
<li class="<?php echo (isset($title) && $title == 'Tests')?'active':''; ?>"><a href="{{route('tests')}}">All Tests/Exams</a></li>
<li class="<?php echo (isset($title) && $title == 'Add New Test')?'active':''; ?>"><a href="{{route('addnewtest')}}">Add New Tests</a></li>
<li class="<?php echo (isset($title) && $title == 'Test Category')?'active':''; ?>"><a href="{{route('test-category')}}">Categories</a></li>
</ul>
</li>

<li class="nav-item with-sub <?php echo (isset($title) && $title == 'Videos' || $title == 'Add New Video' || $title == 'Video Category')?'active show':''; ?>">
<a href="" class="nav-link"><i data-feather="video"></i> <span>Live Classes & Videos</span></a>
<ul>
<li class="<?php echo (isset($title) && $title == 'Videos')?'active':''; ?>"><a href="{{route('all-videos')}}">All Videos</a></li>
<li class="<?php echo (isset($title) && $title == 'Add New Video')?'active':''; ?>"><a href="{{route('add-new-video')}}">Add New Videos</a></li>
<li class="<?php echo (isset($title) && $title == 'Video Category')?'active':''; ?>"><a href="{{route('video-category')}}">Categories</a></li>
</ul>
</li>

<li class="nav-item with-sub <?php echo (isset($title) && $title == 'Study' || $title == 'Add New Study' || $title == 'Study Category')?'active show':''; ?>">
<a href="" class="nav-link"><i data-feather="clipboard"></i> <span>Study Materials</span></a>
<ul>
<li class="<?php echo (isset($title) && $title == 'Study')?'active':''; ?>"><a href="{{route('all-study-material')}}">All Study Materials</a></li>
<li class="<?php echo (isset($title) && $title == 'Add New Study')?'active':''; ?>"><a href="{{route('add-new-study')}}">Add New Study Materials</a></li>
<li class="<?php echo (isset($title) && $title == 'Study Category')?'active':''; ?>"><a href="{{route('study-category')}}">Categories</a></li>
</ul>
</li>

<li class="nav-item with-sub <?php echo (isset($title) && $title == 'Students' || $title == 'Add New Student' || $title == 'Student Group')?'active show':''; ?>">
<a href="" class="nav-link"><i data-feather="users"></i> <span>Students</span></a>
<ul>
<li class="<?php echo (isset($title) && $title == 'Students')?'active':''; ?>"><a href="{{route('all-students')}}" >All Students</a></li>
<li class="<?php echo (isset($title) && $title == 'Add New Student')?'active':''; ?>"><a href="{{route('add-new-student')}}" >Add New Student</a></li>
<li  class="<?php echo (isset($title) && $title == 'Student Group')?'active':''; ?>"><a href="{{route('student-group')}}">Student Groups</a></li>
</ul>
</li>

<li class="nav-item with-sub <?php echo (isset($title) && $title == 'Packages' || $title == 'Add New Package' || $title == 'Package Category')?'active show':''; ?>">
<a href="packages.html" class="nav-link"><i data-feather="shopping-bag"></i> <span>Packages</span></a>
<ul>
<li class="<?php echo (isset($title) && $title == 'Packages')?'active':''; ?>"><a href="{{route('all-packages')}}" >All Packages</a></li>
<li class="<?php echo (isset($title) && $title == 'Add New Package')?'active':''; ?>"><a href="{{route('add-new-package')}}" >Add New Packages</a></li>
<li  class="<?php echo (isset($title) && $title == 'Package Category')?'active':''; ?>"><a href="{{route('package-category')}}">Categories</a></li>

</ul>
</li>




<!--<li class="nav-item <?php echo (isset($title) && $title == 'Offers')?'active':''; ?>"><a href="{{route('offers-promos')}}" class="nav-link"><i data-feather="gift"></i> <span>Offers & Promos</span></a></li>-->

<li class="nav-item <?php echo (isset($title) && $title == 'Orders')?'active':''; ?>"><a href="{{route('order')}}" class="nav-link"><i data-feather="shopping-cart"></i> <span>Orders</span></a></li>






<li class="nav-item with-sub <?php echo (isset($title) && $title == 'Faculty' || $title == 'Add New Faculty')?'active show':''; ?>">
<a href="#" class="nav-link"><i data-feather="user"></i> <span>Faculties</span></a>
<ul>
<li class="<?php echo (isset($title) && $title == 'Faculty')?'active':''; ?>"><a href="{{route('faculty')}}" >Manage Faculties</a></li>
<li class="<?php echo (isset($title) && $title == 'Add New Faculty')?'active':''; ?>"><a href="{{route('add-new-faculty')}}" >Add New Faculty</a></li>


</ul>
</li>

<li class="nav-item with-sub <?php echo (isset($title) && $title == 'Offers' || $title == 'Add New Offer')?'active show':''; ?>">
<a href="#" class="nav-link"><i data-feather="gift"></i> <span>Offers & Promos</span></a>
<ul>
<li class="<?php echo (isset($title) && $title == 'Offers')?'active':''; ?>"><a href="{{route('offers-promos')}}" >All Offers</a></li>
<li class="<?php echo (isset($title) && $title == 'Add New Offer')?'active':''; ?>"><a href="{{route('add-new-offers')}}" >Add New Offer</a></li>


</ul>
</li>


<li class="nav-item <?php echo (isset($title) && $title == 'Transaction')?'active':''; ?>"><a href="{{route('transaction')}}" class="nav-link"><i data-feather="dollar-sign"></i> <span>Transaction</span></a></li>

<li class="nav-item <?php echo (isset($title) && $title == 'Reports')?'active':''; ?>"><a href="{{route('reports')}}" class="nav-link"><i data-feather="box"></i> <span>Reports</span></a></li>

<li class="nav-item with-sub <?php echo (isset($title) && $title == 'Settings' || $title == 'Account Setting')?'active show':''; ?>">
<a href="" class="nav-link"><i data-feather="settings"></i> <span>Settings</span></a>
<ul>
<li class="<?php echo (isset($title) && $title == 'Settings')?'active':''; ?>"><a href="{{route('store-setting')}}">Store Setting</a></li>
<li class="<?php echo (isset($title) && $title == 'Account Setting')?'active':''; ?>"><a href="{{route('account-setting')}}">Account Setting</a></li>
</ul>
</li>

</ul>
</div>
</aside>

<div class="content ht-100v pd-0">
<div class="content-header">
<nav class="nav">
<a href="#" class="btn btn-sm pd-x-15 btn-white  mg-r-5" style="padding:4px 10px 2px">Visit Site</a>
</nav>
<nav class="nav">
<div class="aside-alert-link">
<a href="#" class="btn btn-sm pd-x-15 btn-white  mg-r-5" style="padding:4px 10px 2px"><i data-feather="message-square"></i> Chat</a>

<!--<a href="" class="new" data-toggle="tooltip" title="You have 2 unread messages"><i data-feather="message-square"></i></a>
<a href="" class="new" data-toggle="tooltip" title="You have 4 new notifications"><i data-feather="bell"></i></a>
<a href="{{route('adminLogout')}}" onclick="return confirm('Are you sure you want to logout?') "data-toggle="tooltip" title="Sign out"><i data-feather="log-out"></i></a>-->
</div>
</nav>


</div><!-- content-header -->
@yield('content')
</div>
<script src="https://cdn.ckeditor.com/4.12.1/full-all/ckeditor.js"></script>
<script src="<?php echo ADMIN_ASSETS_URL?>lib/jquery/jquery.min.js"></script>
<script src="<?php echo ADMIN_ASSETS_URL?>lib/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo ADMIN_ASSETS_URL?>lib/feather-icons/feather.min.js"></script>
<script src="<?php echo ADMIN_ASSETS_URL?>lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="<?php echo ADMIN_ASSETS_URL?>lib/jquery.flot/jquery.flot.js"></script>
<script src="<?php echo ADMIN_ASSETS_URL?>lib/jquery.flot/jquery.flot.stack.js"></script>
<script src="<?php echo ADMIN_ASSETS_URL?>lib/jquery.flot/jquery.flot.resize.js"></script>
<script src="<?php echo ADMIN_ASSETS_URL?>lib/chart.js/Chart.bundle.min.js"></script>
<script src="<?php echo ADMIN_ASSETS_URL?>lib/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo ADMIN_ASSETS_URL?>lib/jqvmap/maps/jquery.vmap.usa.js"></script>

<script src="<?php echo ADMIN_ASSETS_URL?>assets/js/dashforge.js"></script>
<script src="<?php echo ADMIN_ASSETS_URL?>assets/js/dashforge.aside.js"></script>
<script src="<?php echo ADMIN_ASSETS_URL?>assets/js/dashforge.sampledata.js"></script>
<script src="<?php echo ADMIN_ASSETS_URL?>assets/js/dashboard-one.js"></script>

<!-- append theme customizer -->
<script src="<?php echo ADMIN_ASSETS_URL?>lib/js-cookie/js.cookie.js"></script>
<script src="<?php echo ADMIN_ASSETS_URL?>assets/js/dashforge.settings.js"></script>
<script src="<?php echo ADMIN_ASSETS_URL?>assets/js/admin.js"></script>

</body>
</html>
