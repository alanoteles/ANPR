window.addEvent("load",function(){
	$ES(".gk_tab").each(function(el,i){
		var module_id = el.getProperty("id");
		var $G = $Gavick["gk_tab"+module_id]; 
		var sfx = $G["styleSuffix"];
		var modsArray = el.getElementsBySelector('.gk_tab_item-'+sfx);
		var animation = ($G["autoAnimation"] == 0) ? true : false;
		var actual = 0;
		var evnt = ($G["activator"] == 0) ? "click" : "mouseenter";
		var amount = modsArray.length;
		var timer = false;
		if($G["styleType"] == 1){
			var baseWidth = $E(".gk_tab_container2-"+sfx, el).getSize().size.x;
			el.setStyle("width",baseWidth+"px");
			var listTab = $E('.gk_tab_ul-'+sfx,el);
			baseWidth -= listTab.getSize().size.x;
			baseWidth -= listTab.getStyle("margin-left").toInt();
			baseWidth -= listTab.getStyle("margin-right").toInt();
			baseWidth -= $E(".gk_tab_container0-"+sfx,el).getStyle("margin-left").toInt();
			baseWidth -= $E(".gk_tab_container0-"+sfx,el).getStyle("margin-right").toInt();
			baseWidth -= $E(".gk_tab_container0-"+sfx,el).getStyle("padding-left").toInt();
			baseWidth -= $E(".gk_tab_container0-"+sfx,el).getStyle("padding-right").toInt();
			$E(".gk_tab_container1-"+sfx,el).setStyle("width",baseWidth+"px");
			$E(".gk_tab_container0-"+sfx,el).setStyle("width",baseWidth+"px");
			$ES(".gk_tab_item"+sfx, el).setStyle("width",baseWidth+"px");
		}
		$E('.gk_tab_ul-'+sfx+' li',el).addClass("active");
		var param = ($G["animationType"] == 1) ? "width": "height";
		$E(".gk_tab_container2-"+sfx, el).setStyle(param, ((amount+1)*$E(".gk_tab_container1-"+sfx, el).getSize().size.x));
		$ES(".gk_tab_item-"+sfx, el).each(function(e){e.setStyle("width", $E(".gk_tab_container1-"+sfx, el).getSize().size.x + "px");});
		$ES('.gk_tab_ul-'+sfx+' li', el).each(function(elm,j){
			elm.addEvent(evnt,function(){
			    actual = gk_tab_anim(j, actual, amount, modsArray, el, $G["animationTransition"], $G["animationSpeed"], $G);
				$ES('.gk_tab_ul-'+sfx+' li', el).each(function(elmt){elmt.setProperty("class","");});
				$ES('.gk_tab_ul-'+sfx+' li', el)[actual].toggleClass("active");
				
				if(timer){
					$clear(timer);	
					timer = (function(){
						actual = gk_tab_anim("right" , actual, amount, modsArray, el, $G["animationTransition"], $G["animationSpeed"], $G);
						$ES('.gk_tab_ul-'+sfx+' li', el).each(function(elmt, i){elmt.setProperty("class","");});
						$ES('.gk_tab_ul-'+sfx+' li', el)[actual].toggleClass("active");
					}).periodical($G["animationInterval"]);
				}
			});
		});
		
		if($E(".gk_tab_button_next-"+sfx, el)){
			$E(".gk_tab_button_next-"+sfx, el).addEvent("click",function(){
				actual = gk_tab_anim('right', actual, amount, modsArray, el, $G["animationTransition"], $G["animationSpeed"], $G);
				$ES('.gk_tab_ul-'+sfx+' li', el).each(function(elmt){elmt.setProperty("class","");});
				$ES('.gk_tab_ul-'+sfx+' li', el)[actual].toggleClass("active");
				
				if(timer){
					$clear(timer);
					timer = (function(){
						actual = gk_tab_anim("right" , actual, amount, modsArray, el, $G["animationTransition"], $G["animationSpeed"], $G);
						$ES('.gk_tab_ul-'+sfx+' li', el).each(function(elmt, i){elmt.setProperty("class","");});
						$ES('.gk1_tab_ul-'+sfx+' li', el)[actual].toggleClass("active");
					}).periodical($G["animationInterval"]);
				}
			});
		}
		
		if($E(".gk_tab_button_prev-"+sfx, el)){
			$E(".gk_tab_button_prev-"+sfx, el).addEvent("click",function(){
				actual = gk_tab_anim('left', actual, amount, modsArray, el, $G["animationTransition"], $G["animationSpeed"], $G);	
				$ES('.gk_tab_ul-'+sfx+' li', el).each(function(elmt){elmt.setProperty("class","");});
				$ES('.gk_tab_ul-'+sfx+' li', el)[actual].toggleClass("active");
				
				if(timer){
					$clear(timer);	
					timer = (function(){
						actual = gk_tab_anim("right" , actual, amount, modsArray, el, $G["animationTransition"], $G["animationSpeed"], $G);
						$ES('.gk_tab_ul-'+sfx+' li', el).each(function(elmt, i){elmt.setProperty("class","");});
						$ES('.gk_tab_ul-'+sfx+' li', el)[actual].toggleClass("active");
					}).periodical($G["animationInterval"]);
				}
			});
		}
		
		if($G["autoAnimation"] == 1){
			timer = (function(){
				actual = gk_tab_anim("right" , actual, amount, modsArray, el, $G["animationTransition"], $G["animationSpeed"], $G);
				$ES('.gk_tab_ul-'+sfx+' li', el).each(function(elmt, i){elmt.setProperty("class","");});
				$ES('.gk_tab_ul-'+sfx+' li', el)[actual].toggleClass("active");
			}).periodical($G["animationInterval"]);
		}
	});
});

function gk_tab_anim(direct, actual, amount, modsArray, el, t, s, $G){	
	var sfx = $G["styleSuffix"];
	var scr = new Fx.Scroll($E(".gk_tab_container1-"+sfx, el), {duration: s, wait: true, transition: $G["animationTransition"],wheelStops:false});
	
	if(direct == 'left'){
		(actual > 0) ? actual-- : actual = amount - 1;
		scr.toElement(modsArray[actual]);
	}else if(direct == 'right'){
		(actual < (amount-1)) ? actual += 1 : actual = 0;
		scr.toElement(modsArray[actual]);
	}else{
		actual = direct;
		scr.toElement(modsArray[actual]);
	}
	
	return actual;
}