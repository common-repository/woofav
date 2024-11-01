<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

/* Get all thecolor.in this part you can set of your settings too,be carefull */
/* get user id */
/*cuser login or not */
add_action('woofav_show','woofavGetUser');
function woofavGetUser(){
	$getMetaData=new woofav_getMetaData();
	$woofav_data= $getMetaData->woofavGetUserID();
	$woofav_userId=$woofav_data['user'];
	if (isset($woofav_userId)&&($woofav_userId!=NULL)){
		if ( class_exists( 'WooCommerce' ) ) {
  // code that requires WooCommerce
			do_action('woocommerce_after_add_to_cart_button');
		}
	}
}
add_action( 'woocommerce_after_add_to_cart_button', 'woofav_after_addtocart_button_func');
function woofav_after_addtocart_button_func($productid) {
// Echo content.
	if ( is_user_logged_in() ) {
		wp_enqueue_script ( 'main',  woofav__PLUGIN_URL . 'inc/js/main.js');
		admin_url('admin-ajax.php');
 
		$getMetaData=new woofav_getMetaData();
		/*get data from this user and prdct*/
		$woofav_data= $getMetaData->woofavGetUserID();
		$woofav_userId=$woofav_data['user'];
		global $product;
		if($productid==null)
		{
			$woofav_prdid= $product->id;
		}
		else
		{
			$woofav_prdid=$productid;
		}
		$WooImg=new wooSetMetaPosts();
		$WooImg->WFSetImage($woofav_prdid,$woofav_userId);
		$img=$WooImg->WFGetImage();
		?>
		<div id="showid"></div>
		<div class="second_content" >
			<img style="cursor: pointer;" id="woofave_icon-<?php echo $woofav_prdid ?>" class="woofave_icon" data-user="<?php echo $woofav_userId  ?>"  data-post="<?php echo $woofav_prdid ?>" src="<?php echo plugins_url( $img, __FILE__ ) ?>">
		</div>
		<?php
	}
}
