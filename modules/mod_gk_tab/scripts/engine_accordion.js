window.addEvent("domready",function(){
	$ES(".gk_accordion").each(function(el,i){
		var module_id = el.getProperty("id");
		var $G = $Gavick["gk_tab"+module_id]; 
		var sfx = $G["styleSuffix"];
		var evnt = ($G["activator"] == 0) ? "click" : "mouseenter";
		
		var accordion = new Accordion($ES('h3', el), $ES('div.gk_tab_container-'+sfx, el), {
    		alwaysHide: ($G['alwaysHide'] ? true : false),
    		fixedHeight: ($G['fixedHeight'] ? ($G['fixedHeightValue']) : false),
		    onActive: function(toggler){toggler.setProperty("class", "active");},
 			onBackground: function(toggler){toggler.setProperty("class", "");},
			transition: $G["animationTransition"], 
			duration: $G["animationSpeed"]
		});
		
		if(evnt == "mouseenter"){
			$ES('h3', el).each(function(elm,j){
				elm.addEvent("mouseenter", function(){
					accordion.display(j);
				});
			});
		}
	});
});