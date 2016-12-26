<?php
// installer
if(isset($_POST['installsql']))
{
include ("./installer.php");
db_query("DROP TABLE IF EXISTS `power_settings`");
$sql = 'CREATE TABLE IF NOT EXISTS `power_settings` ('.
'`id` int(11) NOT NULL auto_increment,'.
'`paypalemail` text NOT NULL,'.
'`paypalcurrency` text NOT NULL,'.
'`fortumorel` text NOT NULL,'.
'`serverip` text NOT NULL,'.
'`servername` text NOT NULL,'.
'PRIMARY KEY  (`id`))';	 
db_query($sql);
db_query("DROP TABLE IF EXISTS `power_donate`");
$sql2 = 'CREATE TABLE IF NOT EXISTS `power_donate` ('.
'`id` int(11) NOT NULL auto_increment,'.
'`price` text NOT NULL,'.
'`credits` text NOT NULL,'.
'`payment` text NOT NULL,'.
'PRIMARY KEY  (`id`))';	 
db_query($sql2);
db_query("DROP TABLE IF EXISTS `power_user`");
$sql3 = 'CREATE TABLE IF NOT EXISTS `power_user` ('.
'`id` int(11) NOT NULL auto_increment,'.
'`username` text NOT NULL,'.
'`account_id` text NOT NULL,'.
'`email` text NOT NULL,'.
'`money` text NOT NULL,'.
'PRIMARY KEY  (`id`))';	 
db_query($sql3);
db_query("DROP TABLE IF EXISTS `power_donatelogs`");
$sql4 = 'CREATE TABLE IF NOT EXISTS `power_donatelogs` ('.
'`id` int(11) NOT NULL auto_increment,'.
'`account_id` text NOT NULL,'.
'`credits` text NOT NULL,'.
'`transid` text NOT NULL,'.
'`date` text NOT NULL,'.
'`response` text NOT NULL,'.
'`debug` text NOT NULL,'.
'`payment` text NOT NULL,'.
'PRIMARY KEY  (`id`))';	 
db_query($sql4);
}
//installer config
if(isset($_POST['installconfig']))
{
$paypalemail = $_POST['paypalemail'];
$paypalcurrency = $_POST['paypalcurrency'];
$fortumorel = $_POST['fortumorel'];
$serverip = $_POST['serverip'];
$servername = $_POST['servername'];

include ("./installer.php");
db_query("insert into power_settings (paypalemail,paypalcurrency,fortumorel,serverip,servername) values ('".$paypalemail."','".$paypalcurrency."','".$fortumorel."','".$serverip."','".$servername."')");
}
//update the settings table
if(isset($_POST['updatesettings']))
{
db_query("DROP TABLE IF EXISTS `power_settings`");
$sql = 'CREATE TABLE IF NOT EXISTS `power_settings` ('.
'`id` int(11) NOT NULL auto_increment,'.
'`paypalemail` text NOT NULL,'.
'`paypalcurrency` text NOT NULL,'.
'`fortumorel` text NOT NULL,'.
'`serverip` text NOT NULL,'.
'`servername` text NOT NULL,'.
'PRIMARY KEY  (`id`))';	 
db_query($sql);

$paypalemail = $_POST['paypalemail'];
$paypalcurrency = $_POST['paypalcurrency'];
$fortumorel = $_POST['fortumorel'];
$serverip = $_POST['serverip'];
$servername = $_POST['servername'];

db_query("insert into power_settings (paypalemail,paypalcurrency,fortumorel,serverip,servername) values ('".$paypalemail."','".$paypalcurrency."','".$fortumorel."','".$serverip."','".$servername."')");
}

//start reward value's
//reward ep
if(isset($_POST['addep']))
{
$epreward = $_POST['epreward'];
$epprice = $_POST['epprice'];
db_query("insert into power_donate (price,credits,payment) values ('".$epprice."','".$epreward."','ep')");

}
//reward summon
if(isset($_POST['addsummon']))
{
$summonreward = $_POST['summonreward'];
$summonprice = $_POST['summonprice'];
db_query("insert into power_donate (price,credits,payment) values ('".$summonprice."','".$summonreward."','summon')");
}
//reward tokens
if(isset($_POST['addtoken']))
{
$tokenreward = $_POST['tokenreward'];
$tokenprice = $_POST['tokenprice'];
db_query("insert into power_donate (price,credits,payment) values ('".$tokenprice."','".$tokenreward."','token')");
}
//reward vip
if(isset($_POST['addvip']))
{
$vipreward = $_POST['vipreward'];
$vipprice = $_POST['vipprice'];
db_query("insert into power_donate (price,credits,payment) values ('".$vipprice."','".$vipreward."','vip')");
}
//Reward Credits
if(isset($_POST['addcredit']))
{
$creditreward = $_POST['creditreward'];
$creditprice = $_POST['creditprice'];
db_query("insert into power_donate (price,credits,payment) values ('".$creditprice."','".$creditreward."','paypal')");
}
//add pk point remove options
if(isset($_POST['addpk']))
{
$pkreward = $_POST['pkreward'];
$pkprice = $_POST['pkprice'];
db_query("insert into power_donate (price,credits,payment) values ('".$pkprice."','".$pkreward."','pk')");
}
//Remove a Reward
if(isset($_POST['removereward']))
{
$id = $_POST['removeid'];
db_query("DELETE FROM power_donate WHERE id = $id");
}

if(!isset($_POST))
{
echo ("Post Value is missing");
}
?>