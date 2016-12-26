<?php
include ("././functions.php");
// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';
foreach ($_POST as $key => $value) {
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";
}
if ($_POST) {
  $kv = array();
  foreach ($_POST as $key => $value) {
    $kv[] = "$key => $value";
  }
  $query_string = join("\n", $kv);
}
else {
  $query_string = $_SERVER['QUERY_STRING'];
}

$item_name = $_POST['item_name'];
if ($item_name != "")
{
// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);
// assign posted variables to local variables
$user = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$txn_id = $_POST['txn_id'];
$payment_amount = $_POST['mc_gross'];
$reward = $_POST['option_selection1'];
if (!$fp) {
db_query("insert into power_donatelogs (account_id,credits,transid,date,response,debug,payment) values ('".$user."','".$reward."','".$txn_id."','".date("y-m-d H:i:s", time())."','!fp failt','".$query_string."','paypal')");
} 
fputs ($fp, $header . $req);
while (!feof($fp)) {
$res = fgets ($fp, 1024);
if (strcmp ($res, "VERIFIED") == 0) {
if (strcmp ($payment_status, "Completed") == 0) {
// check the payment_status is Completed
// check that txn_id has not been previously processed
// check that receiver_email is your Primary PayPal email
// check that payment_amount/payment_currency are correct
// process payment
$credits = db_array("SELECT * FROM power_donate WHERE (`price` LIKE '".$payment_amount."')");
//check if credits are a match before rewarding to the user
if ($reward == $credits['credits'])
{ 
		db_query("UPDATE `power_user` SET `money` = `money` +'".$reward."' WHERE `account_id` = '".$user."'") or die(mysql_error());
		db_query("insert into power_donatelogs (account_id,credits,transid,date,response,debug,payment) values ('".$user."','".$reward."','".$txn_id."','".date("y-m-d H:i:s", time())."','".$payment_status."','".$query_string."','paypal')");
}
else
{
// credits does not mathc allowed credits for payment -> no reward for user
db_query("insert into power_donatelogs (account_id,credits,transid,date,response,debug,payment) values ('".$user."','".$reward."','".$txn_id."','".date("y-m-d H:i:s", time())."','Reward (".$reward.") does not match original credits (".$credits['credits']." , probaly fraude by the user (altered submit form)','".$query_string."','paypal')");

		}
}
else
 {
//verified and not completed ??  
db_query("insert into power_donatelogs (account_id,credits,transid,date,response,debug,payment) values ('".$user."','".$reward."','".$txn_id."','".date("y-m-d H:i:s", time())."','verified and not complete','".$query_string."','paypal')");
}
}
else if (strcmp ($res, "INVALID") == 0) {
//its invalid
db_query("insert into power_donatelogs (account_id,credits,transid,date,response,debug,payment) values ('".$user."','".$reward."','".$txn_id."','".date("y-m-d H:i:s", time())."','payment is invalid','".$query_string."','paypal')");

}
}
fclose ($fp);
}
else
{
?>
Paypal Callback file , protected by PowerChaos anti cheat system
<?php
}
?>