<?php
accdb();
$unban = $_POST['unban'];
$id = $_POST['id'];
$accountdata = db_query("SELECT * FROM account WHERE online = '1' ORDER BY 'id' ASC");
$total = db_number("SELECT * FROM account WHERE online = '1' ORDER BY 'id' ASC");
if ($_POST['action'] == "unban")
{
$accountunban = db_query("SELECT type FROM account WHERE id LIKE ".$id." AND `online` = '1' ORDER BY 'id' ASC");
$unban = mysql_fetch_assoc($accountunban);
$num = mysql_num_rows($accountunban);
	if ($num != 0)
	{
	db_query("UPDATE account SET online='0' WHERE id='".$id."'");
    echo ("accountID ".$id." sucesfully unbanned <meta http-equiv='refresh' content='2'>");
}
else {
echo ("Unable to unban accountID ".$id." <br> accountID ".$id." is not banned in first place");
}
}
?>
<p><?php echo "$total"; ?> Banned Accounts</p>
<table border='1'>
<tr>
<th>ID</th>
<th>ACCOUNT</th>
</tr>
<?php
while ($account = mysql_fetch_assoc($accountdata))
{
echo ("<tr>");
echo ("<td><font color='red'>".$account['id']."</font></td>");
echo ("<td>".$account['name']."</td>");
echo "</tr>";
}
?>
</table>
<br>
<form method="post" action="./index.php?admin=unban">
<input type="hidden" name="action" value="unban" />
<TABLE>
<tr><td>Account ID: <input type="text" size="10" name="id" /></tr></td>
<tr><td>
<input class=Butt type=submit value="Unban Account" name="unban">
</td></tr>
</TABLE>
</form>