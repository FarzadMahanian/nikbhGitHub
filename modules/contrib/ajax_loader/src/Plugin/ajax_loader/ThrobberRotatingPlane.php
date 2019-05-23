<?php

namespace Drupal\ajax_loader\Plugin\ajax_loader;

use Drupal\ajax_loader\ThrobberPluginBase;

/**
 * @Throbber(
 *   id = "throbber_rotating_plane",
 *   label = @Translation("Rotating plane")
 * )
 */
class ThrobberRotatingPlane extends ThrobberPluginBase {

  /**
   * @inheritdoc
   */
  protected function setMarkup() {
    return '<div class="ajax-throbber sk-rotating-plane"></div>';
  }

  /**
   * @inheritdoc
   */
  protected function setCssFile() {
    return $this->path . '/css/rotating-plane.css';
  }

}