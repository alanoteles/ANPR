	<?php // @version $Id: default_results.php 11917 2009-05-29 19:37:05Z ian $
defined('_JEXEC') or die('Restricted access');
$count = 0;
?>

<?php if (!empty($this->searchword)) : ?>
<div class="searchintro<?php echo $this->escape($this->params->get('pageclass_sfx')) ?>">
	<p>
		<?php echo JText::_('Search Keyword') ?> <strong><?php echo $this->escape($this->searchword) ?></strong>
		<?php echo $this->result ?>
	</p>
</div>
<?php endif; ?>

<?php if (count($this->results)) : ?>
<div class="results">
	<h3><?php echo JText :: _('Search_result'); ?></h3>
	<?php $start = $this->pagination->limitstart + 1; ?>
	<ol class="list<?php echo $this->escape($this->params->get('pageclass_sfx')) ?>" start="<?php echo (int)$start ?>">
		<?php foreach ($this->results as $result) : $count++;?>
		<li class="<?php echo $count%2 ? 'var1' : 'var2'; ?>">
			<?php if ($result->href) : ?>
			<h4>
				<a href="<?php echo JRoute :: _($result->href) ?>" <?php echo ($result->browsernav == 1) ? 'target="_blank"' : ''; ?> >
					<?php echo $this->escape($result->title); ?></a>
			</h4>
			<?php endif; ?>
			<?php if ($result->section) : ?>
			<p><?php echo JText::_('Category') ?>:
				<span class="small<?php echo $this->escape($this->params->get('pageclass_sfx')) ?>">
					<?php echo $this->escape($result->section); ?>
				</span>
			</p>
			<?php endif; ?>

			<?php echo $result->text; ?>
			<span class="small<?php echo $this->escape($this->params->get('pageclass_sfx')) ?>">
				<?php echo $this->escape($result->created); ?>
			</span>
		</li>
		<?php endforeach; ?>
	</ol>
	<div style="text-align:center; padding-top:10px"><?php echo $this->pagination->getPagesLinks(); ?></div>
</div>
<?php endif; ?>
