<?php
$id = mysql_real_escape_string($_POST['id']);
$name = mysql_real_escape_string($_POST['name']);
if ($_POST['action'] == "ban")
{
accdb();
$accountcheck = db_query("SELECT * FROM account WHERE (`id` LIKE '".$id."') AND `online` = '0' ORDER BY name DESC");
$check = mysql_num_rows($accountcheck);
	if ($check != 0)
	{
mysql_query("UPDATE account SET online='1' WHERE id='".$id."'");
echo ("accountID ".$id." sucesfully banned <meta http-equiv='refresh' content='2'>");
}
else
{
echo ("<b>".$id."</b> is already banned ?? or dit you make a typo ?");
}
}
?>
<br>
<p>Search for characters</p>
<form method="post" action="./index.php?admin=ban">
<input type="hidden" name="action" value="search" />
<TABLE>
<tr><td>Character Name <input type="text" size="10" name="name" /></tr></td>
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
echo ("<td>".$type."</td>");
echo "</tr>";
}
?>
</table>

<form method="post" action="./index.php?admin=ban">
<input type="hidden" name="action" value="ban"/>
Account ID:<input type="text" name="id"  value=""/>
<TABLE>
<tr><td>
<input class=Butt type=submit value="Ban Account" name="ban">
</td></tr>
</TABLE>
</form>
<?php
}
else {
echo ("Sorry , the Character ".$name." dit not exist");
}
}
?>