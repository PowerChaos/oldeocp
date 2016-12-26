<?php
if ($_SESSION['id'] != "" && $_POST['buytoken'] =="")
{
?>
<table border='1'>
<tr>
<th>Character</th>
<th>Tokens</th>
</tr>
<?php
$gamedata = db_query("SELECT * FROM cq_user WHERE (`account_id` LIKE '".$_SESSION['id']."')");
while ($gameinfo = mysql_fetch_assoc($gamedata))
{
echo ("<tr>");
echo ("<td><font color='red'>".$gameinfo[name]."</font></td>");
echo ("<td>".$gameinfo[bonus_points]."</td>");
echo "</tr>";
}
?>
</table>
<table align="center">	
<form method="post" action="./?page=buytoken">
<tr><td align="center">Tokens:</tr></td>
<tr><td align="center"><select name="token">
 <?php 
$gettokenvalue = db_query("SELECT * FROM power_donate WHERE (`payment` LIKE 'token' ) ORDER BY credits DESC");
while ($tokenvalue = mysql_fetch_assoc($gettokenvalue))
{
echo "<option value ='".$tokenvalue[credits]."@".$tokenvalue[price]."'>".$tokenvalue[credits]." Tokens for ".$tokenvalue[price]." credits</option>";
}
?>

</select>
</tr></td>
<tr><td align="center">												
<tr><td align="center">Character:</tr></td>
<tr><td align="center"><select name="character">
 <?php 
$chars = db_query("SELECT * FROM cq_user WHERE (`account_id` LIKE '".$_SESSION['id']."' )");
while ($character = mysql_fetch_assoc($chars))
{
echo "<option value ='".$character[name]."'>".$character[name]."</option>";
}
?>
</select>
</tr></td>
<tr><td align="center">
<input class="Butt" type="submit" value="Charge your account" name="buytoken">
</td></tr>
</form>
</table>

<?php
}
if ($_POST['buytoken'] && $_SESSION['id'] != "")
{

$user = $_POST['character'];
$token = $_POST['token'];
$account = $_SESSION['id'];
$extract = explode("@",$token);
$reward = $extract[0];
$price = $extract[1];
$check = db_array("SELECT * FROM power_user WHERE (`account_id` LIKE '".$account."' )");
$check2 = db_array("SELECT * FROM cq_user WHERE (`name` LIKE '".$user."' )");
if ($check['money'] >= ($price ) ){
if (($check2['bonus_points'] >= "1500000000") || (($check2['bonus_points'] + $reward) >= "1500000000"))
{
echo "Sorry, You got to mutch tokens , please spend some Tokens before you can donate for more tokens";
}
else
{
db_query("UPDATE `cq_user` SET `bonus_points` = `bonus_points` +'".$reward."' WHERE `name` = '".$user."'") ;
db_query("UPDATE `power_user` SET `money` = `money` -'".$price."' WHERE `account_id` = '".$account."'") ;
db_query("insert into power_donatelogs (account_id,credits,transid,date,response,debug,payment) values ('".$user."','".$reward."','Tokens added','".date("y-m-d H:i:s", time())."','Succesfull','$reward tokens added for $price credits','token')");
echo "Your $reward Tokens has beein added to account $user";
}
}
else
{
echo "Sorry you do not have enouf credits , please buy more credits before you can donate for Tokens";
}
}
else if ($_SESSION['id'] == "")
{
echo "please login before using this function";
}
?>