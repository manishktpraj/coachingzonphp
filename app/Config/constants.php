<?php
if (!defined('DS')) {
   define('DS', DIRECTORY_SEPARATOR);
}
define('ROOT', dirname(__DIR__));
$strPath ='';
  ////$_SERVER['HTTP_HOST'];
if(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST']=='localhost' || isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST']=='192.168.1.38')
{
   $strPath ='coachingzon/';
}else{
   $strPath ='portal/';
}
define('SITE_ABS_PATH',$strPath);
  define('SITE_PATH',$_SERVER['DOCUMENT_ROOT'].'/'.SITE_ABS_PATH);
define('SITE_URL',((isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=='on'))?'https://':'http://').(isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:'').'/'.SITE_ABS_PATH);
 define('ADMIN_URL',SITE_URL.'csadmin/');
//echo SITE_PATH;die;
define('ADMIN_ASSETS_URL',SITE_URL.'public/admin-assets/');
define('SITE_UPLOAD_URL',SITE_URL.'public/img/uploads/');
define('SITE_UPLOAD_PATH',SITE_PATH.'public/img/uploads/');
define('SITE_STUDY_MATERIAL_IMAGE','study_material_images/');
define('SITE_VIDEO_IMAGE','video_images/');
define('SITE_NO_IMAGE_PATH',SITE_URL.'public/img/500.png');
define('SITE_PACKAGE_IMAGE','package_images/');
define('SITE_TEST_IMAGE','test_images/');
define('SITE_THEME_IMAGE','theme_images/');
define('SITE_FACULTY_IMAGE','faculty_images/');
//define('CHAT_URL',SITE_URL.'portal/chat/');
define('CHAT_URL',SITE_URL.'chat/');