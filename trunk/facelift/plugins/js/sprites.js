/*
FLIR Plugin - Sprites v1.0
*/
// this will generate sprites in fixed dimensions to avoid xhr
// detect the maximum flirFontSize and make that the default space between
var FLIRSprites = {
	 version: '1.0'	
	 
	,injectDIV: false
	 
	,spriteBlocks: []
	,defaults:[]
	,urlCache: []
	
	,init: function() {
		if(this.defaultStyle == null) this.defaultStyle = FLIR.defaultStyle;
	}
	
	,renderSprites: function(FStyle) {
		if(this.spriteBlocks[FStyle] && this.spriteBlocks[FStyle].length > 0) {
			var json = [];
			var maxheight = 0;
			for(var i=0; i< this.spriteBlocks[FStyle].length; i++) {
				if(this.spriteBlocks[FStyle][i].offsetHeight > maxheight)
					maxheight = this.spriteBlocks[FStyle][i].offsetHeight;
				json.push(this.fstyle_serialize(this.spriteBlocks[FStyle][i], this.spriteBlocks[FStyle][i].innerHTML, FStyle));
			}
			maxheight = maxheight + (maxheight*.2);
							
			var url = FLIR.options.path+'generate.php?t=['+json.join(',')+']&c='+this.defaults[FStyle].CSS.join('|')+'&d='+FLIR.dpi+'&f='+encodeURIComponent('{"mode":"sprites","mSH":"'+Math.round(maxheight)+'"}');
	
//			if(url.length>2000)
//				return this._xhr_render(FStyle, json);
			this.urlCache[FStyle] = { url:url };
			
			var wheight = maxheight;
			var hoversprites = [];
			FLIRSprites.urlCache[FStyle].map = [];
			for(var i=0; i < (this.spriteBlocks[FStyle].length*2); i++) {
				FLIRSprites.urlCache[FStyle].map.push([wheight, -1, -1]);
				wheight += maxheight;
			}

			FLIRSprites._position_sprites(FLIRSprites.urlCache[FStyle].url
												, FStyle
												, FLIRSprites.urlCache[FStyle].map); 

			return true;
		}
	}
	
	,_xhr_render: function(FStyle, json) {
		var params = 'sprites=['+json.join(',')+']';
		var url = FLIR.options.path+'generate.php?c='+this.defaults[FStyle].CSS.join('|')+'&d='+FLIR.dpi+'&f='+encodeURIComponent('{"mode":"sprites"}')+'&req='+FStyle;
		this.urlCache[FStyle] = { url:url };

		var xmlhttp=null;
		if(window.XMLHttpRequest)
			xmlhttp=new XMLHttpRequest();
		else if (window.ActiveXObject)
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

		if(xmlhttp!=null) {
			xmlhttp.open('POST', url, true);
			xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xmlhttp.setRequestHeader('Content-length', params.length);
			xmlhttp.setRequestHeader('Connection', 'close');

			xmlhttp.onreadystatechange = function() {
				if(xmlhttp.readyState == 4) {
					FLIRSprites.urlCache[FStyle].map = eval ('(' + xmlhttp.getResponseHeader("X-FLIR-SpriteMap") + ')');

					var img = new Image();
					img.onload = function() { 
						FLIRSprites._position_sprites(FLIRSprites.urlCache[FStyle].url
															, FStyle
															, FLIRSprites.urlCache[FStyle].map); 
					};
					FLIRSprites.urlCache[FStyle].url = img.src = xmlhttp.responseText;//FLIRSprites.urlCache[FStyle].url;
				}
			};
			xmlhttp.send(params);
		}
	}
	
	,_position_sprites: function(url, FStyle, map) {
		var targ;
		for(var i=0; i< this.spriteBlocks[FStyle].length; i++) {
			targ = this.spriteBlocks[FStyle][i];
			
			targ.style.display = 'block';
			targ.oldTextIndent = targ.style.textIndent;
			targ.style.textIndent='-9999px';	

			this._position_background(targ, url, map[i]);
		}	
	}
	
	,_position_background: function(targ, url, map) {
		targ.style.height = map[2]+'px';
		targ.style.background = 'url("'+url.replace(/ /g, '%20').replace(/\(/g, '%28').replace(/\)/g, '%29')+'") no-repeat 0px -'+map[0]+'px';	
	}
	
	,replace: function(args) {
		var o = args[0];
		var FStyle = args[1];

		if(FStyle.options.mode!='sprites') return true;
		FStyle.replaceBackground = true;

		return [o,FStyle];
	}
	
	,replaceBackground: function(args) {
		var o = args[0];
		var FStyle = args[1];
		if(FStyle.options.mode!='sprites') return true;

		var targ;
		if(this.injectDIV) {
			targ = document.createElement('DIV');
			targ.innerHTML = o.innerHTML;
			o.innerHTML = '';
			o.appendChild(targ);
		}else {
			targ = o;
		}
				
		if(!this.spriteBlocks[FStyle])
			this.spriteBlocks[FStyle] = [];
		
		this.spriteBlocks[FStyle].push(targ);

		return false;
	}
	
	,hover: function(args) {
		var on = args[0];
		var hoverTree = args[3];
		var FStyle = hoverTree.flirStyle;
		if(!FStyle || FStyle.options.mode!='sprites') return true;	

		if(this.injectDIV)
			hoverTree = hoverTree.childNodes[0];

		var found=false;
		var idx =0;
		for(var i=0; i<this.spriteBlocks[FStyle].length; i++ ) {
			if(this.spriteBlocks[FStyle][i] == hoverTree) {
				found = this.spriteBlocks[FStyle][i];
				break;
			}
			
			idx++;
		}

		if(!found || this.spriteBlocks[FStyle].length == this.urlCache[FStyle].map.length) { console.log('not found'); return false; }

		var hovidx = this.spriteBlocks[FStyle].length+idx;
		var pos = on ? this.urlCache[FStyle].map[hovidx] : this.urlCache[FStyle].map[idx];
						
		this._position_background(found, this.urlCache[FStyle].url, pos);
		
		return false;
	}
	
	,fstyle_serialize: function(o, text, FStyle) {
		var parts = FStyle.URL(o, text).match(/t=(.*?)&h=\d*&w=\d*&c=(.*?)&d=\d*&f=(.*?)$/i);
		var data = {
			 text: parts[1]
			,css: parts[2].split('|')
			,fstyle: eval('('+unescape(parts[3])+')')
			,fstyle_raw: parts[3]
		};
		
		var urltxt = '';
		if(!this.defaults[FStyle]) {
			this.defaults[FStyle] = {
				 'FStyle': data.fstyle
				,'CSS': data.css
			};

			if(FStyle != FStyle.hoverStyle && FStyle.hoverStyle.options.cColor != null)
				this.defaults[FStyle].FStyle['hC'] = FStyle.hoverStyle.options.cColor;
			
			urltxt = '{"T":"'+data.text+'","F":'+data.fstyle_raw+'}';
		}else {
			var css = '';
			for(var i in data.css) {
				css += '|'
				if(this.defaults[FStyle].CSS != data.css[i])
					css += data.css[i];
			}
			
			urltxt = '{"T":"'+data.text+'","F":'+data.fstyle_raw+',"C":"'+css.substr(1)+'"}';
		}
		
		return urltxt.replace(/"/g, '%22'); // double quotes will cause problems with the generated CSS
	}
	
	,toString: function() {
		return '[Sprites FLIRPlugin]';
	}
};
FLIR.install(FLIRSprites);