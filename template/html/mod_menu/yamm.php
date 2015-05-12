<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Note. It is important to remove spaces between elements.

$startlevel = $params->get('startLevel');


?>
<?php // The menu class is deprecated. Use nav instead. ?>

<!--<style>

	.yamm-fw .dropdown-menu {
		display: block!important;
	}

</style>-->

<ul class="<?php echo $class_sfx;?> nav navbar-nav"<?php
	$tag = '';

	if ($params->get('tag_id') != null) {
		$tag = $params->get('tag_id') . '';
		echo ' id="' . $tag . '"';
	}
?>>
<?php

foreach ($list as $i => &$item)
{
	
	$class = 'item-' . $item->id;

	if ($item->id == $active_id) { $class .= ' current'; }

	if (in_array($item->id, $path))
	{
		$class .= ' active';
	}
	elseif ($item->type == 'alias')
	{
		$aliasToId = $item->params->get('aliasoptions');

		if (count($path) > 0 && $aliasToId == $path[count($path) - 1])
		{
			$class .= ' active';
		}
		elseif (in_array($aliasToId, $path))
		{
			$class .= ' alias-parent-active';
		}
	}
	
	if($item->params->get('headline') == 1) { $class .= ' headline'; }

	if ($item->type == 'separator') { $class .= ' divider'; }

	if ($item->deeper) { $class .= ' deeper'; }

	if ($item->parent) { $class .= ' parent'; }
	
	if($item->parent OR $item->deeper) { $class .= ' dropdown'; }
	
	if($item->params->get('dropdowncolumns')) { $columnwidth = 12 / $item->params->get('dropdowncolumns'); }
	
	if(($item->parent OR $item->deeper) && $item->params->get('dropdownfullwidth') == 1) { $class .= ' yamm-fw'; }

	if (!empty($class))
	{
		$class = ' class="' . trim($class) . '"';
	}
	
	if($item->params->get('headline') == 1 && $columntoclose == true) {
	
		echo '</ul></div>';
		
		$columntoclose = false;
		
	}
	
	
	if($item->params->get('headline') == 1) {
	
		echo '<div class="col-md-'.$columnwidth.'"><ul class="list-unstyled">';
		
		$columntoclose = true;
		$listtoopen = false;
		
	} elseif($listtoopen == true) {
	
		echo '<ul class="list-unstyled">';
		
		$listtoopen = false;
		
	}
	
	echo '<li' . $class . '>';

	// Render the menu item.
	switch ($item->type) :
		case 'separator':
		case 'url':
		case 'component':
		case 'heading':
			require JModuleHelper::getLayoutPath('mod_menu', 'yamm_' . $item->type);
			break;

		default:
			require JModuleHelper::getLayoutPath('mod_menu', 'yamm_url');
			break;
	endswitch;

	// The next item is deeper.
	if($item->deeper) {
	
		// Menüpunkte der ersten Ebene, die Unterpunkte haben, bekommen ein Dropdown-Menü
		if($item->level == $startlevel && $item->deeper) {
			echo '<ul class="dropdown-menu"><li><div class="yamm-content"><div class="row">';
			$listtoopen = true;
		} else {
			echo '<ul class="list-unstyled">';
		}
		
	}
	elseif ($item->shallower)
	{
		// The next item is shallower.

		
		echo '</li>';
		
		if($item->level - $item->level_diff == $startlevel) {
			echo str_repeat('</ul></li>', $item->level_diff - 1).'</ul>';
			if($columntoclose) { echo '</div>'; $columntoclose = false; }
			echo '</div></div></li></ul></li>';
		} else {
			echo str_repeat('</ul></li>', $item->level_diff);
		}
		
	}
	else
	{
		// The next item is on the same level.
		echo '</li>';
	}
}
?>
</ul>

<script>

	jQuery(function($) {
	
		$('.navbar .dropdown').hover(function() {
			$(this).find('.dropdown-menu').first().stop(true, true).slideDown(150);
		}, function() {
			$(this).find('.dropdown-menu').first().stop(true, true).slideUp(105)
		});
	
	});

</script>
