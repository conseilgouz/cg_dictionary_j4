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
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

// HTMLHelper::_('formbehavior.chosen', 'select');
// Import CSS/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
$wa->registerAndUseStyle('dictionary', 'media/com_cgdictionary/css/dictionary.css')
	->useScript('keepalive')
	->useScript('form.validate');

?>
<form action="<?php echo Route::_('index.php?option=com_cgdictionary&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="letterdefinition-form" class="form-validate">
    <div class="form-horizontal">
        <div class="row-fluid">
            <div class="span10 form-horizontal">
                <fieldset class="adminform">
					<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('word'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('word'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('definition'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('definition'); ?></div>
					</div>
                </fieldset>
            </div>
        </div>
        <input type="hidden" name="task" value="" />
        <?php echo HTMLHelper::_('form.token'); ?>

    </div>
</form>