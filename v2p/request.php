<?php
require_once(dirname(__FILE__).'/classes/WP.class.php');

if(isset($_POST['v2pMakeRequest'])) {
  echo json_encode(array('status'=>1, 'request_id'=>34));
}
