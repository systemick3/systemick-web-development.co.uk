<?php
/**
 * @file
 * systemick_content_types.features.inc
 */

/**
 * Implements hook_node_info().
 */
function systemick_content_types_node_info() {
  $items = array(
    'front' => array(
      'name' => t('Front'),
      'base' => 'node_content',
      'description' => t('The front page for the site'),
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
    'page' => array(
      'name' => t('Basic page'),
      'base' => 'node_content',
      'description' => t('Use <em>basic pages</em> for your static content, such as an \'About us\' page.'),
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
    'skill' => array(
      'name' => t('Skill'),
      'base' => 'node_content',
      'description' => '',
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
  );
  drupal_alter('node_info', $items);
  return $items;
}
