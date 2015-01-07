<?php

/*
Template Name: Loginbereich
*/


	$user = wp_get_current_user();
	pd($user);

	$args = array(
	    'author'        =>  $user->ID,
	    'orderby'       =>  'post_date',
	    'order'         =>  'ASC',
	    'posts_per_page' => 1
    );

	$user_post = get_posts($args);

	pd($user_post);


	foreach ($user_post as $key => $post) {
		$repeater = get_field('field_54a8027ac8a7f', $user_post->ID);

		pd($repeater);
		
	}


require_once('Templates/Header.php');
?>

<div class="module module--userSite">
	<div class="headline">HELLO <?php echo $user->display_name;?></div>
	<div class="information--wrapper">
		<div class="portal--wrapper">
			<?php foreach ($user_post as $key => $post):
				$repeaterField = get_field('field_54a8027ac8a7f', $user_post->ID);

				foreach ($repeaterField as $key => $portal) { 
						$count = $key + 1;
						echo '<div class="portal--item portal-' . $count . '">';
				?>

						<div class="portal__name"><?php echo $portal['portal']; ?></div>
						<div class="portalInfos cf">
							<div class="portalInfos__email">
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
	

<?php
// $renderer->renderFlexibleContentFields();
require_once('Templates/Footer.php');