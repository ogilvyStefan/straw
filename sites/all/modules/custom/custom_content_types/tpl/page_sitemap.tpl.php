<?php
	// no main header image page, used for terms page
?>
<section id="terms" class="light-grey-bg menu-container">
		
	<div class="h10"><!-- --></div>	
	<div class="max-container">
		<div class="h25 onlyOnMobile"><!-- --></div>
		
		<?php strawberry_RenderSiteMenu(); ?>
		
		<div class="max-content">
			<div class="tomb">
				<div class="h40"><!-- --></div>
				<h1><?php print t('Sitemap'); ?></h1>
				
				<ul class="sitemap-menu">
					<?php $used = array(); ?>
					<?php foreach($mainMenu as $key => $item): 	?>
						<?php if(isset($used[$item['href']])) continue; ?>
						<?php $used[$item['href']] = true; ?>
						<li><?php echo l($item['title'], $item['href']); ?></li>
					<?php endforeach; ?>

					<?php foreach($footerMenu as $key => $item): 	?>
						<?php if(isset($used[$item['href']])) continue; ?>
						<?php $used[$item['href']] = true; ?>
						<li><?php echo l($item['title'], $item['href']); ?></li>
					<?php endforeach; ?>
				</ul>
			<div class="clear"><!-- --></div>
			</div>
		</div>
		<div class="clear"><!-- --></div>
	</div>
	<div class="h100"><!-- --></div>
</section>