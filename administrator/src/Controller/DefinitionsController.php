<?php
/**
 * @package     cg_dictionary for Joomla 4.x/5.x/6.x
 * @copyright   Copyright (C) 2025. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      ConseilgGouz à partir de Dictionary de www.web-eau.net
 **/
namespace ConseilGouz\Component\CGDictionary\Administrator\Controller;

\defined('_JEXEC') or die;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\AdminController;
use Joomla\CMS\Router\Route;
use Joomla\Database\DatabaseInterface;
use Joomla\Utilities\ArrayHelper;

class DefinitionsController extends AdminController {
	/**
	 * The default view.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $default_view = 'definitions';



	public function delete()
	{
		// Get the input
		$input = Factory::getApplication()->getInput();
		$pks = $input->post->get('cid', array(), 'array');
		
		$count = 0;
		foreach ($pks as $pk)	{
			$db = Factory::getContainer()->get(DatabaseInterface::class);
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__cg_dictionary'));
			$query->where($db->quoteName('id') . ' = '.$pk);
			$db->setQuery($query);
			$result = $db->execute();
			$count++;
		}	
		Factory::getApplication()->enqueueMessage($count.Text::_('COM_CGDICTIONARY_DELETE'), 'notice');
		$this->setRedirect(Route::_('index.php?option=com_cgdictionary', false));		
	}

	/**
	 * Method to save the submitted ordering values for records via AJAX.
	 *
	 * @return  void
	 *
	 * @since   3.0
	 */
	public function saveOrderAjax()
	{
		// Get the input
		$input = Factory::getApplication()->getInput();
		$pks = $input->post->get('cid', array(), 'array');
		$order = $input->post->get('order', array(), 'array');

		// Sanitize the input
		ArrayHelper::toInteger($pks);
		ArrayHelper::toInteger($order);

		// Get the model
		$model = $this->getModel();

		// Save the ordering
		$return = $model->saveorder($pks, $order);

		if ($return)
		{
			echo "1";
		}

		// Close the application
		Factory::getApplication()->close();
	}
    
    
    
}