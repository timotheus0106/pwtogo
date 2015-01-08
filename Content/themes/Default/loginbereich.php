<?php

/*
Template Name: Loginbereich
*/


	$user = wp_get_current_user();
	// pd($user);

	$args = array(
	    'author'        =>  $user->ID,
	    'orderby'       =>  'post_date',
	    'order'         =>  'ASC',
	    'posts_per_page' => 1
    );

	$user_post = get_posts($args);

	// pd($user_post);


	// foreach ($user_post as $key => $post) {
	// 	$repeater = get_field('field_54a8027ac8a7f', $user_post->ID);

	// 	pd($repeater);
		
	// }


require_once('Templates/Header.php');
?>

<div class="module module--userSite">
	<div class="headline">HELLO <?php echo $user->display_name;?></div>
	<div class="button button__addNewPortal js_newPortal">add new</div>
	<div class="button button__logout js_logout">logout</div>
	<div class="information--wrapper">
		<div class="portal--wrapper">
			<?php foreach ($user_post as $key => $post):
				$repeaterField = get_field('field_54a8027ac8a7f', $post->ID);

				foreach ($repeaterField as $key => $portal) { 
						$count = $key + 1;
						echo '<div class="portal--item portal-' . $count . '">';
				?>

						<div class="portal__name" data-portalName="<?php echo $portal['portal']; ?>"><?php echo $portal['portal']; ?>
							<div class="edit--buttons">
								<div class="button edit--button js_editButton">
									<img src="<?php echo home_url(); ?>/Assets/Images/icons/edit_icon.png" alt="edit button" />
								</div>
								<div class="button delete--button js_deleteButton">
									<img src="<?php echo home_url(); ?>/Assets/Images/icons/delete_icon.png" alt="delete button" />
								</div>
							</div>
						</div>
						<div class="portalInfos cf">
							<div class="portalInfos__email">
								<!-- <div class="copy--button">
									<img src="<?php // echo home_url(); ?>/Assets/Images/icons/copy_icon.png" alt="copy button" />
								</div> -->
								<div class="title">Email: </div>
								<div class="content"><?php echo $portal['email']; ?></div>
							</div>
							<div class="portalInfos__username">
								<div class="title">Username: </div>
								<div class="content"><?php echo $portal['username']; ?></div>
							</div>
							<div class="portalInfos__password">
								<div class="title">Password: </div>
								<div class="content"><?php echo $portal['password']; ?></div>
							</div>
							<div class="portalInfos__additionalInformation">
								<div class="title">Further Informations: </div>
								<div class="content"><?php echo $portal['additional_information']; ?></div>
							</div>
						</div>
					</div>


				<?php } ?>


			<?php endforeach ?>
		</div>
	</div>
</div>
	<div class="modal modal__addNewPortal">
		<form action="" id="form__addNewPortal">
			<div class="create create_portal">
				<div class="title">Portal</div>
				<input type="text" name="portal" class="c_portal">
			</div>

			<div class="create create_email">
				<div class="title">email</div>
				<input type="text" name="email" class="c_email">
			</div>

			<div class="create create_username">
				<div class="title">user</div>
				<input type="text" name="user" class="c_username">
			</div>
			<div class="create create_password">
				<div class="title">password</div>
				<input type="text" name="password" class="c_password">
			</div>
			<div class="create create_further">
				<div class="title">further informations</div>
				<!-- <input type="textarea" name="further" class="c_further"> -->
				<textarea name="further" id="c_further" cols="30" rows="10"></textarea>
			</div>
			<div class="modal__buttons">
				<div class="field submit">
					<input type="submit" value="Submit">
				</div>
				<div class="field discard">
					discard
				</div>
			</div>
		</form>
	</div>
	


<!-- </div> -->
	

<?php
// $renderer->renderFlexibleContentFields();
require_once('Templates/Footer.php');