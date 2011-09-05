<?php 
/**
 * @package Component Tag for Joomla! 1.5
 * @version $Id: com_tag.php 599 2010-06-06 23:26:33Z you $
 * @author Joomlatags.org
 * @copyright (C) 2010- http://www.joomlatags.org
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined('_JEXEC') or die('Restricted access');
	$params = array(
 		'smilies'		=> 0,
		'style'			=> 0,
		'layer'			=> 0,
 		'table'			=> 0,
 		'clear_entities'=> 0
 	);
 
 	if (isset($this->term)) {
 		$name			= $this->term->name;
 		$weight			= $this->term->weight;
 		$description	= $this->term->description;
 		$id				= $this->term->id;
 	} else {
 		$name			= '';
 		$weight			= 0;
 		$description	= '';
 		$id				= false;
 	}
$editor =& JFactory::getEditor();
?>

<form action="index2.php" method="post" name="adminForm" id="adminForm"
	class="adminForm" onsubmit="<?php echo $editor->save('description'); ?>">
<table width="75%" align="left">
	<tr>
		<td>
 				<?php echo JText::_('TERM NAME');?>:
 				<input style="margin: 0 2em;" class="inputbox" type="text" size="30" maxlength="100" name="name" value="<?php echo $name;?>">

		<?php echo JText::_('WEIGHT');?>:
				<input class="inputbox" type="text" size="10" maxlength="10" name="weight" value="<?php echo $weight;?>">
 			</td>
	</tr>
	<tr>
		<td><?php echo JText::_('TERM DESCRIPTION');?>:</td>
	</tr>
	<tr>
	<td>
 				<?php echo $editor->display('description', $description, '100%', '400px', '150', '20', true, $params); ?>
 			</td>
	</tr>

</table>

<input type="hidden" name="controller" value="term" /> 
<input	type="hidden" name="task" value="save"> 
<input type="hidden" name="id"	value="<?php  echo  $term->id;?>">
<input type="hidden" name="cid[]"	value="<?php  echo  $term->id;?>">
<input type="hidden" name="option"	value="com_tag">
<?php echo JHTML::_( 'form.token' ); ?>
</form>
