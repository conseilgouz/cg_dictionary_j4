<?php
/**
 * @version     2.0.2
 * @package     cg_dictionary for Joomla 4.0
 * @copyright   Copyright (C) 2021. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      ConseilgGouz à partir de Dictionary de www.web-eau.net
 **/
 
// no direct access

defined('_JEXEC') or die;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;

$doc = Factory::getDocument();

HTMLHelper::_('bootstrap.framework');
HTMLHelper::_('bootstrap.framework');
$iso_layout ='masonry';

$params = Factory::getApplication()->getParams('com_cgdictionary'); // global parameters
// get menu parameters
$input = Factory::getApplication()->getInput();
$nbcol = $input->getInt('iso_nbcol',0);
$defhidden = $input->getString('hide_definition','');
// get global parameters if not defined in menu parameters
if (!$nbcol) $nbcol = $params->get('iso_nbcol');
if (!$defhidden) $defhidden = $params->get('hide_definition');

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = Factory::getApplication()->getDocument()->getWebAssetManager();

$doc->addStyleSheet(JURI::base() . 'media/com_cgdictionary/css/dictionary.css');
$doc->addScript(JURI::base() . 'media/com_cgdictionary/js/imagesloaded.min.js');
$doc->addScript(JURI::base() . 'media/com_cgdictionary/js/isotope.min.js');
$doc->addScript(JURI::base() . 'media/com_cgdictionary/js/packery-mode.min.js');
$doc->addScript(JURI::base() . 'media/com_cgdictionary/js/dictionary.js');

// send parameters to ditionary.js
$doc->addScriptOptions('cg_dictionary', 
		array('layout' => $iso_layout,'nbcol' => $nbcol,'defhidden' => $defhidden)
		);
?>
<meta name="viewport" content="width=device-width" />

<?php
$db = Factory::getDbo();
$q2 = $db->getQuery(true);
$counter = 1;
?>
	<div >
	<div >
	<input type="text" class="quicksearch_sigle" style="margin-left: 10%;float:left" placeholder="Chercher un Sigle" />
	</div>
	<div  >
		<input type="text" class="quicksearch_text" style="margin-left: 10%;margin-bottom:1em" placeholder="Chercher un Texte" />
	</div>
    <div class="isotope_grid">
 
<?php
	$prev = "";
	$q2 = "SELECT * FROM `#__cg_dictionary` order by SUBSTR(word, 1, 1)";
	$db->setQuery($q2);
	$r2 = $db->loadObjectList();
	for($j=0; $j<count($r2); $j++) {
		$letter = "";
		$first = strtoupper(strtr(substr($r2[$j]->word,0,1),'éè','ee'));
		if ($first != $prev) {
			$prev = $first;
			$letter = "<div class='isotope_item letter' data-word=''>---".$prev."---</div>";
		}
		echo $letter."<div id='counter-".$counter."' class='isotope_item ' data-word='". $r2[$j]->word."'>";
		$def = "";
		if ($defhidden == 'hover') 
			$def = 'class ="gloss" gloss="'.$r2[$j]->definition.'" ';
		
		echo '<a  class="cg_a" data-target="text_'.$counter.'"><span '.$def.'> <b>'. $r2[$j]->word .'</b></span></a>';
		if ($defhidden == 'click') $div = "div"; else $div = "span";
		echo "<".$div." id='text_".$counter."' class='cg_text'>". $r2[$j]->definition ."</".$div."><span class='right'>".$r2[$j]->family."</span></div>";
		$counter++;
	}
?>
	</div>
</div>
