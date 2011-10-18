<?php
require_once(dirname(__FILE__).'/Settings.class.php');
require_once(dirname(__FILE__).'/../lib/gapi/gapi.class.php');

class GA {
  private $settings = array();
  private $gs = '';

  public function __construct() {
    $settings = new Settings();
    $this->settings = $settings->getArray();

    $this->ga = new gapi($this->settings['ga']['email'],$this->settings['ga']['password']);
  }

  public function getPagesAndVisitors() {
    $this->ga->requestReportData(
      $this->settings['ga']['profile_id'],
      array('pagePath'),
      array('visitors'),
      '-visitors',
      null,
      null,
      null,
      null,
      $this->settings['ga']['max_results']
    );

    return $this->ga->getResults();
  }
}
