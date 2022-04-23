<?php
/**
 * @version     2.0.2
 * @package     cg_dictionary for Joomla 4.0
 * @copyright   Copyright (C) 2021. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      ConseilgGouz à partir de Dictionary de www.web-eau.net
 **/
namespace ConseilGouz\Component\CGDictionary\Administrator\Controller;

\defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\FormController;
use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;

class ImportController extends FormController
{
	public function importcsv()
	{
		$file_tmp_path = $_FILES['fileupload']['tmp_name'];
		$file_name = $_FILES['fileupload']['name'];

		$model = $this->getModel('import');
		$model->import(addslashes($file_tmp_path),addslashes($file_name));
		$this->setRedirect(Route::_('index.php?option=com_cgdictionary', false));
	
	}
}