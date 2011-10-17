<?php
require_once(dirname(__FILE__).'/DB.class.php');
require_once(dirname(__FILE__).'/Settings.class.php');

class PostVisitor {
  private $settings = array();
  private $pdo = '';

  public function __construct() {
    $settings = new Settings();
    $this->settings = $settings->getArray();

    $db = new DB();
    $this->pdo = $db->connect();
  }

  public function getVisitors4PostId($post_id) {
    $sth = $this->pdo->prepare('SELECT `visitors` FROM `v2p_post_visitor` WHERE `post_id`=?');
    $sth->execute(array($post_id));
    $row = $sth->fetch();

    return $row['visitors'] ? $row['visitors'] : 0;
  }
}
