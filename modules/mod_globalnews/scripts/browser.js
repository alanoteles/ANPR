/*
* @version		$Id: browser.js 2008 vargas $ @package Joomla
*/
function GN_Browser(marquee,container,varname,speed){

this.marqueespeed=speed/1000;
this.pauseit=1; //Pause marquee onMousever (0=no. 1=yes)?
this.copyspeed=this.marqueespeed;
this.pausespeed=(this.pauseit==0)? this.copyspeed: 0;
this.delayb4scroll=2000; //Specify initial delay before marquee starts to scroll on page (ms)

this.marquee=marquee;
this.container=container;
this.varname=varname;
this.cross_marquee=document.getElementById(this.marquee);

this.actualheight='';

eval("this.cross_marquee.onmouseover=function(){"+this.varname+".pause();}");
eval("this.cross_marquee.onmouseout=function(){"+this.varname+".play();}");
if (window.addEvent) {
eval("window.addEvent('load',function(){"+this.varname+".initialize()})");
} else if (window.addEventListener) {
eval("window.addEventListener('load',function(){"+this.varname+".initialize()}, false)");
} else if (window.attachEvent) {
eval("window.attachEvent('onload',function(){"+this.varname+".initialize()})");
} else if (document.getElementById){
eval("window.onload=function(){"+this.varname+".initialize()}");
}
}

GN_Browser.prototype.pause=function(){
this.copyspeed=this.pausespeed;
}

GN_Browser.prototype.play=function(){
this.copyspeed=this.marqueespeed;
}

GN_Browser.prototype.scrollmarquee=function(){
if (parseInt(this.cross_marquee.style.top)>(this.actualheight*(-1)+8))
this.cross_marquee.style.top=parseInt(this.cross_marquee.style.top)-this.copyspeed+"px";
else
this.cross_marquee.style.top=parseInt(this.marqueeheight)+8+"px";
}

GN_Browser.prototype.initialize=function(){
this.cross_marquee.style.top=0;
this.marqueeheight=document.getElementById(this.container).offsetHeight;
this.actualheight=this.cross_marquee.offsetHeight;
if (window.opera || navigator.userAgent.indexOf("Netscape/7")!=-1){ //if Opera or Netscape 7x, add scrollbars to scroll and exit
this.cross_marquee.style.height=this.marqueeheight+"px";
this.cross_marquee.style.overflow="scroll";
return;
}
setTimeout('lefttime=setInterval("'+this.varname+'.scrollmarquee();",30)',this.delayb4scroll);
}
