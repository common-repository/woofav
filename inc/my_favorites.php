<?php if ( ! defined( 'ABSPATH' ) ) exit; 
function woofav_show_myfavs() {
	?>
	<style type="text/css">
		.ulfav{

		}
		.ulfav li{
			list-style: none;
			text-decoration: none !important;
		}

		.ulfav li a {

			text-decoration: none;
			color: red;
		}
		.ulfav li  img{

		}
		.navigation li a,
		.navigation li a:hover,
		.navigation li.active a,
		.navigation li.disabled {
			color: #fff;
			text-decoration:none;
		}
		.navigation li {
			display: inline;
		}
		.navigation li a,
		.navigation li a:hover,
		.navigation li.active a,
		.navigation li.disabled {
			background-color: #6FB7E9;
			border-radius: 3px;
			cursor: pointer;
			padding: 12px;
			padding: 0.75rem;
		}
		.navigation li a:hover,
		.navigation li.active a {
			background-color: #3C8DC5;
		}


	</style>

	<?php
	$getMetaData=new woofav_getMetaData();
	$woofavGetUserIDdata=$getMetaData->woofavGetUserID();
	$wooUserID=$woofavGetUserIDdata['user'];
	$num_rec_per_page=3;
	$page = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
	$start_from = ($page-1) * $num_rec_per_page;
	$max   = intval( $wp_query->max_num_pages );
	global $wpdb;
	$table_name = $wpdb->prefix . 'woofav';
	$table_posts = $wpdb->prefix . 'posts';
	$results = $wpdb->get_results( "SELECT  p.ID ,p.post_title ,p.guid , p.post_parent
		,u.id ,u.userid ,u.prdctid
		FROM $table_name AS u
		INNER JOIN  $table_posts  AS p
		where u.prdctid=p.ID
		And u.userid = $wooUserID  LIMIT $start_from, $num_rec_per_page"  , OBJECT );
		?>
		<ul class="ulfav">
			<?php
			foreach ($results as $value) {
				?>
				<li>
					<a href="<?php echo $value->guid; ?>">
						<?php 
						$attachment_id=$value->ID;
						$image = wp_get_attachment_image_src( get_post_thumbnail_id( $attachment_id ), 'thumbnail' );
						$img1=$image[0];
						echo $value->post_title;
						?>
					</a><hr/>
					<img src="<?php echo $img1; ?>">
				</li>
				<?php } ?>
			</ul>
			<?php
			if ( is_user_logged_in() ) {
			$pagination = $wpdb->get_results( "SELECT  p.ID ,p.post_title ,p.guid , p.post_parent
				,u.id ,u.userid ,u.prdctid
				FROM $table_name AS u
				INNER JOIN  $table_posts  AS p
				where u.prdctid=p.ID
				/* WHERE value=1 */
				And u.userid = $wooUserID "  , OBJECT );
$path = explode( '/', $_SERVER['REQUEST_URI'] ); // Blow up URI
$currentPage=$path[1];
$total_records=count($pagination);
$total_pages = ceil($total_records / $num_rec_per_page); 
?>
<div class="navigation">
	<li><a href="<?php echo esc_url( home_url( '' ) ).'/'.$currentPage.'/page/1'?>">|<</a></li>
	<?php
	for ($i=1; $i<=$total_pages; $i++) { 
		?>
		<li><a href="<?php echo esc_url( home_url( '' ) ).'/'.$currentPage.'/page/'.$i?>"><?php echo $i ?></a></li>
		<!-- <a href="<?php  echo $i ?>"><?php  echo $i ?></a>  -->
		<?php
	}
	?>
	<li><a href="<?php echo esc_url( home_url( '' ) ).'/'.$currentPage.'/page/'.$total_pages?>"> >| </a></li>

</div>
<?php
}
}
add_shortcode('woo_fav_show', 'woofav_show_myfavs');
