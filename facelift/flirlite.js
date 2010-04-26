/*
Facelift Image Replacement v2.0 beta 3
Facelift was written and is maintained by Cory Mawhorter.  
It is available from http://facelift.mawhorter.net/

===

This file is part of Facelife Image Replacement ("FLIR").

FLIR is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

FLIR is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Facelift Image Replacement.  If not, see <http://www.gnu.org/licenses/>.
*/


_UD_ = 'undefined'; // FLIR undefined value to shrink filesize further
var FLIR = {
	version: '2.0Liteb1'
	
	,options: {
		path: ''

		,defaultStyle:			null

		,onreplacing: 			null
		,onreplaced: 			null
	}

	,dpi: 96
	
	,init: function(options) {
		this.options.defaultStyle = new FLIRStyle();
		if(typeof options != _UD_)
			for(var i in options)
				this.options[i] = options[i];

		this.dpi();
	}
    
	,replace: function(o, F) { // o can be a selector, element, or array of elements
		if(!o || o.flirReplaced) return; // bad element or already replaced
		if(!F || !F.cssMap) // something else/nothing passed, use default
			F = this.options.defaultStyle; // no FStyle specified, use default

		if(typeof o == 'string') return; // not supported in lite

		if(typeof o.length != _UD_) {
			if(o.length == 0) return; // not found
			
			for(var i=0; i< o.length; i++)
				this.replace(o[i], F);
			
			return; // finished replacing list of elements, exit
		}
		
		o.flirStyle = F;
				
		if(typeof FLIR.options.onreplacing == 'function') o = FLIR.options.onreplacing(o, F);
		
		o.innerHTML = o.innerHTML.replace(/^\s+|\s+$/g, '').replace(/<\s*(\w|\/)[^>]+>/g, ''); // prepare text for replacement
		var op = F.options.output;
		if((typeof document.body.style.maxHeight==_UD_) && (o.fPNG6 = (op == 'png' || (op =='auto' && FLIR.style(o, 'background-color')=='transparent')))) // force this method when a transparent png is needed
			FLIR._Rimg(o, F, true);
		else
			FLIR._Rimg(o, F);
		
		if(typeof FLIR.options.onreplaced == 'function') FLIR.options.onreplaced(o, F);
	}
    
	,_Rimg: function(o, F, png6) { // replace text with an image tag, png6 = is transparent png and IE6
		var img = document.createElement('IMG');
		var url = F.URL(o);
		img.alt = o.innerHTML;
		
		img.onerror = function() {
			o.innerHTML = img.alt;
		};
		
		img.className = 'flir-image';
		img.style.border='none';
		
		if(png6) {
			img.src = this.options.path+'spacer.png';
			if(o.offsetWidth) {
				img.style.width=o.offsetWidth+'px';
				img.style.height=o.offsetHeight+'px';
			}
			img.style.filter = 'progid:DXImageTransform.Microsoft.AlphaImageLoader(src="'+url+'", sizingMethod="image")';
		}else {
			img.src = url;
		}
		
		o.innerHTML='';
		o.appendChild(img);
	}

	,style: function(el,prop) {
	  if(el.currentStyle) {
			if(prop.indexOf('-') > -1)
				 prop = prop.split('-')[0]+prop.split('-')[1].substr(0, 1).toUpperCase()+prop.split('-')[1].substr(1);
			var y = el.currentStyle[prop];
	  }else if(window.getComputedStyle) {
			var y = document.defaultView.getComputedStyle(el,'').getPropertyValue(prop);
	  }
	  return y;
	}
    
	,dpi: function() {
		if(screen.logicalXDPI) {
			var dpi = parseInt(screen.logicalXDPI);
		}else {
			var dpicook = document.cookie.match(/<dpi>(\d+)<\/dpi>/);
			if(dpicook) {
				this.dpi = dpicook[1];
				return;
			}
			
			var test = document.createElement('DIV');
			test.style.position='absolute';
			test.style.visibility='hidden';
			test.style.border=test.style.padding=test.style.margin='0';
			test.style.height=test.style.width='1in';
			document.body.appendChild(test);
			
			var dpi = parseInt(test.offsetHeight);
			document.body.removeChild(test);

			var future = new Date();
			future.setDate(new Date().getDate()+365);
			document.cookie = 'dpi=<dpi>'+this.dpi+'</dpi>;expires='+future.toGMTString()+';path=/';
		}
		
		if(dpi > 0)
			this.dpi = dpi;
	}
};


function FLIRStyle(options) {
	// options are sent along with the query string
	this.options = {};
	//these are the default settings for FLIR. If you change a default here, be sure 
	//to also change it in generate.php, otherwise you may run into problems
	this.defaults = {
		 mode: 			'static' // static, wrap, progressive or name of a plugin
		,output:			'auto' // png, gif, auto
		,fixBaseline: 	false
		,hq:				false // use high quality rendering
		,css:				{}
	};
	
	// css vals that get passed and their corresponding value parser
	this.cssMap = {
		 'background-color'	: 'Background'
		,'color'					: 'Color'
		,'font-family'			: 'Font'
		,'font-size'			: 'FontSize'
		,'line-height'       : 'LineHeight'
		,'text-align'			: 'Default'
	};
	
	for(var i in this.defaults) // set defaults
		this.options[i] = this.defaults[i];

	if(options && typeof options.css == 'string')
		options.css = this.pcs(options.css);
		
//	if(typeof this.loadopts == _UD_) console.log(this);
	this.loadopts(options);
}

FLIRStyle.prototype.loadopts = function(options) {
	for(var i in this.cssMap) {
		i = i.replace(/[A-Z]/g, function(w){ // change JS style prop names to regular
			return '-'+w.toLowerCase();
		});
		this.options['css'][i] = options && options.css && typeof options.css[i] != _UD_ ? options.css[i] : null;
	}

	if(typeof options != _UD_) {
		for(var i in options) {
			if(options[i] == null) continue;
			if(typeof this[i] != _UD_) {
				this[i] = options[i];
			}else {
				if(i=='css')
					for(var csi in options[i])
						this.options[i][csi] = options[i][csi];
				else
					this.options[i] = options[i];
			}
		}
	}
};

FLIRStyle.prototype.pcs = function(css) { // parse_css_string
	var p = css.split(';');
	var c = {};
	var v;
	for(var i=0; i < p.length; i++) {
		if(p[i].indexOf(':') < 0) continue;
		v = p[i].split(':');
		c[v[0].replace(/^\s+|\s+$/, '')] = v[1].replace(/^\s+|\s+$/, '');
	}
	
	return cssobj;
};

// generate a url based on an object
FLIRStyle.prototype.URL = function(o, ot) { // [, text]
	var tx = ot?ot:o.innerHTML;
	var t = this.options.css['text-transform'];
	if(t==null)
		t = FLIR.style(o, 'text-transform');
	
	switch(t) {
		case 'capitalize':
			tx = tx.replace(/\w+/g, function(w){
				return w.charAt(0).toUpperCase()+w.substr(1).toLowerCase();
			});
			break;
		case 'lowercase':
			tx = tx.toLowerCase();
			break;
		case 'uppercase':
			tx = tx.toUpperCase().replace(/&[a-z0-9]+;/gi, function(m) { return m.toLowerCase(); }); // keep entities lowercase, numeric don't matter
			break;
	}

	return FLIR.options.path+'generate.php?t='+this.enc(tx, o.fPNG6)+'&h='+o.offsetHeight+'&w='+o.offsetWidth+'&c='+this.fC(o)+'&d='+FLIR.dpi+'&f='+this.ser();
};

FLIRStyle.prototype.enc = function(str, bIE6Png) {  // encodeText
	str = encodeURIComponent(str.replace(/&/g, '{*A}').replace(/\+/g, '{*P}').replace(/\(/g, '{*LP}').replace(/\)/g, '{*RP}')); 
	if(bIE6Png)
		str = escape(str);
	return str;
};

FLIRStyle.prototype.ser = function() { // serialize
	var s = '';
	for(var i in this.options) {
		if(i=='css' || this.options[i] == this.defaults[i]) continue;
		s += ',"'+i+'":"'+this.options[i].toString().replace(/"/g, "'")+'"';
	}
	
	return encodeURIComponent('{'+s.substr(1)+'}');
};

FLIRStyle.prototype.fC = function(o) { // flattenCSS
	var opt = {};
	for(var i in this.options.css)
		opt[i] = this.options.css[i];    
	
	for(var i in this.cssMap)
		this.options.css[i] = this.get(o, i, this.cssMap[i]);
	
	var s='';
	for(var i in this.options.css) {
		if(this.options.css[i] == null || typeof this.options.css[i] == _UD_)
			this.options.css[i] = '';
		s += '|'+encodeURIComponent(this.options.css[i].toString().replace(/|/g, ''));
	}
	
	s = s.substr(1);
	this.options.css = opt;
	
	return s;
};

FLIRStyle.prototype.get = function(o, css_property, flirstyle_name) {
	var func = 'get'+flirstyle_name;
	
	var optprop = this.options.css[css_property];
	var val = !optprop || optprop == null ? FLIR.style(o, css_property) : this.options.css[css_property];
	var ret = typeof this[func] == 'function' ? this[func](o, val) : val;
	return ret == 'normal' || ret == 'none' || ret == 'start' ? '' : ret;
};

FLIRStyle.prototype.getBackground = function(o, val) { 
	return this.getColor(o, val);
};

FLIRStyle.prototype.getFont = function(o, val) { 
    if(val.indexOf(','))
        val = val.split(',')[0];

    return val.replace(/['"]/g, '').toLowerCase();
};

FLIRStyle.prototype.getColor = function(o, val) {
	switch(val) {
		case 'transparent': case 'none': return '';
		default:
			if(val.substr(0, 1)=='#')
				val = val.substr(1);
	
			return val.replace(/['"\(\) ]|rgba?/g, '').toLowerCase();
	}
};

FLIRStyle.prototype.getFontSize = function(o, val) {
	var px = this.getMeasurement(o, val, true);
	var prepx = px;
	// fix this... need to make it detect which property is being retrieved and change the final val based on the setting in.css
	if('*/+-'.indexOf(val[0])>-1) {
		try {
			px = Math.round(   (parseFloat(eval(px.toString().concat(val))))  *10000)/10000;
		}catch(err) { px = 16; }
	}
	
	o.flirFontSize = px;
	return px;
};

FLIRStyle.prototype.getMeasurement = function(o, val, bFontSize) {
	var px,em,prcnt;
	if(val == 'normal' || val == 'none') return '';

	if(val.indexOf('px') > -1) {
		px = Math.round(parseFloat(val));
	}else if(val.indexOf('pt') > -1) {
		var pts = parseFloat(val);
		px = pts/(72/FLIR.dpi);
	}else if((em = (val.indexOf('em') > -1)) || (prcnt = (val.indexOf('%') > -1))) {
		if(!o.flirFontSize) {
			var test = document.createElement('DIV');
			test.style.padding = test.style.border = '0';
			test.style.position='absolute';
			test.style.visibility='hidden';
			if(bFontSize)
				test.style.lineHeight = '100%';
			test.innerHTML = 'FlirTest';        
			o.appendChild(test);
			
			px = test.offsetHeight;
			o.removeChild(test);
		}else {
			px = o.flirFontSize;
		}
	}
	
	return px;
};