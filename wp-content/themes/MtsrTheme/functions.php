<?php 
add_action('wp_enqueue_scripts','MtsrHelp_scripts');

function MtsrHelp_scripts(){
    wp_enqueue_style('main',get_stylesheet_uri());
    wp_enqueue_style('MtsrHelp',get_template_directory_uri().'/styles/login.css');
    wp_enqueue_style('header',get_template_directory_uri().'/styles/header.css');
    wp_enqueue_style('normalize',get_template_directory_uri().'/styles/normalize.css');
    wp_enqueue_style('application',get_template_directory_uri().'/styles/application.css');
    wp_enqueue_style('createpost',get_template_directory_uri().'/styles/createPost.css');
    wp_enqueue_style('post',get_template_directory_uri().'/styles/post.css');
    wp_enqueue_script('jquery');
}
add_action( 'wp_footer','scripts');
function scripts(){
    wp_enqueue_script( 'MtsrHelp', get_stylesheet_directory_uri() . '/jquery/edit-button-file.js', null, true );
}