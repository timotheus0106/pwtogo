<?php

/*
Template Name: Home
*/

require_once('Templates/Header.php');
?>

<div class="module module--login">
	<div class="login__wrapper cf">
		<form action="" id="checkLogin">
			<div class="field user">
				<div class="title">user</div>
				<input type="text" name="user" class="username">
			</div>
			<div class="field password">
				<div class="title">password</div>
				<input type="password" name="password" class="password">
			</div>
			<div class="field submit">
				<input type="submit" value="Submit">
			</div>
		</form>
	</div>
</div>
	

<?php
// $renderer->renderFlexibleContentFields();
require_once('Templates/Footer.php');