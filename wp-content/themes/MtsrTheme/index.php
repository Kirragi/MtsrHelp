<?php
define('CONFIG_ROOT', __DIR__);

require_once(CONFIG_ROOT.'/path11.php');
$oblPATH = new \Path11\Path12;
$test=$oblPATH->urlAddres;
wp_redirect("http://".$test."/login-user/") ;