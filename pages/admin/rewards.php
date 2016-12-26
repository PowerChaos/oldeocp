<?php
executerewards();
$data = db_query("SELECT * FROM power_donate WHERE (`payment` LIKE 'ep' )");
$data1 = db_query("SELECT * FROM power_donate WHERE (`payment` LIKE 'summon' )");
$data2 = db_query("SELECT * FROM power_donate WHERE (`payment` LIKE 'token' )");
$data3 = db_query("SELECT * FROM power_donate WHERE (`payment` LIKE 'vip' )");
$data4 = db_query("SELECT * FROM power_donate WHERE (`payment` LIKE 'paypal' )");
$data5 = db_query("SELECT * FROM power_donate WHERE (`payment` LIKE 'pk' )");
?>
<center>
<p>Current EP List</p>
<table border='1'>
<tr>
<th>id</th>
<th>Reward</th>
<th>Cost</th>
</tr>
<?php
while ($info = mysql_fetch_array($data))
{
echo ("<tr>");
echo ("<td><font color='red'>".$info[id]."</font></td>");
echo ("<td>".$info[credits]."</td>");
echo ("<td>".$info[price]."</td>");
echo "</tr>";
}
?>
</table>
<form method="post" action="./?admin=rewards">
<TABLE align="center">
<tr><td align="center">Add EP Rewards</tr></td>
<tr><td align="center">Reward <input type="text" name="epreward" id="epreward" value=""> ep for <input type="text" name="epprice" id="epprice" value=""> Credits</tr></td>
<tr><td align="center">
<input class="Butt" type="submit" value="Add Ep Reward" name="addep">
</td></tr>
</TABLE>
</form>
</center>
<br>
<center>
<p>Current Summon List</p>
<table border='1'>
<tr>
<th>id</th>
<th>Reward</th>
<th>Cost</th>
</tr>
<?php
while ($info1 = mysql_fetch_array($data1))
{
echo ("<tr>");
echo ("<td><font color='red'>".$info1[id]."</font></td>");
echo ("<td>".$info1[credits]."</td>");
echo ("<td>".$info1[price]."</td>");
echo "</tr>";
}
?>
</table>
<form method="post" action="./?admin=rewards">
<TABLE align="center">
<tr><td align="center">Add Summon Rewards</tr></td>
<tr><td align="center">Reward <input type="text" name="summonreward" id="summonreward" value=""> Summon for <input type="text" name="summonprice" id="summonprice" value=""> Credits</tr></td>
<tr><td align="center">
<input class="Butt" type="submit" value="Add Summon Reward" name="addsummon">
</td></tr>
</TABLE>
</form>
</center>
<br>
<center>
<p>Current Token List</p>
<table border='1'>
<tr>
<th>id</th>
<th>Reward</th>
<th>Cost</th>
</tr>
<?php
while ($info2 = mysql_fetch_array($data2))
{
echo ("<tr>");
echo ("<td><font color='red'>".$info2[id]."</font></td>");
echo ("<td>".$info2[credits]."</td>");
echo ("<td>".$info2[price]."</td>");
echo "</tr>";
}
?>
</table>
<form method="post" action="./?admin=rewards">
<TABLE align="center">
<tr><td align="center">Add Token Rewards</tr></td>
<tr><td align="center">Reward <input type="text" name="tokenreward" id="tokenreward" value=""> Tokens for <input type="text" name="tokenprice" id="tokenprice" value=""> Credits</tr></td>
<tr><td align="center">
<input class="Butt" type="submit" value="Add Token Reward" name="addtoken">
</td></tr>
</TABLE>
</form>
</center>
<br>
<center>
<p>Current Vip List</p>
<table border='1'>
<tr>
<th>id</th>
<th>Reward</th>
<th>Cost</th>
</tr>
<?php
while ($info3 = mysql_fetch_array($data3))
{
echo ("<tr>");
echo ("<td><font color='red'>".$info3[id]."</font></td>");
echo ("<td>".$info3[credits]."</td>");
echo ("<td>".$info3[price]."</td>");
echo "</tr>";
}
?>
</table>
<form method="post" action="./?admin=rewards">
<TABLE align="center">
<tr><td align="center">Add VIP Rewards</tr></td>
<tr><td align="center">Reward Vip level <input type="text" name="vipreward" id="vipreward" value="">  for <input type="text" name="vipprice" id="vipprice" value=""> Credits</tr></td>
<tr><td align="center">
<input class="Butt" type="submit" value="Add Vip Reward" name="addvip">
</td></tr>
</TABLE>
</form>
</center>
<br>
<center>
<p>Current Credit List</p>
<table border='1'>
<tr>
<th>id</th>
<th>Reward</th>
<th>Cost</th>
</tr>
<?php
while ($info4 = mysql_fetch_array($data4))
{
echo ("<tr>");
echo ("<td><font color='red'>".$info4[id]."</font></td>");
echo ("<td>".$info4[credits]."</td>");
echo ("<td>".$info4[price]."</td>");
echo "</tr>";
}
?>
</table>
<form method="post" action="./?admin=rewards">
<TABLE align="center">
<tr><td align="center">Add Credits Rewards</tr></td>
<tr><td align="center">Reward <input type="text" name="creditreward" id="creditreward" value=""> Credits for <input type="text" name="creditprice" id="creditprice" value=""> Money (paypal)</tr></td>
<tr><td align="center">
<input class="Butt" type="submit" value="Add Credit Reward" name="addcredit">
</td></tr>
</TABLE>
</form>
</center>
<br>
<center>
<p>Current PK Remove List</p>
<table border='1'>
<tr>
<th>id</th>
<th>Reward</th>
<th>Cost</th>
</tr>
<?php
while ($info5 = mysql_fetch_array($data5))
{
echo ("<tr>");
echo ("<td><font color='red'>".$info5[id]."</font></td>");
echo ("<td>".$info5[credits]."</td>");
echo ("<td>".$info5[price]."</td>");
echo "</tr>";
}
?>
</table>
<form method="post" action="./?admin=rewards">
<TABLE align="center">
<tr><td align="center">Add PK  Remove Rewards</tr></td>
<tr><td align="center">remove <input type="text" name="pkreward" id="pkreward" value=""> pk points for <input type="text" name="pkprice" id="pkprice" value=""> Credits</tr></td>
<tr><td align="center">
<input class="Butt" type="submit" value="Add Pk Remove Reward" name="addpk">
</td></tr>
</TABLE>
</form>
</center>
<br>
<center>
<form method="post" action="./?admin=rewards">
<TABLE align="center">
<tr><td align="center">Remove Rewards</tr></td>
<tr><td align="center">Remove Reward ID <input type="text" name="removeid" id="removeid" value=""> From reward List</tr></td>
<tr><td align="center">
<input class="Butt" type="submit" value="Remove This Reward" name="removereward">
</td></tr>
</TABLE>
</form>
</center>