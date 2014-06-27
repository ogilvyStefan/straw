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
<div id="homepage">
	<div id="one" class="scroll-section" style="<?php print $bgStyle;?>">
		<div class="h10"><!-- --></div>
		
		<div class="max-container">
			<div class="h25 onlyOnMobile"><!-- --></div>
			
			<?php strawberry_RenderSiteMenu(false); ?>

			<div class="triunghi">
				<div class="triunghi_title"><h1><?php print $title;?></h1></div>
				<?php print $body[0]['safe_value'];?>
			</div>
			<?php if($field_section): ?>
			<a href="#two"  data-slide="#two" class="section-arrow jumper"><img src="<?php print $img_path;?>screen_arrow.png" alt=""></a>
			<?php endif; ?>
		</div>
	</div>

    <?php print render($content['field_section']); ?>

</div>