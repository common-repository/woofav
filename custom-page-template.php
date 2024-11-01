<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Proper way to enqueue scripts and styles.
 */
function wooProducts_shortcode(){
//wp_enqueue_script ( 'jquery.tablesorter.min', plugins_url( '/inc/js/jquery.tablesorter.min.js' , __FILE__ ) , true);

//to set and get data from data base for table settings 
	$values=new wpwoofav_GetPostData();
	$value=$values->wpwoofavgetdata();
	
	$getthecolor=$value['thecolor'];
	$getevencolor=$value['evencolor'];
	$thebordercolor=$value['thebordercolor'];
	$theFontcolor=$value['theFontcolor'];
	$theFontevebcolor=$value['theFontevebcolor'];

	//var_dump($values);
	?>
	<style type="text/css">
#woofavTable tr:nth-child(odd) {
		background-color: <?php echo $getthecolor ?>;
		color:<?php echo $theFontcolor ?>;
	}
#woofavTable tr:nth-child(even) {
	background-color: <?php echo $getevencolor ?>;
	color:<?php echo $theFontevebcolor ?>;
}
	#woofavTable tr td {

border: 1px solid <?php echo $thebordercolor ?>;
}

th.header { 

	border: 1px solid <?php echo $thebordercolor ?>; 

}
th.headerSortUp { 
	background-color: <?php echo $getthecolor ?>; 
}
th.headerSortDown { 
	background-color: <?php echo $getthecolor ?>; 
}
</style>
<?php

	// set the meta_key to the appropriate custom field meta key
global $wpdb;
global $current_user;
$table_name = $wpdb->prefix . 'woofav';
$userid=$current_user->ID;
wp_enqueue_style( 'woocss', get_bloginfo( 'wpurl' ) . woofav__PLUGIN_DIR . '/inc/css/woocss.css');
//get all data from woofav table from user 
$wooResults = $wpdb->get_results( "SELECT * FROM $table_name WHERE userid = $userid", OBJECT );
?>
<h2><?php _e('my Favorite Products','woofavtext') ?></h2>
<table id="woofavTable" >
	<thead> 
		<tr>
			<th ><?php _e('image','woofav') ?></th>
			<th><?php _e('Product','woofav') ?></th>
			<th><?php _e('date','woofav') ?></th>
			<th><?php _e('Woofav/disWoofav','woofav') ?></th>
		</tr>
	</thead> 
	<tbody> 
		<?php 
		foreach($wooResults as $result=>$value ) {
			$product = new WC_Product($value->prdctid);
			$product=$product->post;
			if(isset($product)){			
				$imgProduct = wc_get_product( $value->prdctid );
				
				?>
				<tr>
					<td><?php echo $imgProduct->get_image(); ?></td>
					<td><a href="<?php echo $product->guid ?>"><?php echo $product->post_name ?></a></td>
					<td><?php echo $value->time ?></td>
					<td>
						<?php 
						do_action( 'woocommerce_after_add_to_cart_button',$value->prdctid);
						?>
					</td>
				</tr>
				<?php
			}}
			?>
		</tbody> 
	</table>
	<?php
}
add_shortcode('woofav', 'wooProducts_shortcode');