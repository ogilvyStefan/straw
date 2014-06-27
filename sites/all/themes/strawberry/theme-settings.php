<?php
/**
 * Implements hook_form_system_theme_settings_alter() function.
 *
 * @param $form
 *   Nested array of form elements that comprise the form.
 * @param $form_state
 *   A keyed array containing the current state of the form.
 */
function strawberry_form_system_theme_settings_alter(&$form, $form_state, $form_id = NULL) {
  // Work-around for a core bug affecting admin themes. See issue #943212.
  if (isset($form_id)) {
    return;
  }

  $form['reset_admin_region_users'] = array(
    '#type'          => 'checkboxes',
    '#title'         => t('Display Admin region to'),
    '#default_value' => theme_get_setting('reset_admin_region_users'),
    '#options'       => user_roles($membersonly = FALSE, $permission = NULL),
  );
}
