<?php
$time = time();
$date = strtotime("-7 days",$time);
$gamedata = db_query("SELECT * FROM cq_user WHERE (`Login_time` >= '".$date."' ) ORDER BY Login_time DESC");
$total = db_number("SELECT * FROM cq_user WHERE (`Login_time` >= '".$date."' ) ORDER BY Login_time DESC");
?>

<p>Search for other Date</p>
<form method="post" action="./index.php?staff=lastlogin">
<input type="hidden" name="action" value="search" />
<TABLE>
<tr><td>Search:<input type="text" size="3" name="datum" value="" />Days Back</tr></td>
<tr><td>
<input class=Butt type=submit value="Search History" name="search">
</td></tr>
</TABLE>
</form>
<?php
if ($_POST['action'] != "search")
{
?>
<p> <?php echo ($total);?> Last Logins for the past 7 days</p>
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
if ($_POST['action'] == "search")
{
$days = $_POST['datum'];
$time2 = time();
$date2 = strtotime("-".$days." days",$time2);
$gamesearch = db_query("SELECT * FROM cq_user WHERE (`Login_time` >= '".$date2."' ) ORDER BY Login_time DESC");
$total2 = db_number("SELECT * FROM cq_user WHERE (`Login_time` >= '".$date2."' ) ORDER BY Login_time DESC");
?>
<p> <?php echo ($total2); ?> Last Logins for the past <?php echo($days);?> days</p>
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
while ($gametime = mysql_fetch_array($gamesearch))
{
if ($gametime[profession] == 10)
{$prof = "Mage";}
if ($gametime[profession] == 20)
{$prof = "Warior";}
if ($gametime[profession] == 30)
{$prof = "Paladin";}
if ($gametime[profession] == 50)
{$prof = "Vampire";}
if ($gametime[type] == 1)
{$type = "<font color='green'>Alt</font>";}
if ($gametime[type] == 0)
{$type = "<font color='red'>Main</font>";}
echo ("<tr>");
echo ("<td><font color='red'>".$gametime[name]."</font></td>");
echo ("<td>".$gametime[level]."</td>");
echo ("<td>".$prof."</td>");
echo ("<td>".$type."</td>");
echo ("<td>".$gametime[emoney]."</td>");
echo ("<td>".date("d/m/Y @ H:i:s",$gametime[Login_time])."</td>");
echo "</tr>";
}
?>
</table>
<?php
}
?>