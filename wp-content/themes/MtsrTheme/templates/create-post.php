<?php
/*
Template Name: CreatePost
*/
get_header();
wp_head();
$oblPATH = new \Path11\Path12;
$test=$oblPATH->urlAddres;
$logged=is_user_logged_in();
if(!$logged){
	wp_redirect("http://".$test."/login-user/") ;
}
?>
<body>
	<div class="create_post">
	<a class="a_null a_back" href="http://<?php echo ($test);?>/application"><div class="img_back_container"><img class="img_back" src="<?php echo get_template_directory_uri() ?>/assets/image/back.png" alt=""></div></a>
		<div class="form_add_post">
		<div class="header_create_post">
			<p>СОЗДАНИЕ ЗАЯВКИ</p>
		</div>
			<?php echo do_shortcode('[user-submitted-posts ]');?>
		</div>
	</div>
</body>


<?php wp_footer() ?>