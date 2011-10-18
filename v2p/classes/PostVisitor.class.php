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

  public function getWPPostId4Url($url) {
    $sth = $this->pdo->prepare('SELECT `ID` FROM `wp_posts` WHERE `post_name`=?');
    $sth->execute(array(substr($url, 2)));
    $row = $sth->fetch();

    return $row['ID'];
  }

  public function insertOrUpdate($post_id, $visitors) {
    $sth = $this->pdo->prepare('SELECT `post_id` FROM `v2p_post_visitor` WHERE `post_id`=?');
    $sth->execute(array($post_id));
    $row = $sth->fetch(); 
    if($row['post_id']) {
      $sthUpdate = $this->pdo->prepare('UPDATE `v2p_post_visitor` SET `visitors`=? WHERE `post_id`=?');
      $sthUpdate->execute(array($visitors, $post_id));
    } else {
      $sthInsert = $this->pdo->prepare("INSERT INTO `v2p_post_visitor` VALUES('',?,?)");
      $sthInsert->execute(array($post_id,$visitors));
    }
  }
}
