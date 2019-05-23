<?php

namespace Drupal\ajax_loader\Plugin\ajax_loader;

use Drupal\ajax_loader\ThrobberPluginBase;

/**
 * @Throbber(
 *   id = "throbber_pulse",
 *   label = @Translation("Pulse")
 * )
 */
class ThrobberPulse extends ThrobberPluginBase {

  /**
   * @inheritdoc
   */
  protected function setMarkup() {
    return '<div class="ajax-throbber sk-spinner sk-spinner-pulse"></div>';
  }

  /**
   * @inheritdoc
   */
  protected function setCssFile() {
    return $this->path . '/css/pulse.css';
  }
}