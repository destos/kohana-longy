// Auto-Fill Plugin
// Written by Joe Sak http://www.joesak.com/2008/11/19/a-jquery-function-to-auto-fill-input-fields-and-clear-them-on-click/
(function($){
	$.fn.autofill = function(options){

		var defaults={
			value:'First Name',
			toValue:'',
			defaultTextColor:"#b2adad",
			activeTextColor:"#333"
		};
		
		var options = $.extend(defaults,options);
		
		return this.each(function(){
		
			var obj = $(this);
			obj.css({color:options.defaultTextColor}).val(options.value)
			.focus(function(){
				if(obj.val()==options.value){
					obj.val(options.toValue).css({color:options.activeTextColor});
					}})
			.blur(function(){
				if(obj.val()==options.toValue){
					obj.css({color:options.defaultTextColor}).val(options.value);
				}});
		});
	};
	
})(jQuery);