<?php 
/**
 * @package Component Tag for Joomla! 1.5
 * @version $Id: com_tag.php 599 2010-06-06 23:26:33Z you $
 * @author Joomlatags.org
 * @copyright (C) 2010- http://www.joomlatags.org
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined('_JEXEC') or die('Restricted access');

?>

<form action="index2.php" method="post" name="adminForm" id="adminForm"
	class="adminForm">
<table>
	
	<tr>
		<td colspan="5"><?php echo JText::_('Batch add terms, seperator with comma.');?></td>
	</tr>
	<tr>
		<td colspan="5"><textarea id="names" name="names" rows="5" cols="60"></textarea></td>
	</tr>

</table>

 <input type="hidden"
	name="task" value="batchsave"> <input type="hidden"
	name="controller" value="term"> <input type="hidden" name="option"
	value="com_tag"> <?php echo JHTML::_( 'form.token' ); ?></form>
