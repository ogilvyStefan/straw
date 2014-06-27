<?php


function strawberry_theme(&$existing, $type, $theme, $path) {
  $hooks = array();
  $hooks['site_menu'] = array(
    'variables' => array('menu' => array(), 'greyLogo'=>true),
    'template' => 'templates/site_menu',
  );

  return $hooks;
}

function strawberry_RenderSiteMenu($greyLogo = true) {
	print theme('site_menu', array('menu' => menu_navigation_links('main-menu'), 'greyLogo'=> $greyLogo));
}


/**
 * CSS Alter Hook
 * @param $css
 */
function strawberry_css_alter(&$css) {

  // Remove drupal default css files

  $isAdmin = user_access('administer site configuration');

  $cssFiles = array(
    'modules/search/search.css',
    'modules/comment/comment.css',
    'modules/system/system.base.css',
    'modules/system/system.menus.css',
    'modules/system/system.messages.css',
    'modules/system/system.theme.css',
    'modules/field/theme/field.css',
    'modules/user/user.css',
    'modules/poll/poll.css',
    'modules/locale/locale.css',
    'modules/fields/field_collection/field_collection.theme.css',
    'sites/all/modules/fields/date/date_api/date.css',
    'sites/all/modules/fields/date/date_popup/themes/datepicker.1.7.css',
    'sites/all/modules/structure/views/css/views.css',
    'sites/all/modules/structure/ctools/css/ctools.css',
    'sites/all/modules/content/flag/theme/flag.css',
	'sites/all/modules/fields/field_collection/field_collection.theme.css',
    //'sites/all/modules/ckeditor/ckeditor.css',
    'modules/node/node.css',
  );


  foreach ($cssFiles as $file) {
    if(isset($css[$file])) unset($css[$file]);
  }
}

/**
 * JS Alter Hook
 *
 * @param $javascript
 */
function strawberry_js_alter(&$javascript) {
  // Load the latest jquery version
  $javascript['misc/jquery.js']['data'] = '//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js';

  $unsetJsFiles = array(
    'sites/all/modules/content/flag/theme/flag.js', // build our js for ajax flag
	'misc/jquery.form.js' //overrided in plugins.js
  );

  //print_r($javascript);

   if(arg(0) == 'node' && arg(1) == 'get' && arg(2) == 'ajax') {
		$unsetJsFiles = array(
			'misc/jquery.js',
			'misc/drupal.js',
			'sites/all/themes/strawberry/js/vendor/plugins.js',
			'sites/all/themes/strawberry/js/main.js',
			'sites/all/modules/content/clientside_validation/jquery-validate/jquery.validate.js',
			'sites/all/modules/content/clientside_validation/clientside_validation.ie8.js',
			'sites/all/modules/content/clientside_validation/clientside_validation.js'
		 );
   }

  /*
  if(isset($javascript['misc/ui/jquery.ui.core.min.js'])) {
    $javascript['misc/ui/jquery.ui.core.min.js']['data'] = '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js';
  }
  */

  
  foreach ($unsetJsFiles as $file) {
    if(isset($javascript[$file])) unset($javascript[$file]);
  }
}

/**
 * check if user role is selected in theme settings
 */
function strawberry_is_authorized_auth() {
  $authorized_auth = &drupal_static(__FUNCTION__);
  if(!$authorized_auth) {
    global $user;
    // Grab the user roles
    $roles = $user->roles;

    $authorized_auth = false;
    foreach(theme_get_setting('reset_admin_region_users') as $auth_role){
      if($auth_role != 0 && array_key_exists($auth_role, $roles))
        $authorized_auth = true;
    }
  }

  return $authorized_auth;
}

/**
 * Override or insert variables into the page template.
 */
function strawberry_preprocess_page(&$vars) {

  $vars['authorized_auth'] = strawberry_is_authorized_auth();

  $vars['primary_local_tasks'] = $vars['tabs'];
  unset($vars['primary_local_tasks']['#secondary']);
  $vars['secondary_local_tasks'] = array(
    '#theme' => 'menu_local_tasks',
    '#secondary' => $vars['tabs']['#secondary'],
  );
}

/**
 * Override or insert variables into the node templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */

function strawberry_preprocess_node(&$variables, $hook) {

  if(in_array($variables['view_mode'], array('highlight', 'testimonial'))) $variables['theme_hook_suggestions'][] = 'node__'.$variables['view_mode'];
	

  if(in_array($variables['node']->type, array('section_page', 'brand', 'brand_article'))) {
    $variables['theme_hook_suggestions'][] = 'node__' . $variables['node']->type . '__'.$variables['view_mode'];
  }
	
  $path = drupal_get_path('theme', $GLOBALS['theme']);
  $imgPath = base_path() . $path . '/img/';
  $variables['img_path'] =  $imgPath;


  //print_r($variables['theme_hook_suggestions']);

  // Optionally, run node-type-specific preprocess functions, like
  // redworks_preprocess_node_page() or redworkds_preprocess_node_story().
  /*
	$function = __FUNCTION__ . '_' . $variables['node']->type;
	if (function_exists($function)) {
		$function($variables, $hook);
	}
  */
}


function strawberry_preprocess_html(&$variables) {


  if(strawberry_is_authorized_auth()) {
    drupal_add_css(drupal_get_path('theme', 'strawberry') . "/css/admin.css");
  }



  //drupal_add_css('//fast.fonts.net/cssapi/56467c7a-477f-4ea2-ac28-07a7b2046aca.css', array('type' => 'external'));
  //drupal_add_css('//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800', array('type' => 'external'));
}


/**
 * helper function
 *
 * get trace of code execution .. used for debug
 *
 * @return array
 */
function npro_errorBackTrace() {

  $bt = debug_backtrace();
  //unset($bt[0]);
  //unset($bt[1]);
  $results = array();
  foreach($bt as $i => $val) {
    if(isset($bt[$i]["file"])) {
      /*
      $pos = strpos($bt[$i]["file"], Config::$projectAbsoluteLocation);
      if($pos!== false)
        $bt[$i]["file"] = substr($bt[$i]["file"], $pos + strlen(Config::$projectAbsoluteLocation));
      */
    }
    if(isset($bt[$i]["type"]) && $bt[$i]["type"]=="->") unset($bt[$i]["type"]);
    unset($bt[$i]["object"]);
    if(count($bt[$i]["args"])==0) unset($bt[$i]["args"]);
    else {
      $ind_arg = 0;
      foreach($bt[$i]["args"] as $arg) {
        if(gettype($arg)=='object') $arg = get_class($arg);
        $bt[$i]["args_".$ind_arg] = $arg;
        $ind_arg++;
      }
      unset($bt[$i]["args"]);
    }
    $results[] = $bt[$i];
  }
  return $results;
}


//helper functions

/**
 * array_chunk implementation with data distributed by lines (columns are balanced as much as possible)
 *
 * @param array $data
 * @param int $columns - number of columns
 *
 * @return array
 */
function array_chunk_vertical($data, $columns) {
  if($columns == 0) {
    $tabular = array( 0 => $data ) ;
    return $tabular;
  }
  $n = count($data) ;
  $per_column = floor($n / $columns) ;
  $rest = $n % $columns ;

  // The map
  $per_columns = array( ) ;
  for ( $i = 0 ; $i < $columns ; $i++ ) {
    $per_columns[$i] = $per_column + ($i < $rest ? 1 : 0) ;
  }

  $tabular = array( ) ;
  foreach ( $per_columns as $rows ) {
    for ( $i = 0 ; $i < $rows ; $i++ ) {
      $tabular[$i][ ] = array_shift($data) ;
    }
  }

  return $tabular ;
}

/**
 * hook preprocess field
 *
 * @param $variables
 */
function strawberry_preprocess_field(&$variables) {

  
}


/**
 * custom function for nl2br
 *
 * @param $text
 *
 * @return string
 */
function npro_nl2br($text) {
  return nl2br($text);
}

function strawberry_preprocess_webform_email(&$variables) {
  if (!isset($variables['element']['#attributes']['placeholder'])) {
    $variables['element']['#attributes']['placeholder'] = t('Enter email address');
  }
}

/**
 * Alter the passed element appropriately to add the hint.
 *
 * @param array $element
 *   The Webform element.
 * @param string $required_label
 *   The string appended to the end of a required element's hint.
 */
function strawberry_formfield_add_title(&$element, $required_label = '') {
  // Perform a recursive call on container (fieldset, etc.) form items.
  foreach (element_children($element) as $key) {
    strawberry_formfield_add_title($element[$key], $required_label);
  }

  // Regular form items.
  if (isset($element['#type'])) {
    // Element isn't required.
    if (empty($element['#required'])) {
      $required_label = '';
    }
    // Define the field types to act on.
    $fieldtypes = array('textfield', 'textarea', 'webform_email', 'email', 'webform_number');
    if (in_array($element['#type'], $fieldtypes)) {
      // Add attributes and classes to the element.
      //$element['#attributes']['title'] = $element['#title'] . $required_label;
      //$element['#attributes']['class'] = array('webform-hints-field');
      //if (!isset($element['#attributes']['placeholder'])) {
        $element['#attributes']['placeholder'] = $element['#title'] . $required_label;
      //}
      /*
      if (variable_get('webform_hints_legacy_support', FALSE)) {
        $element['#attributes']['label'] = $element['#title'] . $required_label;
      }
      // Hide the label while keeping it available to screen readers.
      $element['#title_display'] = 'invisible';
      */
    }
    /*
    elseif ($element['#type'] == 'select') {
      // Single value select lists.
      $element['#empty_option'] = '- ' . $element['#title'] . $required_label . ' -';
      $element['#title_display'] = 'invisible';
    }
    */
  }
}

function strawberry_form_alter(&$form, $form_state, $form_id) {


  if (substr($form_id, 0, 20) == 'webform_client_form_' && $form_id != 'webform_client_form_2') {
    foreach (element_children($form['submitted']) as $key) {
      strawberry_formfield_add_title($form['submitted'][$key]);
    }
  }

  

  switch($form_id) {
    case 'webform_client_form_2':
      //$form['actions']['#attributes']['class'][] = 'align_button';
      //print_r($form);
      break;
	 case 'webform_client_form_7':		
		$form['submitted']['name']['#attributes']['onkeypress'] = ' return false;';
		break;
  }

	return ;

  switch($form_id) {
    case 'user_register_form':
        $form['actions']['#attributes']['class'][] = 'align_button';
        //print_r($form);
      break;

    case 'search_form': // customize search form
        $path = drupal_get_path('theme', $GLOBALS['theme']);
        $imgPath = base_path() . $path . '/images/';

        $form['#method'] = 'get';
        unset($form['form_id']);
        unset($form['form_build_id']);
        unset($form['form_token']);


        $txtField = &$form['basic']['keys'];
        $submitBtn = &$form['basic']['submit'];

        $txtField['#attributes']['placeholder'] = t('Enter a keyword');
        $txtField['#attributes']['class'] = array();
        $txtField['#title_display'] = 'invisible'; // Toggle label visibilty
        $txtField['#title'] = '';

        $submitBtn['#type'] = 'image_button';
        $submitBtn['#src'] =  $imgPath.'search-ico.png';
        unset($submitBtn['#value']);
      break;

    case 'user_login': //customize user login form
        unset($form['name']['#description']);
        unset($form['pass']['#description']);

        $form['actions']['#attributes']['class'][] = 'align_button';
      break;

    default:
      if(substr($form_id, 0, 19) == 'webform_client_form') {
        $form['actions']['#attributes']['class'][] = 'align_button';
      }
      break;
  }

}


function strawberry_menu_tree($variables) {
  return '<ul>' . $variables['tree'] . '</ul>';
}