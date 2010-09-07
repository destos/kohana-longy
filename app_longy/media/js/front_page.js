$(document).ready(function(){
	
		var autofillop = {
		value: 'website url to longyfy',
		toValue: 'http://',
		defaultTextColor: '#777',
		activeTextColor: '#222'
	}
	
	// autofill add url form
	$('input[name=url]').autofill(autofillop);
	
	if( $.browser.msie = true && $.browser.version <= 6 ){
		$("h1").html('You will have to use another web browser, or upgrade your current one to get the full functionality of this website<br/><br/>Sorry for the inconvenience');
		// don't continue
		return false;
	}
	
	$("#add_form").ajaxForm({
		type: "POST",
		dataType: "json",
		beforeSubmit: lockDown,
		success: checkData
/* 		beforeSerialize: adjustUrl */
	});
	
	function lockDown(formData, jqForm, options){
		
		var form = jqForm[0];
				
		if( form.url.value == autofillop.value ){
			alert('please enter a url to longyfy!');
			return false;
		}
		
		return true;
	};
	
	function checkData(data) {
  		
		if(data.success == true){
		
  		// replace html
  		fade_speed = 300;
  		$('.container').fadeOut(fade_speed, function(){
  			$('.box').replaceWith(data.new_html);
  			$('.container').fadeIn(fade_speed)
  		});

		}else{
			alert('please enter a valid url');
		}
  		
  };
  
  // focus select
  $('#success_form textarea').live('click',function(){
  	$(this).select()
  });
	
});