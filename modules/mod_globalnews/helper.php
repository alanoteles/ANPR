<?php
/**
* @version		$Id: helper.php 2008 Vargas $
* @package		Joomla
* @license		GNU/GPL, see LICENSE.php
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');

class modGlobalNewsHelper {

function getGN_Img( &$params, $link, $img, $pfx ) {

	$align 	    = $params->get( $pfx.'_img_align', 'left' );
	$margin 	= $params->get( $pfx.'_img_margin', '3px' );
	$width 		= (int)$params->get( $pfx.'_img_width', '' );
	$height 	= (int)$params->get( $pfx.'_img_height', '' );
	$border		= $params->get( $pfx.'_img_border', '0' );
	
	if ( $align == 'left' )  :
		   $style = 'float:left;';
		   if ( $pfx == 'cat' ) {
		        $style .= 'margin-right:' . $margin . ';';
		   } else {
		        $style .= 'margin:' . $margin . ';';
		   }
	endif;
	
	if ( $align == 'right' )  :
		   $style = 'float:right;';
		   if ( $pfx == 'cat' ) {
		        $style .= 'margin-left:' . $margin . ';';
		   } else {
		        $style .= 'margin:' . $margin . ';';
		   }
	endif;
	
	$style .= 'border:' . $border . ';';
	
	$attribs = array ('style' => $style);
		
	if ( $height )
		$attribs = array('height' => $height, $attribs);
	
	if ( $width )
		$attribs = array('width' => $width,  $attribs );
	
	$image = JHTML::_('image', $img, JText::_('IMAGE'), $attribs );
	
	if ( $link )
		$image = JHTML::_('link', $link, $image);
		
	if ( $align = 'center')
		$image = '<center>' . $image . '</center>';
		
    return $image;
}

	function getGN_Cats(&$params)
	{
		global $article_id;

		$db			=& JFactory::getDBO();
		$user		=& JFactory::getUser();
		$userId		= (int) $user->get('id');

		$catlist	= trim( $params->get('catids', '') );
		$seclist    = trim( $params->get('secids', '') ); 
		$catexc		= trim( $params->get('catexc', '') );
		$secexc		= trim( $params->get('secexc', '') );
		$curcat     = $params->get('curcat', 0);
		$current    = $params->get('current', 1);
		$show_cat   = $params->get('show_cat', 1);
		$cat_title  = $params->get('cat_title', 1);
		$cat_img    = $params->get( 'cat_img_align', 0);
		$global     = $params->get('global', 's');
		$filter     = $params->get('filter', 0);
		$aid		= $user->get('aid', 0);

		$contentConfig = &JComponentHelper::getParams( 'com_content' );
		$access		= !$contentConfig->get('shownoauth');
		
		$group_id = $article_id = '';

		switch ($params->get( 'cat_order', 1))
		{
			case '0':
				$ordering		= 'rand()';
				break;
			case '1':
				$ordering		= $global.'.id ASC';
				break;
			case '2':
				$ordering		= $global.'.title ASC';
				break;
			case '3':
			default:
				$ordering		= $global.'.ordering ASC';
				break;
		}
		
        if ( $seclist ) {
	        $secids = explode( ',', $seclist );
	        JArrayHelper::toInteger( $secids );
	        $condition = ' AND (s.id=' . implode( ' OR s.id=', $secids ) . ')';
        } elseif ( $secexc ) {
	        $secids = explode( ',', $secexc );
	        JArrayHelper::toInteger( $secids );
	        $condition = ' AND (s.id!=' . implode( ' AND s.id!=', $secids ) . ')';
        } else {
	        $condition = '';
        }
		
        if ( $filter != 0 || $curcat == 1 || $current != 1 ) :
		
			 if ( JRequest::getCmd('option') == 'com_content' ) {
			 
		          $view		= JRequest::getCmd('view');
			 
		          $temp		= JRequest::getString('id');
		          $temp		= explode(':', $temp);
		          $id		= $temp[0];
			 
			      if ( $filter != 0 ) {
			 	       switch ( $view ) {
				            case 'section':
							     $group_id = $id;
					             $condition .= ' AND s.id='. $id;
							     break;
				            case 'category':
							     $group_id = $id;
					             $query = 'SELECT section from #__categories WHERE id='.$id;
							     $db->setQuery($query);
							     $condition .= ' AND s.id='. $db->loadResult();
							     break;
				            case 'article':
					             $query = 'select sectionid from #__content where id='.$id;
							     $db->setQuery($query);
							     $condition .= ' AND s.id='. $db->loadResult();
							     if ( $current != 1 )
							         $article_id = $id;
							     break;
				       }
			      } elseif ( $current != 1 && $view == 'article' && $id ){
			           $article_id = $id;
			      } elseif ( $curcat == 1 && $view != 'article' ) {
				       $group_id = $id;
				  }
			  }
		
        endif;

        if ( $global == 'c' ) {
		
            if ( $catlist ) {
	            $catids = explode( ',', $catlist );
	            JArrayHelper::toInteger( $catids );
	            $condition .= ' AND (c.id=' . implode( ' OR c.id=', $catids ) . ')';
            } elseif ( $catexc ) {
	            $catids = explode( ',', $catexc );
	            JArrayHelper::toInteger( $catids );
	            $condition .= ' AND (c.id!=' . implode( ' AND c.id!=', $catids ) . ')';
            }
			
		    $query = 'SELECT c.*, ' .
			' CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(":", c.id, c.alias) ELSE c.id END as slug' .
			' FROM #__categories AS c' .
			' INNER JOIN #__sections AS s ON s.id = c.section' .
			' WHERE s.scope = "content"' .
			($access ? ' AND c.access <= ' .(int) $aid : '').
			($condition!='' ? $condition : '').
			' AND c.published = 1' .
			' ORDER BY c.section, '. $ordering;
			
        } else {
		
		    $query = 'SELECT s.* ' .
			' FROM #__sections AS s' .
			' WHERE s.scope = "content"' .
			($access ? ' AND s.access <= ' .(int) $aid : '').
			($condition!='' ? $condition : '').
			' AND s.published = 1' .
			' ORDER BY '. $ordering;
		}
			
		$db->setQuery($query, 0, (int) $params->get('cat_limit', ''));
		$rows = $db->loadObjectList();

		$i		= 0;
		$cats	= array();
		
		foreach ( $rows as $row ) {
				
		    if ( $global == 's')  {
			$cats[$i]->link = JRoute::_(ContentHelperRoute::getSectionRoute( $row->id ));
			$cats[$i]->cond = ' AND a.sectionid = '.$row->id;
			    if ( $catlist ) {
	            $catids = explode( ',', $catlist );
	            JArrayHelper::toInteger( $catids );
				$cats[$i]->cond .= ' AND (a.catid=' . implode(' OR a.catid=', $catids ) . ')';
			    } elseif ( $catexc ) {
	            $catids = explode( ',', $catexc );
	            JArrayHelper::toInteger( $catids );
				$cats[$i]->cond .= ' AND (a.catid!= ' . implode(' AND a.catid!=', $catids ) . ')';
			    }
            } else {
			$cats[$i]->link = JRoute::_(ContentHelperRoute::getCategoryRoute( $row->slug, $row->section ));
			$cats[$i]->cond = ' AND a.catid = '.$row->id;
            }
				
	    	$cats[$i]->title = '';
	    	$cats[$i]->image = '';
			
			if ( $cat_img && $row->image ) {
		     	$config 	= JComponentHelper::getParams ('com_media');
			 	$folder 	= $config->get('image_path');
			 	$cats[$i]->image .= modGlobalNewsHelper::getGN_Img( $params, $cats[$i]->link, $folder .'/'. $row->image, 'cat' );
        	}
		
	    	if ( $group_id == $row->id && $curcat == 1 ) {
			 	$cats[$i]->link = '';
			}
		
	    	if ( $cat_title != 0 ) {
			 	$tags = array(array('',''),array('',''),array('<strong>','</strong>'),array('<u>','</u>'),array('<strong><u>','</u></strong>'),array('<h1>','</h1>'),array('<h2>','</h2>'),array('<h3>','</h3>'),array('<h4>','</h4>'),array('<h5>','</h5>'),array('<h6>','</h6>'));
		     	if ( $show_cat == 2 ) {
			      	$cats[$i]->title .= $tags[$cat_title][0] .  $row->title . $tags[$cat_title][1];
		     	} else {
			      $cats[$i]->title .= ( $cat_title > 4 ? $tags[$cat_title][0] : '' ) . ( $cats[$i]->link ? '<a href="' . $cats[$i]->link. '">' : '' ) . ( $cat_title < 5 ? $tags[$cat_title][0] : '' ) .  $row->title . ( $cat_title < 5 ? $tags[$cat_title][1] : '' ) . ( $cats[$i]->link ? '</a>' : '' ) . ( $cat_title > 4 ? $tags[$cat_title][1] : '' );
		        }
		    }
		
			$i++;
		}

		return $cats;
	}

	function getGN_List(&$params,$listCondition)
	{
		global $article_id;

		$db			=& JFactory::getDBO();
		$user		=& JFactory::getUser();
		$userId		= (int) $user->get('id');

		$count		= trim( $params->get('count', 5) );
		$current    = trim( $params->get('current', 1) );
		$layout     = $params->get('layout', 'list');
		$html       = $params->get('html');
		$show_front	= $params->get('show_front', 1);
		$aid		= $user->get('aid', 0);
		$limittitle	= $params->get('limittitle', '');
		
		$contentConfig = &JComponentHelper::getParams( 'com_content' );
		$access		= !$contentConfig->get('shownoauth');

		$nullDate	= $db->getNullDate();
		jimport('joomla.utilities.date');
		$date = new JDate();
		$now = $date->toMySQL();
		
		$where		= 'a.state = 1'
			. ' AND ( a.publish_up = '.$db->Quote($nullDate).' OR a.publish_up <= '.$db->Quote($now).' )'
			. ' AND ( a.publish_down = '.$db->Quote($nullDate).' OR a.publish_down >= '.$db->Quote($now).' )'
			;
			
		if ( $article_id && $current == 0 )
		{
			$where .= ' AND a.id != ' . $article_id;
		}

		switch ($params->get( 'user_id', 0 ))
		{
			case 'by_me':
				$where .= ' AND (a.created_by = ' . (int) $userId . ' OR a.modified_by = ' . (int) $userId . ')';
				break;
			case 'not_me':
				$where .= ' AND (a.created_by <> ' . (int) $userId . ' AND a.modified_by <> ' . (int) $userId . ')';
				break;
		}
		
		$joins = ' INNER JOIN #__categories AS cc ON cc.id = a.catid' .
				 ' INNER JOIN #__sections AS s ON s.id = a.sectionid';
				 
		switch ( $show_front )
		{
			case 1:
				$joins .= ' LEFT JOIN #__content_frontpage AS f ON f.content_id = a.id';
				$where .= ' AND f.content_id IS NULL';
				break;
			case 2:
				$joins .= ' LEFT JOIN #__content_frontpage AS f ON f.content_id = a.id';
				$where .= ' AND f.content_id = a.id';
				break;
		}

		switch ($params->get( 'ordering', 'c_dsc' ))
		{
			case 'random':
				$ordering		= 'rand()';
				break;
			case 'h_asc':
				$ordering		= 'a.hits ASC';
				break;
			case 'h_dsc':
				$ordering		= 'a.hits DESC';
				break;
			case 'alpha':
				$ordering		= 'a.title';
				break;
			case 'ralpha':
				$ordering		= 'a.title DESC';
				break;
			case 'm_dsc':
				$ordering		= 'a.modified DESC, a.created DESC';
				break;
			case 'order':
				$ordering		= 'a.ordering ASC';
				break;
			case 'rating':
				$joins         .= ' LEFT JOIN #__content_rating AS r ON r.content_id = a.id';
				$ordering		= 'r.rating_sum DESC';
				break;
			case 'c_dsc':
			default:
				$ordering		= 'a.created DESC';
				break;
		}
				
		$query = 'SELECT a.*, ' .
			' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'.
			' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug'.
			' FROM #__content AS a' .
			$joins .
			' WHERE '. $where .' AND s.id > 0' .
			($access ? ' AND a.access <= ' .(int) $aid : '').
			' AND s.published = 1' .
			$listCondition.
			' ORDER BY '. $ordering;
			
		$db->setQuery($query, 0, $count);
		$rows = $db->loadObjectList();
		
		$i		= 0;
		$lists	= array();
		
		foreach ( $rows as $row ) {
							
            if ( $article_id == $row->id && $current == 2 ) {
		         $link = '';
			} else {
		         $link = JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catslug, $row->sectionid));
			}		
			if ( $limittitle && strlen( $row->title ) > $limittitle ) {
			   $row->title = substr( $row->title, 0, $limittitle ). '...';
			}			
            if ( $link ) {
		         $lists[$i]->title = '<a href="'.$link.'">'.htmlspecialchars( $row->title ).'</a>'; 
            } else {
		         $lists[$i]->title = htmlspecialchars( $row->title );
			}
			
	        if ( $layout != 'list' ) :
			
				$gn_image    = '';
				$gn_title    = '';
				$gn_created  = '';
				$gn_author   = '';
				$gn_text     = '';
				$gn_readmore = '';
				$gn_comments = '';
				$rm          = 0;
			
				if ( preg_match("/GN_title/", $html) ) {
		            $gn_title = $lists[$i]->title;
					$gn_title = preg_replace('/\$/','$-',$gn_title);
			    }
			
		        if ( preg_match("/GN_date/", $html) ) {
	      	    	$gn_created = JHTML::_('date',  ($params->get( 'date' ) == 'created' ? $row->created : $row->modified ),  $params->get('date_format', '' ) );
			    }
				
		        if ( preg_match("/GN_author/", $html) ) {
					$author = $params->get( 'author' );
					if ( $author != 'alias' ) {
						$query = "SELECT " . $author . " FROM #__users WHERE id = " . $row->created_by;
						$db->setQuery($query);
						$gn_author = $db->loadResult();
						if ( $params->get('cb_link')) {
							$menu 		= &JSite::getMenu();
							$CB_Items	= $menu->getItems('link', 'index.php?option=com_comprofiler');
							$CB_Itemid  = '';
							if (isset($CB_Items[0]->id))
								$CB_Itemid .= '&amp;Itemid='.$CB_Items[0]->id;
							$gn_author = '<a href=' . JRoute::_('index.php?option=com_comprofiler&task=userProfile&user=' . $row->created_by . $CB_Itemid) . ' title= ' . $gn_author . '>' . $gn_author . '</a>';
						}
					} else {
						$gn_author = $row->created_by_alias;
					}
			    }
				 
		        if ( preg_match("/GN_image/", $html) ) {
					$regex   = "/<img[^>]+src\s*=\s*[\"']\/?([^\"']+)[\"'][^>]*\>/";
					$search  = $row->introtext . $row->fulltext;
					preg_match ($regex, $search, $matches);
					$images = (count($matches)) ? $matches : array();
					if ( count($images) ) {
					  $gn_image  = modGlobalNewsHelper::getGN_Img ( $params, $link, $images[1], 'item' );
					}
		        }
						
		        if ( preg_match("/GN_text/", $html) ) {
					$text    = $params->get( 'text', 0 );
					$limit   = trim( $params->get('limittext', '150') );
					if ($text < 2) { 
					  $gn_text = $row->introtext;
					  if ( $text == 1 )
					    $gn_text .= '&nbsp;' . $row->fulltext;
					}
					if ( $text == 2 )
					  $gn_text = $row->fulltext;
					if ( $params->get('striptext', '1'))
					  $gn_text = trim( strip_tags(  $gn_text, $params->get('allowedtags', '') ) );
					$pattern = array("/[\n\t\r]+/",'/{(\w+)[^}]*}.*{\/\1}|{(\w+)[^}]*}/Us', '/\$/');
					$replace = array(' ', '', '$-');
					$gn_text = preg_replace( $pattern, $replace, $gn_text );
					if ( $limit && strlen( $gn_text ) > $limit ) {
					   $gn_text = substr( $gn_text, 0, $limit );
					   $space   = strrpos( $gn_text, ' ' );
					   $gn_text = substr( $gn_text, 0, $space ). '...';
					   $rm = 1;
					} elseif ( $text == 0 && $row->fulltext ) {
					   $rm = 1;
					}
			    }
				 
		        if ( preg_match("/GN_comments/", $html) ) {
					$query = 'SELECT count(id) FROM ' . $params->get( 'comments_table' ) . ' WHERE ' . $params->get( 'article_column' ) . ' = ' . $row->id;
					$db->setQuery($query);
					if (($number = $db->loadResult()) !== NULL) {
						if ( $link ) {
							$gn_comments = '<a href="'. $link .'">';
						}
						if ( $number == 1 ) {
							$gn_comments .= $number . '&nbsp;' . JText::_('Comment');
						} else {
							$gn_comments .= $number . '&nbsp;' . JText::_('Comments');
						}
						if ( $link ) {
							$gn_comments .= '</a>';
						}
					}
			    }
				 
	 			if ( preg_match("/GN_readmore/", $html) && $link && $rm ) {
		        	$gn_readmore  = JHTML::_('link', $link, JText::_('Read more > '));
	            }
				 
				$code = array("/GN_image/", "/GN_title/", "/GN_date/", "/GN_author/", "/GN_text/", "/GN_readmore/", "/GN_comments/","/GN_break/","/GN_space/");
				$rplc = array( $gn_image, $gn_title, $gn_created, $gn_author, $gn_text, $gn_readmore, $gn_comments, "<br />", "&nbsp;");
				 
				$lists[$i]->content = preg_replace($code, $rplc, $html);
				$lists[$i]->content = preg_replace('/\$-/','$',$lists[$i]->content);
				 				 
            endif;
			
			$i++;
		}

		return $lists;
	}
	
	function addGN_CSS(&$params, $layout, $globalnews_id) {
	
		$doc =& JFactory::getDocument();

		$layout   = $params->get( 'layout', 'list' );
		$padding  = (int)$params->get('padding', '5px');
		$border   = $params->get('border', '1px solid #EFEFEF');
		$color    = $params->get('color', '#FFFFFF');
		$show_cat = $params->get('show_cat', '1');
		
		$css = '';
		
		if ( $globalnews_id == 1 ) :
			$css .= ".gn_clear { clear:both; height:0; line-height:0; }\n";
		endif;
		
		$header   = '.gn_header_' . $globalnews_id . ' {'
			.' background-color:' . $params->get('header_color', '#EFEFEF') . ';'
			.' border:' . $border . ';'
			.' border-bottom:none;'
			.' padding:' . (int)$params->get('header_padding', '5px') . 'px;'
			.' }';
		
		$marquee  = ' border:' . $border . ';'
			. ( $show_cat != 0 ? ' border-top:none;' : '' )
			.' padding:' . $padding . 'px;'
			.' height:' . $params->get('height', '100px') . ';'
			.' background-color:' . $color . ';'
			.' overflow:hidden;';
				 
		switch ( $layout ) {
		 
			 case 'list' :
				   $css .=  $header . "\n"
						 .".gn_list_" . $globalnews_id . " {"
						 . $marquee
						 ." }";
				   break;
			
			 case 'static' :
				   $css .=  $header . "\n"
						 .".gn_static_" . $globalnews_id . " {"
						 . $marquee
						 ." }";
				   break;
		
			 case 'slider' :
				   $css .=  $header . "\n"
						 .".gn_slider_" . $globalnews_id . " {"
						 . $marquee
						 ." border-bottom:none;"
						 ." }" . "\n"
						 .".gn_slider_" . $globalnews_id . " .gn_opacitylayer {"
						 ." height:100%;"
						 ." filter:progid:DXImageTransform.Microsoft.alpha(opacity=100);"
						 ." -moz-opacity:1;"
						 ." opacity:1;"
						 ." }" . "\n"
						 .".gn_pagination_" . $globalnews_id . " {"
						 ." border:" . $border . ";"
						 ." border-top:none;"
						 ." padding:2px " . $padding . "px;"
						 ." text-align:right;"
						 ." background-color:" . $color . ";"
						 ." }" . "\n"
						 .".gn_pagination_" . $globalnews_id . " a:link {"
						 ." font-weight:bold;"
						 ." padding:0 2px;"
						 ." }" . "\n"
						 .".gn_pagination_" . $globalnews_id . " a:hover, .gn_pagination_" . $globalnews_id . " a.selected {"
						 ." color:#000;"
						 ." }";
				   break;
		
			 case 'browser' :
				   $containerIds = array();
				   for ($m=0;$m<$total;$m++) { 
						$containerIds[$m] = '#gn_container_' . $globalnews_id . '_' . ($m+1); }
				   $css .=  $header . "\n"
						 . implode(',' , $containerIds) . " {"
						 . $marquee
						 ." position: relative;"
						 ." }";
				   break;
		
			 case 'scroller' :
				   $scrollerIds = array();
				   for ($m=0;$m<$total;$m++) { 
						$scrollerIds[$m] = '#gn_scroller_' . $globalnews_id . '_' . ($m+1); }
				   $css .=  $header . "\n"
						 . implode(',' , $scrollerIds) . " {"
						 . $marquee
						 ." }";
				   break;
		}
		 
		return $doc->addStyleDeclaration($css);		 
	}
	
}