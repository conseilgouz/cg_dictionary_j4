<?php
/**
 * @package     cg_dictionary for Joomla 4.x/5.x/6.x
 * @copyright   Copyright (C) 2025. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      ConseilgGouz à partir de Dictionary de www.web-eau.net
 **/
namespace ConseilGouz\Component\CGDictionary\Administrator\Model;
use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\Registry\Registry;
use Joomla\CMS\Table\Table;
use Joomla\Database\DatabaseInterface;

class DefinitionModel extends AdminModel {

	protected $text_prefix = 'definition';

	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = '', $prefix = 'DictionaryTable', $config = array())
	{
	    $db = Factory::getContainer()->get(DatabaseInterface::class);
	    return Table::getInstance('DictionaryTable','ConseilGouz\\Component\\CGDictionary\Administrator\\Table\\', array('dbo' => $db));
	    
		// return Table::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		An optional array of data for the form to interogate.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	JForm	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Initialise variables.
		$app	= Factory::getApplication();
		// Get the form.
		$form = $this->loadForm('com_cgdictionary.definition', 'definition', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}
		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = Factory::getApplication()->getUserState('com_cgdictionary.edit.definition.data', array());

		if (empty($data)) {
			$data = $this->getItem();
            
		}

		return $data;
	}
	protected function prepareTable($table)
	{
		if (empty($table->id)) {
			// Set ordering to the last item if not set
			if (@$table->ordering === '') {
				$db = Factory::getContainer()->get(DatabaseInterface::class);
				$db->setQuery('SELECT MAX(ordering) FROM #__cg_dictionary');
				$max = $db->loadResult();
				$table->ordering = $max+1;
			}
		}
	}

}