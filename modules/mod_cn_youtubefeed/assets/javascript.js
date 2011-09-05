/*
 * @version		2.0
 * @package		mod_youtubefeed
 * @author    	Caleb Nance
 * @copyright	Copyright (c) 2009 - 2010 CalebNance.com. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * 
 * @file		default.php
 */


var state = 'hidden';
function showhide(layer_ref) { 
	if (state == 'visible') { 
		state = 'hidden'; 
	} 
	else { 
		state = 'visible'; 
	} 
	
	if (document.all) { 
		eval( "document.all." + layer_ref + ".style.visibility = state");
	} 
	
	if (document.layers) { 
		document.layers[layer_ref].visibility = state; 
	} 
	
	if (document.getElementById && !document.all) { 
		show = document.getElementById(layer_ref); show.style.visibility = state; 
	} 
}

function showonlyone(thechosenone) {
      var newboxes = document.getElementsByTagName("div");
            for(var x=0; x<newboxes.length; x++) {
                  name = newboxes[x].getAttribute("name");
                  if (name == 'newboxes') {
                        if (newboxes[x].id == thechosenone) {
                        newboxes[x].style.display = 'block';
                  }
                  else {
                        newboxes[x].style.display = 'none';
                  }
            }
      }
}