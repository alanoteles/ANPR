
/**
 * @version		2.0
 * @package		mod_cn_youtubefeed
 * @author    	Caleb Nance
 * @copyright	Copyright (c) 2009 - 2010 CalebNance.com. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

var stor = -1;
var timeout = 3500;

function autorot() {
	showNext();
	/*time = setTimeout("showNext()",5000);*/
	time = setTimeout('autorot();', timeout);
}

function rotateDiv(stor){
  var divs = document.getElementById("youtubeContainer").getElementsByTagName("div");
  for (var i=0; i < divs.length; i++ ) {
    var div = divs[i];
    if ( (div.id != "")) {
	if(i != stor){
        	div.style.display = "none";
	}
	else{
		div.style.display = "block";
	}
    }
  }
}

function showNext(){
	if(stor < maxstor)
		stor++;
	else
		stor=0;

	rotateDiv(stor);
}

function showNext(){
	if(stor < maxstor)
		stor++;
	else
		stor=0;

	rotateDiv(stor);
}

function stoprot() {
	clearTimeout(time);
}


function showNext(){
	if(stor < maxstor)
		stor++;
	else
		stor=0;

	rotateDiv(stor);
}

function showPrev(){
	if(stor > 0)
		stor--;
	else
		stor=maxstor;

	rotateDiv(stor);
}

function showYouTube1(){
	stor=0;
	rotateDiv(stor);
}
function showYouTube2(){
	stor=1;
	rotateDiv(stor);
}
function showYouTube3(){
	stor=2;
	rotateDiv(stor);
}
function showYouTube4(){
	stor=3;
	rotateDiv(stor);
}
function showYouTube5(){
	stor=4;
	rotateDiv(stor);
}
function showYouTube6(){
	stor=5;
	rotateDiv(stor);
}
function showYouTube7(){
	stor=6;
	rotateDiv(stor);
}
function showYouTube8(){
	stor=7;
	rotateDiv(stor);
}
function showYouTube9(){
	stor=8;
	rotateDiv(stor);
}
function showYouTube10(){
	stor=9;
	rotateDiv(stor);
}
function showYouTube11(){
	stor=10;
	rotateDiv(stor);
}
function showYouTube12(){
	stor=11;
	rotateDiv(stor);
}
function showYouTube13(){
	stor=12;
	rotateDiv(stor);
}
function showYouTube14(){
	stor=13;
	rotateDiv(stor);
}
function showYouTube15(){
	stor=14;
	rotateDiv(stor);
}
function showYouTube16(){
	stor=15;
	rotateDiv(stor);
}
function showYouTube17(){
	stor=16;
	rotateDiv(stor);
}
function showYouTube18(){
	stor=17;
	rotateDiv(stor);
}
function showYouTube19(){
	stor=18;
	rotateDiv(stor);
}
function showYouTube20(){
	stor=19;
	rotateDiv(stor);
}

function rotateDiv(stor){
  var divs = document.getElementById("youtubeContainer").getElementsByTagName("div");
  for (var i=0; i < divs.length; i++ ) {
    var div = divs[i];
    if ( (div.id != "")) {
	if(i != stor){
        	div.style.display = "none";
	}
	else{
		div.style.display = "block";
	}
    }
  }
  
    var spans = document.getElementById("nav_new").getElementsByTagName("span");
  for (var i=0; i < spans.length; i++ ) {
    var span = spans[i];
    if ( (span.id != "")) {
	if(i != stor)
        	span.className = "none";
	else
		span.className = "highlightStory";
    }
  }
}