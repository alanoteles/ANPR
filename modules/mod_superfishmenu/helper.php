<?php

require_once JPATH_BASE.DS.'modules'.DS.'mod_mainmenu'.DS.'helper.php';

class modSuperfishMenuHelper extends modMainMenuHelper {

	function render(&$params, $callback) {
	
		// Include the new menu class
		$xml = modMainMenuHelper::getXML($params->get('menutype'), $params, $callback);
		if ($xml) {
//			$class = implode(" ", Array($params->get('class_sfx'), 'sf-menu', 'sf-'.$params->get('menu_style')));
			$class = implode(" ", Array($params->get('class_sfx'), 'sf-menu'.$params->get('class_sfx'), 'sf-'.$params->get('menu_style')));
			$xml->addAttribute('class', 'menu'.$class);
			if ($tagId = $params->get('tag_id')) {
				$xml->addAttribute('id', $tagId);
			}

			$result = JFilterOutput::ampReplace($xml->toString((bool)$params->get('show_whitespace')));
			$result = str_replace(array('<ul/>', '<ul />'), '', $result);
			if($params->get('clearingDiv', 0)) $result .= '<div class="superfish_clear"></div>';
			echo $result."\n";

			$doc =& JFactory::getDocument();
			$cache =& JFactory::getCache();

			$noCache = !$params->get('cache') || !$cache->_options['caching'];
			
			$cs_path = JURI::base().'modules/mod_superfishmenu/tmpl/%s/%s.%s';
			$js_path = JURI::base().'modules/mod_superfishmenu/tmpl/%s/%s.%s';
			
		
			/* add the javascript files.  order is important! */
			$addScripts = Array();
			if($params->get('loadJQuery',true)) 	 $addScripts[] = 'jquery';
			if($params->get('useEventSpecialHover')) $addScripts[] = 'jquery.event.hover';
			if($params->get('useBgIframe')) 		 $addScripts[] = 'jquery.bgiframe.min';
			if($params->get('useSuperSubs')) 		 $addScripts[] = 'supersubs';
			if($params->get('menuWidthMod_enable'))  $addScripts[] = 'superfish_width_mod';
			$addScripts[] = 'superfish';

			foreach($addScripts as $name) {
				if($noCache)
					$doc->addScript(sprintf($js_path, 'js', $name, 'js'),'text/javascript');
				else
					echo '<script language="javascript" type="text/javascript" src="'.sprintf($js_path, 'js', $name, 'js').'"></script>'."\n";
			}

			/* add the stylesheet files */
			$addStyles = Array();
			if($params->get('menu_style')!='list') $addStyles[] = 'superfish';
			if($params->get('menu_style')=='vertical') $addStyles[] = 'superfish-vertical';
			if($params->get('menu_style')=='navbar') $addStyles[] = 'superfish-navbar';

			foreach($addStyles as $name) {
				if($noCache)
					$doc->addStyleSheet(sprintf($cs_path, 'css', $name, 'css'),'text/css');   
				else
					echo '<link rel="stylesheet" type="text/css" href="'.sprintf($cs_path, 'css', $name, 'css').'" />'."\n";
			}


			/* add any custom stylesheet files */
			if($params->get('custom_stylesheets')) {
				$sheets = preg_split('/\n/', $params->get('custom_stylesheets') );
				foreach($sheets as $idx=>$sheet) {
					if(!$sheet) continue;
					$parts = preg_split('/(?<!(\\\)|(http)):/i', $sheet );
					$media = count($parts) >= 2 ? array_pop($parts) : 'all';
					$url = str_replace( Array("\\:","{mostemplate}"), Array(':',JURI::base().'templates/'.$doc->get('template')), implode('', $parts));
//					die($url);
					// get parameters of the style, for security reasons, backslash any quotes
					// i think joomla fixes this automagically, but just in case :)
					$url = preg_replace( '/"/', '\\"', $url );
					$url = preg_replace( '/{(.*?)}/e', '$doc->params->get("\\1","")', $url );
					
					// add base path to urls beginning with /
					$url = preg_replace( '|^/|', JURI::base(), $url );

					if($noCache)
						$doc->addStyleSheet($url, 'text/css', $media);
					else
						echo '<link rel="stylesheet" type="text/css" href="'.$url.'" media="'.$media.'" />'."\n";
				}
			}
			
			/* add any custom css */
			if($params->get('custom_css')) {

				if($noCache)
					$doc->addStyleDeclaration( $params->get('custom_css') ,'text/css');
				else
					echo '<style type="text/css">'."\n".($params->get('custom_css'))."\n".'</style>'."\n";
			}
			
			/* get the superfish options */
			$superfish_options = Array(
				'hoverClass' 	=> $params->get('hoverClass', 'sfHover'),
				'pathClass' 	=> $params->get('pathClass', 'active'),
				'pathLevels' 	=> $params->get('pathLevels', '0'),
				'delay' 		=> $params->get('delay', '800'),
				'animation' 	=> $params->get('animation','{opacity:\'show\'}'),
				'speed' 		=> $params->get('speed', 'def'),
				'autoArrows' 	=> $params->get('autoArrows','1'),
				'dropShadows' 	=> $params->get('dropShadows','1'),
				'onInit' 		=> $params->get('onInit',''),
				'onBeforeShow' 	=> $params->get('onBeforeShow',''),
				'onShow' 		=> $params->get('onShow',''),
				'onHide' 		=> $params->get('onHide',''),
			);
			if($params->get('menu_style') != 'navbar') $superfish_options['pathLevels']=0;
			if($superfish_options['animation']=='custom') $superfish_options['animation'] = $params->get('custom_animation');
			if($superfish_options['animation']=='{}') $superfish_options['animation'] = '';

			$no_quote = Array('animation', 'onInit', 'onBeforeShow','onShow','onHide');
			
			if(!function_exists('hasValue')) {
				function hasValue($var) { return $var !== ''; }
			}
			$superfish_options = array_filter( $superfish_options, 'hasValue' );

			foreach($superfish_options as $key=>$value) $superfish_options[$key] = $key.':'.(in_array($key, $no_quote) || preg_match('/^(true|false|([0-9]+))$/i', $value) ? $value : "'$value'");
			$superfish_options = implode(', ', $superfish_options);
			
//			$superstring = '$("ul.sf-menu")';
			$superstring = '$("ul.sf-menu'.$params->get('class_sfx').'")';
			
			if($params->get('useSuperSubs') && $params->get('menu_style')!='navbar' ) {
				$min_width = preg_replace('/[^\d\.]/', '', $params->get('min_width'));
				$max_width = preg_replace('/[^\d\.]/', '', $params->get('max_width'));
				$extra_width = preg_replace('/[^\d\.]/', '', $params->get('extra_width'));
				$superstring .= ".supersubs({minWidth:$min_width, maxWidth:$max_width, extraWidth:$extra_width})";
			}
			
			$superstring .= '.superfish({'.$superfish_options.'})';
			
			if($params->get('useBgIframe')) {
				$bgi_options = Array(
					'top' 		=> $params->get('bgi_top', 'auto'),
					'left' 		=> $params->get('bgi_left', 'auto'),
					'width' 	=> $params->get('bgi_width', 'auto'),
					'height' 	=> $params->get('bgi_height', 'auto'),
					'opacity' 	=> $params->get('bgi_opacity', 'true'),
					'src' 		=> $params->get('bgi_src', 'javascript:false;'),
				);
				foreach($bgi_options as $key=>$value) $bgi_options[$key] = $key.':'.(preg_match('/^(true|false|([0-9]+))$/i', $value) ? $value : "'$value'");
				$bgi_options = implode(', ', $bgi_options);
	
				$superstring .= '.find(\'ul\').bgIframe({'.$bgi_options.'})';
			}

			$setup_js = $params->get('jquerySafeMode', true) ? 'jQuery.noConflict();'."\n" : '';
			$setup_js .= "jQuery(function($){ $superstring });\n";
			
			if($params->get('menuWidthMod_enable')) {
				$vertical = $params->get('menu_style')=='vertical' ? 1 : 0;
				$menuWidth = $params->get('menuWidthMod_menuWidth','100%');
				$equalWidth = $params->get('menuWidthMod_equalWidth');
				$resizeSeps = $params->get('menuWidthMod_resizeSeps');
				$resizeSubMenus = $params->get('menuWidthMod_resizeSubMenus');

				$setup_js .= 'jQuery(window).load( function() { jQuery("ul.sf-menu'.$params->get('class_sfx').'")'.".superfish_width_mod({ vertical:$vertical, menuWidth:'$menuWidth', equalWidth:$equalWidth, resizeSeps:$resizeSeps, resizeSubMenus:$resizeSubMenus }) })\n";
			}

			/* get the $.event.special.hover options */
			if($params->get('useEventSpecialHover')) {
				$setup_js .= 'jQuery.event.special.hover.delay = '.$params->get('hover_delay', '100').";\n";
				$setup_js .= 'jQuery.event.special.hover.speed = '.$params->get('hover_speed', '100').";\n";
			}

			if($noCache)
				$doc->addScriptDeclaration($setup_js, 'text/javascript');
			else
				echo '<script language="javascript" type="text/javascript">'."\n".$setup_js."\n".'</script>';
				
		}
	}
}

