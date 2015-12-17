<?php
/** 
* @package     Type Me, Please 
* @subpackage  com_typingresults
* 
* @copyright   Copyright (C) 2015 Section Thirteen. All rights reserved. 
*/ 
// No direct access to this file
defined('_JEXEC') or die('Restricted access'); 
// Get an instance of the controller prefixed by HelloWorld
$controller = JControllerLegacy::getInstance('TypingResults'); 
// Perform the Request task
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task')); 
// Redirect if set by the controller
$controller->redirect(); 
?>