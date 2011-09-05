<?php
/**
 * @package Component Tag for Joomla! 1.5
 * @version $Id: com_tag.php 599 2010-06-06 23:26:33Z you $
 * @author Joomlatags.org
 * @copyright (C) 2010- http://www.joomlatags.org
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined('_JEXEC') or die('Restricted access');

$tag	= JRequest::getVar('tag', null);
$tagKeyword=JText::_('TAG:').$tag;

$params = JComponentHelper::getParams('com_tag');
$topAds=$params->get('topAds');
$bottomAds=$params->get('bottomAds');
$showTagDescription=$params->get('description');
 $config =& JFactory::getConfig();
?>
<div class="componentheading"><?php echo($tag);?></div>

<table class="contentpaneopen" border="0" cellpadding="0"
	cellspacing="0" width="100%">
	<?php
	if(isset($showTagDescription)&&$showTagDescription){
		echo('<tr><td>'.$this->tagDescription.'</td></tr>');
	}
	if(isset($topAds)&&$topAds){
		echo('<tr><td>'.$topAds.'</td></tr>');
	}

	$count=$this->pagination->limitstart;
	if(isset($this->results)&&!empty($this->results)){
		require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');
		$odd=0;
		foreach( $this->results as $result ){ ?>
	<tr class="sectiontableentry<?php echo($odd+1);?>">
		<td>
		<div><span class="small"><?php echo (++$count).'. ';?></span> <a
			href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($result->slug, $result->catslug, $result->sectionid)); ?>">
			<?php echo $this->escape($result->title);?> </a></div>
		</td>
	</tr>
	<?php
	$odd=1-$odd;
		}
	} ?>
	<tr>
		<td>
		<div class="pagination"><?php echo $this->pagination->getPagesLinks(); ?></div>
		</td>
	</tr>
	<?php
	if(isset($bottomAds)&&$bottomAds){
		echo('<tr><td>'.$bottomAds.'</td></tr>');
	}
	?>
	<tr>
		<td>
		<div class="joomlatags">Powered by <a href="http://www.joomlatags.org"
			title="Tags for Joomla">Tags for Joomla</a></div>
		</td>
	</tr>
</table>

	<?php
	$document	   =& JFactory::getDocument();
	if($this->tagDescription){
		$document->setDescription( JoomlaTagsHelper::truncate($this->tagDescription) );
	}else{
		$document->setDescription(  JoomlaTagsHelper::truncate($tag) );
	}
	$document->setTitle($tag.' | '.$config->getValue('sitename'));
	$document->setMetadata('keywords', $tag);
	$document->addStyleSheet(JURI::base() . 'components/com_tag/css/tagcloud.css');
	?>

