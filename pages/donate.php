<?php
if ($_SESSION['loggedin'] == 1)
{
$gamedata2 = db_query("SELECT * FROM power_donate WHERE (`payment` LIKE 'paypal' ) ORDER BY credits DESC");
$gamedata3 = db_query("SELECT * FROM power_donate WHERE (`payment` LIKE 'paypal' ) ORDER BY credits DESC");

//start paypal donation
donate(paypalstart);
?>
<input type="hidden" name="on0" value="Credits">
Credits :
<select name="os0">
<?php
while ($amount = mysql_fetch_assoc($gamedata2))
{ 
echo "<option value ='".$amount[credits]."'>".$amount[credits]." credits for ".$amount[price]." &euro; </option>";
}
?>
</select>
<?php
$c ="0";
while ($amount2 = mysql_fetch_assoc($gamedata3))
{ 
echo "<input type=\"hidden\" name=\"option_select".$c."\" value=\"".$amount2[credits]."\">";
echo "<input type=\"hidden\" name=\"option_amount".$c."\" value=\"".$amount2[price]."\">";
$c++;
}
donate(paypalend);
//end paypal donation
?>
<br>
<p>or you can use fortumo</p>
<br>
<?php
//start fortumo donation
donate(fortumo);
}
else
{
echo "please login before using this function";
}
?>