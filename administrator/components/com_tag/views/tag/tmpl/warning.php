<?php 
/**
 * @package Component Tag for Joomla! 1.5
 * @version $Id: com_tag.php 599 2010-06-06 23:26:33Z you $
 * @author Joomlatags.org
 * @copyright (C) 2010- http://www.joomlatags.org
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

defined('_JEXEC') or die('Restricted access');
$firstWarning=JRequest::getVar('FirstWarning',true);
$warning=JRequest::getVar('tagsWarning','FIRST_SAVE_WARNING');
if($firstWarning){
	$document =& JFactory::getDocument();
	$document->addStyleSheet(JURI::base() . 'components/com_tag/css/tag.css');

	?>

<div class="warning">
<h1><?php echo JText::_('WARNING');?></h1>
<h2>
<?php echo JText::_('FIRST_SAVE_WARNING');?>
</h2>
</div>
	<?php };
	JRequest::setVar('FirstWarning',false);
	?>

