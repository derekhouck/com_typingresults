<?php
/**
 * @package     Type Me, Please
 * @subpackage  com_typingresults
 *
 * @copyright   Copyright (C) 2015 Section Thirteen. All rights reserved. 
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<form action="index.php?option=com_typingresults&view=typingresults" method="post" id="adminForm" name="adminForm">
	<table class="table table-striped table-hover">
		<thead>
		<tr>
			<th width="1%"><?php echo JText::_('COM_TYPINGRESULTS_NUM'); ?></th>
			<th width="2%">
				<?php echo JHtml::_('grid.checkall'); ?>
			</th>
			<th width="90%">
				<?php echo JText::_('COM_TYPINGRESULTS_TYPINGRESULTS_HEADSHOT') ;?>
			</th>
			<th width="5%">
				<?php echo JText::_('COM_TYPINGRESULTS_DATE_TIME'); ?>
			</th>
			<th width="2%">
				<?php echo JText::_('COM_TYPINGRESULTS_ID'); ?>
			</th>
		</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="5">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php if (!empty($this->items)) : ?>
				<?php foreach ($this->items as $i => $row) : ?>
 
					<tr>
						<td>
							<?php echo $this->pagination->getRowOffset($i); ?>
						</td>
						<td>
							<?php echo JHtml::_('grid.id', $i, $row->id); ?>
						</td>
						<td>
							<?php echo $row->headshot; ?>
						</td>
						<td align="center">
							<?php echo $row->date_time; ?>
						</td>
						<td align="center">
							<?php echo $row->id; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
</form>