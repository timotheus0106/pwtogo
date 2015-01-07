<?php
$userId;
function ajaxCall() {
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        header('Content-Type: application/json; charset=utf-8'); // no json parse necessary in js
        // -----------------------------------------------------------------------------------
       if($_POST['action'] == 'checklogin') {
            
            $form = $_POST['form'];
            $username = $form[0]['value'];
            $plain_password = $form[1]['value'];

            $userAuth = wp_authenticate($username, $plain_password);

            // echo '<pre>';
            // print_r($userAuth);
            // echo '</pre>';

            $content = 'correct username and password';
            $userExists = true;
            $userId = $userAuth->ID;
            $userDisplayName = $userAuth->display_name;
            $gotoPage = get_page_link(16);

            // setUserClass($userId);

            // wp_set_current_user( $userId, $name );

            wp_set_current_user( $userId);
            wp_set_auth_cookie( $userId );
            do_action( 'wp_login', $userExists->user_login );

            if( is_wp_error($userAuth)) {
                $content = '<div class="errorMsg">you have entered an invalid username and/or password</div>';
                $userExists = false;
            }

            if ($userExists === true) {
                $return = array(
                    'success' => true,
                    'userid' => $userId,
                    'pageUrl' => $gotoPage,
                    'displayName' => $userDisplayName,
                    'content' => $content
                );
            }
            if ($userExists === false) {
                $return = array(
                    'success' => false,
                    'content' => $content
                );
            }


           die(json_encode($return));
        }
        // -----------------------------------------------------------------------------------
   }
}
add_action('init', 'ajaxCall');

// pd($userId);