<?php
if ($_SESSION['id'] != "" AND $_POST['pk'] != "reset")
{
$chardata = db_query("SELECT * FROM cq_user WHERE (`account_id` LIKE '".$_SESSION['id']."' )");
?>
<p>Please logout of the game before using this , or the cleaning will break your character</p><br>
<table border='1'>
<tr>
<th>Character</th>
<th>PK points</th>
</tr>
<?php
while ($gameinfo = mysql_fetch_assoc($chardata))
{
echo ("<tr>");
echo ("<td><font color='red'>".$gameinfo[name]."</font></td>");
echo ("<td><font color='green'>".$gameinfo[pk]."</font></td>");
echo "</tr>";
}
?>
</table>
<br>
<FORM action="./index.php?page=resetpk" method="POST">
<input type="hidden" name="pk" value="reset" />
<table>													
Avaible Characters:
<select name="character" id="character">
<?php

$chardata = db_query("SELECT * FROM cq_user WHERE pk >=1 AND (`account_id` LIKE '".$_SESSION['id']."' ) ORDER BY name DESC");
while ($charlist = mysql_fetch_assoc($chardata))
{
echo "<option value ='".$charlist['name']."'>".$charlist['name']."</option>";
}
?>
</select>
<tr><td align="center">Remove PK Points:</tr></td>
<tr><td align="center"><select name="pkpoints">
 <?php 
$getpkvalue = db_query("SELECT * FROM power_donate WHERE (`payment` LIKE 'pk' ) ORDER BY credits DESC");
while ($pkvalue = mysql_fetch_assoc($getpkvalue))
{
echo "<option value ='".$pkvalue[credits]."@".$pkvalue[price]."'> Remove ".$pkvalue[credits]." Pk Points for ".$pkvalue[price]." credits</option>";
}
?>
</select>
</tr></td>
</table>
<br>
<input class=Butt type=submit value="Reset Pk Points" name="reset">
</FORM>
<?php
}
else if ($_POST['pk'] == "reset")
{
$pk = $_POST['pkpoints'];
$character = $_POST['character'];
$account = $_SESSION['id'];
$extract = explode("@",$pk);
$reward = $extract[0];
$price = $extract[1];
$check = db_array("SELECT * FROM power_user WHERE (`account_id` LIKE '".$account."' )");
$check2 = db_array("SELECT * FROM cq_user WHERE (`name` LIKE '".$character."' )");
if ($check['money'] >= ($price ) ){
if ($check2['pk'] <= $reward)
{
db_query("UPDATE cq_user SET pk = '0' WHERE name='".$character."'");
db_query("UPDATE `power_user` SET `money` = `money` -'".$price."' WHERE `account_id` = '".$account."'") ;
db_query("insert into power_donatelogs (account_id,credits,transid,date,response,debug,payment) values ('".$character."','".$reward."','All PK Removed','".date("y-m-d H:i:s", time())."','Succesfull','All PK points removed for $price credits','pk')");

echo "your Character <font color='red'>".$character."</font> pk points are magicaly dissapeared for a small fee of <font color='green'>".$price." Credits</font>";
}
else
{
db_query("UPDATE `cq_user` SET `pk` = `pk` -'".$reward."' WHERE `name` = '".$character."'") ;
db_query("UPDATE `power_user` SET `money` = `money` -'".$price."' WHERE `account_id` = '".$account."'") ;
db_query("insert into power_donatelogs (account_id,credits,transid,date,response,debug,payment) values ('".$character."','".$reward."','pk points removed','".date("y-m-d H:i:s", time())."','Succesfull','$reward pk points removed for $price credits','pk')");
echo "your Character <font color='red'>".$character."</font> pk points are decreased by $reward for a small fee of <font color='green'>".$price." credits</font>";
}
}
else
{
echo "Sorry you do not have enouf credits , please buy more credits before you can Decrease your pk points";
}
}
if ($_SESSION['id'] == "")
{
echo ("Please login before using this function");
}  
?> 