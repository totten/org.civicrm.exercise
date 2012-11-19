<?php

require_once 'exercise.civix.php';

define('EXERCISE_ACTIVITY_TYPE_ID', 41);
define('EXERCISE_DEFAULT_ASSIGNEE_ID', 1);

/**
 * Implementation of hook_civicrm_post
 */
function exercise_civicrm_post($op, $objectName, $objectId, &$objectRef) {
  if ($objectName == 'Profile') {
    if (function_exists('ip_address')) {
      $ip = ip_address();
    } else {
      $ip = $_SERVER['REMOTE_ADDR'];
    }
    $result = civicrm_api('Activity', 'create', array(
      'version' => '3',
      'source_contact_id' => $objectId,
      'activity_type_id' => EXERCISE_ACTIVITY_TYPE_ID,
      'target_contact_id' => $objectId,
      'assignee_contact_id' => EXERCISE_DEFAULT_ASSIGNEE_ID,
      'location' => 'IP: ' . $ip,
      'subject' => ts('Verify publicly submitted information for contact %1', array(
        '1' => $objectId,
      )),
    ));
    if ($result['is_error']) {
      CRM_Core_Error::debug_var('failed_activity', $result);
    }
  }
}

/**
 * Implementation of hook_civicrm_config
 */
function exercise_civicrm_config(&$config) {
  _exercise_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_xmlMenu
 *
 * @param $files array(string)
 */
function exercise_civicrm_xmlMenu(&$files) {
  _exercise_civix_civicrm_xmlMenu($files);
}

/**
 * Implementation of hook_civicrm_install
 */
function exercise_civicrm_install() {
  return _exercise_civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_uninstall
 */
function exercise_civicrm_uninstall() {
  return _exercise_civix_civicrm_uninstall();
}

/**
 * Implementation of hook_civicrm_enable
 */
function exercise_civicrm_enable() {
  return _exercise_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 */
function exercise_civicrm_disable() {
  return _exercise_civix_civicrm_disable();
}

/**
 * Implementation of hook_civicrm_upgrade
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 */
function exercise_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _exercise_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implementation of hook_civicrm_managed
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 */
function exercise_civicrm_managed(&$entities) {
  return _exercise_civix_civicrm_managed($entities);
}
