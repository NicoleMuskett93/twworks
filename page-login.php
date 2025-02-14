<?php 

get_header();

if (!is_user_logged_in()) {
    $args = array(
        'echo' => true,
        'form_id' => 'loginform',
        'label_username' => 'hello',
        'label_password' => 'Password',
        'label_remember' => 'Remember Me',
        'label_log_in' => 'Log In',
        'id_username' => 'user_login',
        'id_password' => 'user_pass',
        'id_remember' => 'rememberme',
        'id_submit' => 'wp-submit',
        'remember' => true,
        'value_username' => '',
        'value_remember' => false
    );
    ?> <div class="hi my-5">
         
        </div>
<?php }