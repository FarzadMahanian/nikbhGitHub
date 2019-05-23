<?php

namespace Drupal\ajax_loader\Plugin\ajax_loader;

use Drupal\ajax_loader\ThrobberPluginBase;

/**
 * @Throbber(
 *   id = "throbber_three_bounce",
 *   label = @Translation("Three bounce")
 * )
 */
class ThrobberThreeBounce extends ThrobberPluginBase {

  /**
   * @inheritdoc
   */
  protected function setMarkup() {
    return '<div class="ajax-throbber sk-three-bounce">
              <div class="sk-child sk-bounce1"></div>
              <div class="sk-child sk-bounce2"></div>
              <div class="sk-child sk-bounce3"></div>
            </div>';
  }

  /**
   * @inheritdoc
   */
  protected function setCssFile() {
    return $this->path . '/css/three-bounce.css';
  }

}