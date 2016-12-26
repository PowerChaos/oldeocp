<?php
$id = mysql_real_escape_string($_POST['id']);
$name = mysql_real_escape_string($_POST['name']);
?>
<br>
<p>Search for Characters</p>
<form method="post" action="./index.php?admin=character">
<input type="hidden" name="action" value="search" />
<TABLE>
<tr><td>Account Name: <input type="text" size="10" name="name" /></tr></td>
<tr><td>
<input class=Butt type=submit value="Search Accounts" name="search">
</td></tr>
</TABLE>
</form>
<?php
if ($_POST['action'] == "search")
{
accdb();
$characterfind = db_query("SELECT * FROM account WHERE (`name` LIKE '%".$name."%') ORDER BY name DESC");
$total = mysql_num_rows($characterfind);
	if ($total != 0)
	{
	?>
	<p>Founded Accounts</p>
<table border='1'>
<tr>
<th>ID</th>
<th>Account</th>
<th>Vip Level</th>
<th>Banned</th>
</tr>
<?php
while ($characters = mysql_fetch_assoc($characterfind))
{
if ($characters[online] == 0)
{$type = "<font color='green'>NO</font>";}
if ($characters[online] != 0)
{$type = "<font color='red'>YES</font>";}
echo ("<tr>");
echo ("<td><font color='red'>".$characters['id']."</font></td>");
echo ("<td>".$characters['name']."</td>");
echo ("<td>".$characters['VIP']."</td>");
echo ("<td>".$type."</td>");
echo "</tr>";
}
?>
</table>

<form method="post" action="./index.php?admin=character">
<input type="hidden" name="action" value="lookup"/>
Account ID:<input type="text" name="id"  value=""/>
<TABLE>
<tr><td>
<input class=Butt type=submit value="Lookup Account" name="lookup">
</td></tr>
</TABLE>
</form>
<?php
}
else {
echo ("Sorry , the Account ".$name." dit not exist");
}
}

if ($_POST['action'] == "lookup")
{
gamedb();
$accountcheck = db_query("SELECT * FROM cq_user WHERE (`account_id` LIKE '".$id."') ORDER BY name DESC");

$check = mysql_num_rows($accountcheck);
	if ($check != 0)
	{
	?>
	<p>Character Information</p>
<table border='1'>
<tr>
<th>ID</th>
<th>CHARACTER</th>
<th>Level</th>
<th>ALT</th>
</tr>
<?php
while ($account = mysql_fetch_assoc($accountcheck))
{
if ($account[type] != 0)
{$type = "<font color='green'>ALT</font>";}
if ($account[type] == 0)
{$type = "<font color='red'>MAIN</font>";}
echo ("<tr>");
echo ("<td><font color='red'>".$account['id']."</font></td>");
echo ("<td>".$account['name']."</td>");
echo ("<td>".$account['level']."</td>");
echo ("<td>".$type."</td>");
echo "</tr>";
}
?>
</table>
<?php
}
else
{
echo ("<b>No Characters found for id ".$id."</b>");
}
}
?>