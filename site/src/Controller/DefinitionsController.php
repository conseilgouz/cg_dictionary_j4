<?php
/**
 * @version     2.0.2
 * @package     cg_dictionary for Joomla 4.0
 * @copyright   Copyright (C) 2021. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      ConseilgGouz à partir de Dictionary de www.web-eau.net
 **/
namespace ConseilGouz\Component\CGDictionary\Site\Controller;
\defined('_JEXEC') or die;
use Joomla\CMS\MVC\Controller\BaseController;

class DefinitionsController extends BaseController
{
	public function getModel($name = 'Page', $prefix = 'CGDictionaryModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
}