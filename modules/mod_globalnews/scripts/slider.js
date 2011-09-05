/*
* @version		$Id: slider.js 2008 vargas $ @package Joomla
*/
var csbustcachevar=0;
var enabletransition=1;
var csloadstatustext="Loading...";
var csexternalfiles=[];
var enablepersist=true;
var slidernodes=new Object();
var csloadedobjects="";

function GN_ContentSlider(sliderid, autorun, nextText, linkMore){
	var slider=document.getElementById(sliderid);
	if (typeof nextText!="undefined" && nextText!="")slider.nextText=nextText;
	if (typeof linkMore!="undefined" && linkMore!="")slider.linkMore=linkMore;
		
	slidernodes[sliderid]=[];
	GN_ContentSlider.loadobjects(csexternalfiles);
	var alldivs=slider.getElementsByTagName("div");
	for (var i=0; i<alldivs.length; i++){
		if (alldivs[i].className=="gn_opacitylayer")
			slider.opacitylayer=alldivs[i];
		else if (alldivs[i].className=="gn_news"){
			slidernodes[sliderid].push(alldivs[i]);
			if (typeof alldivs[i].getAttribute("rel")=="string") 
				GN_ContentSlider.ajaxpage(alldivs[i].getAttribute("rel"), alldivs[i]);
		}
	}
	GN_ContentSlider.buildpagination(sliderid);
	var loadfirstcontent=true;
	if (enablepersist && getCookie(sliderid)!=""){
		var cookieval=getCookie(sliderid).split(":");
		if (document.getElementById(cookieval[0])!=null && typeof slidernodes[sliderid][cookieval[1]]!="undefined"){
			GN_ContentSlider.turnpage(cookieval[0], parseInt(cookieval[1]));
			loadfirstcontent=false;
		}
	}
	if (loadfirstcontent==true)
		GN_ContentSlider.turnpage(sliderid, 0); 
	if (typeof autorun=="number" && autorun>0)
		window[sliderid+"timer"]=setTimeout(function(){GN_ContentSlider.autoturnpage(sliderid, autorun)}, autorun);
}

GN_ContentSlider.buildpagination=function(sliderid){
	var slider=document.getElementById(sliderid);
	var paginatediv=document.getElementById("paginate-"+sliderid);
	var pcontent="";
	for (var i=0; i<slidernodes[sliderid].length; i++)
		pcontent+='<a href="#" onClick=\"GN_ContentSlider.turnpage(\''+sliderid+'\', '+i+'); return false\">'+(i+1)+'</a> ';
	pcontent+='<a href="#" onClick=\"GN_ContentSlider.turnpage(\''+sliderid+'\', parseInt(this.getAttribute(\'rel\'))); return false\">'+(slider.nextText || "")+'</a>';
	if (slider.linkMore)
		pcontent+=slider.linkMore;
	paginatediv.innerHTML=pcontent;
	paginatediv.onclick=function(){
	if (typeof window[sliderid+"timer"]!="undefined")
		clearTimeout(window[sliderid+"timer"]);
	}
}

GN_ContentSlider.turnpage=function(sliderid, thepage){
	var paginatelinks=document.getElementById("paginate-"+sliderid).getElementsByTagName("a"); 
	for (var i=0; i<slidernodes[sliderid].length; i++){
		paginatelinks[i].className="";
		slidernodes[sliderid][i].style.display="none";
	}
	paginatelinks[thepage].className="selected";
	if (enabletransition){
		if (window[sliderid+"fadetimer"])
			clearTimeout(window[sliderid+"fadetimer"]);
		this.setopacity(sliderid, 0.1);
	}
	slidernodes[sliderid][thepage].style.display="block";
	if (enabletransition)
		this.fadeup(sliderid, thepage);
	paginatelinks[slidernodes[sliderid].length].setAttribute("rel", thenextpage=(thepage<slidernodes[sliderid].length-1)? thepage+1 : 0);
	if (enablepersist)
		setCookie(sliderid, sliderid+":"+thepage);
}

GN_ContentSlider.autoturnpage=function(sliderid, autorunperiod){
	var paginatelinks=document.getElementById("paginate-"+sliderid).getElementsByTagName("a");
	var nextpagenumber=parseInt(paginatelinks[slidernodes[sliderid].length].getAttribute("rel")); 
	GN_ContentSlider.turnpage(sliderid, nextpagenumber);
	window[sliderid+"timer"]=setTimeout(function(){GN_ContentSlider.autoturnpage(sliderid, autorunperiod)}, autorunperiod);
}

GN_ContentSlider.setopacity=function(sliderid, value){ 
	var targetobject=document.getElementById(sliderid).opacitylayer || null;
	if (targetobject && targetobject.filters && targetobject.filters[0]){ 
		if (typeof targetobject.filters[0].opacity=="number")
			targetobject.filters[0].opacity=value*100;
		else
			targetobject.style.filter="alpha(opacity="+value*100+")";
		}
	else if (targetobject && typeof targetobject.style.MozOpacity!="undefined")
		targetobject.style.MozOpacity=value;
	else if (targetobject && typeof targetobject.style.opacity!="undefined")
		targetobject.style.opacity=value;
	targetobject.currentopacity=value;
}

GN_ContentSlider.fadeup=function(sliderid){
	var targetobject=document.getElementById(sliderid).opacitylayer || null;
	if (targetobject && targetobject.currentopacity<1){
		this.setopacity(sliderid, targetobject.currentopacity+0.1);
		window[sliderid+"fadetimer"]=setTimeout(function(){GN_ContentSlider.fadeup(sliderid)}, 100);
	}
}

function getCookie(Name){ 
	var re=new RegExp(Name+"=[^;]+", "i"); 
	if (document.cookie.match(re))
		return document.cookie.match(re)[0].split("=")[1];
	return "";
}

function setCookie(name, value){
	document.cookie = name+"="+value;
}

GN_ContentSlider.ajaxpage=function(url, thediv){
	var page_request = false;
	var bustcacheparameter="";
	if (window.XMLHttpRequest)
		page_request = new XMLHttpRequest();
	else if (window.ActiveXObject){
		try {
		page_request = new ActiveXObject("Msxml2.XMLHTTP");
		} 
		catch (e){
		try{
		page_request = new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch (e){}
		}
	}
	else
		return false;
	thediv.innerHTML=csloadstatustext;
	page_request.onreadystatechange=function(){
		GN_ContentSlider.loadpage(page_request, thediv);
	}
	if (csbustcachevar)
		bustcacheparameter=(url.indexOf("?")!=-1)? "&"+new Date().getTime() : "?"+new Date().getTime();
	page_request.open('GET', url+bustcacheparameter, true);
	page_request.send(null);
}

GN_ContentSlider.loadpage=function(page_request, thediv){
	if (page_request.readyState == 4 && (page_request.status==200 || window.location.href.indexOf("http")==-1))
		thediv.innerHTML=page_request.responseText;
}

GN_ContentSlider.loadobjects=function(externalfiles){
	for (var i=0; i<externalfiles.length; i++){
		var file=externalfiles[i];
		var fileref="";
		if (csloadedobjects.indexOf(file)==-1){
			if (file.indexOf(".js")!=-1){
				fileref=document.createElement('script');
				fileref.setAttribute("type","text/javascript");
				fileref.setAttribute("src", file);
			}
			else if (file.indexOf(".css")!=-1){ 
				fileref=document.createElement("link");
				fileref.setAttribute("rel", "stylesheet");
				fileref.setAttribute("type", "text/css");
				fileref.setAttribute("href", file);
			}
		}
		if (fileref!=""){
			document.getElementsByTagName("head").item(0).appendChild(fileref);
			csloadedobjects+=file+" ";
		}
	}
}
