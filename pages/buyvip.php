<?php
accdb();
if ($_SESSION['id'] != "" && $_POST['buyvip'] =="")
{
?>
<table border='1'>
<tr>
<th>Character</th>
<th>Vip Level</th>
</tr>
<?php
$gamedata = db_query("SELECT * FROM account WHERE (`id` LIKE '".$_SESSION['id']."')");
while ($gameinfo = mysql_fetch_assoc($gamedata))
{
echo ("<tr>");
echo ("<td><font color='red'>".$gameinfo[name]."</font></td>");
echo ("<td>".$gameinfo[VIP]."</td>");
echo "</tr>";
}
?>
</table>
<table align="center">	
<form method="post" action="./?page=buyvip">
<tr><td align="center">Vip Level:</tr></td>
<tr><td align="center"><select name="vip">
 <?php 
 gamedb();
$getvipvalue = db_query("SELECT * FROM power_donate WHERE (`payment` LIKE 'vip' ) ORDER BY credits DESC");
while ($vipvalue = mysql_fetch_assoc($getvipvalue))
{
echo "<option value ='".$vipvalue[credits]."@".$vipvalue[price]."'> Vip level ".$vipvalue[credits]." for ".$vipvalue[price]." credits</option>";
}
?>

</select>
</tr></td>
<tr><td align="center">
<input class="Butt" type="submit" value="Change Vip Level" name="buyvip">
</td></tr>
</form>
</table>

<?php
}
if ($_POST['buyvip'] && $_SESSION['id'] != "")
{
$vip = $_POST['vip'];
$account = $_SESSION['id'];
$extract = explode("@",$vip);
$reward = $extract[0];
$price = $extract[1];
$check = db_array("SELECT * FROM power_user WHERE (`account_id` LIKE '".$account."' )");
accdb();
$check2 = db_array("SELECT * FROM account WHERE (`id` LIKE '".$account."' )");
if ($check['money'] >= ($price ) ){
if ($check2['VIP'] >= $reward)
{
echo "Sorry , but your vip level is already higher then you want to buy";
}
else
{
db_query("UPDATE `account` SET `VIP` = '".$reward."' WHERE `id` = '".$account."'") ;
gamedb();
db_query("UPDATE `power_user` SET `money` = `money` -'".$price."' WHERE `account_id` = '".$account."'") ;
db_query("insert into power_donatelogs (account_id,credits,transid,date,response,debug,payment) values ('".$account."','".$reward."','Vip Added','".date("y-m-d H:i:s", time())."','Succesfull','Vip level $reward added for $price credits','summon')");
echo "You are now vip level $reward";
}
}
else
{
echo "Sorry you do not have enouf credits , please buy more credits before you can upgrade your vip level";
}
}
else if ($_SESSION['id'] == "")
{
echo "please login before using this function";
}
?>