<?php
require_once(dirname(__FILE__).'/Settings.class.php');

class DB {
  private $settings = array();

  public function __construct() {
    $settings = new Settings();
    $this->settings = $settings->getArray();
  }

  public function connect() {
    return new PDO($this->settings['db']['driver'] . ':host=' .$this->settings['db']['host']. ';dbname=' . $this->settings['db']['db'], $this->settings['db']['user'], $this->settings['db']['password']);
  }
}
