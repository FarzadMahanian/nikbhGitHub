<?php

namespace Drupal\ajax_loader;

use Drupal\Core\Plugin\PluginBase;

/**
 * Class ThrobberBase
 */
abstract class ThrobberPluginBase extends PluginBase implements ThrobberPluginInterface {

  protected $path;
  protected $markup;
  protected $css_file;
  protected $label;


  /**
   * ThrobberPluginBase constructor.
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->path = '/' . drupal_get_path('module', 'ajax_loader');
    $this->markup = $this->setMarkup();
    $this->css_file = $this->setCssFile();
  }


  /**
   * @return mixed
   */
  public function getMarkup() {
    return $this->markup;
  }

  /**
   * @return mixed
   */
  public function getCssFile() {
    return $this->css_file;
  }

  /**
   * @return mixed
   */
  public function getLabel() {
    return $this->configuration['label'];
  }

  /**
   * Sets markup for throbber.
   */
  protected abstract function setMarkup();

  /**
   * Sets css file for throbber.
   */
  protected abstract function setCssFile();

}