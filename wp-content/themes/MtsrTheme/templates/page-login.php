<?php
/*
Template Name: login-user
*/
get_header();
wp_head();
$oblPATH = new \Path11\Path12;
$test=$oblPATH->urlAddres;
$logged=is_user_logged_in();
if($logged){
	wp_redirect("http://".$test."/application/") ;
}

?>

<body style="background-image:url('<?php echo get_template_directory_uri() ?>/assets/image/login_Image2.jpg') ;" >
<div class="login_main">
<div class="login_container">
        <div class='title_login'> <img draggable="false" class="image_title" src="<?php echo get_template_directory_uri() ?>/assets/image/man.png" alt=""> <H1 class="title_text">MTSR HELPER</H1></div>
        <div class="login-form">
			<?php echo do_shortcode('[ultimatemember form_id="11"]'); ?>
     </div>
</div>
</div>
</body>
<?php wp_footer() ?>
</html>