<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/*interfaces with the classess */
/*user */
interface  wooFav_Login{
	function woofavGetUserID();
}
interface wooSet_metaposts{
	function WFSetImage($post_id,$user_id);
	function WFGetImage();
	function WFUpdateImage($post_id,$user_id);
}
class wooSetMetaPosts implements wooSet_metaposts{
	protected $WooFavImg;
	protected $value;
	protected $results;
	public function WFSetImage($post_id,$user_id){
		if ( is_user_logged_in() ) {
			$post_id=$post_id;
			$userid=$user_id;
			global $wpdb;
			$table_name = $wpdb->prefix . 'woofav';
			$this->results = $wpdb->get_results( "SELECT * FROM $table_name WHERE prdctid = $post_id And  userid = $user_id" , OBJECT );
			if(empty($this->results[0])){
				$this->value=null;
			}
			else{
				$this->value= $this->results[0]->userid;
			}
			$values=new wpwoofav_GetPostData();
			$value=$values->wpwoofavgetdata();
			$woofavicon=$value['woofavicon'];
			if ($woofavicon==False){
				$woofavicon='defaultfavirote';
			}
			if ($this->value==null ) {

				$this->WooFavImg='img/'.$woofavicon.'.png';
			}
			else{
				$this->WooFavImg= 'img/dis'.$woofavicon.'.png';
			}
		}
		return $this;
	}
	/*get image */
	public function WFGetImage(){
		return $this->WooFavImg;
	}
	function WFUpdateImage($post_id,$user_id){
		if ( is_user_logged_in() ) {
			global $wpdb;
			$table_name = $wpdb->prefix . 'woofav';
			$prdctid= $post_id;
			$userid= $user_id;
//insert data to  database
			if ( !isset($this->value) ) {
				$table_name = $wpdb->prefix . 'woofav';
				$wpdb->insert(
					$table_name,
					array(
						'time' => current_time( 'mysql' ),
						'prdctid' => $prdctid,
						'userid' => $userid,
						)
					);
			}
//delete data from database
			else{
				$wpdb->query(
					$wpdb->prepare(
						"
						DELETE FROM $table_name
						WHERE prdctid = %d
						AND userid = %s
						",
						$prdctid, $userid
						)
					);
			}
		}
	}
}
/* get current  user id*/
class woofav_getMetaData implements wooFav_Login {
	protected $GetData=array();
	public function __construct(){
		global $current_user;
		global $product;
		$this->GetData['user']=$current_user->ID;

/*		$this->GetData['prdct']=$product->ID;*/
	}
	public function woofavGetUserID(){
		return $this->GetData;
	}
}
/*do action woofav*/