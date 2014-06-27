<?php
// node home

//print_r(array_keys($variables));
//print_r($field_section);

$sectionsIndArr = array('one', 'two', 'three', 'four', 'five', 'six', 'seven');

global $sectionInd;
if(!isset($sectionInd)) $sectionInd = 0;

$projectsIdArr = array();
foreach ($field_projects as $entity_id) {
	$projectsIdArr[] = $entity_id['value'];  
}

$tEntities = entity_load('field_collection_item', $projectsIdArr);
$projectsItems = array();
foreach($tEntities as $v) {
	//if($v->archived == 1) continue;
	$projectsItems[] = $v;
}

$bgUrl = file_create_url($field_header_background[0]['uri']);
$bgStyle = 'background-image:url('.$bgUrl.');';

/*
//ie8 fix
$bgStyle .= ' filter: progid:DXImageTransform.Microsoft.AlphaImageLoader( src=\''.$bgUrl.'\', sizingMethod=\'scale\'); ';
$bgStyle .= ' -ms-filter: progid:DXImageTransform.Microsoft.AlphaImageLoader( src=\''.$bgUrl.'\', sizingMethod=\'scale\'); ';
*/
?>
<div id="london">
	<section id="one" class="scroll-section" style="<?php print $bgStyle;?>">
		<div class="h10"><!-- --></div>
		
		<div class="max-container">
			<div class="h25 onlyOnMobile"><!-- --></div>
			
			<?php strawberry_RenderSiteMenu(false); ?>

			<div class="middle-content">
				<h1><?php print $title;?></h1>
            </div>
			
			<?php if($field_section): ?>
			<a href="#two" data-slide="#two" class="section-arrow jumper"><img src="<?php print $img_path;?>screen_arrow.png" alt=""></a>
			<?php endif; ?>
		</div>
	</section>
	

<?php $sectionInd ++ ;?>
<div id="<?php print $sectionsIndArr[$sectionInd];?>" class="light-grey-bg section_page scroll-section skip-middle-valign" style="padding-bottom:0;">
	
	<div id="our-project-text-section">
	<?php global $skipSectionContainer; $skipSectionContainer = true;?>
    <?php print render($content['field_section']); ?>
	<?php $skipSectionContainer = false; ?>
	</div>

  <?php $prjSectionId = $sectionsIndArr[count($field_section) + 1]; ?>
  <section id="<?php print $prjSectionId;?>" class="projects-section">
	
	<div class="onlyOnDesk">
	<div class="overlay_carousel">
		<div class="close"></div>
		<div class="arrow-left"></div>
		<div class="arrow-right"></div>
		<div class="carousel_c">
			<div class="item" >
				<div class="txt">
					<div class="in"></div>
				</div>
				<div class="img">
				</div>
			</div>		 
		</div>
	</div>
	</div>

      <?php foreach($projectsItems as $ind => $prj):?>
          <?php $sectionImg = $prj->field_section_image['und'][0]; ?>
          <div class="span6 columns col-frame">
		     <?php // get slides list for desktop;
				$slides = array();
				//$slides[] = image_style_url('mobile-prj-slide', $sectionImg['uri']);
				//$slides[] = file_create_url($sectionImg['uri']);
				$slides[] = array(
								'url' => file_create_url($sectionImg['uri']),
								'w' => $sectionImg['width'],
								'h' => $sectionImg['height']
							);
				if(!empty($prj->field_big_image)) {
                   foreach($prj->field_big_image['und'] as $i) {
					   //print_r($i);
					   //exit;
                        //$slides[] = image_style_url('mobile-prj-slide', $i['uri']);
						$slides[] = array(
								'url' => file_create_url($i['uri']),
								'w' => $i['width'],
								'h' => $i['height']
							);
				   }
				}
			 ?>
              <div class="frame" data-prj-ind="<?php print $ind; ?>" data-desk-slides='<?php print json_encode($slides);?>'>
                  <div class="inner">

                    <img  src="<?php print file_create_url($sectionImg['uri']);?>" alt="" class="pa s_img" data-prj-ind="<?php print $ind; ?>" data-w="<?php print $sectionImg['width'];?>" data-h="<?php print $sectionImg['height'];?>" >
                    <?php 
					// create mobile slider
					$slideInd = 0; ?>
                    <div class="swiper-container">
                      <div class="swiper-wrapper">
                        <div class="swiper-slide"><img data-ind="0" src="<?php print image_style_url('mobile-prj-slide', $sectionImg['uri']);?>" alt="" class="full-width-img" ></div>
                        <?php if(!empty($prj->field_big_image)): ?>
                          <?php foreach($prj->field_big_image['und'] as $i):?>
                            <?php $slideInd ++; ?>
                          <div class="swiper-slide"><img data-ind="<?php print $slideInd;?>" src="<?php print image_style_url('mobile-prj-slide', $i['uri']);?>" alt=""  class="full-width-img"></div>
                          <?php endforeach ;?>
                        <?php endif; ?>
                        </div>
                        <div class="slide-ind"> <span class="current">1</span> / <span class="total"><?php print $slideInd + 1;?> </span> </div>
                      </div>

                      <div class="detalii">
                          <img src="<?php print file_create_url($prj->field_section_hover_image['und'][0]['uri']);?>" alt="" class="s_img">

                          <div class="v_center">
                              <div class="in">
                                  <h1><?php print $prj->field_title['und'][0]['safe_value'];?></h1>
                                  <p><?php print $prj->field_description['und'][0]['value'];?></p>
                                  <div class="h50"></div>
                                  
								  <div class="onlyOnDesk"><a href="#<?php print $prjSectionId;?>" onclick="overlayCarousel.show(this, <?php print $ind; ?>); return false;">view</a></div>
								  <div class="onlyOnMobile"><a href="#<?php print $prjSectionId;?>" onclick="overlayCarousel.mobileShow(this, <?php print $ind; ?>);return false;" class="show_more">show more</a></div>
								
								  <div class="mobile-prj-view-section">
									  <div class="onlyOnMobile">
											<div class="mobile-det">
											<?php print $prj->field_content['und'][0]['value'];?>
											</div>
											<div class="h50"></div>
											<a href="#<?php print $prjSectionId;?>" onclick="overlayCarousel.mobileHide(this, <?php print $ind; ?>); return false;" class="show_less">show less</a>
									  </div>
								   </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      <?php endforeach; ?>
      <div class="clear"><!-- --></div>
	</section>
</div> <!-- prj scroll section -->
</div><!-- london -->