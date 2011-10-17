<?php
require_once(dirname(__FILE__).'/classes/WP.class.php');
if(isset($_POST['v2pMakeTransaction'])) {
  echo json_encode(array('status'=>1));
}
