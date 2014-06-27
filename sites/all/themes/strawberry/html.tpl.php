<?php
$base_path = $GLOBALS['base_path'];

/**
 * @file
 * Default theme implementation to display the basic html structure of a single
 * Drupal page.
 *
 * Variables:
 * - $css: An array of CSS files for the current page.
 * - $language: (object) The language the site is being displayed in.
 *   $language->language contains its textual representation.
 *   $language->dir contains the language direction. It will either be 'ltr' or 'rtl'.
 * - $rdf_namespaces: All the RDF namespace prefixes used in the HTML document.
 * - $grddl_profile: A GRDDL profile allowing agents to extract the RDF data.
 * - $head_title: A modified version of the page title, for use in the TITLE
 *   tag.
 * - $head_title_array: (array) An associative array containing the string parts
 *   that were used to generate the $head_title variable, already prepared to be
 *   output as TITLE tag. The key/value pairs may contain one or more of the
 *   following, depending on conditions:
 *   - title: The title of the current page, if any.
 *   - name: The name of the site.
 *   - slogan: The slogan of the site, if any, and if there is no title.
 * - $head: Markup for the HEAD section (including meta tags, keyword tags, and
 *   so on).
 * - $styles: Style tags necessary to import all CSS files for the page.
 * - $scripts: Script tags necessary to load the JavaScript files and settings
 *   for the page.
 * - $page_top: Initial markup from any modules that have altered the
 *   page. This variable should always be output first, before all other dynamic
 *   content.
 * - $page: The rendered page content.
 * - $page_bottom: Final closing markup from any modules that have altered the
 *   page. This variable should always be output last, after all other dynamic
 *   content.
 * - $classes String of classes that can be used to style contextually through
 *   CSS.
 *
 * @see template_preprocess()
 * @see template_preprocess_html()
 * @see template_process()
 *
 * @ingroup themeable
 */

if(arg(0) == 'node' && is_numeric(arg(1))) {
	$attributes .= ' data-nid="'.arg(1).'" ';
}

?>
<!DOCTYPE html>
<html lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>"<?php print $rdf_namespaces; ?>>
<head>
  <?php print $head; ?>
  <title><?php print $head_title; ?></title>
  <!-- <meta name="viewport" id="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" /> -->
  <meta name="viewport" id="viewport" content="" > 
  <script>		
		//alert(screen.width);
		if(screen.width > 640) {
			//document.getElementById("viewport").setAttribute("content", "width=device-width");
		}
		else {
			document.getElementById("viewport").setAttribute("content", "width=640, target-densitydpi=medium-dpi, initial-scale=0.5");
		}

		//alert(screen.width);
	</script>
  <?php print $styles; ?>
  <!--[if lt IE 9]>		
		<script src="<?php print $base_path . $directory; ?>/js/vendor/html5shiv.min.js"></script>
	<![endif]-->
	<script src="<?php print $base_path . $directory; ?>/js/vendor/modernizr-2.6.2.min.js"></script>
	<script src="<?php print $base_path . $directory; ?>/js/top_scripts.js"></script>
</head>
<body class="<?php print $classes; ?>" <?php print $attributes;?>>
<!--[if lt IE 7]>
	<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
  <?php print $page_top; ?>
	
  <?php print $page; ?>
	
  <div id="ajax-page-loading"></div>
  <?php print $scripts; ?>
  <?php print $page_bottom; ?>
  
  <script>
      
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-41879394-1', 'strawberrystar.com');
      ga('send', 'pageview');

    </script>
</body>
</html>
