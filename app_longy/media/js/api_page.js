$(document).ready(function(){

	$responce = $('<div class="responce">')
	
	// run api queries when clicked.
	$('code a').click(function(){
		
		// check if we where clicked already.
		var clicked = $.data( this , 'clicked');
		
		// don't load again if clicked.
		if( !clicked ){
			var ajax_url = $(this).attr('href');
			
			$responce.clone().eq(0).load(ajax_url).insertAfter(this).hide().fadeIn(500);
			//$(this).filter('.responce');
			
			$.data( this , 'clicked', true );
		}
		
		// don't follow link
		return false;
	});
	
}); 