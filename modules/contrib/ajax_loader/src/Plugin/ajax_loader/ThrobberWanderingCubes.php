<?php

namespace Drupal\ajax_loader\Plugin\ajax_loader;

use Drupal\ajax_loader\ThrobberPluginBase;

/**
 * @Throbber(
 *   id = "throbber_wandering_cubes",
 *   label = @Translation("Wandering cubes")
 * )
 */
class ThrobberWanderingCubes extends ThrobberPluginBase{

  /**
   * @inheritdoc
   */
  protected function setMarkup() {
    return '<div class="ajax-throbber sk-wandering-cubes">
              <div class="sk-cube sk-cube1"></div>
              <div class="sk-cube sk-cube2"></div>
            </div>';
  }

  /**
   * @inheritdoc
   */
  protected function setCssFile() {
    return $this->path . '/css/wandering-cubes.css';
  }

}