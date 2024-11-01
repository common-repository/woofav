<?php 

/*
*
* This is set a page in wp menues and submenu for settings
* Register a custom menu page.
*
*/

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'admin_menu','woofav_register_woofav_settings' );
function woofav_register_woofav_settings(){
	add_menu_page( 
		__( 'woofav', 'textdomain' ),
		'woofav',
		'manage_options',
		'woofav_settings',
		'woofav_settings',
		plugins_url( 'img/icon.png', __FILE__ ),
		6
		); 
}

function woofav_settings(){
	/* This is home page plugin */
	?>
	<p>

		More woofav with refresh button  and settings 
		select one ore more Categories.
		select one ore more Post Types.
		enable/disable to show Content.
		enable/disable to show Thumbnails.
	</p>
	<h2>go to  woofav post settings</h2>
	<h3>
		<?php 
		if ( !class_exists( 'WooCommerce' ) ) {
			echo "Please install / Active WooCommerce !";
		}

		?>
	</h3>
	<?php
}

/*
*
* Display a custom sub menu page
*
*/

add_action('admin_menu', 'woofav_register_my_woofav_submenu_page');
function woofav_register_my_woofav_submenu_page() {
	add_submenu_page(
		'woofav_settings',
		'woofav post settings',
		'woofav post settings',
		'manage_options',
		'woofav_Settings',
		'woofav_submenu_page_callback' );
}

class  wpwoofav_GetPostData
{
	private $wpwoofavgetdata = array();
	function wpwoofavgetdata(){
		
		/*get cats saved*/
		$this->wpwoofavgetdata['thecolor']=get_option('thecolor');
		$this->wpwoofavgetdata['evencolor']=get_option('evencolor');
		$this->wpwoofavgetdata['thebordercolor']=get_option('thebordercolor');
		$this->wpwoofavgetdata['theFontcolor']=get_option('theFontcolor');
		$this->wpwoofavgetdata['theFontevebcolor']=get_option('theFontevebcolor');
		$this->wpwoofavgetdata['woofavicon']=get_option('woofavicon');

		


		/*get post types saved*/

		return $this->wpwoofavgetdata;
	}

}

// create custom plugin settings menu
add_action('admin_menu', 'woofav_create_menu');
function woofav_create_menu() {
	//call register settings function
	add_action( 'admin_init', 'register_woofav_settings' );
}

function register_woofav_settings() {
	//register our settings

	register_setting( 'woofav-settings-group', 'thecolor' );
	register_setting( 'woofav-settings-group', 'thebordercolor' );
	register_setting( 'woofav-settings-group', 'theFontcolor' );
	register_setting( 'woofav-settings-group', 'evencolor' );
	register_setting( 'woofav-settings-group', 'theFontevebcolor' );
	register_setting( 'woofav-settings-group', 'woofavicon' );
}


