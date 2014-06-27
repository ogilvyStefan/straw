<?php
$path = drupal_get_path('theme', $GLOBALS['theme']);
$imgPath = base_path() . $path . '/img/';
?>
<nav>
	<div class="logo columns">
		<a href="<?php print url('<front>');?>" data-nid="1"><img src="<?php print $imgPath;?><?php print $greyLogo ? 'logo-grey.png' : 'logo-white.png';?>" alt=""></a>
	</div>                      
	<div class="menu-btn onlyOnMobyle">&#9776;</div>
	<div class="menu onlyOnDesk">
		<?php 
		foreach($menu as $menuK => $menuItem) {
			$class = '';
			if(isset($menuItem['attributes']) && !empty($menuItem['attributes']['class']) &&  $menuItem['attributes']['class'][0] == 'active-trail') {
				$active = true;
				$class .= ' active';
			}
			//echo $menuItem['href'];
			$nid = 0;
			if(substr($menuItem['href'], 0, 5) == 'node/') {
				$nid = substr($menuItem['href'],  5);
			}
			elseif($menuItem['href'] == '<front>') $nid = 1;
			echo '<a href="'.url($menuItem['href']).'" data-nid="'.$nid.'" class="'.$class.'">'.$menuItem['title'].'</a>';
		}
		?>		
	</div>                        
	<div class="clear"><!-- --></div>
</nav>