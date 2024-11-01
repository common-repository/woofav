<?php 
/*
    Plugin Name: WooFav
    Plugin URI: http://www.misaco.ir
    Description: Favorite Posts by users in Woocommwece
    Tag: Woo , WooCommerce , Favorite , woofav
    Author: MiSaCo.ir
    Version: 0.3.1.1
    Author URI: http://www.misaco.ir
    Text Domain: woofav
*/ 
    /*-------------------------------------------------------------------------------------------------*/
    /* Get functions and Classess */
    # Silence is golden.
    if ( ! defined( 'ABSPATH' ) ) exit;
    // get Core file \
    
    /* Set Define Root */
    define( 'woofav__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
    define( 'woofav__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );


    require_once(woofav__PLUGIN_DIR.'woofavcore.php');
    require_once(woofav__PLUGIN_DIR.'custom-page-template.php');
    require_once(woofav__PLUGIN_DIR.'inc/wp_menu.php');
    require_once(woofav__PLUGIN_DIR.'inc/show_data.php');

    /* Add settings to random-post-plugin */
    add_filter( 'plugin_action_links', 'woofav_add_action_plugin', 30, 20 );
    function woofav_add_action_plugin( $actions, $plugin_file ) 
    {
        static $plugin;
        if (!isset($plugin))
            $plugin = plugin_basename(__FILE__);
        if ($plugin == $plugin_file) {
            $site_link = array('support' => '<a href="http://wpmen.ir" target="_blank">Support</a>');
            $actions = array_merge($site_link, $actions); 
        }
        return $actions;
    }
    // i18n plugin domain
    define('woofav_I18N_DOMAIN', 'woofav');

    /* Initialise the internationalisation domain */
    load_plugin_textdomain(woofav_I18N_DOMAIN, woofav__PLUGIN_DIR .'/languages','woofav/languages');
    register_activation_hook( __FILE__, 'woofav_table' );
    /* Runs when plugin is activated */
    register_activation_hook(__FILE__,'woofav_install'); 
    /* Runs on plugin deactivation*/
    register_deactivation_hook( __FILE__, 'woofav_remove' );
    function woofav_install() {
        global $wpdb;
        $the_page_title = 'woofav';
        $the_page_name = 'woofav';
    // the menu entry...
        delete_option("woofav_page_title");
        add_option("woofav_page_title", $the_page_title, '', 'yes');
    // the slug...
        delete_option("woofav_page_name");
        add_option("woofav_page_name", $the_page_name, '', 'yes');
    // the id...
        delete_option("woofav_page_id");
        add_option("woofav_page_id", '0', '', 'yes');
        $the_page = get_page_by_title( $the_page_title );
        if ( ! $the_page ) {
        // Create post object
            $_p = array();
            $_p['post_title'] = $the_page_title;
            $_p['post_content'] = "[woofav]";
            $_p['post_status'] = 'publish';
            $_p['post_type'] = 'page';
            $_p['comment_status'] = 'closed';
            $_p['ping_status'] = 'closed';
        $_p['post_category'] = array(1); // the default 'Uncatrgorised'
        // Insert the post into the database
        $the_page_id = wp_insert_post( $_p );
    }
    else {
        // the plugin may have been previously active and the page may just be trashed...
        $the_page_id = $the_page->ID;
        //make sure the page is not trashed...
        $the_page->post_status = 'publish';
        $the_page_id = wp_update_post( $the_page );
    }
    delete_option( 'woofav_page_id' );
    add_option( 'woofav_page_id', $the_page_id );
}
function woofav_remove() {
    global $wpdb;
    $the_page_title = get_option( "woofav_page_title" );
    $the_page_name = get_option( "woofav_page_name" );
    //  the id of our page...
    $the_page_id = get_option( 'woofav_page_id' );
    if( $the_page_id ) {
        wp_delete_post( $the_page_id ); // this will trash, not delete
    }
    delete_option("woofav_page_title");
    delete_option("woofav_page_name");
    delete_option("woofav_page_id");
}
global $jal_db_version;
$jal_db_version = '1.0';
function woofav_table() {
    global $wpdb;
    global $jal_db_version;
    $table_name = $wpdb->prefix . 'woofav';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
    id mediumint(11) NOT NULL AUTO_INCREMENT,
    time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
    userid int(100) NOT NULL,
    prdctid int(100) NOT NULL,
    UNIQUE KEY id (id),
    UNIQUE KEY user_prduct (userid,prdctid)
    ) $charset_collate;";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    add_option( 'jal_db_version', $jal_db_version );
}

