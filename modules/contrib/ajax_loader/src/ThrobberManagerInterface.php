<?php

namespace Drupal\ajax_loader;

/**
 * Interface for the class that gathers the throbber plugins.
 */
interface ThrobberManagerInterface {

  /**
   * Returns the definition of a plugin by a given plugin ID.
   * @param $plugin_id
   * @param $exception_on_invalid
   * @return mixed
   */
  public function getDefinition($plugin_id, $exception_on_invalid);

  /**
   * Get an options list suitable for form elements for throbber selection.
   *
   * @return array
   *   An array of options keyed by plugin ID with label values.
   */
  public function getThrobberOptionList();


  /**
   * Loads an instance of a plugin by given plugin id.
   * @param $plugin_id
   * @return object
   */
  public function loadThrobberInstance($plugin_id);

  /**
   * Loads all available throbbers.
   * @return mixed
   */
  public function loadAllThrobberInstances();

  /**
   * Checks if ajax loader has to be included on current page.
   * @return mixed
   */
  public function RouteIsApplicable();

}
