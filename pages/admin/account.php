<?php
$id = mysql_real_escape_string($_POST['id']);
$name = mysql_real_escape_string($_POST['name']);
?>
<br>
<p>Search for Accounts</p>
<form method="post" action="./index.php?admin=account">
<input type="hidden" name="action" value="search" />
<TABLE>
<tr><td>Character Name: <input type="text" size="10" name="name" /></tr></td>
<tr><td>
<input class=Butt type=submit value="Search Characters" name="search">
</td></tr>
</TABLE>
</form>
<?php
if ($_POST['action'] == "search")
{
$characterfind = db_query("SELECT * FROM cq_user WHERE (`name` LIKE '%".$name."%') ORDER BY name DESC");
$total = mysql_num_rows($characterfind);
	if ($total != 0)
	{
	?>
	<p>Founded Characters</p>
<table border='1'>
<tr>
<th>ID</th>
<th>CHARACTER</th>
<th>Level</th>
<th>ALT</th>
</tr>
<?php
while ($characters = mysql_fetch_assoc($characterfind))
{
if ($characters[type] == 1)
{$type = "<font color='green'>Alt</font>";}
if ($characters[type] == 0)
{$type = "<font color='red'>Main</font>";}
echo ("<tr>");
echo ("<td><font color='red'>".$characters['account_id']."</font></td>");
echo ("<td>".$characters['name']."</td>");
echo ("<td>".$characters['level']."</td>");
echo ("<td>".$type."</td>");
echo "</tr>";
}
?>
</table>

<form method="post" action="./index.php?admin=account">
<input type="hidden" name="action" value="lookup"/>
Account ID:<input type="text" name="id"  value=""/>
<TABLE>
<tr><td>
<input class=Butt type=submit value="Lookup Character Account" name="lookup">
</td></tr>
</TABLE>
</form>
<?php
}
else {
echo ("Sorry , the Character ".$name." dit not exist");
}
}

if ($_POST['action'] == "lookup")
{
accdb();
$accountcheck = db_query("SELECT * FROM account WHERE (`id` LIKE '".$id."') ORDER BY name DESC");
$account = mysql_fetch_assoc($accountcheck);
$check = mysql_num_rows($accountcheck);
	if ($check != 0)
	{
	?>
	<p>Account Information</p>
<table border='1'>
<tr>
<th>ID</th>
<th>Account</th>
<th>Vip Level</th>
<th>Banned</th>
</tr>
<?php
if ($account['online'] == 0)
{$type = "<font color='green'>No</font>";}
if ($account['online'] != 0)
{$type = "<font color='red'>YES</font>";}
echo ("<tr>");
echo ("<td><font color='red'>".$account['id']."</font></td>");
echo ("<td>".$account['name']."</td>");
echo ("<td>".$account['VIP']."</td>");
echo ("<td>".$type."</td>");
echo "</tr>";
?>
</table>
<?php
}
else
{
echo ("<b>please input a valid id instead ".$id."</b>");
}
}
?>