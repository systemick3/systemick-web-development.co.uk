<?php
/**
 * @file
 * Contains the theme's functions to manipulate Drupal's default markup.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728096
 */
 

function systemick_css_alter(&$css) {
  $replace = 'http://fonts.googleapis.com/css?family=Quattrocento+Sans';
  foreach ($css as $delta => &$css_data) {
    if ($delta == 'http://fonts.googleapis.com/css?family=Quattrocento_Sans') {
      $css_data['data'] = $replace;
      $css[$replace] = $css_data;
      unset($css[$delta]);
      break;
    }
  }
  
  // Add the Font Awesome CSS
  $fa = 'http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css';
  $css[$fa] = array(
    'type' => 'external',
    'weight' => -99.995,
    'group' => '0',
    'media' => 'all',
    'preprocess' => 1,
    'data' => $fa,
    'every_page' => 1,
    'browsers' => array(
    ),
  );
}

/**
 * Override or insert variables into the maintenance page template.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("maintenance_page" in this case.)
 */
/* -- Delete this line if you want to use this function
function systemick_preprocess_maintenance_page(&$variables, $hook) {
  // When a variable is manipulated or added in preprocess_html or
  // preprocess_page, that same work is probably needed for the maintenance page
  // as well, so we can just re-use those functions to do that work here.
  systemick_preprocess_html($variables, $hook);
  systemick_preprocess_page($variables, $hook);
}
// */

/**
 * Override or insert variables into the html templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("html" in this case.)
 */
function systemick_preprocess_html(&$variables, $hook) {
  if (drupal_is_front_page()) {
    $variables['head_title'] = 'Open source CMS development in Leeds, West Yorkshire using Drupal | Systemick';
  }
  else {
    $node = menu_get_object();
    if (!empty($node) && $node->type == 'skill') {
      $variables['head_title'] = $node->title . ' Development | Systemick';
    }
  }
}

/**
 * Override or insert variables into the page templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */
function systemick_preprocess_page(&$variables, $hook) {
  if (!module_exists('mobile_detect')) {
    return;
  }
  
  $detect = mobile_detect_get_object();
  $is_mobile = $detect->isMobile();
  $is_tablet = $detect->isTablet();
  
  if ($is_mobile && !$is_tablet) {
    $variables['theme_hook_suggestions'][] =  'page__mobile';
  }
  else if ($is_tablet) {
    $variables['theme_hook_suggestions'][] =  'page__tablet';
  }
  else {
    $variables['theme_hook_suggestions'][] =  'page__desktop';
  }
  
  // Don't display the node title on the front page
  $node = menu_get_object();
  if (!empty($node) && $node->type == 'front') {
    $variables['title'] = '';
  }
}
// */

/**
 * Override or insert variables into the node templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
function systemick_preprocess_node(&$variables, $hook) {
  // Optionally, run node-type-specific preprocess functions, like
  // systemick_preprocess_node_page() or systemick_preprocess_node_story().
  $function = __FUNCTION__ . '_' . $variables['node']->type;
  if (function_exists($function)) {
    $function($variables, $hook);
  }
}

/**
 * Override or insert variables into the node templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
function systemick_preprocess_node_skill(&$variables, $hook) {
  if (!module_exists('mobile_detect')) {
    return;
  }
  
  $detect = mobile_detect_get_object();
  $is_mobile = $detect->isMobile();
  $is_tablet = $detect->isTablet();
  
  if ($is_mobile && !$is_tablet) {
    unset($variables['content']['field_skill_image']);
  }
  
  if (!empty($variables['teaser']) && (!$is_mobile || $is_tablet)) {
    $variables['title'] = '';
  }
}
 
 /**
 * Override or insert variables into the node templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
function systemick_preprocess_node_front(&$variables, $hook) {
  if (!module_exists('mobile_detect')) {
    return;
  }
  
  $detect = mobile_detect_get_object();
  $is_mobile = $detect->isMobile();
  $is_tablet = $detect->isTablet();
  
  // Add different js for the mobile site
  if ($is_mobile && ! $is_tablet) {
    drupal_add_js(drupal_get_path('theme', 'systemick') . '/js/script_mobile.js');
  }
  else {
    drupal_add_js(drupal_get_path('theme', 'systemick') . '/js/script.js');
  }
	
	// Process the front page content
	// The main image should be the background image of the main div
	$content = $variables['content'];
	$image_url = image_style_url('front_image', $content['field_front_image'][0]['#item']['uri']);
	$description = '<div class="description">' . $variables['body'][0]['safe_value'] . '</div>';
  $prefix = '<div class="front-content" style="background-image: url(' . $image_url . '); background-size: cover; background-repeat: none;"><div class="text-wrapper"><div class="text">';
	$suffix = '</div></div></div>';
	
	$content = $prefix . $description . $suffix;
	$variables['content'] = array('#markup' => $content);
}

/**
 * Override or insert variables into the comment templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
/* -- Delete this line if you want to use this function
function systemick_preprocess_comment(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the region templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("region" in this case.)
 */
/* -- Delete this line if you want to use this function
function systemick_preprocess_region(&$variables, $hook) {
  // Don't use Zen's region--sidebar.tpl.php template for sidebars.
  //if (strpos($variables['region'], 'sidebar_') === 0) {
  //  $variables['theme_hook_suggestions'] = array_diff($variables['theme_hook_suggestions'], array('region__sidebar'));
  //}
}
// */

/**
 * Override or insert variables into the block templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
function systemick_preprocess_block(&$variables, $hook) {
  if ($variables['elements']['#block']->delta == 'skills-block') {
    if (!module_exists('mobile_detect')) {
      return;
    }
  
    $detect = mobile_detect_get_object();
    $is_mobile = $detect->isMobile();
    $is_tablet = $detect->isTablet();
    
    // Add a header on the mobile site only
    if ($is_mobile && !$is_tablet) {
      $div = '<div class="skills-header"><h3>Technologies</h3></div>';
      $variables['elements']['#markup'] = $div . $variables['elements']['#markup'];
    }
  }
}
