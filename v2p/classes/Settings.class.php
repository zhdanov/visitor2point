<?php
require_once(dirname(__FILE__).'/../lib/sfYaml/sfYaml.php');

class Settings {
  private $fileSettings = '';

  public function __construct() {
    $this->fileSettings = dirname(__FILE__).'/../settings.yml';
  }

  public function getArray() {
    $sfYaml = new sfYaml();
    return $sfYaml->load($this->fileSettings);
  }
}
