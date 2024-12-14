<?php
/**
 * Plugin Name:       HTML Tag and Class Replace
 * Plugin URI:        https://wordpress.org/plugins/html-tag-and-class-replace/
 * Description:       Allows you to Replace any HTML Tag and Class of your WordPress WebSite.
 * Version:           1.1.0
 * Requires at least: 4.7
 * Tested up to: 6.7
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
    $this->plugin->folder                   = plugin_dir_path( __FILE__ );
    $this->plugin->url                      = plugin_dir_url( __FILE__ );
    define( 'HTMLTagReplace_VERSION', '1.0.9' );
    define( 'HTMLTagReplace_URL', plugin_dir_url( __FILE__ ) );

    /**
    * Hooks
    */

    add_action('admin_menu', array($this,'html_tag_replace_admin_add_page'));
    add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array($this,'html_tag_replace_page_settings'));
    $this->html_tag_and_class_replace_function();

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

    $this->html_tag_replace_info = array(
      'html_class_replace' => get_option( 'html_class_replace' ),
      'html_tag_replace' => get_option( 'html_tag_replace' )
    );
    include_once $this->plugin->folder.'/view/deshboard.php';

  }

  /**
  * Activated Plugin Setting
  */

  function html_tag_replace_activated( $plugin ) {
    if ( plugin_basename( __FILE__ ) == $plugin ) {
      wp_redirect( admin_url( 'options-general.php?page='.$this->plugin->name ) );
      die();
    }
  }


  /**
  * Plugin Setting Page Linked
  */

  function html_tag_replace_page_settings( $links ) {
    $link = sprintf( "<a href='%s' style='color:#2271b1;'>%s</a>", admin_url( 'options-general.php?page='.$this->plugin->name ), __( 'Settings', 'html-tag-and-class-replace' ) );
    array_push( $links, $link );
    return $links;
  }

  /**
   * Load Function
   *
   * @return void
  */
  function html_tag_and_class_replace_function(){
    require_once __DIR__ . '/inc/functions.php';
  }

}

$HTMLtagreplace = new HTMLtagreplace();