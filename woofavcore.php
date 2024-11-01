<?php 

if ( ! defined( 'ABSPATH' ) ) exit;


add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'add_action_links' );

/* Get and set queries */
require_once(woofav__PLUGIN_DIR.'inc/my_favorites.php');
require_once(woofav__PLUGIN_DIR.'inc/interfaces.php');
require_once(woofav__PLUGIN_DIR.'inc/wp-js.php');
require_once(woofav__PLUGIN_DIR.'inc/woofunctions.php');

/* Set menu and submenu for wordpress */
/*require_once(woofav__PLUGIN_DIR.'inc/wp_menu.php');
*/
/* Show data to admin in dashboard */
/*require_once(woofav__PLUGIN_DIR.'inc/show_data.php');*/
/* To get and prepare shortcodes */
/* ajax posts */
add_action( 'wp_ajax_nopriv_post_woofav_Sorting', 'woofav_ajax' );
add_action( 'wp_ajax_woofav_ajax', 'woofav_ajax' );
function woofav_ajax(){
	header('Content-Type: application/json');
	$getMetaData=new woofav_getMetaData();
	/*get data from this user and prdct*/
	$woofav_data= $getMetaData->woofavGetUserID();
	$woofav_prdid=$_REQUEST['prdctid'];
	$woofav_userId=$_REQUEST['userid'];
	$WooImg=new wooSetMetaPosts();
	$WooImg->WFSetImage($woofav_prdid,$woofav_userId);
	$WooImg->WFUpdateImage($woofav_prdid,$woofav_userId);
	$WooImg->WFSetImage($woofav_prdid,$woofav_userId);
	$img=$WooImg->WFGetImage();
	$img=plugins_url( 'inc/'.$img, __FILE__ );
	$result['img']=$img;
	echo json_encode($result);
	wp_die();
}

