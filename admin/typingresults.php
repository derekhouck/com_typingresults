<?php
/**
/**
 * @package     Type Me, Please
 * @subpackage  com_typingresults
 *
* @copyright   Copyright (C) 2015 Section Thirteen. All rights reserved. 
*/ 
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// Get an instance of the controller prefixed by TypingResults
$controller = JControllerLegacy::getInstance('TypingResults');
 
// Perform the Request task
$controller->execute(JFactory::getApplication()->input->get('task'));
 
// Redirect if set by the controller
$controller->redirect();
?>