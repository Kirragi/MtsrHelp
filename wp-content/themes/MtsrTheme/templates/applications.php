<?php
/*
Template Name: application
*/

get_header();
wp_head();
$oblPATH = new \Path11\Path12;
$test=$oblPATH->urlAddres;
$role_user = wp_get_current_user()->roles[0];
$count_posts = wp_count_posts();
$published_posts = $count_posts->publish;
$user = wp_get_current_user()->display_name;
$userEmail= wp_get_current_user()->user_email;
$myIsp ='http://'.$test.'/application/?Filtr=user,'.$user;
$url ='http://'.$test.$_SERVER['REQUEST_URI'];
$filtr = explode("=", $url);
$noUrl=explode("?", $url);
$noUrl=stristr($noUrl[1], '=', true);
$filtr = urldecode($filtr[1]);
$paramFiltr = explode(",", $filtr);
$isAdmin= false;

$currentRoles= array();
for($i=1;$i<count(wp_get_current_user()->roles);$i++){
    array_push( $currentRoles,wp_roles()->roles[wp_get_current_user()->roles[$i]]['name']);
}


if($role_user=='editor'||$role_user=='administrator'){
    $isAdmin= true;
}
if($noUrl=='usp_redirect'){
    if($isAdmin){
        wp_redirect('http://'.$test.'/application/?Filtr=post,all');
    }else{
        wp_redirect('http://'.$test.'/application/?Filtr=user,'.$user);
    }
}
if($filtr==''){
    if($isAdmin){
        wp_redirect('http://'.$test.'/application/?Filtr=post,all');
    }else{
        wp_redirect('http://'.$test.'/application/?Filtr=user,'.$user);
    }

}
$args = array();
$filtrArr = array();
if(isset($_GET['createpost'])) {
    function createpost(){
        wp_redirect('http://'.$test.'/createpost/');
    }
}
if(isset($_POST['selectStat'])) {
    wp_redirect('http://'.$test.'/application/?Filtr=status,'.$_POST['selectStat']) ;
}

if(isset($_POST['selectCategory'])) {
    wp_redirect('http://'.$test.'/application/?Filtr=category,'.$_POST['selectCategory']) ;
}

if(isset($_POST['selectUserPosts'])) {
    wp_redirect('http://'.$test.'/application/?Filtr=user,'.$_POST['selectUserPosts']) ;
}

if(isset($_POST['selectID'])) {
    wp_redirect('http://'.$test.'/application/?Filtr=id,'.$_POST['selectID']) ;
}

$logged=is_user_logged_in();
if(!$logged){
	wp_redirect("http://".$test."/login-user/") ;
}
$args = array(
    'posts_per_page' => $published_posts,
);
?>
<div class="application">
  <div class="application_constainer">

  <div class="application_box_description">
       
       <div class="application_id description"> <span class="application_text">ID</span></div>
       <div class="application_title description"> <span class="application_text">Тема</span></div>
       <div class="application_category description"> <span class="application_text">Раздел</span></div> 
       <div class="application_author description"> <span class="application_text">Автор</span></div>
       <div class="application_date description"> <span class="application_text">Дата</span></div>    
       <div class="application_time description"> <span class="application_text">Время</span></div>      
       <div class="application_status description"><span class="application_text">статус</span></div>     
       </div>    
<?php
$firstQuery = new WP_Query($args);
if ( $firstQuery->have_posts() ) {
    while($firstQuery->have_posts()){
        $firstQuery->the_post();
        $FiltrName=get_author_name();
        $FiltrId=get_the_ID();
        $FiltrIsp=get_post_custom_values( "usp_custom_field_3", $FiltrId);
        $FiltrStatus=get_post_custom_values( "usp_custom_field", $FiltrId);
        $FiltrCategories = get_the_category( $FiltrId);
            if($paramFiltr[0]=='user'&& $FiltrName==$paramFiltr[1]) 
            {
             array_push( $filtrArr,get_post($FiltrId));
             continue;
            }
            if($paramFiltr[0]=="post"&& $paramFiltr[1]=='all')
            {
                for($i=0; $i<count($currentRoles); $i++){
                    if($currentRoles[$i]==$FiltrCategories[0]->name){
                        array_push( $filtrArr,get_post($FiltrId));
                    }
                }
             continue;
            }
            if($paramFiltr[0]=="id"&& $paramFiltr[1]==$FiltrId)
            {
             array_push( $filtrArr,get_post($FiltrId));
             continue;
            }
            if($paramFiltr[0]=='isp'&& $paramFiltr[1]==$FiltrIsp[0])
            {
             array_push( $filtrArr,get_post($FiltrId));
             continue;
            }
            if($role_user=='editor'||$role_user=='administrator'){
            if($paramFiltr[0]=='status'&& $paramFiltr[1]==$FiltrStatus[0])
            {
             array_push( $filtrArr,get_post($FiltrId));
             continue;
            }
            if($paramFiltr[0]=='category'&& $paramFiltr[1]==$FiltrCategories[0]->name)
            {
             array_push( $filtrArr,get_post($FiltrId));
             continue;
            }
        }else{
            if($paramFiltr[0]=='status'&& $paramFiltr[1]==$FiltrStatus[0]&&$user==$FiltrName)
            {
             array_push( $filtrArr,get_post($FiltrId));
             continue;
            }
            if($paramFiltr[0]=='category'&& $paramFiltr[1]==$FiltrCategories[0]->name&&$user==$FiltrName)
            {
             array_push( $filtrArr,get_post($FiltrId));
             continue;
            }
        }
    }
?>
               
<?php


for($i=0;$i<count($filtrArr);$i++){
    $authorName=get_author_name($filtrArr[$i]->post_author) ;
    $post_category = get_the_category($filtrArr[$i]->ID);
    $date = get_the_date('',$filtrArr[$i]->ID);
    $time = get_the_time('',$filtrArr[$i]->ID);
    $updateCheckUser = get_post_custom_values( "usp_custom_field_4",$filtrArr[$i]->ID );
    $updateCheckAdmin = get_post_custom_values( "usp_custom_field_5",$filtrArr[$i]->ID );
    if($updateCheckAdmin[0]==NULL){
        update_post_meta( $filtrArr[$i]->ID, 'usp_custom_field_5', 'true' );
        update_post_meta( $filtrArr[$i]->ID, 'emailAthor', $userEmail );
        $updateCheckAdmin = get_post_custom_values( "usp_custom_field_5",$filtrArr[$i]->ID );
        $AllDatauser=get_users();
        for($j=0;$j<count($AllDatauser);$j++){
           for($k=0;$k<count($AllDatauser[$j]->roles);$k++){
            if($post_category[0]->name== wp_roles()->roles[$AllDatauser[$j]->roles[$k]]['name']){
                 $to = $AllDatauser[$j]->user_email;
                 $subject = 'Создана заявка №'.$filtrArr[$i]->ID;
                 $message = $filtrArr[$i]->post_title.'<br/>'.' <a href="http://<?php echo ($test);?>/post/?id='.($filtrArr[$i]->ID).'"'.'>http://'.$test.'/post/?id='.($filtrArr[$i]->ID).'</a>';
                 remove_all_filters( 'wp_mail_from' );
                 remove_all_filters( 'wp_mail_from_name' );
                 $headers = array(
            	 'From: '.$authorName.' <mtsr.helper@mail.ru>',
            	 'content-type: text/html',
            );
            wp_mail( $to, $subject, $message, $headers );
            }
           }
        }
    }
      ?>
     
       <a   class='a_null' href="http://<?php echo ($test);?>/post/?id=<?php echo ($filtrArr[$i]->ID);?>">
       <div class="application_box <?php if($isAdmin){if($updateCheckAdmin[0]=='true'){echo 'checkMe';}}else{if($updateCheckUser[0]=='true'){echo 'checkMe';}} ?>" >
       <div class="application_id"> <span class="application_text"><?php echo $filtrArr[$i]->ID; ?></span></div>
       <div class="application_title"> <span class="application_text"><?php   echo  $filtrArr[$i]->post_title;?></span></div>
       <div class="application_category"> <span class="application_text"><?php   echo $post_category[0]->name ;?></span></div> 
       <div class="application_author"> <span class="application_text"><?php   echo $authorName ;?></span></div> 
       <div class="application_date"> <span class="application_text"><?php  echo   $date;?></span></div> 
       <div class="application_time"> <span class="application_text"><?php    echo $time;?></span></div>  
       <?php
          $mykey_values = get_post_custom_values( "usp_custom_field",$filtrArr[$i]->ID );
          foreach( $mykey_values as $key => $value ) {
              if( $value=='Ожидание'){
                  ?>
                  <div class="application_status open"> 
                  <?php 
              }elseif( $value=='Закрыта'){
                  ?>
                  <div class="application_status close"> 
                  <?php 
               } elseif( $value =='В работе'){
                  ?>
                   <div class="application_status work"> 
                  <?php 
          }
              ?>
            <span class="application_text">   <?php echo  $value ;?></span></div>                        
              
              <?php
          }
          ?>
       </div>
       </a>
       <?php
   }
  
  }
?>
 </div>
 <div class="application_menu">
        <form  action="createpost" method="get" class="menu-container-element">
             <input class='application-create-button' type="submit" name="createpost" value="Создать заявку" > 
        </form>

       

        <a href="<?php echo $myIsp;?>" class="menu-container-element">
            <input class='application-create-button' type="submit" value="Мои заявки" > 
        </a>
        <form  method="post" class="menu-container-element">
 			<input class="application-create-button" type="submit" name="Status" value="Найти заявку по ID">
			<input placeholder="<?php  if($paramFiltr[0]=="id"){ echo ($paramFiltr[1]);}else{echo 'Введите ID';}?>" type="number" class="select_id" name="selectID" >
		</form>
    <?php 
        if($role_user=='editor'||$role_user=='administrator'){		
    ?>
        <a href="http://<?php echo ($test);?>/application/?Filtr=post,all" class="menu-container-element">
            <input class='application-create-button' type="submit" value="Все заявки" > 
        </a>

        <a href="http://<?php echo ($test);?>/application/?Filtr=isp,<?php echo $user;?>" class="menu-container-element">
            <input class='application-create-button' type="submit" value="На исполнении" > 
        </a>

        <form  method="post" class="menu-container-element">
 			<input class="application-create-button" type="submit" name="Status" value="Найти заявки пользователя">
			    <select class="select_ispolnitel" name="selectUserPosts" >
			        <option value="" selected disabled haide hidden >Выберите пользователя</option>
                        <?php 
                            $allUserName = get_users();
                            if( $allUserName ){
                                foreach( $allUserName as $user ){
                                    if( $user->display_name!='MtsrHelp')
                                    echo '<option value="'. $user->display_name. '">'. $user->display_name. '</option>';
                                }
                            }
                        ?>
			</select>
		</form>

        <?php
		}
		?>
        <form  method="post" class="menu-container-element">
 			<input class="application-create-button" type="submit" name="Status" value="Найти по статусу">
			<select class="select_ispolnitel" name="selectStat" >
				<option value="" selected disabled haide hidden >Выберите статус</option>
				<option value='Ожидание' > Ожидание</option>
				<option value='В работе' > В работе</option>
				<option value='Закрыта' > Закрыта</option>
			</select>
		</form>
        <form  method="post" class="menu-container-element">
 			<input class="application-create-button" type="submit" name="Status" value="Найти по разделу">
			<select class="select_ispolnitel" name="selectCategory" >
			    <option value="" selected disabled haide hidden >Выберите раздел</option>
                    <?php 
                            foreach( $currentRoles as $cat ){
                                echo '<option value="'. $cat. '">'. $cat. '</option>';
                            }
                    ?>
			</select>
		</form>
 </div>
         
 </div>
    </div>  
    
<?php wp_footer() ?>
