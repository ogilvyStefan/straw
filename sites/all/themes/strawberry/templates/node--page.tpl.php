<?php
// node home

$bgUrl = file_create_url($field_header_background[0]['uri']);
$bgStyle = 'background-image:url('.$bgUrl.');';

/*
//ie8 fix
$bgStyle .= ' filter: progid:DXImageTransform.Microsoft.AlphaImageLoader( src=\''.$bgUrl.'\', sizingMethod=\'scale\'); ';
$bgStyle .= ' -ms-filter: progid:DXImageTransform.Microsoft.AlphaImageLoader( src=\''.$bgUrl.'\', sizingMethod=\'scale\'); ';
*/
?>
<section id="lettings">
	<section id="one" class="scroll-section" style="<?php print $bgStyle;?>">
		<div class="h10"><!-- --></div>
		
		<div class="max-container">
			<div class="h25 onlyOnMobile"><!-- --></div>
			
			<?php strawberry_RenderSiteMenu(false); ?>

			<div class="middle-content">
				<h1><?php print $title;?></h1>
				<?php if(!empty($field_display_body) && $field_display_body[0]['value'] == 1): ?>					
					<p><?php print $body[0]['safe_value'];?></p>
				<?php endif; ?>
			</div>
				
			<?php if($field_section): ?>
			<a href="#two" class="section-arrow jumper" data-slide="#two"><img src="<?php print $img_path;?>screen_arrow.png" alt=""></a>
			<?php endif; ?>
		</div>
	</section>

    <?php print render($content['field_section']); ?>

</section>