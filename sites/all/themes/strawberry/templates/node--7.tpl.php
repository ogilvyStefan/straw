<?php 
	//contact us
	//print_r(array_keys($content));

$bgUrl = file_create_url($field_header_background[0]['uri']);
$bgStyle = 'background-image:url('.$bgUrl.');';
?>
<section id="lettings">
	<section id="one" class="scroll-section" style="<?php print $bgStyle;?>">
		<div class="h10"><!-- --></div>
		
		<div class="max-container">
			<div class="h25 onlyOnMobile"><!-- --></div>
			
			<?php strawberry_RenderSiteMenu(false); ?>

			<div class="middle-content">
				<h1><?php print $field_title[0]['safe_value'];?></h1>
			</div>
				
			<a href="#two" class="section-arrow jumper" data-slide="#two"><img src="<?php print $img_path;?>screen_arrow.png" alt=""></a>			
		</div>
	</section>    
</section>

<section id="two" class="light-grey-bg section_page scroll-section node-contact-us">
	<div class="h10"></div>
	<div class="max-container">
		
		<?php strawberry_RenderSiteMenu(); ?>

		<div class="middle-container">
			<h1><?php print $title;?></h1>								
			<?php print $body[0]['safe_value'];?>
			<div class="h30"></div>
			<?php print render($content['webform']); ?>
			
			<?php if(!empty($field_footer_mailto)): ?>
			<p>
				Interested in joining the team ? <a href="mailto:<?php print $field_footer_mailto[0]['safe_value'];?>"><?php print $field_footer_mailto[0]['safe_value'];?></a>
			</p>
			<?php endif; ?>
			<br />
		</div>
	</div>
</section>