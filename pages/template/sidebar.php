<div id="navlist">
<?php serverstatus();
?>
        <ul>
		<?php
		if ($_SESSION['loggedin'] != 1) // if user is NOT logged in -> show login form
{
    echo("<!--Begin Login -->");
    echo("<font color='red'>");
    echo($_SESSION['ERROR']); //show our sesion error above the login form
    $_SESSION['ERROR'] = ""; // reset the error message if there is one.
    echo("</font><br />");
	echo ("<script type=\"text/javascript\" src=\"./settings/md5.js\"></script>");
    echo("<form method=\"POST\" action=\"");
    echo($_SERVER['PHP_SELF']);
    echo("\">");
    echo("Username: <br /><input type=\"text\" name=\"username\" size=\"15\" /><br />");
    echo("Password: <br /><input type=\"password\" name=\"passwort\" size=\"15\" /><br />");
    echo("<input type=\"hidden\" name=\"action\" value=\"login\" />");
    echo("<p><input type=\"hidden\" name=\"hash\"><input class=Butt type=submit onClick=\"hash.value = login(passwort.value)\" value=\"Log in\" name=complete></p>");
    echo("</form>");
    echo("<!--End Login -->");
	echo("<br>");
?>
            <li><a href="?page=home" class="active">Home</a></li>
            <li><a href="?page=register">Register</a></li>
        </ul>
    </div>
<?php	
}
else // User is logged in
{
showtotalpoints();
//grab pages to set the button to active
$page = $_GET['page'];
$staff = $_GET['staff'];
$admin =  $_GET['admin'];
?>
            <li><a href="?page=home" <?php if($page==='home') echo "class=\"active\"";?>>Home</a></li>
			<?php
if ($_SESSION['admin'] == 1 )
{
?>
			<li>Admin Menu</li>
			<li><a href="./?admin=version" <?php if($admin==='version') echo "class=\"active\"";?>>Show Changelog</a></li>
			<li><a href="./?admin=logs" <?php if($admin==='logs') echo "class=\"active\"";?>>LogFiles</a></li>
			<li>&nbsp;</li>
			<li><a href="./?admin=settings" <?php if($admin==='settings') echo "class=\"active\"";?>>General Settings</a></li>
			<li><a href="./?admin=rewards" <?php if($admin==='rewards') echo "class=\"active\"";?>>Donation Settings</a></li>
			<li><a href="./?admin=account" <?php if($admin==='account') echo "class=\"active\"";?>>Search account</a></li>
			<li><a href="./?admin=character" <?php if($admin==='character') echo "class=\"active\"";?>>Search Character</a></li>
			<li><a href="./?admin=changepass" <?php if($admin==='changepass') echo "class=\"active\"";?>>Change passwords</a></li>
			<li><a href="./?admin=ban" <?php if($admin==='ban') echo "class=\"active\"";?>>Ban Account</a></li>
			<li><a href="./?admin=unban" <?php if($admin==='unban') echo "class=\"active\"";?>>Lift Ban Account</a></li>
<?php
}
if ($_SESSION['admin'] == 1 || $_SESSION['staff'] == 1 ) 
{
?>
			<li>Staff Menu</li>
			<li>&nbsp;</li>
			<li><a href="./?staff=jail" <?php if($staff==='jail') echo "class=\"active\"";?>>Jail Account</a></li>
			<li><a href="./?staff=unjail" <?php if($staff==='unjail') echo "class=\"active\"";?>>Unjail Account</a></li>
			<li><a href="./?staff=mute" <?php if($staff==='mute') echo "class=\"active\"";?>>Mute Account</a></li>
			<li><a href="./?staff=unmute" <?php if($staff==='unmute') echo "class=\"active\"";?>>Unmute Account</a></li>
			<li>&nbsp;</li>
			<li><a href="./?staff=stats" <?php if($staff==='stats') echo "class=\"active\"";?>>Server Stats</a></li>
			<li><a href="./?staff=online" <?php if($staff==='online') echo "class=\"active\"";?>>online players</a></li>
			<li><a href="./?staff=lastlogin" <?php if($staff==='lastlogin') echo "class=\"active\"";?>>Last Logins</a></li>
<?php
}
?>			
			<li>Donation Related</li>
			<li>&nbsp;</li>
			<li><a href="./?page=donate" <?php if($page==='donate') echo "class=\"active\"";?>>Donate for credits</a></li>
			<li><a href="./?page=buyep" <?php if($page==='buyep') echo "class=\"active\"";?>>Buy EP</a></li>
			<li><a href="./?page=buysummon" <?php if($page==='buysummon') echo "class=\"active\"";?>>Buy Summon</a></li>
			<li><a href="./?page=buytoken" <?php if($page==='buytoken') echo "class=\"active\"";?>>Buy Tokens</a></li>
			<li><a href="./?page=buyvip" <?php if($page==='buyvip') echo "class=\"active\"";?>>Buy Vip</a></li>
			<li><a href="./?page=resetpk" <?php if($page==='resetpk') echo "class=\"active\"";?>>Reset pk Points</a></li>
			<li>Account Related</li>
			<li>&nbsp;</li>
			<li><a href="./?page=characterstats" <?php if($page==='characterstats') echo "class=\"active\"";?>>Show account Stats</a></li>
			<li><a href="./?page=changepass" <?php if($page==='changepass') echo "class=\"active\"";?>>Change Password</a></li>
			<li>&nbsp;</li>
			<li><a href="./?page=signature" <?php if($page==='signature') echo "class=\"active\"";?>>Dynamic Signature</a></li>
			<li><a href="./?page=signature" <?php if($page==='signature') echo "class=\"active\"";?>>Download Client</a></li>
            <li><a href="./?action=logout">Logout</a></li>
        </ul>
    </div>	
<?php
}
?>	