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
 * @since  0.0.1
 */
class TypingResultsModelTypingResults extends JModelItem
{
	protected function getCurrentHeadshot() {
		$jinput = JFactory::getApplication()->input;
		$currentHeadshot = $jinput->get('headshot');
		return $currentHeadshot;
	}
	// Get current actor
	public function getCurrentActor() {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$currentHeadshot = $this->getCurrentHeadshot();
		$query
			->select($db->quoteName(array('b.name')))
			->from($db->quoteName('#__content', 'a'))
			->join('INNER', $db->quoteName('#__users', 'b') . ' ON (' . $db->quoteName('a.created_by') . ' = ' . $db->quoteName('b.id') . ')')
			->where($db->quoteName('a.id')." = ".$db->quote($currentHeadshot));
		$db->setQuery($query);
		$result = $db->loadResult();
		return $result;
	}
	
	// Get name of current headshot
	public function getHeadshotName() {
		$currentHeadshot = $this->getCurrentHeadshot();
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select($db->quoteName(array('title')))
			->from($db->quoteName('#__content'))
			->where($db->quoteName('id')." = ".$db->quote($currentHeadshot));
		$db->setQuery($query);
		$result = $db->loadResult();
		return $result;
	}
	
	// Get headshot image
	public function getHeadshotImage() {
		$currentHeadshot = $this->getCurrentHeadshot();
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select($db->quoteName(array('b.headshot_image')))
			->from($db->quoteName('#__content', 'a'))
			->join('INNER', $db->quoteName('#__cck_store_form_headshot', 'b') . ' ON (' . $db->quoteName('a.id') . ' = ' . $db->quoteName('b.id') . ')')
			->where($db->quoteName('a.id')." = ".$db->quote($currentHeadshot));
		$db->setQuery($query);
		$result = $db->loadResult();
		$fileName = JFile::getName($result);
		$path =	substr( $result, 0, strrpos( $result, '/' ) ).'/';
		$thumb = $path . '_thumb1/' . $fileName;
		return $thumb;
	}
	
	// Integer results query
	private function getInt($field)	{
		$currentHeadshot = $this->getCurrentHeadshot();
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select(array($field, 'COUNT(*)'))
			->from($db->quoteName('headshot_typing'))
			->where($db->quoteName('headshot')." = ".$db->quote($currentHeadshot)." AND ".$db->quoteName($field)." IS NOT NULL" )
			->group($db->quoteName($field));
		$db->setQuery($query);
		$rows = $db->loadRowList();
		$formattedRows = array();
		foreach ($rows as $row)
		{
			$formattedRows[] = array('label' => $row[0], 'value' => $row[1]);
		}
		$jsonRows = json_encode($formattedRows, JSON_NUMERIC_CHECK);
		return $jsonRows;
	}
	public function getAgeMin() {	
		// Age Range Minimum query
		$ageMinResults = $this->getInt('age_range_minimum');
		return $ageMinResults;
	}
	public function getAgeMax() {	
		// Age Range Minimum query
		$ageMaxResults = $this->getInt('age_range_maximum');
		return $ageMaxResults;
	}
	public function getLookLikeHeadshot() {	
		$currentHeadshot = $this->getCurrentHeadshot();
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select(array('look_like_headshot_', 'COUNT(*)'))
			->from($db->quoteName('headshot_typing'))
			->where($db->quoteName('headshot')." = ".$db->quote($currentHeadshot)." AND ".$db->quoteName('look_like_headshot_')." != ' '")
			->group($db->quoteName('look_like_headshot_'));
		$db->setQuery($query);
		$rows = $db->loadRowList();
		$formattedRows = array();
		foreach ($rows as $row)
		{
			$formattedRows[] = array('label' => $row[0], 'value' => $row[1]);
		}
		$jsonRows = json_encode($formattedRows, JSON_NUMERIC_CHECK);
		return $jsonRows;
	}
	private function formatResults($results) {
		$brackets = array ('"', "[", "]");
		$removeBrackets = str_replace($brackets, "", $results);
		$allLowercase = strtolower($removeBrackets);
		return $allLowercase;
	}
	private function getStringArray($field) {	
		$currentHeadshot = $this->getCurrentHeadshot();
		// String Array query
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select(array($field))
			->from($db->quoteName('headshot_typing'))
			->where($db->quoteName('headshot')." = ".$db->quote($currentHeadshot)." AND ".$db->quoteName($field)." != ' '");
		$db->setQuery($query);
		$column = $db->loadColumn();
		$columnData = implode(",", $column);
		$formattedResults = $this->formatResults($columnData);
		$formattedArray = explode(",", $formattedResults);
		return $formattedArray;
	}
	private function convertToJson($formattedArray) {
		$jsonRows = json_encode($formattedArray, JSON_NUMERIC_CHECK);
		return $jsonRows;	
	}
	private function countStringArray($stringArray) {
		$valueCountArray = array_count_values($stringArray);
		$formattedValueCount = array();
		foreach ($valueCountArray as $key => $value)
		{
			$formattedValueCount[] = array('label' => $key, 'value' => $value);
		}
		$jsonRows = json_encode($formattedValueCount, JSON_NUMERIC_CHECK);
		return $jsonRows;
	}
	private function countCloudArray($stringArray) {
		$valueCountArray = array_count_values($stringArray);
		$formattedValueCount = array();
		foreach ($valueCountArray as $key => $value)
		{
			$formattedValueCount[] = array('text' => $key, 'size' => $value * 2 + 10, 'value' => $value);
		}
		$jsonRows = json_encode($formattedValueCount, JSON_NUMERIC_CHECK);
		return $jsonRows;
	}
	public function getEthnicity() {
		//Ethnicity query
		$ethnicityResults = $this->getStringArray('ethnicity');
		$ethnicityCount = $this->countCloudArray($ethnicityResults);
		return $ethnicityCount;
	}
	public function getOrientation() {
		//Orientation query
		$orientationResults = $this->getStringArray('orientation');
		$orientationCount = $this->countStringArray($orientationResults);
		return $orientationCount;
	}
	public function getOccupation() {
		//Occupation query
		$occupationResults = $this->getStringArray('occupation');
		$occupationCount = $this->countCloudArray($occupationResults);
		return $occupationCount;
	}
	public function getPersonality() {
		//Personality query
		$personalityResults = $this->getStringArray('personality');
		$personalityCount = $this->countCloudArray($personalityResults);
		return $personalityCount;
	}
	public function getArchetype() {
		//Archetype query
		$archetypeResults = $this->getStringArray('archetype');
		$archetypeCount = $this->countCloudArray($archetypeResults);
		return $archetypeCount;
	}
}
?>