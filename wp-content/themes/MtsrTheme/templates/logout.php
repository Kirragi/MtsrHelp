<?php
/*
Template Name: logout
*/
wp_logout(); 

$oblPATH = new \Path11\Path12;
$test=$oblPATH->urlAddres;
wp_redirect("http://".$test."/login-user/") ;
?>