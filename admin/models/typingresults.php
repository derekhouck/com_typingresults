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
 * TypingResults Model
 *
 * @since  0.0.8
 */
class TypingResultsModelTypingResults extends JModelList
{
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return      string  An SQL query
	 */
	protected function getListQuery()
	{
		// Initialize variables.
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
 
		// Create the base select statement.
		$query->select('*')
                ->from($db->quoteName('headshot_typing'));
 
		return $query;
	}
} ?>