<!-- This is our dynamic homepage , follow the comments to know how to make dynamic -->

		<?php
		if ($_SESSION['loggedin'] != 1) // if user is NOT logged in -> show login form
{
?>
    <div id="content">
        <h3>Welcome</h3>
            <p>Welcome to our fun server<br>
This server is a low rate server and contains some unic stuf<br>
As you can see , 1 of the unic stuff is this control panel<br>
For the rest we got a nice database and definaly worth to check us out<br>
enjoy Your Playtime <br>
Greetings From PowerChaos Company
<br><br>
The last 30 Shouts<br>
Last Shout was at 
<?php
$shoutpersonal = db_query("SELECT * FROM cq_ad_log ORDER BY publish_time DESC LIMIT 30");
$lastshouting = mysql_fetch_array($shoutpersonal);
echo ("".date("d/m/Y @ H:i:s",$lastshouting[publish_time])."");
?>
<table border=1>
<tr> 
<th>#</th>
<th>Message</th>
</tr>
<?php
$a=1;
echo ("<tr>");
echo ("<td>".$a."-</td>");
echo ("<td>".$lastshouting['words']."</td>");
echo ("</tr>");
while($shouting = mysql_fetch_array($shoutpersonal))
{
$a=$a+1;
echo ("<tr>");
echo ("<td>".$a."-</td>");
echo ("<td>".$shouting['words']."</td>");
echo ("</tr>");
}
?></table>	
</p>			
				</div>
    <div class="br"></div>
<?php
}
else // User is logged in
{
?>
    <div id="content">
        <h3>Welcome</h3>
            <p>
<br>
The last 5 Shouts<br>
Last Shout was at 
<?php
$shoutpersonal = db_query("SELECT * FROM cq_ad_log ORDER BY publish_time DESC LIMIT 5");
$lastshouting = mysql_fetch_array($shoutpersonal);
echo ("".date("d/m/Y @ H:i:s",$lastshouting[publish_time])."");
?>
<table border=1>
<tr> 
<th>#</th>
<th>Message</th>
</tr>
<?php
$a=1;
echo ("<tr>");
echo ("<td>".$a."-</td>");
echo ("<td>".$lastshouting['words']."</td>");
echo ("</tr>");
while($shouting = mysql_fetch_array($shoutpersonal))
{
$a=$a+1;
echo ("<tr>");
echo ("<td>".$a."-</td>");
echo ("<td>".$shouting['words']."</td>");
echo ("</tr>");
}
?></table>			
</p>			
				</div>
    <div class="br"></div>
	<?php
	
}
?>