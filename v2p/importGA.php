<?php
require_once(dirname(__FILE__).'/classes/GA.class.php');
require_once(dirname(__FILE__).'/classes/PostVisitor.class.php');

if(isset($_POST['start'])) {
  $ga = new GA();
  $pv = new PostVisitor();

  foreach($ga->getPagesAndVisitors() as $result) {
    $post_id = $pv->getWPPostId4Url('/'.$result);
    if($post_id) {
      $pv->insertOrUpdate($post_id, $result->getVisitors());
    }
  }
  
  echo json_encode(array('status'=>1));
}
