<?php

/**
 * 
 * @version		3.0.0
 * @package		Joomla
 * @subpackage	Tabs Manager GK3
 * @copyright	Copyright (C) 2008 - 2009 GavickPro. All rights reserved.
 * @license		GNU/GPL
 * 
 * ==========================================================================
 * 
 * Gavick News View.
 * 
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
class ViewGavickNews
{	
    /**
     * ViewGavickNews::view_news()
     * 
     * @return null
     */
     
    function view_news()
    {
   	    //
    	$modal_news =  (JRequest::getCmd( 'tmpl', '' ) == 'component') ? 1 : 0;
    	//
    	$uri =& JURI::getInstance();
		//
		$content = $this->loadGavickRSS('one', $modal_news);
		require_once(JPATH_COMPONENT.DS.'views'.DS.'navigation.view.php');
		require_once(JPATH_COMPONENT.DS.'views'.DS.'tmpl'.DS.'gavick.news.news.html.php');
    }
    
    /**
     * ViewGavickNews::view_all()
     * 
     * @return null
     */
     
    function view_all()
	{
		//
    	$modal_news =  (JRequest::getCmd( 'tmpl', '' ) == 'component') ? 1 : 0;
		//
    	$uri =& JURI::getInstance();
		//
		$content = $this->loadGavickRSS('all', $modal_news);
		require_once(JPATH_COMPONENT.DS.'views'.DS.'navigation.view.php');
		require_once(JPATH_COMPONENT.DS.'views'.DS.'tmpl'.DS.'gavick.news.news_all.html.php');
	}
    
    /**
     * ViewGavickNews::loadGavickRSS()
     * 
     * @param mixed $mode
     * @param mixed $modal_news
     * @return null
     */
     
    function loadGavickRSS($mode, $modal_news)
    {
    	//
    	$uri =& JURI::getInstance();
    	//
    	if($mode == 'one')
		{
			$num = (int) JRequest::getCmd( 'num', '0' );
			//
			$rssNews = '';
			//
			if(ini_get('allow_url_fopen'))
			{
				$rssNews = file_get_contents('http://gavick.com/index.php?format=feed&type=rss');
				$xml = & JFactory::getXMLParser('Simple');
				$rssNews = str_replace(' xmlns:atom="http://www.w3.org/2005/Atom"', '',$rssNews);
				$rssNews = str_replace('<atom:link rel="self" type="application/atom+xml" href="http://www.gavick.com/index.php?format=feed&amp;type=atom" />', '', $rssNews);
				
				if($xml->loadString($rssNews))
				{
					$rssNews = '';
					
					$rssNews .= '<h2><a href="'.$xml->document->channel[0]->item[$num]->link[0]->data().'">'.$xml->document->channel[0]->item[$num]->title[0]->data().'</a></h2><p><small>'.$xml->document->channel[0]->item[$num]->pubDate[0]->data().'</small></p>';
					$rssNews .= $xml->document->channel[0]->item[$num]->description[0]->data().'<br /><a href="'.$xml->document->channel[0]->item[$num]->link[0]->data().'">'.JText::_('READ_MORE').' &raquo;</a><br />';
				}
				else
				{
					$rssNews = JText::_('NEWS_PARSE_ERROR');
				}
			}
			else
			{
				$rssNews = JText::_('NEWS_NO_CONFIGURATION');
			}
			
			return $rssNews;		
		}
		else
		{
			//
			$rssNews = '';
			//
			if(ini_get('allow_url_fopen'))
			{
				$rssNews = file_get_contents('http://gavick.com/index.php?format=feed&type=rss');
				$xml = & JFactory::getXMLParser('Simple');
				$rssNews = str_replace(' xmlns:atom="http://www.w3.org/2005/Atom"', '',$rssNews);
				$rssNews = str_replace('<atom:link rel="self" type="application/atom+xml" href="http://www.gavick.com/index.php?format=feed&amp;type=atom" />', '', $rssNews);
				//
				if($xml->loadString($rssNews))
				{
					//
					$rssNews = '';
					//
					$i = 0;
					//
					while(isset($xml->document->channel[0]->item[$i]))
					{
						$rssNews .= '<h2><a href="'.$xml->document->channel[0]->item[$i]->link[0]->data().'">'.$xml->document->channel[0]->item[$i]->title[0]->data().'</a></h2><p><small>'.$xml->document->channel[0]->item[$i]->pubDate[0]->data().'</small></p>';
						$rssNews .= $xml->document->channel[0]->item[$i]->description[0]->data().'<br /><a href="'.$xml->document->channel[0]->item[$i]->link[0]->data().'">'.JText::_('READ_MORE').' &raquo;</a><br />';
						$i++;
					}
				}
				else
				{
					$rssNews = JText::_('NEWS_PARSE_ERROR');
				}
			}
			else
			{
				$rssNews = JText::_('NEWS_NO_CONFIGURATION');
			}
			
			return $rssNews;
		}
    }
}

/* End of file gavick.news.view.php */
/* Location: ./views/gavick.news.view.php */