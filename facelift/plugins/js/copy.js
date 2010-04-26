// JavaScript Document

var FLIR_Copy = {
	 version: '0.1'
	 
	 ,copyDiv: null
	 ,cmVisible: false
	 
	 ,activeTab: 'text'

	,init: function() {
		this._injectContext();

		if(document.body.addEventListener)
			document.body.addEventListener( 'mouseup', FLIR_Copy.mouseup, false );
		else if (document.body.attachEvent)
			document.body.attachEvent( 'onmouseup', function() { FLIR_Copy.mouseup( window.event ); } );
		
		var ss=document.createElement('link');
		ss.setAttribute('rel', 'stylesheet');
		ss.setAttribute('type', 'text/css');
		ss.setAttribute('href', FLIR.options.path+'js-plugins/copy/styles.css');
		document.getElementsByTagName('head')[0].appendChild(ss);
	}
	
	,_injectContext: function() {
		var div = document.createElement('DIV');
		div.id = 'flircopy-container';
		div.style.position='absolute';
		div.style.display='none';
		div.style.width='400px'; 
		dHTML = '<div id="flircopy-tabs">';
   	dHTML += 	'<a href="javascript:void(0);" onclick="FLIR_Copy.changeTab(0);" class="flircopy-selected">Text</a>';
		dHTML += 	'<a href="javascript:void(0);" onclick="FLIR_Copy.changeTab(1);">HTML</a>';
		dHTML += 	'<a href="javascript:void(0);" onclick="FLIR_Copy.changeTab(2);">HTML Preview</a>';
		dHTML += '</div>';
		dHTML += '<div id="flircopy-body">';
		dHTML += 	'<div id="flircopy-inr">';
		dHTML += 		'<textarea id="flircopy-text" class="flircopy-selected"></textarea>';
		dHTML += 		'<textarea id="flircopy-html"></textarea>';
		dHTML += 		'<iframe id="flircopy-htmlpreview" frameborder="0"></iframe>';
		dHTML += 	'</div>';
		dHTML += '</div>';
		dHTML += '<div id="flircopy-nav"><div id="flircopy-inr">';
		if(window.clipboardData)
			dHTML += 	'<a href="">Copy</a> ';
		dHTML += 	'<a href="javascript:void(0);" onclick="FLIR_Copy.hideCopy(-1);">Cancel</a>';
		dHTML += '</div></div>';
		div.innerHTML = dHTML;

		this.copyDiv = div;
		document.body.appendChild(this.copyDiv);
		
		if(FLIR.isIE) {
			this.copyDiv.onmouseup = function(e) {
				if(!e) e = window.event;
				
				e.cancelBubble=true;
				e.returnValue = false;
	
				if(e.stopPropagation) {
					e.stopPropagation();
					e.preventDefault();
				}
				
				return false;
			}
		}else {
			if(this.copyDiv.addEventListener)
				this.copyDiv.addEventListener( 'mouseup', FLIR_Copy._stop, false );
			else if (this.copyDiv.attachEvent)
				this.copyDiv.attachEvent( 'mouseup', function() { return FLIR_Copy._stop( window.event ); } );	
		}
	}
	
	,changeTab: function(showidx) {
		var tabs = FLIR.getChildren(document.getElementById('flircopy-tabs'));
		var bods = FLIR.getChildren(FLIR.getChildren(document.getElementById('flircopy-body'))[0]);
		
		for(var i=0; i<tabs.length; i++) {
			if(i == showidx)
				tabs[i].className = bods[i].className = 'flircopy-selected';
			else
				tabs[i].className = bods[i].className = '';
		}
	}
	
	,html_entity_decode: function(str) {
		var ta=document.createElement("textarea");
		ta.innerHTML=str.replace(/</g,"&lt;").replace(/>/g,"&gt;");
		return ta.value;
	}
	
	,_stop: function(e) {
		if(!e) e = window.event;
		
		if(e.cancelBubble)
			e.cancelBubble=true;
		if(e.stopPropagation)
			e.stopPropagation();
		
		return false;
	}

	,showCopy: function(x,y,text,html) {
		FLIR_Copy.cmVisible = true;
		FLIR_Copy.changeTab(0);
//		console.log('showing');
//		console.log('here');
		var div = FLIR_Copy.copyDiv;

		div.style.left=x+'px';
		div.style.top=y+'px';
		
		div.style.display = 'block';
		var tb = document.getElementById('flircopy-text');
		var hb = document.getElementById('flircopy-html');
		var pv = document.getElementById('flircopy-htmlpreview');
		
//		console.log(text, html);
		
		if(tb) {
			tb.value = FLIR_Copy.html_entity_decode(text);
			hb.value = FLIR_Copy.html_entity_decode(html);
			pv.contentWindow.document.body.innerHTML = html;
		}
	}
	
	,hideCopy: function(e) {
//		console.log('hiding');
		if(e != -1) {
			var targ = FLIR.evsrc(e);
			var p=targ;
			var ignore = false;
			while(p != document.body) {
				p = p.parentNode;
				
				if(p == FLIR_Copy.copyDiv) {
					ignore = true;
					break;
				}
			}
	
			if(ignore) return;
		}
		
		FLIR_Copy.copyDiv.style.display='none';
		FLIR_Copy.cmVisible = false;
	}
	
	,_mousepos: function(e) {
		var posx = 0;
		var posy = 0;
		if (!e) var e = window.event;
		if (e.pageX || e.pageY) 	{
			posx = e.pageX;
			posy = e.pageY;
		}
		else if (e.clientX || e.clientY) 	{
			posx = e.clientX + document.body.scrollLeft
				+ document.documentElement.scrollLeft;
			posy = e.clientY + document.body.scrollTop
				+ document.documentElement.scrollTop;
		}
		
		return {'x':posx, 'y':posy};
	}
	
	,mouseup: function(e) {
		if(FLIR_Copy.cmVisible) FLIR_Copy.hideCopy(-1);
		
		if (!e) var e = window.event;
		
		var userSelection;
		if (window.getSelection) {
			userSelection = window.getSelection();
		}
		else if (document.selection) { // should come last; Opera!
//			console.log('IE creating range');
			userSelection = document.selection.createRange();
		}
	
		if(typeof userSelection.text != 'undefined') {
		}else if (userSelection.getRangeAt) {
			userSelection = userSelection.getRangeAt(0);
		}else { // Safari!
			var range = document.createRange();
			range.setStart(userSelection.anchorNode,userSelection.anchorOffset);
			range.setEnd(userSelection.focusNode,userSelection.focusOffset);
			userSelection = range;
		}
		
		if(userSelection.startContainer) {
			var n = userSelection.cloneContents() || document.createDocumentFragment();
		}else { // ie
			var n = document.createElement('DIV');
			n.innerHTML = userSelection.htmlText;
		}
		
		if(FLIR_Copy.checkSelectedObjects(n)) {
			var mpos = FLIR_Copy._mousepos(e);
			FLIR_Copy.showCopy(mpos.x, mpos.y, FLIR_Copy.getSelection(), FLIR_Copy.getSelection(true));
		}
	}
	
	,checkSelectedObjects: function(n) {
		var flirObjFound = false;
		if(n.hasChildNodes()) {
			for(var i =0; i < n.childNodes.length; i++) {
				if(FLIR_Copy.checkSelectedObjects(n.childNodes[i])) {
					flirObjFound = true;
				}
				
				if(n.childNodes[i].nodeType == 1 && n.childNodes[i].className.indexOf('flir-replaced')>-1)
					return true;
			}
		}
		
		return flirObjFound;
	}
	
	,getSelection: function(bHTML) {
//		console.log('here');
		var userSelection;
		if (window.getSelection) {
			userSelection = window.getSelection();
		}
		else if (document.selection) { // should come last; Opera!
//			console.log('IE creating range');
			userSelection = document.selection.createRange();
		}
	
		if(typeof userSelection.text != 'undefined') {
		}else if (userSelection.getRangeAt) {
			userSelection = userSelection.getRangeAt(0);
		}else { // Safari!
			var range = document.createRange();
			range.setStart(userSelection.anchorNode,userSelection.anchorOffset);
			range.setEnd(userSelection.focusNode,userSelection.focusOffset);
			userSelection = range;
		}
		
		if(userSelection.startContainer) {
			var n = userSelection.cloneContents() || document.createDocumentFragment();
		}else { // ie
			var n = document.createElement('DIV');
			n.innerHTML = userSelection.htmlText;
		}
		
		if(bHTML) {
			var html = '';
			for(var i=0; i<n.childNodes.length; i++) {
 				html += n.childNodes[i].innerHTML;
			}
			html = html.replace(/<\/?span[^>]*?>/ig, '').replace(/flir[a-z]+=".*?"/ig, '');
			html = html.replace(/<img.*?class=.*?flir-image.*?>/ig, function(m) {
														  		var alt = FLIR.isIE ? m.match(/alt="?(.+?)"?\s+/i) : m.match(/alt="([^"]+)"+/i);
																console.log(alt);
																return alt[1];
														  });
		
			return html;
		}else {
			return FLIR_Copy.getFullText(n);
		}
	}
	
	,getFullText: function(n) {
		var ret = '';
		if(!n) return ret;
		
		if(n.hasChildNodes()) {
			for(var i =0; i < n.childNodes.length; i++) {
				ret += this.getFullText(n.childNodes[i]);
			}
		}else if(n.nodeName == 'IMG') {
			ret += n.alt;
		}else if(n.nodeType == 3) { // text node
			ret += n.data;
		}else if(n.nodeName == 'BR'){
			ret += '\n';
		}
		
		return ret;
	}
	
	,toClipboard: function(copytext) {
		if(window.clipboardData) {
			window.clipboardData.setData('text', copytext);
			return true;
		}
		
		return true;
	}
		
	,toString: function() {
		return '[Copy FLIRPlugin]';
	}
};
FLIR.installPlugin(FLIR_Copy, '1.2.1');
