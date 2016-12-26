<?php
if ($_SESSION['id'] != "" && $_POST['buyep'] =="")
{
?>
<table border='1'>
<tr>
<th>Character</th>
<th>EP</th>
</tr>
<?php
$gamedata = db_query("SELECT * FROM cq_user WHERE (`account_id` LIKE '".$_SESSION['id']."')");
while ($gameinfo = mysql_fetch_assoc($gamedata))
{
echo ("<tr>");
echo ("<td><font color='red'>".$gameinfo[name]."</font></td>");
echo ("<td>".$gameinfo[emoney]."</td>");
echo "</tr>";
}
?>
</table>
<table align="center">	
<form method="post" action="./?page=buyep">
<tr><td align="center">EP:</tr></td>
<tr><td align="center"><select name="ep">
 <?php 
$getepvalue = db_query("SELECT * FROM power_donate WHERE (`payment` LIKE 'ep' ) ORDER BY credits DESC");
while ($epvalue = mysql_fetch_assoc($getepvalue))
{
echo "<option value ='".$epvalue[credits]."@".$epvalue[price]."'>".$epvalue[credits]." ep for ".$epvalue[price]." credits</option>";
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
<input class="Butt" type="submit" value="Charge your account" name="buyep">
</td></tr>
</form>
</table>

<?php
}
if ($_POST['buyep'] && $_SESSION['id'] != "")
{

$user = $_POST['character'];
$ep = $_POST['ep'];
$account = $_SESSION['id'];
$extract = explode("@",$ep);
$reward = $extract[0];
$price = $extract[1];
$check = db_array("SELECT * FROM power_user WHERE (`account_id` LIKE '".$account."' )");
$check2 = db_array("SELECT * FROM cq_user WHERE (`name` LIKE '".$user."' )");
if ($check['money'] >= ($price ) ){
if (($check2['emoney'] >= "1500000000") || (($check2['emoney'] + $reward) >= "1500000000"))
{
echo "Sorry, You just got to mutch ep , please spend some ep before you can donate for more ep";
}
else
{
db_query("UPDATE `cq_user` SET `emoney` = `emoney` +'".$reward."' WHERE `name` = '".$user."'") ;
db_query("UPDATE `power_user` SET `money` = `money` -'".$price."' WHERE `account_id` = '".$account."'") ;
db_query("insert into power_donatelogs (account_id,credits,transid,date,response,debug,payment) values ('".$user."','".$reward."','EP Added','".date("y-m-d H:i:s", time())."','Succesfull','$reward ep added for $price credits','ep')");
echo "$reward ep has beein added to account $user";
}
}
else
{
echo "Sorry you do not have enouf credits , please buy more credits before you can donate for ep";
}
}
else if ($_SESSION['id'] == "")
{
echo "please login before using this function";
}
?>