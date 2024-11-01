/* Make a ajax function for use ajax in site */
jQuery.noConflict();
(function( $ ) {
	$(function() {
		$('.woofave_icon').click(function() {	
			var userid =  $(this).attr('data-user') ;
			var prdctid =  $(this).attr('data-post') ;
			GetNews(userid,prdctid);
		});
		function GetNews(userid,prdctid){
			$.ajax({
				url:ajaxurl,
				type : "POST",
				data : {action: "woofav_ajax",userid:userid,prdctid:prdctid},
				success: function(response) {	
					$('#woofave_icon-'+prdctid).attr('src',response.img);
				}
			});   
		}
    // More code using $ as alias to jQuery
});
})(jQuery);



