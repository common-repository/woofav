<?php 
add_action( 'admin_enqueue_scripts', 'woofave_enqueue_color_picker' );
function woofave_enqueue_color_picker( $hook_suffix ) {
    // first check that $hook_suffix is appropriate for your admin page
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'color', woofav__PLUGIN_URL . 'inc/js/color.js' , array( 'wp-color-picker' ), false, true );

}
function woofav_submenu_page_callback(){
	$values=new wpwoofav_GetPostData();
	$value=$values->wpwoofavgetdata();
	/*	var_dump($values);*/
	$getthecolor=$value['thecolor'];
	$getevencolor=$value['evencolor'];
	$thebordercolor=$value['thebordercolor'];
	$theFontcolor=$value['theFontcolor'];
	$theFontevebcolor=$value['theFontevebcolor'];
	$woofavicon=$value['woofavicon'];
/*	$rnd_dates=$value['rnd_dates'];
$rnd_content=$value['rnd_content'];*/
?>
<!-- begin change layout  -->
<style type="text/css">
	
	.misaco {
		background-color: #fff;
		margin: 3px 0;
		padding: 4px;
		box-shadow: 0px 2px 2px #B7B7B7;
		border-radius: 3px;
		text-align: center;
	}
	/*----- Tabs -----*/
	.tabs {
		width:70%;
		display:inline-block;
	}
	@media only screen and (max-width:550px){
		.tabs {
			width:100%;
			display:inline-block;
		}
	}

	/*----- Tab Links -----*/
	/* Clearfix */
	.tab-links:after {
		display:block;
		clear:both;
		content:'';
	}

	.tab-links li {
		margin:0px 5px;
		float:left;
		list-style:none;
	}

	.tab-links a {
		padding:9px 15px;
		display:inline-block;
		border-radius:3px 3px 0px 0px;
		background:#7FB5DA;
		font-size:16px;
		font-weight:600;
		color:#4c4c4c;
		transition:all linear 0.15s;
		text-decoration: none;
	}

	.tab-links a:hover {
		background:#a7cce5;
		text-decoration:none;
	}

	li.active a, li.active a:hover {
		background:#fff;
		color:#4c4c4c;
	}

	/*----- Content of Tabs -----*/
	.tab-content {
		padding:15px;
		border-radius:3px;
		box-shadow:-1px 1px 1px rgba(0,0,0,0.15);
		background:#fff;
	}

	.tab {
		display:none;
	}

	.tab.active {
		display:block;
	}

	select {
		min-height: 150px;
		min-width: 300px;
	}
	.box {
		border: 1px #eee solid;
		padding: 15px;
		margin: 1px 0px;
	}
	.help-box {
		background-color: rgba(6, 216, 6, 0.33);
		padding: 7px;
		margin-bottom: 15px;
	}

</style>

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('.tabs .tab-links a').on('click', function(e)  {
			var currentAttrValue = jQuery(this).attr('href');
        // Show/Hide Tabs
			jQuery('.tabs ' + currentAttrValue).siblings().slideUp(400);
			jQuery('.tabs ' + currentAttrValue).delay(400).slideDown(400);

        // Change/remove current tab to active
			jQuery(this).parent('li').addClass('active').siblings().removeClass('active');

			e.preventDefault();
		});
	});
</script>
<form method="post" action="options.php">
	<?php 
			/* set the wordpress settings to create option page 
			* Do NOt change or remove these lines
			 */
			settings_fields( 'woofav-settings-group' ); 
			do_settings_sections( 'woofav-settings-group' ); 
			?>
			<div class="tabs">
				<ul class="tab-links">
					<li class="active"><a href="#tab1">Color Settings</a></li>
					<li><a href="#tab2">Icon settings</a></li>
					<li><a href="#tab3">Help</a></li>
				</ul>
				<div class="tab-content">
					<div id="tab1" class="tab active">
						<div class="box"> <b>- <?php  _e('Choose the Color for show in woofav','woofav'); ?></b>
							<div>
								<label>Table settings</label>
							</div>
							<h2>Background Color(odd)</h2>
							<?php 
							/*get thecolor in oop in the functions */
							if(isset($getthecolor) && ($getthecolor!=NULL)) { ?>

								<input type="text" name="thecolor" value="<?php echo $getthecolor ?>" class="my-color-field" data-default-color="#effeff" />
								<?php 
							}
							else{
								?>
								<input type="text"  name="thecolor" value="#fff" class="my-color-field" data-default-color="#effeff" />
								<?php
							}
							?>	
							<h2>Font Color(odd)</h2>
							<?php 
							/*get thebordercolor in oop in the functions */
							if(isset($theFontcolor) && ($theFontcolor!=NULL)) { ?>

								<input type="text" name="theFontcolor" value="<?php echo $theFontcolor ?>" class="my-color-field" data-default-color="#effeff" />
								<?php 
							}
							else{
								?>
								<input type="text"  name="theFontcolor" value="#fff" class="my-color-field" data-default-color="#effeff" />
								<?php
							}
							?>	

							<h2>Background Color(even)</h2>
							<?php 
							/*get thecolor in oop in the functions */
							if(isset($getevencolor) && ($getevencolor!=NULL)) { ?>

								<input type="text" name="evencolor" value="<?php echo $getevencolor ?>" class="my-color-field" data-default-color="#effeff" />
								<?php 
							}
							else{
								?>
								<input type="text"  name="evencolor" value="#fff" class="my-color-field" data-default-color="#effeff" />
								<?php
							}
							?>	
							<h2>Font Color(even)</h2>
							<?php 
							/*get thebordercolor in oop in the functions */
							if(isset($theFontevebcolor) && ($theFontevebcolor!=NULL)) { ?>

								<input type="text" name="theFontevebcolor" value="<?php echo $theFontevebcolor ?>" class="my-color-field" data-default-color="#effeff" />
								<?php 
							}
							else{
								?>
								<input type="text"  name="theFontevebcolor" value="#fff" class="my-color-field" data-default-color="#effeff" />
								<?php
							}
							?>	
							<h2>Border Color</h2>
							<?php 
							/*get thebordercolor in oop in the functions */
							if(isset($thebordercolor) && ($thebordercolor!=NULL)) { ?>

								<input type="text" name="thebordercolor" value="<?php echo $thebordercolor ?>" class="my-color-field" data-default-color="#effeff" />
								<?php 
							}
							else{
								?>
								<input type="text"  name="thebordercolor" value="#fff" class="my-color-field" data-default-color="#effeff" />
								<?php
							}
							?>	
						</div></div>
						<div id="tab2" class="tab">
							<div class="well box">
								<div class="help-box">in this section you can choose the icon of favorite</div>
							</div> 
							<div class="box">
								<div> <?php _e('get fav icon', 'woofav'); ?> </div>
								<label for="rnd_number">favicon</label><br/>
								<input type="radio" name="woofavicon" 
								<?php if ($woofavicon=='favstar') {?> checked="checked"<?php }?> value="favstar">
								<img src="<?php echo plugins_url( 'img/favstar.png', __FILE__ ) ?>">
								<img src="<?php echo plugins_url( 'img/disfavstar.png', __FILE__ ) ?>"><br>
								<input type="radio" name="woofavicon"
								<?php if ($woofavicon=='woofav-hert') {?> checked="checked"<?php }?> value="woofav-hert">
								<img src="<?php echo plugins_url( 'img/woofav-hert.png', __FILE__ ) ?>">
								<img src="<?php echo plugins_url( 'img/diswoofav-hert.png', __FILE__ ) ?>"><br>
								<input type="radio" name="woofavicon" 
								<?php if ($woofavicon=='defaultfavirote') {?> checked="checked"<?php }?> value="defaultfavirote"> 
								<img src="<?php echo plugins_url( 'img/defaultfavirote.png', __FILE__ ) ?>">
								<img src="<?php echo plugins_url( 'img/disdefaultfavirote.png', __FILE__ ) ?>"><br>

								<div class="help-box"> Set your Count's post to show </div>
							</div>
						</div>
						<div id="tab3" class="tab">
							<div class="box">
								
								<h4> instruction of using WooFav: </h4>
								<div>
									First of all, make sure that WooCommerce is installed and activated.
									<br>
									When you activate the plugin woofav, a page called woofav be made. Where products can be seen that the user likes.
									<br>
									Like in the Display button on the product before purchase button will be added automatically.
									<br>
									You can go to Settings Woofav button to select your tastes.
								</div>
							</div>
						</div>
					</div>
					<div class="misaco"> 
						Made With Love By <a href="http://misaco.ir" target="__blank"> MiSaCo. </a>
					</div>
				</div>
				<?php submit_button(); ?>
			</form>
			<!-- End change layout  -->
			<?php
		}
