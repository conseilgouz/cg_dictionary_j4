<?php
/**
 * @version     2.0.2
 * @package     cg_dictionary for Joomla 4.0
 * @copyright   Copyright (C) 2018. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      ConseilgGouz à partir de Dictionary de www.web-eau.net
 **/
// no direct access

defined('_JEXEC') or die;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

HTMLHelper::_('bootstrap.tooltip');

// Import CSS
// Import CSS/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
$wa->registerAndUseStyle('dictionary', 'media/com_cgdictionary/css/dictionary.css');
//Joomla Component Creator code to allow adding non select list filters
if (!empty($this->extra_sidebar)) {
    $this->sidebar .= $this->extra_sidebar;
}
?>

<form action="<?php echo Route::_('index.php?option=com_cgdictionary&view=import'); ?>" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
<?php if(!empty($this->sidebar)): ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
<?php else : ?>
	<div id="j-main-container">
<?php endif;?>
		<div class="clearfix"> </div>
		<p><?php echo Text::_('COM_CGDICTIONARY_IMPORT_NOTE');?></p>
		<div id="filter-bar" class="btn-toolbar">
			<div class="filter-search btn-group pull-left">
				<label><?php echo Text::_('COM_CGDICTIONARY_SELECT');?></label>
				<input type="file" name="fileupload" />
				<input type="submit" value="Import" name="import">
				<input type="hidden" name="task" value="import.importcsv" />
			</div>
		</div>        
		<?php echo HTMLHelper::_('form.token'); ?>
	</div>
</form>        

		
