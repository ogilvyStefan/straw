<?php 
// node home

//print_r(array_keys($variables));

$sectionsInd = array('one', 'two', 'three', 'four', 'five', 'six', 'seven');

$galleriesIdArr = array();
foreach ($field_gallery_items as $entity_id) {
	$galleriesIdArr[] = $entity_id['value'];  
}

$tEntities = entity_load('field_collection_item', $galleriesIdArr);
$galleryItems = array();
foreach($tEntities as $v) {
	//if($v->archived == 1) continue;
	$galleryItems[] = $v;
}

$bgUrl = file_create_url($field_header_background[0]['uri']);
$bgStyle = 'background-image:url('.$bgUrl.');';

/*
//ie8 fix
$bgStyle .= ' filter: progid:DXImageTransform.Microsoft.AlphaImageLoader( src=\''.$bgUrl.'\', sizingMethod=\'scale\'); ';
$bgStyle .= ' -ms-filter: progid:DXImageTransform.Microsoft.AlphaImageLoader( src=\''.$bgUrl.'\', sizingMethod=\'scale\'); ';
*/
?>
<section id="about">
	<section id="one" class="scroll-section" style="<?php print $bgStyle;?>">
		<div class="h10"><!-- --></div>
		
		<div class="max-container">
			<div class="h25 onlyOnMobile"><!-- --></div>
			
			<?php strawberry_RenderSiteMenu(false); ?>

			<div class="middle-content">
				<h1><?php print $title;?></h1>
				<hr />
				<ul class="mini-menu">
					<?php $t = count($field_subsections_links); ?>
					<?php foreach($field_subsections_links as $ind => $val): ?>
					<li <?php print $ind == $t - 1 ? 'class="last"' : '';?>><a href="#<?php print $sectionsInd[$ind + 1];?>" class="jumper" data-slide="#<?php print $sectionsInd[$ind + 1];?>"><?php print $val['safe_value'];?></a></li>
					<?php endforeach; ?>					
				</ul>
			</div>
			<?php if($field_section): ?>
			<a href="#two" class="section-arrow jumper" data-slide="#two"><img src="<?php print $img_path;?>screen_arrow.png" alt=""></a>
			<?php endif; ?>
		</div>
	</section>

	<section id="two" class="light-grey-bg scroll-section">
		<div class="h10"><!-- --></div>
		
		<div class="full-container" style="padding-bottom:40px;">
			<div class="max-container">
				<?php strawberry_RenderSiteMenu(); ?>

				<div class="middle-container">
					<h1><?php print $field_gallery_title[0]['safe_value'];?></h1>
					<?php print $body[0]['safe_value'];?>

					<div class="h100"></div>
					<div class="h10"></div>
				</div>
			</div>
			
			<div class="inner inner-gallery">
				<div class="span3 columns left-col gallery_desc_col">
					<?php foreach($galleryItems as $ind => $item): ?>
					<div id="gallery_item_<?php print $ind;?>" class="gallery_desc" <?php if($ind == 0) print 'style="display:block;"';?>>
						<div class="gallery_desc_in">
						<h1><?php print $item->field_title['und'][0]['value'];?></h1>
						<?php if(!empty($item->field_subtitle)):?>
							<h3><?php print $item->field_subtitle['und'][0]['value'];?></h3>
						<?php endif;?>
						<?php if(!empty($item->field_content)):?>
							<p><?php print $item->field_content['und'][0]['safe_value'];?></p>
						<?php endif;?>
						</div>
					</div>
					<?php endforeach; ?>
				</div>

				<div class="span9 columns gallery-pic-items">
				<div class="gallery-pic-items-in">
					<?php foreach($galleryItems as $ind => $item): ?>
					<div class="span3 columns gallery_pic <?php if($ind == 0) print 'active';?>" data-ind="<?php print $ind;?>">
						<div class="thumb">
							<img src="<?php print image_style_url('gallery', $item->field_gallery_image['und'][0]['uri']);?>" class="hover" />
							<img src="<?php print image_style_url('gallery_bw', $item->field_gallery_image['und'][0]['uri']);?>" class="bw" />
						</div>
					</div>
					<?php endforeach; ?>

					<div class="clear"><!-- --></div>                            
				</div>
				</div>
				<div class="clear"><!-- --></div>
			</div>

			<div class="clear"><!-- --></div>
		</div>
	</section>
	
	<?php 
	global $sectionInd;
	if(!isset($sectionInd)) $sectionInd = 0;

	$sectionInd ++;
	?>

    <?php print render($content['field_section']); ?>

</section>