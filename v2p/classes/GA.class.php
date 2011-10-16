<?php
require_once(dirname(__FILE__).'/Settings.class.php');

class GA {
  private $settings = array();
  private $pdo = '';

  public function __construct() {
    $settings = new Settings();
    $this->settings = $settings->getArray();

    $db = new DB();
    $this->pdo = $db->connect();
  }
}
