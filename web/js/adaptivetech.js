
	//FUNCIONES COMUNES
	function callAjaxGet(){
		
	}
	function callAjaxPost(){
		
	}
	
	function effectOk(object, loader){
		object.hide();
		loader.fadeIn(100).delay(400).fadeOut(800);
		object.delay(1300).fadeIn(400);
		
		
	};	
	
	function effectError(panel){
		object.animate({opacity: '0.1',}).animate({ opacity: '2.0'}).animate({ opacity: '1.0'});
	};
	
