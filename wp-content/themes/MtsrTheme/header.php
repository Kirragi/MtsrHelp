<?php 
define('CONFIG_ROOT', __DIR__);
define('UPPER_DIR', dirname(CONFIG_ROOT));
require_once(CONFIG_ROOT.'/path11.php');
$oblPATH = new \Path11\Path12;
$test=$oblPATH->urlAddres;
if(isset($_GET['logout'])) {
    function logout(){
        wp_redirect('http://'.$test.'/logout/');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<header>
    <?php if(is_user_logged_in()){?>
    <div class="header_container">
        <div class="header_logo">
        <img draggable="false" src="<?php echo get_template_directory_uri() ?>/assets/image/man.png" class='header_img' alt="">
            <p draggable="false" class='header_text'>MTSR HELPER</p>
        </div>
        <div class="header_menu"> 
            <p draggable="false" class="header_name">
            <?php 
                $user = wp_get_current_user();
                echo $user->display_name;
                ?>
            </p>
            <img draggable="false" class="header_user_img" src="<?php echo get_template_directory_uri() ?>/assets/image/user.png" alt="">
            <form class="header-logout-form"action="logout" method="get">
                  <input class="header_logout_button" type="submit" name="logout" value="" style="background-image:url('<?php echo get_template_directory_uri() ?>/assets/image/exit.png') ;"> 
            </form>
        </div>
    </div>
    <?php } ?>
</header>
<body/>