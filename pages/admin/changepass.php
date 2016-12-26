<?php
$newpass = $_POST['newpass'];
$id = $_POST['id'];
$email = $_POST['email'];
$hash = $_POST['hash'];
accdb();
if ($_POST['action'] == "reset")
{
if ($id !="")
{
$passreset = db_query("SELECT * FROM account WHERE id LIKE ".$id."");
$account = mysql_fetch_assoc($passreset);
$num = mysql_num_rows($passreset);
	if ($num != 0)
	{
	db_query("UPDATE account SET password='".$hash."' WHERE id='".$id."'");
    echo ("account <font color='red'> ".$account['name']." </font> password is resetted to <font color='green'>".$newpass."</font>");
	}
else
{
echo ("Unable to find AccountID : ".$id."");
}
}
else
{
echo ("emty ID's are not fun");
}
}
?>

<p>Search for Accounts</p>
<form method="post" action="./index.php?admin=changepass">
<input type="hidden" name="action" value="search" />
<TABLE>
<tr><td>Email: <input type="text" size="10" name="email" /></tr></td>
<tr><td>
<input class=Butt type=submit value="Search For Accounts" name="search">
</td></tr>
</TABLE>
</form>
<?php
if ($_POST['action'] == "search")
{
$characterfind = db_query("SELECT * FROM account WHERE (`email` LIKE '%".$email."%') ORDER BY email DESC");
$total = mysql_num_rows($characterfind);
	if ($total != 0)
	{
	?>
	<p>Founded Accounts for "<?php echo ($email);?>"</p>
<table border='1'>
<tr>
<th>ID</th>
<th>Account</th>
<th>email</th>
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
echo ("<td>".$characters['email']."</td>");
echo ("<td>".$characters['VIP']."</td>");
echo ("<td>".$type."</td>");
echo "</tr>";
}
?>
</table>

</p>Reset Account Password</p>
<form method="post" action="./index.php?admin=changepass">
<input type="hidden" name="action" value="reset" />
<script type="text/javascript" src="./settings/md5.js"></script>
<TABLE>
<tr><td>Account ID: <input type="text" size="10" name="id" /></tr></td>
<tr><td align="center">New Password:<input type="password" size="20" name="newpass"/></td></tr>
<tr><td>
<input type="hidden" name="hash"><input class=Butt type=submit onClick="hash.value = login(newpass.value)" value="reset Password"  name="reset">
</td></tr>
</TABLE>
</form>
<?php
}
else
{
echo ("no emails That contain \"".$email."\" are found");
}
}
?>