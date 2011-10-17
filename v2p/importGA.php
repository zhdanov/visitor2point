<?php
require_once(dirname(__FILE__).'/classes/GA.class.php');
require_once(dirname(__FILE__).'/classes/WP.class.php');

if(isset($_POST['start'])) {
  sleep(4);
  echo json_encode(array('status'=>1));
}
