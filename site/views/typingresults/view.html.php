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
 * HTML View class for the TypingResults Component
 *
 * @since  0.0.1
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
		// Assign data to the view
		$this->currentActor = $this->get('CurrentActor');
		$this->headshotName = $this->get('HeadshotName');
		$this->headshotImage = $this->get('HeadshotImage');
		$this->ageMin = $this->get('AgeMin');
		$this->ageMax = $this->get('AgeMax');
		$this->lookLikeHeadshot = $this->get('LookLikeHeadshot');
		$this->ethnicity = $this->get('Ethnicity');
		$this->orientation = $this->get('Orientation');
		$this->occupation = $this->get('Occupation');
		$this->personality = $this->get('Personality');
		$this->archetype = $this->get('Archetype');
		
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');
 
			return false;
		}
 
		// Display the view
		parent::display($tpl);
	}
}