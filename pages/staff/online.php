<?php
$gamedata = db_query("SELECT * FROM cq_user WHERE cq_user.last_logout < cq_user.login_time ORDER BY login_time DESC");
$online = mysql_num_rows($gamedata);
?>
<p><center><b>There are <font color='red'><?php echo $online;?></font> Characters Online</b></center></p>
<?php if ($online !='0'){ ?>
<table border='1'>
<tr>
<th>Account ID</th>
<th>Character</th>
<th>Level</th>
<th>Class</th>
<th>Alt</th>
<th>Ep</th>
<th>Last Login</th>
</tr>
<?php
while ($gameinfo = mysql_fetch_assoc($gamedata))
{
if ($gameinfo[profession] == 10)
{$prof = "Mage";}
if ($gameinfo[profession] == 20)
{$prof = "Warior";}
if ($gameinfo[profession] == 30)
{$prof = "Paladin";}
if ($gameinfo[profession] == 50)
{$prof = "Vampire";}
if ($gameinfo[type] == 1)
{$type = "<font color='green'>Alt</font>";}
if ($gameinfo[type] == 0)
{$type = "<font color='red'>Main</font>";}
echo ("<tr>");
echo ("<td>".$gameinfo['account_id']."</td>");
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
<?php
}
?>