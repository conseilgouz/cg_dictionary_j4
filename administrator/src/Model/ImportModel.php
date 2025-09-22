<?php
/**
 * @package     cg_dictionary for Joomla 4.x/5.x/6.x
 * @copyright   Copyright (C) 2025. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      ConseilgGouz à partir de Dictionary de www.web-eau.net
 **/
namespace ConseilGouz\Component\CGDictionary\Administrator\Model;

defined('_JEXEC') or die;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Table\Table;
use Joomla\Database\DatabaseInterface;
use Joomla\Utilities\ArrayHelper;

class ImportModel extends ListModel {

    /**
     * Build an SQL query to load the list data.
     *
     * @return	JDatabaseQuery
     * @since	1.6
     */
    protected function getListQuery() {
        // Create a new query object.
        $db = Factory::getContainer()->get(DatabaseInterface::class);
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select', 'DISTINCT a.*'
                )
        );
        $query->from('`#__cg_dictionary` AS a');
        return $query;
    }

    function import($file_tmp_name, $file_name)
    {
        echo "<pre>";
        if (($handle = @fopen($file_tmp_name, "r")) !== FALSE) {
            $counter = 0;

            while (($data = fgetcsv($handle,0,";")) !== FALSE) { // default separator => ;
				$data = array_map("utf8_encode", $data); //added
                if($counter == 0) { $counter++ ; continue; }

                $definitions[$counter] = array(
                    "word" => $data[0],
                    "definition" => $data[1],
                    "family" => $data[2]
                    );

                $counter++;
            }
            fclose($handle);
            $db = Factory::getContainer()->get(DatabaseInterface::class);

            for ($i=1; $i <= count($definitions) ; $i++) { 
                if ( empty($definitions[$i]['word'])) { continue; }
                $query = $db->getQuery(true)
                ->select($db->quoteName('id'))
                ->from($db->quoteName('#__cg_dictionary'))
                ->where($db->quoteName('word') . ' = '.$db->quote($definitions[$i]['word']))
                ->where($db->quoteName('family') . ' = '.$db->quote($definitions[$i]['family']));
                $db->setQuery($query);
                $exist = $db->loadResult();
                if ($exist) {// update
                    $query = $db->getQuery(true)
                            ->update('#__cg_dictionary')
                            ->set('definition = '.$db->quote($definitions[$i]['definition']))
                            ->where('id = '.$exist);
                    $db->setQuery($query);
                    $db->execute();
                } else { // insert
                    $fields = ['word','family','definition'];
                    $values = [$db->quote($definitions[$i]['word'])
                        ,$db->quote($definitions[$i]['family'])
                        ,$db->quote($definitions[$i]['definition'])
                    ];
                    $query = $db->getQuery(true)
                    ->insert('#__cg_dictionary')
                    ->columns($fields) 
                    ->values(implode(',', $values));
                    $db->setQuery($query);
                    $db->execute();
                }
            }
        }
        
    }

}
