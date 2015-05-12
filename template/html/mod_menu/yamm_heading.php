<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

if($item->menu_image) { ?>

<img src="<?=$item->menu_image?>">
<span class="nav-header"><?php echo $item->title; ?></span>

<?php } elseif($item->params->get('loadmodule')) { ?>

<?php

	$document = &JFactory::getDocument();
	$renderer   = $document->loadRenderer('modules');
	$position   = $item->params->get('loadmodule');
	$options   = array('style' => 'raw');
	echo $renderer->render($position, $options, null);

} else { ?>
<span class="nav-header"><?php echo $item->title; ?></span>
<?php } ?>