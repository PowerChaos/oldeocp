<?php
$id = $_POST['id'];
$characterdata = db_query("SELECT * FROM cq_user WHERE cheat_time NOT LIKE '0' ORDER BY 'id' DESC");
$total = db_number("SELECT * FROM cq_user WHERE cheat_time NOT LIKE '0' ORDER BY 'id' DESC");
if ($_POST['action'] == "unjail")
{
$accountunjail = db_query("SELECT * FROM cq_user WHERE id LIKE ".$id." AND cheat_time NOT LIKE '0' ORDER BY 'id' ASC");
$unjail = mysql_fetch_assoc($accountunjail);
$num = mysql_num_rows($accountunjail);
	if ($num != 0)
	{
	mysql_query("UPDATE cq_user SET cheat_time='0' WHERE id='".$id."'");
    echo ("CharacterID ".$id." (character: ".$unjail['name']." ) successfully unjailed <meta http-equiv='refresh' content='2'>");
} 
else {
echo ("Unable to unjail CharacterID ".$id." <br> CharacterID ".$id." is not Jailed in first place");
}
}
?>
<p> <?php echo "$total";?> Jailed Characters</p>
<table border='1'>
<tr>
<th>ID</th>
<th>Character</th>
</tr>
<?php
while ($account = mysql_fetch_assoc($characterdata))
{
echo ("<tr>");
echo ("<td><font color='red'>".$account['id']."</font></td>");
echo ("<td>".$account['name']."</td>");
echo "</tr>";
}
?>
</table>
<br>
<form method="post" action="./index.php?staff=unjail">
<input type="hidden" name="action" value="unjail" />
<TABLE>
<tr><td>Character ID: <input type="text" size="10" name="id" /></tr></td>
<tr><td>
<input class=Butt type=submit value="Unjail Character" name="unjail">
</td></tr>
</TABLE>
</form>
<?php
?>