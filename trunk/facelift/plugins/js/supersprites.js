// JavaScript Document
// this will use an xhr request to generate sprites

var FLIRSprites = {
	
	
	,replace: function(obj, FStyle) {
		
	}
	
	,render: function() {
		var params = '';
		xhr.open('POST', FLIR.options.path+'generate.php?f={"mode":"sprites"}', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.setRequestHeader('Content-length', params);
		xhr.setRequestHeader('Connection', 'close');
		
		xmlhttp.onreadystatechange = function() {
			if(xmlhttp.readyState == 4) {
				FLIR_Sprites.urlCache[FStyle].map = eval ('(' + xmlhttp.getResponseHeader("X-FLIR-SpriteMap") + ')');
				
				var img = new Image();
				img.onload = function() { 
					FLIR_Sprites._position_sprites(FLIR_Sprites.urlCache[FStyle].url
														, FStyle
														, FLIR_Sprites.urlCache[FStyle].map); 
				};
				img.src = FLIR_Sprites.urlCache[FStyle].url;
			}
		};	
		
		xhr.send(params);
	}
};

