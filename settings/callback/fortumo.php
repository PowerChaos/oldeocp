<?php
include ("././functions.php");
  // check that the request comes from Fortumo server
  
 if(!in_array($_SERVER['REMOTE_ADDR'],
      array('81.20.151.38', '81.20.148.122', '79.125.125.1', '209.20.83.207'))) {
      header("HTTP/1.0 403 Forbidden");
      die("Fortumo Callback file , protected by PowerChaos anti cheat system");
  }
  
if ($_GET) {
  $kv = array();
  foreach ($_GET as $key => $value) {
    $kv[] = "$key => $value";
  }
  $query_string = join("\n", $kv);
}
else {
  $query_string = $_SERVER['QUERY_STRING'];
}
  $payment_status = $_GET['status'];
  $sender = $_GET['sender'];//phone num.
  $reward = $_GET['amount'];
  $user = $_GET['cuid'];//resource i.e. user
  $txn_id = $_GET['payment_id'];//unique id

  //hint: find or create payment by payment_id
  //additional parameters: operator, price, user_share, country
  
  if(preg_match("/failed/i", $_GET['status'])) {
   // mark payment as failed
   db_query("insert into power_donatelogs (account_id,credits,transid,date,response,debug,payment) values ('".$user."','".$reward."','".$txn_id."','".date("y-m-d H:i:s", time())."','".$payment_status."','".$query_string."','fortumo')");
  } else {
  //reward player
		db_query("UPDATE `power_user` SET `money` = `money` +'".$reward."' WHERE `account_id` = '".$user."'") or die(mysql_error());
		db_query("insert into power_donatelogs (account_id,credits,transid,date,response,debug,payment) values ('".$user."','".$reward."','".$txn_id."','".date("y-m-d H:i:s", time())."','".$payment_status."','".$query_string."','fortumo')");

  }
?>