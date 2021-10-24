<?php
/**
 * Plugin Name:       HTML Tag and Class Replace
 * Plugin URI:        https://viserx.com/
 * Description:        Allows you to Replace any HTML Tag and Class of your WordPress WebSite.
 * Version:           1.0
 * Requires at least: 4.7
 * Tested up to: 5.8.1
 * Requires PHP:      5.3
 * Author:            jahidcse
 * Author URI:        https://profiles.wordpress.org/jahidcse/


 */

/**
* OOP Class HTMLtagreplace
*/

class HTMLtagreplace {

public function __construct() {

$file_data = get_file_data( __FILE__, array( 'Version' => 'Version' ) );

$this->plugin                           = new stdClass;
$this->plugin->name                     = 'html-tag-and-class-replace';
$this->plugin->displayName              = 'Tag and Class Replace';
$this->plugin->version                  = $file_data['Version'];
$this->plugin->folder                   = plugin_dir_path( __FILE__ );
$this->plugin->url                      = plugin_dir_url( __FILE__ );

/**
* Hooks
*/

add_action('admin_menu', array($this,'html_tag_replace_admin_add_page'));
add_action('admin_enqueue_scripts', array($this,'html_tag_and_class_replace_scripts'));
add_action('wp_enqueue_scripts', array($this,'html_tag_replace_front_custom_scripts'), 100);


}

/**
* Admin Menu
*/

function html_tag_replace_admin_add_page() {
     add_submenu_page( 'options-general.php', $this->plugin->displayName, $this->plugin->displayName, 'manage_options', $this->plugin->name, array( &$this, 'settingsPanel' ) );
}

/**
* Deshboard file and data insert
*/

function settingsPanel() {

if ( ! current_user_can( 'manage_options' ) ) {
  wp_die( __( 'Sorry, you are not allowed to access this page.', 'html-tag-and-class-replace' ) );
}

if(isset($_REQUEST['but_submit'])){
    if ( ! current_user_can( 'unfiltered_html' ) ) {
      wp_die( __( 'Sorry, you are not allowed to access this page.', 'html-tag-and-class-replace' ) );
    } elseif ( !isset( $_REQUEST[ $this->plugin->name . '_nonce' ] ) ) {
      $this->errorMessage = __( 'nonce field is missing. Settings NOT saved.', 'html-tag-and-class-replace' );
    }else{
    update_option( 'html_old_tag', sanitize_text_field($_REQUEST['html_old_tag']) );
    update_option( 'html_new_tag', sanitize_text_field($_REQUEST['html_new_tag'],'') );
    update_option( 'html_old_class', sanitize_text_field($_REQUEST['html_old_class']) );
    update_option( 'html_new_class', isset( $_REQUEST['html_new_class'] ) ? sanitize_text_field($_REQUEST['html_new_class']) : '' );
    $this->message = __( 'Settings Saved.', 'html-tag-and-class-replace' );
    }
  }
  $this->html_tag_replace_info = array(
    'html_old_tag' => esc_html( wp_unslash( get_option( 'html_old_tag' ) ) ),
    'html_new_tag' => esc_html( wp_unslash( get_option( 'html_new_tag' ) ) ),
    'html_old_class' => esc_html( wp_unslash( get_option( 'html_old_class' ) ) ),
    'html_new_class'   => esc_html( wp_unslash( get_option( 'html_new_class' ) ) ),
  );
  include_once $this->plugin->folder.'/view/deshboard.php';

}


/**
* Admin Include CSS
*/

function html_tag_and_class_replace_scripts(){
  wp_enqueue_style( 'html_tag_and_class_replace_css', plugins_url('/assets/css/style.css', __FILE__), false, $this->plugin->version);
}


/**
* Front-End Include JS
*/

function html_tag_replace_front_custom_scripts(){

wp_enqueue_script( 'my_replace_js', plugins_url('/assets/js/replace.js', __FILE__), array('jquery'), '', true );

$jh_html_old_tag = wp_unslash(get_option( 'html_old_tag' ));
$jh_html_new_tag = wp_unslash(get_option( 'html_new_tag' ));
$jh_html_old_class = wp_unslash(get_option( 'html_old_class' ));
$jh_html_new_class = wp_unslash(get_option( 'html_new_class' ));
$jh_data_pass = array(
    'oldtag' => $jh_html_old_tag,
    'newtag' => $jh_html_new_tag,
    'oldclass' => $jh_html_old_class,
    'newclass' => $jh_html_new_class
);
wp_localize_script( 'my_replace_js', 'htc_data', $jh_data_pass );

}



}

$HTMLtagreplace = new HTMLtagreplace();