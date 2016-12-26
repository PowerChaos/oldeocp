<?php
if ($_SESSION['id'] != "")
{
accdb();
$vipinfo= db_assoc("SELECT * FROM account WHERE (`id` LIKE '".$_SESSION['id']."' )");
gamedb();
$accountinfo = db_assoc("SELECT * FROM cq_user WHERE (`account_id` LIKE '".$_SESSION['id']."' )");
$gamedata = db_query("SELECT * FROM cq_user WHERE (`account_id` LIKE '".$_SESSION['id']."' )");
$petdata = db_query("SELECT * FROM cq_eudemon WHERE (`player_id` LIKE '".$accountinfo['id']."' ) ORDER BY star_lev DESC");
$legiondata = db_query("SELECT * FROM cq_syndicate WHERE (`id` LIKE '".$accountinfo['syndicate_id']."' )");
$donationdata = db_query("SELECT * FROM cq_donation_dynasort_rec WHERE (`user_id` LIKE '".$accountinfo['id']."' )");
$chardata = db_query("SELECT * FROM cq_user WHERE (`account_id` LIKE '".$_SESSION['id']."' )");
?>
<center>
<p>your account is <font color="red">vip level <?php echo ($vipinfo[VIP]); ?></font></p>
<p>Your account exist from <font color="green"><?php echo ($vipinfo[reg_date]); ?></font></p>
<table border='1'>
<tr>
<th>Character</th>
<th>Level</th>
<th>Class</th>
<th>Alt</th>
<th>Ep</th>
<th>Last Login</th>
</tr>
<?php
while ($gameinfo = mysql_fetch_array($gamedata))
{
if ($gameinfo[profession] == 10)
{$prof = "Mage";}
else if ($gameinfo[profession] == 20)
{$prof = "Warior";}
else if ($gameinfo[profession] == 30)
{$prof = "Paladin";}
else if ($gameinfo[profession] == 50)
{$prof = "Vampire";}
else
{$prof = "Big Mess";}
if ($gameinfo[type] != 0)
{$type = "<font color='green'>Alt</font>";}
if ($gameinfo[type] == 0)
{$type = "<font color='red'>Main</font>";}
echo ("<tr>");
echo ("<td><font color='red'>".$gameinfo[name]."</font></td>");
echo ("<td>".$gameinfo[level]."</td>");
echo ("<td>".$prof."</td>");
echo ("<td>".$type."</td>");
echo ("<td>".$gameinfo[emoney]."</td>");
echo ("<td>".date("d/m/Y @ H:i:s",$gameinfo[Login_time])."</td>");
echo "</tr>";
}
?>
</table>
<br>
<FORM action="./index.php?page=characterstats" method="POST">
<input type="hidden" name="action" value="search" />
<table>													
Character:
<select name="character" id="character">
<?php

while ($charlist = mysql_fetch_array($chardata))
{
echo "<option value ='".$charlist['id']."'>".$charlist[name]."</option>";
}
?>
</select>
</table>
<br>
<input class=Butt type=submit value="See Character Stats" name="search">
</FORM>
<?php
if ($_POST['action'] != "search")
{
?>
<p><br>Personal Pet Status for <font color="red"><?php echo ($accountinfo['name']);?></font><br></p>
<table border='1'>
<tr>
<th>Eudemon</th>
<th>Reborns</th>
<th>Stars</th>
</tr>
<?php
while ($petinfo = mysql_fetch_array($petdata))
{
$totalstars = $petinfo['star_lev'] / 100 ;
$stars =  round($totalstars, 2);
if (empty($petinfo['ori_owner_name']))
{$stars = "Hatching";} 
$petnames = mysql_query("SELECT * FROM cq_itemtype WHERE (`id` LIKE '".$petinfo['item_type']."' )");
$petname = mysql_fetch_array($petnames);
echo ("<tr>");
echo ("<td>".$petname['name']."</td>");
echo ("<td>".$petinfo['reborn_times']."</td>");
echo ("<td>".$stars."</td>");
echo "</tr>";
}
?>
</table>
<?php
?>
<p><br>Legion Status for <font color="red"><?php echo ($accountinfo['name']);?></font><br></p>
<table border='1'>
<tr>
<th>Legion</th>
<th>Leader</th>
<th>Population</th>
</tr>
<?php
while ($legioninfo = mysql_fetch_array($legiondata))
{
echo ("<tr>");
echo ("<td><font color='red'>".$legioninfo['NAME']."</font></td>");
echo ("<td>".$legioninfo['leader_name']."</td>");
echo ("<td>".$legioninfo['amount']."</td>");
echo "</tr>";
}
?>
</table>
<p><br>Gold Donation Status  of <font color="red"><?php echo ($accountinfo['name']);?></font><br></p>
<table border='1'>
<tr>
<th><br>Donation<br></th>
</tr>
<?php
$donationinfo = mysql_fetch_array($donationdata);
echo ("<tr>");
echo ("<td><font color='green'>".$donationinfo['value']."</font></td>");
echo "</tr>";
?>
</table>
<?php
}

if ($_POST['action'] == "search")
{
$character = $_POST['character'];
$characterinfo = db_array("SELECT * FROM cq_user WHERE (`id` LIKE '".$character."' )");
$petdata2 = db_query("SELECT * FROM cq_eudemon WHERE (`player_id` LIKE '".$character."' ) ORDER BY star_lev DESC");
$donationdata2 = db_query("SELECT * FROM cq_donation_dynasort_rec WHERE (`user_id` LIKE '".$character."' )");
$legiondata2 = db_query("SELECT * FROM cq_syndicate WHERE (`id` LIKE '".$characterinfo['syndicate_id']."' )");
?>
<p><br>Personal Pet Status for <font color="red"><?php echo ($characterinfo['name']);?></font><br></p>
<table border='1'>
<tr>
<th>Eudemon</th>
<th>Reborns</th>
<th>Stars</th>
</tr>
<?php
while ($petinfo = mysql_fetch_array($petdata2))
{
$totalstars = $petinfo['star_lev'] / 100 ;
$stars =  round($totalstars, 2);
if (empty($petinfo['ori_owner_name']))
{$stars = "Hatching";}
$petnames = mysql_query("SELECT * FROM cq_itemtype WHERE (`id` LIKE '".$petinfo['item_type']."' )");
$petname = mysql_fetch_array($petnames); 
echo ("<tr>");
echo ("<td>".$petname['name']."</td>");
echo ("<td>".$petinfo['reborn_times']."</td>");
echo ("<td>".$stars."</td>");
echo "</tr>";
}
?>
</table>
<p><br>Legion Status for <font color="red"> <?php echo ($characterinfo['name']);?></font><br></p>
<table border='1'>
<tr>
<th>Legion</th>
<th>Leader</th>
<th>Population</th>
</tr>
<?php
while ($legioninfo = mysql_fetch_array($legiondata2))
{
echo ("<tr>");
echo ("<td><font color='red'>".$legioninfo['NAME']."</font></td>");
echo ("<td>".$legioninfo['leader_name']."</td>");
echo ("<td>".$legioninfo['amount']."</td>");
echo "</tr>";
}
?>
</table>
<p><br>Gold Donation Status of  <font color="red"><?php echo ($characterinfo['name']);?></font><br></p>
<table border='1'>
<tr>
<th>Donation</th>
</tr>
<?php
$donationinfo2 = mysql_fetch_array($donationdata2);
echo ("<tr>");
echo ("<td><font color='green'>".$donationinfo2['value']."</font></td>");
echo "</tr>";
?>
</center>
</table>
<?php

}
}
else
{
echo ("Please login before you can see this page");
}
?>