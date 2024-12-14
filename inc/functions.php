<?php
class HTML_Tag_Replace_Core {

    public function __construct() {
        add_action( 'init', array($this, 'html_tag_replace_migrate_data' ));
        add_action('admin_enqueue_scripts', array($this,'html_tag_and_class_replace_scripts'));
        add_action('wp_enqueue_scripts', array($this,'html_tag_replace_front_custom_scripts'), 100);
        add_action('wp_ajax_save_html_replace_data', array($this,'html_tag_replace_data_save_callback') );
    }

    
    /**
    * Admin Include CSS
    */

    function html_tag_and_class_replace_scripts(){
        wp_enqueue_style( 'html_tag_and_class_replace_css', HTMLTagReplace_URL.'/assets/admin/css/style.css', false, HTMLTagReplace_VERSION);
        wp_enqueue_script( 'html_tag_and_class_replace_js', HTMLTagReplace_URL.'/assets/admin/js/admin.js', array('jquery'), '', true );
        wp_localize_script('html_tag_and_class_replace_js', 'htmlReplaceAjax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('html_replace_nonce'),
        ]);
    }
    
    
    /**
     * Front-End Include JS
    */
    
    function html_tag_replace_front_custom_scripts(){
        wp_enqueue_script( 'my_replace_js', HTMLTagReplace_URL.'/assets/app/js/replace.js', array('jquery'), '', true );
        
        $html_class_replace = get_option( 'html_class_replace' );
        $html_tag_replace = get_option( 'html_tag_replace' );
        $html_tag_replace_info = array(
            'html_class_replace' => !empty($html_class_replace['repeater_data']) ? $html_class_replace['repeater_data'] : [],
            'html_tag_replace' => !empty($html_tag_replace['repeater_data']) ? $html_tag_replace['repeater_data'] : []
        );

        wp_localize_script( 'my_replace_js', 'htc_data', $html_tag_replace_info );
    }

    /**
     * Settings Data Save
    */
    function html_tag_replace_data_save_callback(){
        // Verify nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'html_replace_nonce')) {
            wp_send_json_error('Invalid nonce');
        }

        // Get the data
        $tag_data = $_POST['tag_data'] ?? [];
        $class_data = $_POST['class_data'] ?? [];

        // Validate and sanitize the input
        $tag_data = array_map(function ($item) {
            return [
                'html_old_tag' => sanitize_text_field($item['html_old_tag']),
                'html_new_tag' => sanitize_text_field($item['html_new_tag']),
            ];
        }, $tag_data);

        $class_data = array_map(function ($item) {
            return [
                'html_old_class' => sanitize_text_field($item['html_old_class']),
                'html_new_class' => sanitize_text_field($item['html_new_class']),
            ];
        }, $class_data);

        update_option('html_class_replace', ['repeater_data' => $class_data]);
        update_option('html_tag_replace', ['repeater_data' => $tag_data]);

        wp_send_json_success();
    }

    /**
     * Settings Data Migrate
    */
    function html_tag_replace_migrate_data() {
        // Check if migration has already been performed
        if ( empty( get_option( 'html_tag_replace_migration' ) ) ) {
            // Get the old class data
            $jh_html_old_class = wp_unslash( get_option( 'html_old_class' ) );
            $jh_html_new_class = wp_unslash( get_option( 'html_new_class' ) );
    
            // Get the old tag data
            $jh_html_old_tag = wp_unslash(get_option( 'html_old_tag' ));
            $jh_html_new_tag = wp_unslash(get_option( 'html_new_tag' ));
    
            // Prepare migration data
            $migrate_able_data = [];
            if ( ! empty( $jh_html_old_class ) && ! empty( $jh_html_new_class ) ) {
                $migrate_able_data[] = [
                    'html_old_class' => $jh_html_old_class,
                    'html_new_class' => $jh_html_new_class,
                ];
            }
    
            // Update the new option with repeater data format
            update_option( 'html_class_replace', ['repeater_data' => $migrate_able_data] );
    
            // Prepare migration data
            $migrate_able_tag_data = [];
            if ( ! empty( $jh_html_old_tag ) && ! empty( $jh_html_new_tag ) ) {
            $tags_array = array_map('trim', explode(',', $jh_html_old_tag));
            foreach($tags_array as $tag){
                $migrate_able_tag_data[] = [
                    'html_old_tag' => $tag,
                    'html_new_tag' => $jh_html_new_tag,
                ];
            }
            }
    
            // Update the new option with repeater data format
            update_option( 'html_tag_replace', ['repeater_data' => $migrate_able_tag_data] );
    
            // Set the migration flag
            update_option( 'html_tag_replace_migration', 1 );
        }
    }

}

$HTML_Tag_Replace_Core = new HTML_Tag_Replace_Core();