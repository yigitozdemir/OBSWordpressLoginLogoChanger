<?php

/**
 * @package com.obs.loginform
 * @version 0.0.1
 */
/*
Plugin Name: Login / Register page logo changer
Plugin URI: https://yigitnot.com/
Description: A plugin for changing logo in Register / login page
Author: Yigit Ozdemir
Version: 0.0.1
Author URI: https://yigitnot.com/
*/

define( 'OBS_SETTING_NAME_LOGIN_IMAGE', 'obsSettingLoginImage' );

function obsLoginImageActivation()
{
    $imageUrl = site_url( 'wp-content/plugins/obs_login_image/img/Logo.png' );
    $imageID = media_sideload_image( $imageUrl, null, null, 'src' );
    add_option( OBS_SETTING_NAME_LOGIN_IMAGE, $imageID);
    error_log($imageID);

}

function obsLoginImageDeactivation()
{
    delete_option( OBS_SETTING_NAME_LOGIN_IMAGE );
}

register_activation_hook( __FILE__, 'obsLoginImageActivation' );
register_deactivation_hook( __FILE__, 'obsLoginImageDeactivation' );


add_action( 'login_enqueue_scripts', function(){
    wp_enqueue_style( 'obs_login', plugins_url( '/style/style.css', __FILE__ ) );

    $style = 'body.login div#login h1 a {background-image: url("{obsCssUrl}");}';
    $data = str_replace("{obsCssUrl}", get_option( OBS_SETTING_NAME_LOGIN_IMAGE )   , $style);
    error_log($data);
    wp_add_inline_style( 'obs_login', $data );
});


require_once __DIR__ . '/obs_login_menu_page.php';


function _obsLogoCreateMenu () 
{
    add_menu_page( 'OBS Login Logo Changer', 'OBS Login Logo Changer', 'activate_plugins', 'obs_logo', 'obsLoginLogoRenderMenuPage', null, null );
}

add_action( 'admin_menu', '_obsLogoCreateMenu' );