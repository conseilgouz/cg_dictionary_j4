<?php

/**
 * @version     2.0.2
 * @package     cg_dictionary for Joomla 4.0
 * @copyright   Copyright (C) 2021. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      ConseilgGouz à partir de Dictionary de www.web-eau.net
 **/
namespace ConseilGouz\Component\CGDictionary\Site\Model;
defined('_JEXEC') or die;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;

class DefinitionsModel extends ListModel {

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array(), MVCFactoryInterface $factory = null) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id', 'a.id',
                'word', 'a.word',
                'definition', 'a.definition',
                'family','a.family'
            );
        }
        parent::__construct($config,$factory);
    }

}
