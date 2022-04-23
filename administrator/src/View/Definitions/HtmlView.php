<?php

/**
 * @version     2.0.2
 * @package     cg_dictionary for Joomla 4.0
 * @copyright   Copyright (C) 2021. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      ConseilgGouz à partir de Dictionary de www.web-eau.net
 **/

namespace ConseilGouz\Component\CGDictionary\Administrator\View\Definitions;
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Helper\ContentHelper;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Language\Text;

class HtmlView extends BaseHtmlView {

    protected $items;
    protected $pagination;
    protected $state;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        $this->state = $this->get('State');
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');

        // Check for errors.
        if ($this->get('Errors') && count($errors = $this->get('Errors'))) {
  			Factory::getApplication()->enqueueMessage(implode("\n", $errors), 'error');        
        }
        //CGDictionaryHelper::addSubmenu('definitions');
        $this->addToolbar();
        // $this->sidebar = JHtmlSidebar::render();
        parent::display($tpl);
    }
    protected function addToolbar() {

		$state = $this->get('State');
        $canDo = ContentHelper::getActions('com_cgdictionary');

        ToolBarHelper::title(Text::_('COM_CGDICTIONARY_TITLE_DEFINITIONS'));

        if ($canDo->get('core.create')) {
            ToolBarHelper::addNew('definition.add', 'JTOOLBAR_NEW');
        }
        if ($canDo->get('core.edit') && isset($this->items[0])) {
            ToolBarHelper::editList('definition.edit', 'JTOOLBAR_EDIT');
        }

        if ($canDo->get('core.edit.state')) {
            if (isset($this->items[0]->state)) {
                ToolBarHelper::divider();
                ToolBarHelper::custom('definitions.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
                ToolBarHelper::custom('definitions.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
                ToolBarHelper::deleteList('', 'definitions.delete', 'JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) {
                ToolBarHelper::divider();
                ToolBarHelper::archiveList('definitions.archive', 'JTOOLBAR_ARCHIVE');
            }
            if (isset($this->items[0]->checked_out)) {
                ToolBarHelper::custom('definitions.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
        }

        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
            if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
                ToolBarHelper::deleteList('', 'definitions.delete', 'JTOOLBAR_EMPTY_TRASH');
                ToolBarHelper::divider();
            } else if ($canDo->get('core.edit.state')) {
                ToolBarHelper::trash('definitions.trash', 'JTOOLBAR_TRASH');
                ToolBarHelper::divider();
            }
        }

        if ($canDo->get('core.admin')) {
            ToolBarHelper::preferences('com_cgdictionary');
        }

        $this->extra_sidebar = '';
    }

}
