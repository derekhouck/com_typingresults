<?php
/**
 * @package     Type Me, Please
 * @subpackage  com_typingresults
 *
* @copyright   Copyright (C) 2015 Section Thirteen. All rights reserved. 
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * TypingResults View
 *
 * @since  0.0.8
 */
class TypingResultsViewTypingResults extends JViewLegacy
{
	/**
	 * Display the Typing Results view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 */
	function display($tpl = null)
	{
		// Get data from the model
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
 
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
 
			return false;
		}
 
		// Display the template
		parent::display($tpl);
	}
} ?>