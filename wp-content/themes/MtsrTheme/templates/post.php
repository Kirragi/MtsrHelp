<?php
/*
Template Name: post
*/
wp_head();

get_header();
$oblPATH = new \Path11\Path12;
$test=$oblPATH->urlAddres;
$status;
$description;
$valu;
$urlImg;
$swither=false;
$arrUrl=array();
$logged=is_user_logged_in();
$current_user = wp_get_current_user();
$commentID;
$commntSwith=false;

	if(!$logged){
		wp_redirect("http://".$test."/login-user/") ;
	}

$ppc = $_GET['id'];
global $post;
$post = get_post( $ppc );
$meta_value;
$post_id=$ppc->ID;
$meta_key='usp_custom_field';
$post_category = get_the_category($ppc->ID);
$mykey_values = get_post_custom_values( "usp_custom_field", $ppc);
$updateCheckUser = get_post_custom_values( "usp_custom_field_4",$ppc);
$updateCheckAdmin = get_post_custom_values( "usp_custom_field_5",$ppc);
$emailAthor = get_post_custom_values( "emailAthor", $ppc);
	foreach( $mykey_values as $key => $value ) {
	 $status = $value ;
	}
	if( $status =='Открыта'){
		$meta_value='В работе';
	}elseif( $status =='В работе'){
		$meta_value='Закрыта';
	}else{
		$meta_value='Открыта';
	}


	$url ='http://'.$test.$_SERVER['REQUEST_URI'];
	$id = explode("=", $url);

	$mykey_values = get_post_custom_values( "usp_custom_field_2", $ppc);
   foreach( $mykey_values as $key => $value ) {
	$description = $value ;
   }
   $isp_values = get_post_custom_values( "usp_custom_field_3", $ppc);
   if($isp_values != NULL){
   foreach( $isp_values as $key => $value ) {
	$isp = $value ;
   }
}else {
	$isp = "--------------------------------------";
   }

	if($current_user->roles[0]=='editor'||$current_user->roles[0]=='administrator'){
			if($updateCheckAdmin[0]=="true"){
				update_post_meta( $ppc, 'usp_custom_field_5', 'false' );
			}
	}
   else
   {
	if($updateCheckUser[0]=="true"){
		 update_post_meta( $ppc, 'usp_custom_field_4', 'false' );
	}
   } 

	if(isset($_POST['GetWork'])) { 
			update_post_meta( $ppc, 'usp_custom_field_3', $current_user->user_firstname );
			wp_redirect($url) ;
	  }
	if(isset($_POST['selectStat'])) {
			update_post_meta( $ppc, $meta_key, $_POST['selectStat']);

			$to = $emailAthor;
			$subject = 'Cтатус заявки  № '.$ppc.'был изменён';
			$message = 'Статус заявки был изменён на "'.$_POST['selectStat'].'"<br/>'.' <a href="http://<?php echo ($test);?>/post/?id='.$ppc.'"'.'>http://'.$test.'/post/?id='.$ppc.'</a>';
			remove_all_filters( 'wp_mail_from' );
			remove_all_filters( 'wp_mail_from_name' );
			$headers = array(
			'From: '.$authorName.' <mtsr.helper@mail.ru>',
			'content-type: text/html',
	   );
	    wp_mail( $to, $subject, $message, $headers );

			if($current_user->roles[0]=='editor'||$current_user->roles[0]=='administrator'){
				update_post_meta( $ppc, 'usp_custom_field_4', 'true' );
			  }
			  else
			  {
				update_post_meta( $ppc, 'usp_custom_field_5', 'true' );
			  }

			wp_redirect($url) ;
	  }
	  
	
	  if(isset($_POST['selectIsp'])) {
			update_post_meta( $ppc, 'usp_custom_field_3', $_POST['selectIsp'] );
			$users = get_users(['role' =>'editor']);
						foreach( $users as $user ){
							if($user->display_name ==  $_POST['selectIsp']){
								$to = $user->user_email;
								$subject = 'Заявки №'.$ppc.' на исполнение ';
								$message =  $current_user->user_firstname.' назначил вас исполнителем заявки № '.$ppc.'<br/>'.' <a href="http://<?php echo ($test);?>/post/?id='.$ppc.'"'.'>http://10.13.2.202/post/?id='.$ppc.'</a>';
								remove_all_filters( 'wp_mail_from' );
								remove_all_filters( 'wp_mail_from_name' );
								$headers = array(
								'From: '.$authorName.' <mtsr.helper@mail.ru>',
								'content-type: text/html',
						   );
							wp_mail( $to, $subject, $message, $headers );
					
								
							}
						}
						wp_redirect($url) ; 
	  }
	  if(isset($_POST['AddComment'])) {
		if($_POST['TextComment']!=''){
		$data = [
			'comment_post_ID'      => $id[1],
			'comment_author'       => $current_user->user_firstname,
			'comment_author_email' => '',
			'comment_author_url'   => '',
			'comment_content'      => $_POST['TextComment'],
			'comment_type'         => 'comment',
			'comment_parent'       => 0,
			'user_id'              => $current_user->ID,
			'comment_author_IP'    => '',
			'comment_agent'        => '',
			'comment_date'         => null, // получим current_time('mysql')
			'comment_approved'     => 1,
			'meta_key'			   =>"comment_img",
			'meta_valeu'		   =>"",
		];
		wp_insert_comment( wp_slash($data) );

		if($current_user->display_name == get_the_author()){
			$users = get_users(['role' =>'editor']);
			foreach( $users as $user ){
				if($user->display_name ==  $isp){
					$to = $user->user_email;}
				}
		 }else{
			$to=$emailAthor;
		 }
		 var_dump ($to);
		 $subject = $current_user->display_name.' отправил коментарий к заявке №'.$ppc;
		 $message =  $_POST['TextComment'].'<br/>'.' <a href="http://<?php echo ($test);?>/post/?id='.$ppc.'"'.'>http://'.$test.'/post/?id='.$ppc.'</a>';
		 remove_all_filters( 'wp_mail_from' );
		 remove_all_filters( 'wp_mail_from_name' );
		 $headers = array(
		 'From: '.$authorName.' <mtsr.helper@mail.ru>',
		 'content-type: text/html',
	);
		wp_mail( $to, $subject, $message, $headers );

		$comments = get_comments();
		foreach( $comments as $comment ){
			if(($comment->comment_post_ID) == $id[1]){
					$commentID=$comment->comment_ID;
					break; 
			}
		}
		if($_FILES['Imgcomment']['name']!=''){
		$uuid= uniqid();
		echo $uuid;
		$uploaddir = 'wp-content/themes/MtsrTheme/parts/commentIMG/'.$uuid;
		$uploadfile = $uploaddir . basename($_FILES['Imgcomment']['name']);
		move_uploaded_file($_FILES['Imgcomment']['tmp_name'], $uploadfile); 
		$filename=$uuid.$_FILES['Imgcomment']['name'];
		update_comment_meta( $commentID, 'img',$filename);	
		}
	}
	if($current_user->roles[0]=='editor'||$current_user->roles[0]=='administrator'){
		update_post_meta( $ppc, 'usp_custom_field_4', 'true' );
 	 }else
  	{
		update_post_meta( $ppc, 'usp_custom_field_5', 'true' );
  	}
		wp_redirect($url) ; 
  }


   
   



?>


<div class="post">
<a class="a_null a_back" href="http://<?php echo ($test);?>/application"><div class="img_back_container"><img class="img_back" src="<?php echo get_template_directory_uri() ?>/assets/image/back.png" alt=""></div></a>
		<div class="post_header">
		
			<div class="post_box_description">
       			 <div class="post_id_description"> <span class="application_text">ID</span></div>
					<div class="post_theme_description"> <span class="application_text">Тема</span></div> 
					<div class="post_author_description"> <span class="application_text">Автор</span></div>
      			 <div class="post_date_description"> <span class="application_text">Дата создания</span></div>    
     			 <div class="post_time_description"> <span class="application_text">Время создания</span></div>      
      			 <div class="post_status_description"><span class="application_text">статус</span></div>     
        </div>    


<div class="dop_info_container">
<div class="post_id_description"><p ><?php echo the_ID(); ?></p></div>   
<div class="post_theme_description"><p class="psot_name"><?php echo  get_the_title();?></p>	</p></div>   
<div class="post_author_description"><p><?php echo  get_the_author(); ?></p></div>     
<div class="post_date_description"><p><?php echo  get_the_date();  ?></p></div>   
<div class="post_time_description"><p><?php  echo the_time();   ?></p></div>
<?php
    	 if( $status=='Ожидание'){
			?>
			<div class="post_status_description open">
			<?php 
		}elseif( $status=='Закрыта'){
			?>
			<div class="post_status_description close">
			<?php 
		 } elseif( $status =='В работе'){
			?>
			<div class="post_status_description work">
			<?php 
			}
		?>   
<p><?php echo $status; ?></p>   </div>
</div>
			
			<div class="status_container">
	
			</div>
			
		<div class="description_post center">Описание</div>
			<div class="post_content">
				<!-- <p class="post_description_title">Описание</p> -->
				<p class="post_description_text"><?php echo $description;?></p>
			</div>
			<div class="description_post center">Изображения</div>
<?php 
   $content = apply_filters( 'the_content', $content );
	for( $i = 0; $i <= strlen($content); $i++ ){
		
		$valu=$content[$i-3].''.$content[$i-2].''.$content[$i-1].''.$content[$i].''.$content[$i+1].''.$content[$i+2];
		if($valu=='f="htt'&& $swither==false){
			$swither=true;
		}
		if($swither){
            $urlImg=$urlImg.''.$content[$i]; 
        }
		$valu=$content[$i+1].''.$content[$i+2].''.$content[$i+3];
		if($valu =='"><' && $swither==true){
			$swither=false;
			array_push($arrUrl, $urlImg);
			$urlImg='';
        }
		$valu='';
	}
	?>
<div class="post_image_container">
<?php 
	for($i=0; $i<count($arrUrl); $i++) {
?>     
<a class="a_null post_image_link" >
<div class="post_button_image" onclick="imgPopup('<?php echo $arrUrl[$i]; ?>')"	 value="<?php echo $arrUrl[$i]; ?>">Изображение <?php echo $i+1; ?> </div></a>
<?php 
	}
	
?>
</div>
<div class="description_post center">Коментарии</div>

<form  enctype="multipart/form-data" method="post">
<div class="coment_container">
	<div class="input_coment_container">		
		    <label >
  				Добавить комментарий
			</label>
			<textarea  class="comment_input" type="text" name="TextComment" ></textarea>
		 </div>
	
			<div class="comment_button_container">
			<label  for="IdImgBtn1" class="custom-file-upload IdImgBtn1">
  				Прикрепить изображение
			</label>
			<input onclick="changeButtonImg('IdImgBtn1')" id="IdImgBtn1" class='comment_file' name="Imgcomment" type="file" >
  			<input class="application-create-button" type="submit" name="AddComment" value="Отправить комментарий">
			  </div>
			  </div>
		</form>

<?php 

// comment_form();
$comments = get_comments();
foreach( $comments as $comment ){
	
	if(($comment->comment_post_ID) == $id[1]){
		?>
	<div class="coment_item">
		<div class="comment_img_item">
			<img class="comment_img" src="<?php echo get_template_directory_uri() ?>/assets/image/manC.png" alt="">
        </div>
		<div class="comment_text_item">
			<p class="comment_aurhor"><?php echo ( $comment->comment_author );?> </p>
			<p class="comment_content"><?php echo ( $comment->comment_content );?> </p>
			</div>
			<div class="dop_info_comment">
			<?php 
			$commentImg=get_comment_meta( $comment->comment_ID, 'img',true );
			if( $commentImg){
			?>
				<a class='a_null' onclick="imgPopup('<?php echo get_template_directory_uri() ?>/parts/commentIMG/<?php echo $commentImg; ?>')"> <button class="comment_img_button">Изображение</button></a>

			<?php 
			}else{
				?>
               <div></div>
				<?php 
			}
			?>
				<span><?php echo $comment->comment_date; ?></span>
			</div>
	
		
	</div>
	<?php 
	}
}
?>
</div>

<div class="post_menu">
	<div class="menu_ispolnitel_container">
		<div class="ispolnitel_title">
			<p>Исполнитель</p>
		</div>
		<div class="ispolnitel_text">
			<p><?php echo $isp?></p>
		</div>
	</div>
	<?php 
	if($current_user->roles[0]=='editor'||$current_user->roles[0]=='administrator'){
		
	?>
		<form  method="post">
  			<input class="application-create-button" type="submit" name="GetWork" value="Взять в работу">
		</form>
		<form  method="post">
 				 <input class="application-create-button" type="submit" name="Status" value="Изменить статус">
				  <select class="select_ispolnitel" name="selectStat" >
				  <option value="" selected disabled haide hidden >Выберите статус</option>
				  <option value='Ожидание' > Ожидание</option>
				  <option value='В работе' > В работе</option>
				  <option value='Закрыта' > Закрыта</option>
				  </select>
		</form>
		<form  method="post">
 				 <input class="application-create-button" type="submit" name="Ispolnitel" value="Изменить исполнителя" >
				<select class="select_ispolnitel" name="selectIsp" >
					<option value="" selected disabled haide hidden >Выберите сотрудника</option>
					<?php
						$users = get_users(['role' =>'editor']);
						foreach( $users as $user ){
							?>
							<option value='<?php echo $user->display_name;?>' > <?php echo $user->display_name;?></option>
							<?php
						}
					?>
				</select>
		</form>
		<?php 
	}
	?>
</div>
</div>

<div id='popup' class="popup hidden" >
<div class="img_popup_container" >
	<div class="popup_exit" onclick="closePopup()" >
		<img class="popup_exit_img"  src="<?php echo get_template_directory_uri() ?>/assets/image/close.png" alt="">
	</div>
	<img id='img_popup' class="popup_img" src="" alt="">
	</div>
	<div class="popup" onclick="closePopup()" ></div>
</div>

<?php wp_footer();?>