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
            do_action( 'wp_login', $userAuth->user_login );

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

        if($_POST['action'] == 'addNewPortal') {
            
            $form = $_POST['form'];
            $portal = $form[0]['value'];
            $email = $form[1]['value'];
            $newuser = $form[2]['value'];
            $password = $form[3]['value'];
            $further = $form[4]['value'];

            $oldPortal = $_POST['oldPortal'];


            $field_key = 'field_54a8027ac8a7f';

            $user = wp_get_current_user();

            $is_edit = $_POST['is_editing'];

            $args = array(
                'author'        =>  $user->ID,
                'orderby'       =>  'post_date',
                'order'         =>  'ASC',
                'posts_per_page' => 1
            );

            $user_post = get_posts($args);

            // pd($is_edit);

            foreach ($user_post as $key => $post) {
                $repeater = get_field($field_key, $post->ID);

                if ($is_edit == 'false') {
                    $repeater[] = array(
                        "portal" => $portal,
                        "email" => $email,
                        "username" => $newuser,
                        "password" => $password,
                        "additional_information" => $further
                    );
                } else {
                    foreach ($repeater as $key => $portalItem) {
                        if ($portalItem['portal'] == $oldPortal) {

                            $editkey = $key;
                            $newArray = array(
                                "portal" => $portal,
                                "email" => $email,
                                "username" => $newuser,
                                "password" => $password,
                                "additional_information" => $further          
                            );
                        }                    
                    }
                    $repeater[$editkey] = $newArray;
                }
                update_field( $field_key, $repeater, $post->ID );
            }

            // $content = 'worked';
            // if ($userExists === true) {
                $return = array(
                    'success' => true
                );
            // }
            // if ($userExists === false) {
            //     $return = array(
            //         'success' => false,
            //         'content' => $content
            //     );
            // }


           die(json_encode($return));
        }
                // -----------------------------------------------------------------------------------

        if($_POST['action'] == 'deletePortal') {
            
            $field_key = 'field_54a8027ac8a7f';
            $portal = $_POST['portalName'];

            $user = wp_get_current_user();

            $args = array(
                'author'        =>  $user->ID,
                'orderby'       =>  'post_date',
                'order'         =>  'ASC',
                'posts_per_page' => 1
            );

            $user_post = get_posts($args);

            // echo $portal;

            foreach ($user_post as $key => $post) {
                $repeater = get_field($field_key, $post->ID);

                foreach ($repeater as $key => $portalItem) {
                    if ($portalItem['portal'] == $portal) {
                        $deleteKey = $key;
                    }                    
                }

                // echo '<pre>';
                // print_r($repeater);
                // echo '</pre>';

                // echo '<pre>';
                // var_dump($deleteKey);
                // echo '</pre>';

                array_splice($repeater, $deleteKey, 1);

                update_field( $field_key, $repeater, $post->ID );
            }

            // $content = 'worked';
            // if ($userExists === true) {
                $return = array(
                    'success' => true
                );
            // }
            // if ($userExists === false) {
            //     $return = array(
            //         'success' => false,
            //         'content' => $content
            //     );
            // }


           die(json_encode($return));
        }

// -----------------------------------------------------------------------------------

        if($_POST['action'] == 'editPortal') {
            
            $field_key = 'field_54a8027ac8a7f';
            $portal = $_POST['portalName'];

            $user = wp_get_current_user();

            $args = array(
                'author'        =>  $user->ID,
                'orderby'       =>  'post_date',
                'order'         =>  'ASC',
                'posts_per_page' => 1
            );

            $user_post = get_posts($args);

            // echo $portal;

            foreach ($user_post as $key => $post) {
                $repeater = get_field($field_key, $post->ID);

                foreach ($repeater as $key => $portalItem) {
                    if ($portalItem['portal'] == $portal) {
                        $e_portal = $portalItem['portal'];
                        $e_email = $portalItem['email'];
                        $e_user = $portalItem['username'];
                        $e_password = $portalItem['password'];
                        $e_aI = $portalItem['additional_information'];
                    }                    
                }
            }

            // $content = 'worked';
            // if ($userExists === true) {
                $return = array(
                    'success' => true,
                    'portal' => $e_portal,
                    'mail' => $e_email,
                    'user' => $e_user,
                    'password' => $e_password,
                    'addInfo' => $e_aI
                );
            // }
            // if ($userExists === false) {
            //     $return = array(
            //         'success' => false,
            //         'content' => $content
            //     );
            // }


           die(json_encode($return));
        }

        if($_POST['action'] == 'logout') {
            
            wp_logout();

            $gotoPage = get_page_link(2);

            $return = array(
                'success' => true,
                'gotopage' => $gotoPage
            );

           die(json_encode($return));
        }
        // -----------------------------------------------------------------------------------
   }
}
add_action('init', 'ajaxCall');

// pd($userId);