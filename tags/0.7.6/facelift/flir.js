// JavaScript Document

/*
Facelift Image Replacement v1.2 beta 3
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
along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
*/

var FLIR = {
	version: '1.2 beta3'
	
	,path: ''
	,classnameIgnore: false
	,replaceLinks: true
	
	,findEmbededFonts: false
	,embededFonts: {}

	,flirElements: []
	
	,isCraptastic: true
	,isIE: true

	,defaultStyle: null
	,classStyles: {}
	
	,ignoredElements: 'BR,HR,IMG,INPUT,SELECT'
	
	,checkImageSupport: false
	,imagesDisabled: null
	
	,callQueue: []
	,dpi: 96
	
	// either (options Object, fstyle FLIRStyle Object) or (fstyle FLIRStyle Object)
	,init: function(options, fstyle) { // or options for flir style
		if(this.isFStyle(options)) { // (fstyle FLIRStyle Object)
			this.defaultStyle = options;
		}else { // [options Object, fstyle FLIRStyle Object]
			if(typeof options != 'undefined')
				this.loadOptions(options);
		
			if(typeof fstyle == 'undefined') {
				this.defaultStyle = new FLIRStyle();
			}else {
				if(this.isFStyle(fstyle))
					this.defaultStyle = fstyle;
				else
					this.defaultStyle = new FLIRStyle(fstyle);
			}
		}
	
		if(this.checkImageSupport)
			DetectImageState.init(this.path+'generate.php', this._detection_complete);
		else
			this.imagesDisabled = false;
			
		this.calcDPI();
			
		if(this.findEmbededFonts)
			this.discoverEmbededFonts();
		
		this.isIE = (navigator.userAgent.toLowerCase().indexOf('msie')>-1 && navigator.userAgent.toLowerCase().indexOf('opera')<0);
		this.isCraptastic = (typeof document.body.style.maxHeight=='undefined');
		
		if(this.isIE) {
			this.flirIERepObj = [];
			this.flirIEHovEls = [];
			this.flirIEHovStyles = [];	
		}
	}
	
	,loadOptions: function(options) {
		for(var i in options)
			if(typeof this[i] != 'function')
				this[i] = options[i];
	}
	
	,_add_to_queue: function(fn,args) {
		FLIR.callQueue.push([fn,args]);
	}
	
	,_detection_complete: function(disabled) {
		FLIR.imagesDisabled = disabled;
		
		if(FLIR.callQueue.length > 0) {
			for(var i=0; i< FLIR.callQueue.length; i++) {
				switch(FLIR.callQueue[i][1].length) {
					case 0:
						FLIR[FLIR.callQueue[i][0]]();
						break;
					case 1:
						FLIR[FLIR.callQueue[i][0]](FLIR.callQueue[i][1][0]);
						break;
					case 2:
						FLIR[FLIR.callQueue[i][0]](FLIR.callQueue[i][1][0], FLIR.callQueue[i][1][1]);
						break;
				}
			}
		}
				
	}
	
	
	
	,auto: function(els) {
		if(FLIR.imagesDisabled == null)
			return this._add_to_queue('auto', arguments);
		else if (FLIR.imagesDisabled)
			return;

		var tags = typeof els=='undefined'?['h1','h2','h3','h4','h5']:(els.indexOf && els.indexOf(',')>-1?els.split(','):els);
		var elements;
		for(var i=0; i<tags.length; i++) {
			elements = this.getElements(tags[i]);			
			if(elements.length>0)
				this.replace(elements);
		}
	}
	
	
	,hover: function(e) {
		var o=FLIR.evsrc(e);
		var targ=o;
		var targDescHover = o.flirHasHover;
		var hoverTree = o;

		var on = (e.type == 'mouseover');
		
		while(o != document.body && !o.flirMainObj) {
			o = FLIR.getParentNode(o);
			
			if(!targDescHover) {
					targDescHover = o.flirHasHover;
					hoverTree = o;
			}
		}
		
		if(o==document.body) return;
		
		var FStyle = FLIR.getFStyle(o);
		if(on && FStyle != FStyle.hoverStyle)
			FStyle = FStyle.hoverStyle;
		
		var objs = FLIR.getChildren(hoverTree);
		if(objs.length == 0 || (objs.length == 1 && (objs[0].flirImage || objs[0].flirHasHover))) {
			objs = [hoverTree];
		}else if(objs.length == 1 && !FLIR.isIgnoredElement(objs[0])) {
			var subobjs = FLIR.getChildren(objs[0]);
			if(subobjs.length > 0)
				if((subobjs.length==1 && !subobjs[0].flirImage) || subobjs.length > 1)
					objs = subobjs;
		}

		var rep_obj;
		for(var i=0; i < objs.length; i++) {
			rep_obj = objs[i];
			if(rep_obj.nodeName == 'IMG') continue;
			if(!rep_obj.innerHTML) continue; // IE 

			if(FLIR.isIE) {
				var idx = FLIR.flirIEHovEls.length;
				FLIR.flirIERepObj[idx] = rep_obj;
				FLIR.flirIEHovStyles[idx] = FStyle;
				
				if(!FLIR.isCraptastic) {
					if(FStyle.useBackgroundMethod && FLIR.getStyle(rep_obj, 'display') == 'block') {
						FLIR.flirIEHovEls[idx] = rep_obj;
						rep_obj.style.background='url('+(on?FStyle.generateURL(rep_obj):rep_obj.flirOrig)+') no-repeat';
						setTimeout('FLIR.flirIERepObj['+idx+'].style.background = "url("+('+on+' ? FLIR.flirIEHovStyles['+idx+'].generateURL(FLIR.flirIERepObj['+idx+']) : FLIR.flirIERepObj['+idx+'].flirOrig)+") no-repeat";', 0);
					}else {
						FLIR.flirIEHovEls[idx] = rep_obj.flirImage ? rep_obj : FLIR.getChildren(rep_obj)[0];
						setTimeout('FLIR.flirIEHovEls['+idx+'].src = '+on+' ? FLIR.flirIEHovStyles['+idx+'].generateURL(FLIR.flirIERepObj['+idx+'], FLIR.flirIEHovEls['+idx+'].alt) : FLIR.flirIERepObj['+idx+'].flirOrig;', 0);
					}
				}else {
					FLIR.flirIEHovEls[idx] = rep_obj.flirImage ? rep_obj : FLIR.getChildren(rep_obj)[0];
					setTimeout('  FLIR.flirIEHovEls['+idx+'].style.filter = \'progid:DXImageTransform.Microsoft.AlphaImageLoader(src="\'+FLIR.flirIEHovStyles['+idx+'].generateURL(FLIR.flirIERepObj['+idx+'], FLIR.flirIEHovEls['+idx+'].alt)+\'", sizingMethod="image")\';  ', 0);
				}
			}else {
				if(FStyle.useBackgroundMethod && FLIR.getStyle(rep_obj, 'display') == 'block') {
					rep_obj.style.background='url('+(on?FStyle.generateURL(rep_obj):rep_obj.flirOrig)+') no-repeat';
				}else {
					var img = rep_obj.flirImage ? rep_obj : FLIR.getChildren(rep_obj)[0];
					img.src = on?FStyle.generateURL(rep_obj, img.alt):rep_obj.flirOrig;
				}
			}
		}
	}

	,addHover: function(obj) {
		obj.flirHasHover = true;
		
		if(obj.addEventListener) {
			obj.addEventListener( 'mouseover', FLIR.hover, false );
			obj.addEventListener( 'mouseout', FLIR.hover, false );
		}else if (obj.attachEvent) {
			obj.attachEvent( 'onmouseover', function() { FLIR.hover( window.event ); } );
			obj.attachEvent( 'onmouseout', function() { FLIR.hover( window.event ); } );
		}
	}
	
	,replace: function(o, fstyle) {
		if(FLIR.imagesDisabled == null)
			return this._add_to_queue('replace', arguments);
		else if (FLIR.imagesDisabled)
			return;
			
		var FStyle = this.isFStyle(fstyle) ? fstyle : this.getFStyle(o, fstyle);

		if(typeof o == 'string')
			o = this.getElements(o);
		
		if(typeof o.length != 'undefined') {
			if(o.length == 0) return;
			
			for(var i=0; i< o.length; i++)
				this.replace(o[i], FStyle);
			
			return;
		}
		
		o.flirMainObj = true;
		this.setFStyle(o, FStyle);
		
		if(this.findEmbededFonts && typeof this.embededFonts[FStyle.getFont(o)] != 'undefined')
			return;
		
		if(FStyle != FStyle.hoverStyle && !o.flirHasHover)
			FLIR.addHover(o);

		var objs = FLIR.getChildren(o);
		if(objs.length == 0) {
			objs = [o];
		}else if(objs.length == 1 && !this.isIgnoredElement(objs[0])) {
			// only add a hover to the link if the parent didn't get one
			if(objs[0].nodeName=='A' && !o.flirHasHover && !objs[0].flirHasHover)
				FLIR.addHover(objs[0]);
			
			var subobjs = FLIR.getChildren(objs[0]);
			if(subobjs.length > 0)
				objs = subobjs;
		}else {
			var nobjs = [];
			for(var i=0; i<objs.length; i++) {
				if(this.isIgnoredElement(objs[i])) continue;
				nobjs.push(objs[i]);
			}
			
			if(nobjs.length==0)
				objs = [o];
		}
		
		var rep_obj;
		for(var i=0; i < objs.length; i++) {
			rep_obj = objs[i];

			if(rep_obj.nodeName == 'IMG' || (FLIR.getChildren(rep_obj).length==1 && FLIR.getChildren(rep_obj)[0].nodeName == 'IMG')) continue;
			if(!rep_obj.innerHTML) continue; // IE

			if(FLIR.hasClass(rep_obj, 'flir-replaced')) continue;
			
			if(rep_obj.nodeName == 'A' && !rep_obj.flirHasHover)
				FLIR.addHover(rep_obj);

			if(!this.isCraptastic)
				if(FStyle.useBackgroundMethod && this.getStyle(rep_obj, 'display') == 'block')
					this.replaceMethodBackground(rep_obj, FStyle);
				else
					this.replaceMethodOverlay(rep_obj, FStyle);
			else
				this.replaceMethodCraptastic(rep_obj, FStyle);
			
			rep_obj.className += ' flir-replaced';
		}
	}
	
	,replaceMethodBackground: function(o, FStyle) {
		var oid = this.saveObject(o);
		var url = FStyle.generateURL(o);
		
		var tmp = new Image();
		tmp.onload = function() {
			FLIR.flirElements[oid].style.width=this.width+'px';
			FLIR.flirElements[oid].style.height=this.height+'px';
		};
		tmp.src = url;
		
		o.style.background = 'url('+url.replace(/ /g, '%20')+') no-repeat';
		o.flirOrig = url;
		
		o.oldTextIndent = o.style.textIndent;
		o.style.textIndent='-9999px';
		
		if(FStyle != FStyle.hoverStyle) {
			var h_img = new Image();
			h_img.src = FStyle.hoverStyle.generateURL(o, img.alt);
		}
	}

	,replaceMethodOverlay: function(o, FStyle) {
		var oid = this.saveObject(o);
		var img = document.createElement('IMG');

		img.flirImage = true;
		img.alt = this.sanitizeHTML(o.innerHTML);
		img.src = FStyle.generateURL(o);
		img.style.border='none';
		
		o.flirOrig = img.src;
		o.innerHTML='';
		o.appendChild(img);
		
		if(FStyle != FStyle.hoverStyle) {
			var h_img = new Image();
			h_img.src = FStyle.hoverStyle.generateURL(o, img.alt);
		}
	}

	,replaceMethodCraptastic: function(o, FStyle) {
		var oid = this.saveObject(o);
		var url = FStyle.generateURL(o);
		
		var img = document.createElement('IMG');

		img.flirImage = true;
		img.alt = this.sanitizeHTML(o.innerHTML);		
		img.src = this.path+'spacer.png';
		img.style.width=o.offsetWidth+'px';
		img.style.height=o.offsetHeight+'px';
		img.style.filter = 'progid:DXImageTransform.Microsoft.AlphaImageLoader(src="'+url+'", sizingMethod="image")';

		o.flirOrig = url;
		o.innerHTML='';
		o.appendChild(img);
		
		if(FStyle != FStyle.hoverStyle) {
			var h_img = new Image();
			h_img.src = FStyle.hoverStyle.generateURL(o, img.alt);
		}
	}

	,saveObject: function(o) {
		if(typeof o.flirId == 'undefined') {
			o.flirId = this.getUID();
			this.flirElements[o.flirId] = o;
		}
		
		return o.flirId;
	}
	
	,getUID: function() {
		var prefix='flir-';
		var id=prefix+Math.random().toString().split('.')[1];
		var i=0;
		while(typeof this.flirElements[id] != 'undefined') {
			if(i>100000) {
				console.error('Facelift: Unable to generate unique id.');	
			}
			id=prefix+Math.random().toString().split('.')[1];
			i++;
		}
		
		return id;
	}
	
	,getElements: function(tag) {
		var found = [];
		var objs,subels,cn,childs,tag,el,matches,subel,rep_el;
	
		el = tag;
		
		subel=false;
		if(el.indexOf(' ')>-1) {
			var parts = el.split(' ');
			el = parts[0];
			subel = parts[1];
		}
		
		var grain_id=false;
		if(el.indexOf('#') > -1) {
			grain_id = el.split('#')[1];
			tag = el.split('#')[0];
		}

		var grain_cn=false;
		if(el.indexOf('.') > -1) {
			grain_cn = el.split('.')[1];
			tag = el.split('.')[0];
		}

		objs = document.getElementsByTagName(tag);
		for(var p=0; p<objs.length; p++) {
			if(objs[p].nodeType != 1) continue;
			matches = false;
			cn = objs[p].className?objs[p].className:'';
			
			if(grain_id && objs[p].id && objs[p].id == grain_id)
				matches=true;
			if(grain_cn && FLIR.hasClass(objs[p], grain_cn))
				matches=true;
			if(!grain_id && !grain_cn)
				matches=true;
			
			if(!matches) continue;
			if(this.classnameIgnore && cn.indexOf(this.classnameIgnore)>-1) continue;
			
			subels = false != subel ? objs[p].getElementsByTagName(subel) : [objs[p]];
			for(var pp=0; pp<subels.length; pp++) {
				rep_el = subels[pp];
				if(this.classnameIgnore && rep_el.className && rep_el.className.indexOf(this.classnameIgnore)>-1) continue;

				if(!this.replaceLinks) {
					childs = this.getChildren(rep_el);
					// skip any links that have a first child that is a link (assuming all text for that element is a link then)
					if(childs.length>0 && childs[0].nodeName=='A') continue; 
					
					// if direct parent is a link then skip (assuming entire header is a link);
					if(this.getParentNode(rep_el).nodeName=='A') continue;
				}
				
				found.push(rep_el);
			}
		}
		
		return found;
	}
	
	,discoverEmbededFonts: function() {
		this.embededFonts = {};
		for(var i in document.styleSheets) {
			if(!document.styleSheets[i].cssRules) continue;
			for(var ii in document.styleSheets[i].cssRules) {
				if(!document.styleSheets[0].cssRules[ii]) continue;
				var node = document.styleSheets[0].cssRules[ii];
				
				if(node.type && node.type == node.FONT_FACE_RULE) {
					var nodesrc = node.style.getPropertyValue('src').match(/url\("?([^"\)]+\.[ot]tf)"?\)/i)[1];
					var font = node.style.getPropertyValue('font-family');
					if(font.indexOf(',')) {
						font = font.split(',')[0];
					}
				
					font = font.replace(/['"]/g, '').toLowerCase();
					
					if(font!='' && nodesrc != '')
						this.embededFonts[font] = nodesrc;
				}
			}
		}	
	}

	,getStyle: function(el,prop) {
		if(el.currentStyle) {
			if(prop.indexOf('-') > -1)
				prop = prop.split('-')[0]+prop.split('-')[1].substr(0, 1).toUpperCase()+prop.split('-')[1].substr(1);
			var y = el.currentStyle[prop];
		}else if(window.getComputedStyle) {
			var y = document.defaultView.getComputedStyle(el,'').getPropertyValue(prop);
		}
		return y;
	}
		
	,getChildren: function(n) {
		var children=[];
		if(n && n.hasChildNodes())
			for(var i in n.childNodes)
				if(n.childNodes[i] && n.childNodes[i].nodeType == 1)
					children[children.length]=n.childNodes[i];
	
		return children;
	}
	
	,getParentNode: function(n) {
		var o=n.parentNode;
		while(o != document && o.nodeType != 1)
			o=o.parentNode;
	
		return o;
	}
	
	,hasClass: function(o, cn) {
		return (o && o.className && o.className.indexOf(cn)>-1);
	}
	
	,evsrc: function(e) {
		var o;
		if (e.target) o = e.target;
		else if (e.srcElement) o = e.srcElement;
		if (o.nodeType == 3) // defeat Safari bug
			o = o.parentNode;	
			
		return o;
	}
	
	,calcDPI: function() {
		if(screen.logicalXDPI) {
			var dpi = screen.logicalXDPI;
		}else {
			var id = 'flir-dpi-div-test';
			if(document.getElementById(id)) {
				var test = document.getElementById(id);
			}else {
				var test = document.createElement('DIV');
				test.id = id;
				test.style.position='absolute';
				test.style.visibility='hidden';
				test.style.border=test.style.padding=test.style.margin='0';
				test.style.left=test.style.top='-1000px';
				test.style.height=test.style.width='1in';
				document.body.appendChild(test);
			}
			
			var dpi = test.offsetHeight;
		}
		
		this.dpi = parseInt(dpi);
	}
	
	,isIgnoredElement: function(el) { return (this.ignoredElements.indexOf(el.nodeName)>-1); }
	,sanitizeHTML: function(html) { return html.replace(/<[^>]+>/g, ''); }
	
	,getFStyle: function(o, fstyle) { 
		var cStyle = this.getClassStyle(o);
		if(this.isFStyle(cStyle))
			fstyle = cStyle;

		if(this.isFStyle(fstyle)) {
			return fstyle;
		}else if(this.isFStyle(o.FLIRStyleObj)) {
			return o.FLIRStyleObj;
		}else {
			return this.defaultStyle;
		}
	}
	,setFStyle: function(o, FStyle) { o.FLIRStyleObj = FStyle; }
	,isFStyle: function(o) { return (typeof o != 'undefined' && o.toString() == 'FLIRStyle Object'); }

	,addClassStyle: function(classname, FStyle) {
		if(this.isFStyle(FStyle))
			this.classStyles[classname] = FStyle;
	}
	,getClassStyle: function(o) {
		var cn = o.className;
		if(this.classStyles.length == 0 || typeof cn == 'undefined' || cn=='') return false;
		
		var classes = cn.split(' ');
		for(var i in this.classStyles) {
			for(var ii=0; ii<classes.length; ii++) {
				if(classes[ii]==i) {
					return this.classStyles[i];
				}
			}
		}
		
		return false;
	}
};












function FLIRStyle(options) {
	this.useBackgroundMethod 	= false;
	this.hoverStyle 				= (arguments[1] && FLIR.isFStyle(arguments[1])) ? arguments[1] : this;
		
	this.options = {
		 mode: '' // none (''), wrap,progressive or name of a plugin
		
		,cSize: null
		,cColor: null
		,cFont: null // font-family
		,cAlign: null
		,cTransform: null //text-transform
		,cLine: null //text-transform
		,cSpacing: null //letter-spacing (don't get too excited, read docs)
		,cOpacity: null 
		
		,realFontHeight: false
		,dpi: FLIR.dpi
	};
	

	for(var i in options) {
		if(i.indexOf('css')==0)
			i = 'c'+i.substr(3);

		switch(i) {
			case 'inheritStyle': break; // deprecated
			case 'useBackgroundMethod':
				this.useBackgroundMethod = options[i];
				break;
			default:
				this.options[i] = options[i];
		}
	}
}

// generate a url based on an object
FLIRStyle.prototype.generateURL = function(o) { // [, text]
	var enc_text = (arguments[1]?arguments[1]:o.innerHTML);

	var transform = this.options.cTransform;
	if(transform==null)
		transform = FLIR.getStyle(o, 'text-transform');
		
	switch(transform) {
		case 'capitalize':
			enc_text = enc_text.replace(/\w+/g, function(w){
								  return w.charAt(0).toUpperCase() + w.substr(1).toLowerCase();
							 });
			break;
		case 'lowercase':
			enc_text = enc_text.toLowerCase();
			break;
		case 'uppercase':
			enc_text = enc_text.toUpperCase().replace(/&[a-z0-9]+;/gi, function(m) { return m.toLowerCase(); }); // keep entities lowercase, numeric don't matter
			break;
	}
	
	enc_text = escape(enc_text.replace(/&/g, '{amp}').replace(/\+/g, '{plus}'));

	return FLIR.path+'generate.php?text='+enc_text+'&h='+o.offsetHeight+'&w='+o.offsetWidth+'&fstyle='+this.serialize(o);
};

// create custom url
FLIRStyle.prototype.buildURL = function(text, o) {
	var enc_text = escape(text.replace(/&/g, '{amp}').replace(/\+/g, '{plus}'));
	return FLIR.path+'generate.php?text='+enc_text+'&h=800&w=800&fstyle='+this.serialize(o);
};

FLIRStyle.prototype.serialize = function(o, bDontEncode) {
	var sdata='';
	
	var options = this.copyObject(this.options);
	if(this.options.cColor==null)
		this.options.cColor = this.getColor(o);
	if(this.options.cSize==null)
		this.options.cSize = this.getFontSize(o);
	if(this.options.cFont==null)
		this.options.cFont = this.getFont(o);
	if(this.options.cAlign==null)
		this.options.cAlign = FLIR.getStyle(o, 'text-align');
	if(this.options.cTransform==null)
		this.options.cTransform = FLIR.getStyle(o, 'text-transform');
	if(this.options.cSpacing==null)
		this.options.cSpacing = this.getSpacing(o);
	if(this.options.cLine==null)
		this.options.cLine= this.getLineHeight(o);
	if(this.options.cOpacity==null)
		this.options.cOpacity= FLIR.getStyle(o, 'opacity');

	for(var i in this.options) {
		if(this.options[i] == 'NaN' || typeof this.options[i] == 'undefined') { 
			this.options[i] = '';
		}
		sdata += ',"'+i+'":"'+this.options[i].toString().replace(/"/g, '"')+'"';
	}
	sdata = '{'+sdata.substr(1)+'}';

	this.options = options;

	return bDontEncode?sdata:escape(sdata);
};

FLIRStyle.prototype.getFont = function(o) { 
	var font = FLIR.getStyle(o, 'font-family');
	if(font.indexOf(',')) {
		font = font.split(',')[0];
	}

	return font.replace(/['"]/g, '').toLowerCase();
};

FLIRStyle.prototype.getColor = function(o) { 
	var color = FLIR.getStyle(o, 'color');
	if(color.substr(0, 1)=='#')
		color = color.substr(1);
	
	return color.replace(/['"]/g, '').toLowerCase();
};

FLIRStyle.prototype.getFontSize = function(o) {
	var raw = FLIR.getStyle(o, 'font-size');

	var pix;
	if(raw.indexOf('px') > -1) {
		pix = Math.round(parseFloat(raw));
	}else {
		if(raw.indexOf('pt') > -1) {
			var pts = parseFloat(raw);
			pix = pts/(72/this.dpi);
		}else if(raw.indexOf('em') > -1 || raw.indexOf('%') > -1) {
			pix = this.calcFontSize(o);
		}
	}

	return pix;
};

FLIRStyle.prototype.getSpacing = function(o) {
	var spacing = FLIR.getStyle(o, 'letter-spacing');
	if(spacing != 'normal') {
		if(spacing.indexOf('em') > -1) {
			var fontsize = this.getFontSize(o);
			return (parseFloat(spacing)*fontsize);
		}else if(spacing.indexOf('px') > -1) {
			return parseInt(spacing);
		}else if(spacing.indexOf('pt') > -1) {
			var pts = parseFloat(spacing);
			return pts/(72/this.dpi);			
		}
	}

	return '';	
};

FLIRStyle.prototype.getLineHeight = function(o) {
	var spacing = FLIR.getStyle(o, 'line-height');
	var fontsize = this.getFontSize(o);
	if(spacing.indexOf('em') > -1) {
		return (parseFloat(spacing)*fontsize)/fontsize;
	}else if(spacing.indexOf('px') > -1) {
		return parseInt(spacing)/fontsize;
	}else if(spacing.indexOf('pt') > -1) {
		var pts = parseFloat(spacing);
		return pts/(72/this.dpi)/fontsize;
	}else if(spacing.indexOf('%') > -1) {
		return 1.0;	
	}else {
		return parseFloat(spacing);
	}
};

FLIRStyle.prototype.calcFontSize = function(o) {
		var test = document.createElement('DIV');
		test.style.border = '0';
		test.style.padding = '0';
		test.style.position='absolute';
		test.style.visibility='hidden';
		test.style.left=test.style.top='-1000px';
		test.style.left=test.style.top='10px';
		test.style.lineHeight = '100%';
		test.innerHTML = 'Flir_Test';		
		o.appendChild(test);
		
		var size = test.offsetHeight;
		o.removeChild(test);

		return size;
};


FLIRStyle.prototype.copyObject = function(obj) { 
	var copy = {};
	for(var i in obj) {
		copy[i] = obj[i];	
	}
	
	return copy;
};

FLIRStyle.prototype.toString = function() { return 'FLIRStyle Object'; };






var DetectImageState = {
	 version: '1.0'
	,imagesDisabled: true
	,inserted_id: 'detectimagestate-test-img'
	,callback: function() { }
	,ie_detectionComplete: false
	,img: null
	,ie_Timeout: 100
	
	,init: function(testerimg, cb) {
		this.callback = cb;

		document.body.innerHTML += '<img id="'+this.inserted_id+'" src="'+testerimg+'?'+Math.random()+'" style="visibility:hidden; position:absolute;left:-1000px;" />';
		this.img = document.getElementById(this.inserted_id);
		
		if(window.opera || navigator.userAgent.toLowerCase().indexOf('opera')>-1) {
			var pre = this.img.complete;
			this.img.src = 'about:blank';
			this.imagesDisabled = (!pre && this.img.complete) ? false : true;
			DetectImageState.callback(this.imagesDisabled);
			return;
		}else if(typeof this.img.readyState != 'undefined') {
			this.img.src = this.img.src+'?'+Math.random();
			this.img.onabort = function() {
				DetectImageState.ie_detectionComplete = true;
				DetectImageState.imagesDisabled = false;
				DetectImageState.callback(DetectImageState.imagesDisabled);
			};
		
			setTimeout('if(!DetectImageState.ie_detectionComplete) DetectImageState.callback(DetectImageState.imagesDisabled);', this.ie_Timeout);
			return;
		}else {
			this.imagesDisabled = this.img.complete;
			DetectImageState.callback(this.imagesDisabled);
			return;
		}
	}
};