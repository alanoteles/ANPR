<?php

/**
* Helper class for GK Tab module
*
* GK Tab
* @package Joomla!
* @Copyright (C) 2009 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @ version $Revision: 1.0 $
**/

// access restriction
defined('_JEXEC') or die('Restricted access');

// import JString class for UTF-8 problems
jimport('joomla.utilities.string'); 

if (!function_exists('htmlspecialchars_decode')) {
	function htmlspecialchars_decode($str, $options="") {
        $trans = get_html_translation_table(HTML_SPECIALCHARS, $options);

        $decode = ARRAY();
        foreach ($trans AS $char=>$entity) {
            $decode[$entity] = $char;
        }

        $str = strtr($str, $decode);

        return $str;
    }
}

require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');

class GKTabHelper
{
	var $config;
	var $tabsContent;
	var $tabsTitle;
	var $tabType;
	
	function init(&$params)
	{
		$this->config['moduleWidth'] = $params->get('moduleWidth', 0);
		$this->config['moduleHeight'] = $params->get('moduleHeight', 0);
		$this->config['tabsGroupID'] = $params->get('tabsGroupID', 0);
		$this->config['styleCSS'] =  $params->get('styleCSS', 'style1');
		$this->config['styleFile'] = $params->get('styleFile', '');
		$this->config['styleSuffix'] = $params->get('styleSuffix', '');
		//
		if(strpos($this->config['moduleHeight'],'px') === false) $this->config['moduleHeight'] = 0;
		if(strpos($this->config['moduleWidth'],'px') === false && strpos($this->config['moduleWidth'],'%') === false ) $this->config['moduleWidth'] = 0;
		//
		$this->config['styleCSSfile'] = ($this->config['styleCSS'] == "own") ? $this->config['styleFile'] : $this->config['styleCSS'];
		$this->config['styleSuffix'] = ($this->config['styleCSS'] == "own") ? $this->config['styleSuffix'] : $this->config['styleCSS'];
	}
	
	function render(&$params)
	{
		$this->config['activator'] = $params->get('activator','click');
		$this->config['animation'] = $params->get('animation',0);
		$this->config['animationSpeed'] = $params->get('animationSpeed', 1000);
		$this->config['animationInterval'] = $params->get('animationInterval', 5000);
		$this->config['useCSS'] = $params->get('useCSS',1);
		$this->config['useMoo'] = $params->get('useMoo',1);
		$this->config['useScript'] = $params->get('useScript',1);
		$this->config['animationType'] = $params->get('animationType', 1);
		$this->config['buttons'] = $params->get('buttons', 1);
		$this->config['styleCSS'] = $params->get('styleCSS', 'style');
		$this->config['animationFun'] = $params->get('animationFun', 'linear');
		$this->config['module_id'] = $params->get('module_id', '-mod');
		$this->config['styleType'] = $params->get('styleType', 0);
		$this->config['compress_js'] = $params->get('compress_js', 1);
		$this->config['clean_code'] = $params->get('cleanCode', 1);
		$this->config['news_content_header_pos'] = $params->get('news_content_header_pos', 1);
		$this->config['news_content_image_pos'] = $params->get('news_content_image_pos', 1);
		$this->config['news_content_text_pos'] = $params->get('news_content_text_pos', 1);
		$this->config['news_content_readmore_pos'] = $params->get('news_content_readmore_pos', 2);
		$this->config['news_content_info_pos'] = $params->get('news_content_info_pos', 1); 
		$this->config['news_readmore_text'] = $params->get('news_readmore_text', 'Readmore'); 
		$this->config['news_header_link'] = $params->get('news_header_link', 1);
		$this->config['news_image_link'] = $params->get('news_image_link', 1);
		$this->config['news_text_link'] = $params->get('news_text_link', 0); 
		$this->config['news_header_order'] = $params->get('news_header_order', 1);
		$this->config['news_image_order'] = $params->get('news_image_order', 2); 
		$this->config['news_text_order'] = $params->get('news_text_order', 3); 
		$this->config['news_limit_type'] = $params->get('news_limit_type', 0);
		$this->config['news_limit'] = $params->get('news_limit', 30); 
		$this->config['clean_xhtml'] = $params->get('clean_xhtml', 1); 
		$this->config['img_height'] = $params->get('img_height', 0);
		$this->config['img_width'] = $params->get('img_width', 0);
		$this->config['date_format'] = $params->get('date_format', 'D, d M Y'); 
		$this->config['news_datee'] = $params->get('news_date', 1);
		$this->config['news_cats'] = $params->get('news_cats', 1);
		$this->config['news_authorr'] = $params->get('news_author', 1);
		$this->config['news_info_order'] = $params->get('news_info_order', 4);
		$this->config['timezone'] = $params->get('news_content_timezone','0');
		$this->config['username'] = $params->get('username', 0);
		$this->config["fixedHeight"] = $params->get('fixedHeight', 0);
		$this->config["fixedHeightValue"] = $params->get('fixedHeightValue', 200);
		$this->config["alwaysHide"] = $params->get('alwaysHide', 0);
		//
		$this->tabsTitles = array();
		$this->tabsContent = array();
		$this->tabType = array();
		//
		$db	=& JFactory::getDBO();
		$user =& JFactory::getUser();
		$aid = $user->get('aid', 0);
		//
		$query_news = '
		SELECT DISTINCT
			cats.title AS cat, 
			users.'.(($this->config['username'])?'username':'name').' AS author, 
			cats.section AS SID, 
			content.title AS title, 
			content.introtext AS text, 
			content.created AS date, 
			content.images AS images, 
			content.id AS IID,
			tabs.name AS TNAME,
			tabs.type AS type,
			tabs.content AS content,
			tabs.id AS TID,
			CASE WHEN CHAR_LENGTH(content.alias) 
				THEN CONCAT_WS(":", `content`.`id`, `content`.`alias`) 
					ELSE `content`.`id` END as ID, 
			CASE WHEN CHAR_LENGTH(cats.alias) 
				THEN CONCAT_WS(":", `cats`.`id`, `cats`.`alias`) 
					ELSE `cats`.`id` END as CID 			
		FROM  
			#__gk3_tabs_manager_tabs AS `tabs` 
			LEFT JOIN
				#__content AS `content` 
				ON `tabs`.`content` = `content`.`id`
			LEFT JOIN 
				#__categories AS `categories` 
				ON `categories`.`id` = `content`.`catid` 
			LEFT JOIN 
				#__sections AS `sections` 
				ON `sections`.`id` = `content`.`sectionid` 
			LEFT JOIN 
				#__menu AS `menu` 
				ON `menu`.`componentid` = `content`.`id` 
			LEFT JOIN 
				#__users AS `users` 
				ON `users`.`id` = `content`.`created_by` 
			LEFT JOIN 
				#__categories AS `cats` 
				ON `content`.`catid` = `cats`.`id` 
		WHERE  
			`tabs`.`group_id` = '.$this->config['tabsGroupID'].' 
			AND
			`tabs`.`published` = 1
			AND 
			`tabs`.`access` <= '.(int) $aid.'
		ORDER BY 
			`tabs`.`order` ASC
		;';
		//
		$db->setQuery($query_news);
		//
		$news_id = array();
		$news_iid = array();
		$news_cid = array();
		$news_title = array();
		$news_text = array();
		$news_images = array();	
		$news_date = array();
		$news_author = array();
		$news_catname = array();
		$news_sid = array();
		$content_xhtml = array();
		//
		if($news = $db->loadObjectList())
		{
			// generating tables of news data
			foreach($news as $item)
			{
				$news_id[] = $item->ID; // news IDs
				$news_iid[] = $item->IID; // news IDs
				$news_cid[] = $item->CID; // news CIDs
				$news_title[] = $item->title; // news titles
				$news_text[] = $item->text; // news text
				$news_images[] = $item->images; // news images	
				$news_date[] = $item->date; // news dates
				$news_author[] = $item->author; // news author
				$news_catname[] = $item->cat; // news category name
				$news_sid[] = $item->SID; // news category section ID	
				$this->tabsTitles[] = $item->TNAME; // tab title
				$this->tabType[] = $item->type;
				$content_xhtml[] = $item->content;
			}
		}
		//
		for($y = 0;$y < count($this->tabType);$y++)
		{
			if($this->tabType[$y] == 'module')
			{
				$this->tabsContent[] = $content_xhtml[$y];	
			}
			//
			if($this->tabType[$y] == 'article')
			{
			/*
				GENERATING NEWS CONTENT
			*/
		
			// GENERATING HEADER
			if($this->config['news_content_header_pos'] != 0)
			{
				//
				switch($this->config['news_content_header_pos'])
				{
					case 0: $news_header_style = '';break; 
					case 1: $news_header_style = 'style="text-align: left;"';break; 
					case 2: $news_header_style = 'style="text-align: right;"';break; 
					case 3: $news_header_style = 'style="text-align: center;"';break; 
				}
				//
				$news_header = ($this->config['news_header_link'] == 1) ? '<h4 class="gk_tab_news_header" '.$news_header_style.'><a href="'.JRoute::_(ContentHelperRoute::getArticleRoute($news_id[$y], $news_cid[$y], $news_sid[$y])).'">'.$news_title[$y].'</a></h4>' : '<h4 class="gk_tab_news_header" '.$news_header_style.'>'.$news_title[$y].'</h4>';
			}
			else
			{
				$news_header = '';
			}
			// GENERATING IMAGE
			$news_image = '';
			$IMG_SOURCE = '';
			$IMG_LINK = JRoute::_(ContentHelperRoute::getArticleRoute($news_id[$y], $news_cid[$y], $news_sid[$y]));
			//	
			$imgSPos = strpos($news_text[$y],'src="');
			//
			if($imgSPos)
			{
				$imgEPos = strpos($news_text[$y],'"',$imgSPos+5);
			} 
			//	
			if($imgSPos > 0) 
			{
				$IMG_SOURCE = substr($news_text[$y], ($imgSPos+5), ($imgEPos-($imgSPos+5)));
			}
			//	
			if($IMG_SOURCE != '' && $this->config['news_content_image_pos'] != 0)
			{
				switch($this->config['news_content_image_pos']){
					case 0: $news_image_style = '';break; 
					case 1: $news_image_style = 'display: block;float: left;';break; 
					case 2: $news_image_style = 'display: block;float: right;';break; 
					case 3: $news_image_style = 'display: block;margin: 0 auto;';break; 
				}
				//
				$istyle = '';

				if($this->config['img_width'] == 0)
				{
					if($this->config['img_height'] == 0)
					{
						$istyle = 'style="'.$news_image_style.'"';
					}	
					else
					{
						$istyle = 'style="height: '.$this->img_height.';'.$news_image_style.'"';
					}
				}
				else
				{
					if($this->config['img_height'] == 0)
					{
						$istyle = 'style="width: '.$this->config['img_width'].';'.$news_image_style.'"';
					}	
					else
					{
						$istyle = 'style="width: '.$this->config['img_width'].';height: '.$this->config['img_height'].';'.$news_image_style.'"';
					}
				}
				//
				if($this->config['news_image_link'] == 1){
					$news_image = ($this->config['news_content_image_pos'] == 3) ? '<div><a href="'.$IMG_LINK.'"><img class="gk_tab_news_image" src="'.$IMG_SOURCE.'" alt="News image" '.$istyle.' /></a></div>' : '<a href="'.$IMG_LINK.'"><img class="gk_tab_news_image" src="'.$IMG_SOURCE.'" alt="News image" '.$istyle.' /></a>';
				}
				else
				{
					$news_image = ($this->config['news_content_image_pos'] == 3) ? '<div><img class="gk_tab_news_image" src="'.$IMG_SOURCE.'" alt="News image" '.$istyle.' /></div>' : $news_image = '<img class="gk_tab_news_image" src="'.$IMG_SOURCE.'" alt="News image" '.$istyle.' />';
				}
			} 
		// GENERATING READMORE
		$news_readmore = '';
		//
		if($this->config['news_content_readmore_pos'] != 0)
		{
			switch($this->config['news_content_readmore_pos'])
			{
				case 0: $news_readmore_style = '';break; 
				case 1: $news_readmore_style = 'style="float: left;"';break; 
				case 2: $news_readmore_style = 'style="float: right;"';break; 
				case 4: $news_readmore_style = '';break; 
			}
			//
			if($this->config['news_content_readmore_pos'] != 4)
			{
				$news_readmore = '<a class="readon readon_class" href="'.JRoute::_(ContentHelperRoute::getArticleRoute($news_id[$y], $news_cid[$y], $news_sid[$y])).'" '.$news_readmore_style.'>'.$this->config['news_readmore_text'].'</a>';
			}
			else
			{
				$news_readmore = '<a class="gk_tab_news_readmore_inline" href="'.JRoute::_(ContentHelperRoute::getArticleRoute($news_id[$y], $news_cid[$y], $news_sid[$y])).'" '.$news_readmore_style.'>'.$this->config['news_readmore_text'].'</a>';
			}
		}
		// GENERATING TEXT
		$news_textt = $news_text[$y];
		//
		if($this->config['news_content_text_pos'] != 0)
		{
			switch($this->config['news_content_text_pos'])
			{
				case 0: $news_text_style = '';break; 
				case 1: $news_text_style = 'style="text-align: left;"';break; 
				case 2: $news_text_style = 'style="text-align: right;"';break; 
				case 3: $news_text_style = 'style="text-align: center;"';break; 
				case 4: $news_text_style = 'style="text-align: justify;"';break; 
			}	
			//
			if($this->config['clean_xhtml'] == 1) $news_textt = strip_tags($news_textt);
			//
			if($this->config['news_limit_type'] == 0)
			{
				$str = $news_textt;
				//
				if(strlen($str) > $this->config['news_limit'])
				{
					$words=explode(' ',preg_replace("/\s+/",' ',preg_replace("/(\r\n|\r|\n)/"," ",$str)));
					//
					if(count($words)>=$this->config['news_limit'])
					{
						$str = '';
						//
						for ($i=0;$i<$this->config['news_limit'];$i++)
						{
							$str .= $words[$i].' ';
						}
						//
						$news_textt = trim($str);
						$news_textt .= "...";
					}
				}
			}
			else
			{
				$str = $news_textt;
				//
				if(strlen($str) > $this->config['news_limit'])
				{
					$str = preg_replace("/\s+/", ' ', preg_replace("/(\r\n|\r|\n)/", " ", $str));
					//	
					if(strlen($str) >= $this->config['news_limit'])
					{						
						$news_textt = substr($str, 0, $this->config['news_limit']);
						$news_textt .= "...";
					}
				}
			}
			//	
			$news_textt = ($this->config['news_text_link'] == 1) ? '<a href="'.JRoute::_(ContentHelperRoute::getArticleRoute($news_id[$y], $news_cid[$y], $news_sid[$y])).'">'.$news_textt.'</a>' : $news_textt; 
			//
			$news_textt = ($this->config['news_content_readmore_pos'] == 4) ? '<p class="gk_tab_news_text">'.$news_textt.' '.$news_readmore.'</p>' : $news_textt = '<p class="gk_tab_news_text" '.$news_text_style.'>'.$news_textt.'</p>';
		}
			// GENERATE NEWS INFO
			$news_infoo = '';
			//
			if($this->config['news_content_info_pos'] != 0)
			{
				if($this->config['news_datee'] == 1 || $this->config['news_cats'] == 1 || $this->config['news_authorr'] == 1)
				{
					switch($this->config['news_content_info_pos'])
					{
						case 0: $news_info_style = '';break; 
						case 1: $news_info_style = 'style="text-align: left;"';break; 
						case 2: $news_info_style = 'style="text-align: right;"';break; 
						case 3: $news_info_style = 'style="text-align: center;"';break; 
					}
					//
					$news_infoo .= '<p class="gk_tab_news_info" '.$news_info_style.'>';
					//
					if($this->config['news_cats'] == 1)
					{
						$news_infoo .= '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($news_cid[$y],$news_sid[$y])).'">'.$news_catname[$y].'</a>';
					}
					//
					if($this->config['news_authorr'] == 1)
					{
						if($this->config['news_cats'] == 1)
						{
							$news_infoo .= ' | ';
						}
						//
						$news_infoo .= $news_author[$y];
					}			
					//
					if($this->config['news_datee'] == 1)
					{
						if($this->config['news_cats'] == 1 || $this->config['news_authorr'] == 1)
						{
							$news_infoo .= ' | ';
						}
						//
						$GKD = new GK_Date();
						$GKD->init();
						//
						$news_infoo .= $GKD->news_date($news_date[$y], $this->config['date_format']); 
					}
					//
					$news_infoo .= '</p>';
				}	
			}			
			// GENERATE CONTENT FOR TAB
			$news_generated_content = ''; // initialize variable
			//
			for($i = 1;$i < 5;$i++)
			{
				if($this->config['news_header_order'] == $i) $news_generated_content .= $news_header;
				if($this->config['news_image_order'] == $i) $news_generated_content .= $news_image;
				if($this->config['news_text_order'] == $i) $news_generated_content .= $news_textt;
				if($this->config['news_info_order'] == $i) $news_generated_content .= $news_infoo;
			}			
			//
			if($this->config['news_content_readmore_pos'] != 4) 
			{
				$news_generated_content .= $news_readmore;
			}
			// creating table with news content
			$this->tabsContent[] = $news_generated_content;	
			}
			
			if($this->tabType[$y] == 'xhtml')
			{
				$this->tabsContent[] = $content_xhtml[$y];	
			}
		}		
		// create instances of basic Joomla! classes
		$document =& JFactory::getDocument();
		$uri = JURI::getInstance();
		// add stylesheets to document header
		if($this->config["useCSS"] == 1){
			$document->addStyleSheet( $uri->root().'modules/mod_gk_tab/styles/'.(($this->config['styleType'] == 0) ? 'horizontal' : (($this->config['styleType'] == 1) ? 'vertical' : 'accordion')).'/'.$this->config['styleCSSfile'].'.css', 'text/css' );
		}
		// init $headData variable
		$headData = false;
		// add scripts with automatic mode to document header
		if($this->config['useMoo'] == 2)
		{
			// getting module head section datas
			unset($headData);
			$headData = $document->getHeadData();
			// generate keys of script section
			$headData_keys = array_keys($headData["scripts"]);
			// set variable for false
			$mootools_founded = false;
			// searching phrase mootools in scripts paths
			for($i = 0;$i < count($headData_keys); $i++)
			{
				if(preg_match('/mootools/i', $headData_keys[$i]))
				{
					// if founded set variable to true and break loop
					$mootools_founded = true;
					break;
				}
			}
			// if mootools file doesn't exists in document head section
			if(!$mootools_founded)
			{
				// add new script tag connected with mootools from module
				$headData["scripts"][$uri->root().'modules/mod_gk_tab/scripts/mootools.js'] = "text/javascript";
				// if added mootools from module then this operation have sense
				$document->setHeadData($headData);
			}
		}
		
		if($this->config['useScript'] == 2)
		{
			// getting module head section datas
			unset($headData);
			$headData = $document->getHeadData();
			// generate keys of script section
			$headData_keys = array_keys($headData["scripts"]);
			// set variable for false
			$engine_founded = false;
			// searching phrase mootools in scripts paths
			if(array_search($uri->root().'modules/mod_gk_tab/scripts/engine'.(($this->config['styleType'] == 2) ? '_accordion' : '').(($this->config['compress_js'] == 1) ? '_compress' : '').'.js', $headData_keys) > 0)
			{
				// if founded set variable to true
				$engine_founded = true;
			}
			// if mootools file doesn't exists in document head section
			if(!$engine_founded)
			{
				// add new script tag connected with mootools from module
				$headData["scripts"][$uri->root().'modules/mod_gk_tab/scripts/engine'.(($this->config['styleType'] == 2) ? '_accordion' : '').(($this->config['compress_js'] == 1) ? '_compress' : '').'.js'] = "text/javascript";
				// if added mootools from module then this operation have sense
				$document->setHeadData($headData);
			}
		}
	
		// if clean code is enable use importer.php to include 
		// module settings in head section of document
		if($this->config['clean_code'] == 1)
		{
			/* 
				add script tag with module configuration to document head section
			*/	
			
			// get head document section data 
			unset($headData);
			$headData = $document->getHeadData();
			// add new script tag to head document section data array	
			$headData["scripts"][$uri->root().'modules/mod_gk_tab/scripts/importer.php?modid='.$this->config['module_id'].'&amp;activator='.$this->config['activator'].'&amp;animation='.$this->config['animation'].'&amp;animationFun='.$this->config['animationFun'].'&amp;animationType='.$this->config['animationType'].'&amp;animationSpeed='.$this->config['animationSpeed'].'&amp;animationInterval='.$this->config['animationInterval'].'&amp;styleType='.$this->config['styleType'].'&amp;styleSuffix='.$this->config['styleSuffix'].'&amp;fixedHeight='.$this->config["fixedHeight"].'&amp;fixedHeightValue='.$this->config["fixedHeightValue"].'&amp;alwaysHide='.$this->config["alwaysHide"]] = "text/javascript";		
			// if added mootools from module then this operation have sense
			$document->setHeadData($headData);
		} 
						
		// add default.php template to parse if it's needed
		if($this->config['useMoo'] != 2 || $this->config['useScript'] != 2 || $this->config['clean_code'] == 0)
		{
			require(JModuleHelper::getLayoutPath('mod_gk_tab', 'default'));
		}
		
		require(JModuleHelper::getLayoutPath('mod_gk_tab', 'content'));
	}
	
	function moduleRender()
	{	
		for($i = 0;$i < count($this->tabsContent);$i++)
		{
			if($this->tabType[$i] == 'module')
			{
				$this->modGetter = &JModuleHelper::getModules($this->tabsContent[$i]);
				require(JModuleHelper::getLayoutPath('mod_gk_tab','module'));
			}
			
			if($this->tabType[$i] == 'article') require(JModuleHelper::getLayoutPath('mod_gk_tab','article'));
			if($this->tabType[$i] == 'xhtml') require(JModuleHelper::getLayoutPath('mod_gk_tab','xhtml'));
		}
	}
	
		
	function moduleRenderAccordion($i)
	{	
		if($this->tabType[$i] == 'module')
		{
			$this->modGetter = &JModuleHelper::getModules($this->tabsContent[$i]);
			require(JModuleHelper::getLayoutPath('mod_gk_tab','module'));
		}
		
		if($this->tabType[$i] == 'article') require(JModuleHelper::getLayoutPath('mod_gk_tab','article'));
		if($this->tabType[$i] == 'xhtml') require(JModuleHelper::getLayoutPath('mod_gk_tab','xhtml'));
	}
}

?>