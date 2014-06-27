<?php
/**
 *
 * theme implementation for field_section collection items
 *
 * Available variables:
 * - $content: An array of comment items. Use render($content) to print them all, or
 *   print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $title: The (sanitized) field collection item label.
 * - $url: Direct url of the current entity if specified.
 * - $page: Flag for the full page state.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. By default the following classes are available, where
 *   the parts enclosed by {} are replaced by the appropriate values:
 *   - entity-field-collection-item
 *   - field-collection-item-{field_name}
 *
 * Other variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 *
 * @see template_preprocess()
 * @see template_preprocess_entity()
 * @see template_process()
 */
?>
<?php

global $skipSectionContainer;
if(!isset($skipSectionContainer)) $skipSectionContainer = false;
//print_r(array_keys($variables));
$sectionsIndArr = array('one', 'two', 'three', 'four', 'five', 'six', 'seven');

global $sectionInd;
if(!isset($sectionInd)) $sectionInd = 0;

if(!$skipSectionContainer):
	$sectionInd ++;
	?>
<div id="<?php print $sectionsIndArr[$sectionInd];?>" class="light-grey-bg section_page scroll-section">
<?php endif; ?>
	<div class="h10"></div>
	<div class="max-container">
		
		<?php strawberry_RenderSiteMenu(); ?>

		<div class="middle-container">
			<?php if($field_title): ?>
				<h1><?php print $field_title[0]['safe_value'];?></h1>
			<?php endif;?>
			<?php if(!empty($field_subtitle)): ?>
				<h3><?php print $field_subtitle[0]['value'];?></h3>
			<?php endif;?>
			<?php if($field_content): ?>
				<div class="section-inner">
				<?php print $field_content[0]['safe_value'];?>
				</div>
			<?php endif;?>  
		</div>
	</div>

<?php if(!$skipSectionContainer):?>
</div>
<?php endif; ?>