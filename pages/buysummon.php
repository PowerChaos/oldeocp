<?php
if ($_SESSION['id'] != "" && $_POST['buysummon'] =="")
{
?>
<table border='1'>
<tr>
<th>Character</th>
<th>Summons</th>
</tr>
<?php
$gamedata = db_query("SELECT * FROM cq_user WHERE (`account_id` LIKE '".$_SESSION['id']."')");
while ($gameinfo = mysql_fetch_assoc($gamedata))
{
echo ("<tr>");
echo ("<td><font color='red'>".$gameinfo[name]."</font></td>");
echo ("<td>".$gameinfo[medal_select]."</td>");
echo "</tr>";
}
?>
</table>
<table align="center">	
<form method="post" action="./?page=buysummon">
<tr><td align="center">Summons:</tr></td>
<tr><td align="center"><select name="summon">
 <?php 
$getsummonvalue = db_query("SELECT * FROM power_donate WHERE (`payment` LIKE 'summon' ) ORDER BY credits DESC");
while ($summonvalue = mysql_fetch_assoc($getsummonvalue))
{
echo "<option value ='".$summonvalue[credits]."@".$summonvalue[price]."'>".$summonvalue[credits]." summon for ".$summonvalue[price]." credits</option>";
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
<input class="Butt" type="submit" value="Charge your account" name="buysummon">
</td></tr>
</form>
</table>

<?php
}
if ($_POST['buysummon'] && $_SESSION['id'] != "")
{

$user = $_POST['character'];
$summon = $_POST['summon'];
$account = $_SESSION['id'];
$extract = explode("@",$summon);
$reward = $extract[0];
$price = $extract[1];
$check = db_array("SELECT * FROM power_user WHERE (`account_id` LIKE '".$account."' )");
$check2 = db_array("SELECT * FROM cq_user WHERE (`name` LIKE '".$user."' )");
if ($check['money'] >= ($price ) ){
if (($check2['medal_select'] > $reward))
{
echo "Do you preffer to lower the summon amount you currently have ??";
}
else
{
db_query("UPDATE `cq_user` SET `medal_select` = '".$reward."' WHERE `name` = '".$user."'");
db_query("UPDATE `power_user` SET `money` = `money` -'".$price."' WHERE `account_id` = '".$account."'");
db_query("insert into power_donatelogs (account_id,credits,transid,date,response,debug,payment) values ('".$user."','".$reward."','Summon Added','".date("y-m-d H:i:s", time())."','Succesfull','$reward Summon added for $price credits','summon')");
echo "$reward summon has beein added to account $user";
}
}
else
{
echo "Sorry you do not have enouf credits , please buy more credits before you can buy more summons";
}
}
else if ($_SESSION['id'] == "")
{
echo "please login before using this function";
}
?>