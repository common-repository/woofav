<?php
 if ( ! defined( 'ABSPATH' ) ) exit;
add_action('wp_head','woofav_ajaxurl');
function woofav_ajaxurl() {
?>
<script type="text/javascript">
var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>
<?php
}