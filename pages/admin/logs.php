<p>Show older results</p>
<form method="post" action="./index.php?admin=logs">
<input type="hidden" name="action" value="search" />
<TABLE>
<tr><td>Show:<input type="text" size="3" name="datum" value="" /> entry's back</tr></td>
<tr><td>
<input class=Butt type=submit value="Search History" name="search">
</td></tr>
</TABLE>
</form>
<?php
if ($_POST['action'] != "search")
{
$nums = db_number("SELECT * FROM power_donatelogs ORDER BY id DESC");
$id = ( $nums - 7 );
$gamedata = db_query("SELECT * FROM power_donatelogs WHERE (`id` > '".$id."' ) ORDER BY id DESC");
?>
<p> Last 7 entry's in log</p>
<table border='1'>
<tr>
<th>id</th>
<th>Account</th>
<th>Reward</th>
<th>Transaction</th>
<th>Date</th>
<th>Response</th>
<th>Debug</th>
<th>system</th>
</tr>
<?php
while ($gameinfo = mysql_fetch_array($gamedata))
{
echo ("<tr>");
echo ("<td><font color='red'>".$gameinfo[id]."</font></td>");
echo ("<td>".$gameinfo[account_id]."</td>");
echo ("<td>".$gameinfo[credits]."</td>");
echo ("<td>".$gameinfo[transid]."</td>");
echo ("<td>".$gameinfo[date]."</td>");
echo ("<td>".$gameinfo[response]."</td>");
echo ("<td>".$gameinfo[debug]."</td>");
echo ("<td>".$gameinfo[payment]."</td>");
echo "</tr>";
}
?>
</table>

<?php
}
if ($_POST['action'] == "search")
{
$back = $_POST['datum'];
$nums2 = db_number("SELECT * FROM power_donatelogs ORDER BY id DESC");
$id2 = ( $nums2 - $back );
$gamesearch = db_query("SELECT * FROM power_donatelogs WHERE (`id` > '".$id2."' ) ORDER BY id DESC");
?>
<p> Last <?php echo($back);?> entry's in log</p>
<table border='1'>
<tr>
<th>id</th>
<th>Account</th>
<th>Reward</th>
<th>Transaction</th>
<th>Date</th>
<th>Response</th>
<th>Debug</th>
<th>system</th>
</tr>
<?php
while ($gametime = mysql_fetch_array($gamesearch))
{
echo ("<tr>");
echo ("<td><font color='red'>".$gametime[id]."</font></td>");
echo ("<td>".$gametime[account_id]."</td>");
echo ("<td>".$gametime[credits]."</td>");
echo ("<td>".$gametime[transid]."</td>");
echo ("<td>".$gametime[date]."</td>");
echo ("<td>".$gametime[response]."</td>");
echo ("<td>".$gametime[debug]."</td>");
echo ("<td>".$gametime[payment]."</td>");
echo "</tr>";
}
?>
</table>
<?php
}
?>