<?php
$start_time = microtime(true);
//config file check
if(file_exists("./settings/config.php")){
$config = file_get_contents("./settings/config.php");
if(!strpos($config, "\$install =\"1\"")) 
{
die ("<center><H1><font color=\"red\">No install Detected , <a href=\"./settings/install.php\"> Click here</a> to run the installer</font></H1></center>");
}
include("./settings/config.php");
}
else{
die ("<center><H1><font color=\"red\">No install Detected ,<a href=\"./settings/install.php\"> Click here</a> to run the installer</font></H1></center>");
}

if(!isset($_SESSION)) {
     session_start();
}

function sesions()
{
if(!isset($_SESSION)) {
     session_start();
}
//START SESION TIMEOUT
// check to see if $_SESSION['timeout'] is set
if(isset($_SESSION['expire']) ) {
	$session_life = time() - $_SESSION['expire'];
	$inactive = 600;
	if($session_life > $inactive)
        {
		session_destroy(); header("Location:./index.php?sesion=expired"); }
}
// SESION TIMEOUT

if ($_GET['action'] == "logout")
{
    $_SESSION = array();
    session_destroy();
    $_SESSION['ERROR'] = "You have successfully logged out. <BR />";
}

if ($_GET['sesion'] == "expired" )
{
//change below text to your own sesion expire error
$_SESSION['ERROR'] = "Sesion Expired <br> Please Relog";
}

//LOGIN CONFIG
if ($_SESSION['loggedin'] != 1 and $_POST['action'] == "login")
{
       // convert username and password from _GET to _SESSION
    if($_POST){
      $_SESSION['username']= $_POST["username"];
      $_SESSION['passwort']= mysql_real_escape_string($_POST['hash']); 	  
    } 
    
    $username = $_SESSION['username'];
    $passwort = $_SESSION['passwort'];
    
    $username = addslashes($username);
    $passwort = addslashes($passwort);
    
	accdb();
    $result = db_query("SELECT * FROM account WHERE name = '$username' AND password = '".$passwort."'");
gamedb();
    if (!$_SESSION['loggedin'])
    {
        if (( $num = mysql_num_rows($result) ) and ($passwort != ""))
        {
            if ($num != 0)
            {
                $_SESSION['ERROR'] = "";
                $_SESSION['loggedin'] = 1;
                
                // lets get their Account ID.
				accdb();
                $result = db_array("SELECT * FROM account WHERE name='$username' LIMIT 1");
				$email = $result['email'];
                $_SESSION['id'] = $result['id'];
				$_SESSION['ban'] = $result['online'];
				gamedb();
				$check = db_number("SELECT * FROM power_user WHERE (`account_id` LIKE '".$_SESSION['id']."') LIMIT 1");
				if ($check == 0)
				{
				db_query("insert into power_user (username,email,account_id,money) values ('".$username."','".$email."','".$_SESSION['id']."','0')");
				}
				$PM = db_number("SELECT name FROM cq_user WHERE (`account_id` LIKE '".$_SESSION['id']."' AND name LIKE '%[PM]%') LIMIT 1");
				if ($PM !="1")
				{
				$GM = db_number("SELECT name FROM cq_user WHERE (`account_id` LIKE '".$_SESSION['id']."' AND name LIKE '%[GM]%') LIMIT 1");
				if ($GM != "0")
				{
				$_SESSION['staff'] = "1";
				}
			}	
				if ($PM != "0")
            {
				$_SESSION['admin'] = "1";
            }
}			
        else 
        {
            $_SESSION['ERROR'] = "login is WRONG!!";
		}
 }
} 
    if ($_SESSION['loggedin'] != 1) $_SESSION['ERROR'] = "Login Failed."; 
}
if ($_SESSION['loggedin'] == 1)
{
$_SESSION['expire'] = time();	
}
}

//curl check
function curl_installed() {
	if  (in_array  ('curl', get_loaded_extensions())) {
		return true;
	}
	else {
		return false;
	}
}
if (!curl_installed()) {
 die ("cURL is <span style=\"color:red\">NOT installed</span> on this server , Please install cURL to continue");
}
//version check for homepage
if ($_SESSION['admin'] == "1")
{
function version($version="2.1")
{
   $versioncheck = curl_init();
    curl_setopt ($versioncheck, CURLOPT_URL, "http://powerchaos.info/version.php?version");
	curl_setopt($versioncheck, CURLOPT_RETURNTRANSFER, 1);
    $latest = curl_exec ($versioncheck);
    curl_close ($versioncheck);
if ($version < $latest )
{
	?>
<center><br> New Version ( <?php echo $latest;?> ) avaible at <a href="http://powerchaos.info">PowerChaos.info</a><br>
current Running version is ( <?php echo $version; ?> )<br></center>
<?php
}
}
}
else{
function version()
{
}
}
//version check and changelog
function changelog($version="2.1")
{
   $versioncheck = curl_init();
    curl_setopt ($versioncheck, CURLOPT_URL, "http://powerchaos.info/version.php?version");
	curl_setopt($versioncheck, CURLOPT_RETURNTRANSFER, 1);
    $latest = curl_exec ($versioncheck);
    curl_close ($versioncheck);
if ($version < $latest )
{
?>
<center><p> New Version ( <?php echo $latest;?> ) avaible at <a href="http://powerchaos.info">PowerChaos.info</a><br>
current Running version is ( <?php echo $version; ?> )<br>
<?php }
else
{
?>
<center><p> You are running the latest version ( <?php echo $version; ?> )<br>
<?php } ?>
<h1>Changelog</h1>
<?php
   $changecheck = curl_init();
    curl_setopt ($changecheck, CURLOPT_URL, "http://powerchaos.info/version.php?changelog");
	curl_setopt($changecheck, CURLOPT_RETURNTRANSFER, 1);
    $changelog = curl_exec ($changecheck);
    curl_close ($changecheck);
echo $changelog;
echo "</p></center>";
}

/*
//serial system check
$curl = curl_init();
curl_setopt ($curl, CURLOPT_URL, "http://powerchaos.info/serial.php?host=".$_SERVER['HTTP_HOST']."&serial=".$serial."");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 2);
$output = curl_exec ($curl);
curl_close ($curl);
$extract = explode("-",$output);
$valid = $extract[0];
$expiredate = $extract[1];
$domain = $extract[2];
$host = $extract[3];
//write serial file
if($valid == "1" || $valid == "2")
{
$writeserial = './settings/serial.php'; 
$serialdata = fopen($writeserial, 'w') or die ("unable to write serial.php , please cmod it to 777");
$time = time();
$Data = "$output";
fwrite($serialdata, $Data); 
fclose($serialdata);
}
//our serial file check in case http is not working
if($valid == "" && $output == "0")
{
 $serialfile = "./settings/serial.php";
$serialcheck = '7200'; //caching time, in seconds
$filemtime = @filemtime($serialfile);  // returns FALSE if file does not exist
$time = time() - $filemtime;
if ($time < $serialcheck){
$checkfile = file_get_contents("$serialfile");
$extract = explode("-",$checkfile);
$valid = $extract[0];
$expiredate = $extract[1];
$domain = $extract[2];
$host = $extract[3];
}
else{
die ("Temporary Serial is expired <br> please make sure that <a href=\"http://powerchaos.info\">PowerChaos.info homepage</a> is avaible from your server to get a serial update");
}
}
//show error for wrong domain
if($valid == "3")
{
die ("Domain name do not match<br>current domain used is <font color=\"red\"> $host </font> but serial is valid for the following domain only<br><font color=\"green\">$domain</font><br>Please update the domain at <a href=\"http://powerchaos.info\">PowerChaos.info homepage</a>");
}
*/
$valid=2;

//mysql connection

if (!$con = mysql_connect("$mysqlhost", "$mysqluser", "$mysqlpass")) {
die('<h1 style="color: red;">MySQL Error:</h1>Please copy and paste between the lines and email to webmaster@powerchaos.com<br><br>------------------------------------------------------------------------------------<h3>Query:</h3><pre>' . htmlentities($query) . '</pre><h3>MySQL Error:</h3>' . mysql_error() . '<br><br>------------------------------------------------------------------------------------');
}

if (!mysql_select_db("$mysqldata")) {
die('<h1 style="color: red;">MySQL Error:</h1>Please copy and paste between the lines and email to webmaster@powerchaos.com<br><br>------------------------------------------------------------------------------------<h3>Query:</h3><pre>' . htmlentities($query) . '</pre><h3>MySQL Error:</h3>' . mysql_error() . '<br><br>------------------------------------------------------------------------------------');
}

//db select
function gamedb()
{
include("./settings/config.php");
if (!mysql_select_db("$mysqldata")) {
die('<h1 style="color: red;">MySQL Error:</h1>Please copy and paste between the lines and email to webmaster@powerchaos.com<br><br>------------------------------------------------------------------------------------<h3>Query:</h3><pre>' . htmlentities($query) . '</pre><h3>MySQL Error:</h3>' . mysql_error() . '<br><br>------------------------------------------------------------------------------------');
}
}
function accdb()
{
include("./settings/config.php");
if (!mysql_select_db("$accountdb")) {
die('<h1 style="color: red;">MySQL Error:</h1>Please copy and paste between the lines and email to webmaster@powerchaos.com<br><br>------------------------------------------------------------------------------------<h3>Query:</h3><pre>' . htmlentities($query) . '</pre><h3>MySQL Error:</h3>' . mysql_error() . '<br><br>------------------------------------------------------------------------------------');
}
}
//footer copyright check
if($valid != "2")
{
$footer = file_get_contents("./pages/template/footer.php");
if(!strpos($footer, "<a href=\"http://powerchaos.info\">Powered by PowerChaos Control Panel</a>")) 
{
die ("<center><H1><font color=\"red\">Copyright Remove is NOT allowed<br>Put back the following text in /pages/template/footer.php<br><form><textarea cols=\"120\" rows=\"8\">
<a href=\"http://powerchaos.info\">Powered by PowerChaos Control Panel</a></textarea></form><br>To get the script back working</font></H1></center>");
}
//index copyright check
$index = file_get_contents("./index.php");
if(!strpos($index, "/*Forced Footer*/ template(\"footer\"); /*forced footer*/")) 
{
die ("<center><H1><font color=\"red\">Copyright Remove is NOT allowed <br> Following Text is missing in index.php<br><form><textarea cols=\"120\" rows=\"8\">/*Forced Footer*/ template(\"footer\"); /*forced footer*/</textarea></form><br>Put it back to remove this message</font></H1></center>");
}
}

//show admin pages + staff pages +  normal pages 
if ($_SESSION['admin'] == "1")
{
function showpage()
{
$file = "./pages/".$_GET['page'].".php";
$admin = "./pages/admin/".$_GET['admin'].".php";
$staff = "./pages/staff/".$_GET['staff'].".php";
if (file_exists($file))
{
include ("$file");
}
else if (file_exists($admin)) 
{
include ("$admin");
}
else if (file_exists($staff)) 
{
include ("$staff");
}
else
{
include ("./pages/home.php");
}
}
}
// show only staff + normal pages
else if ($_SESSION['staff'] == "1")
{
function showpage()
{
$file = "./pages/".$_GET['page'].".php";
$staff = "./pages/staff/".$_GET['staff'].".php";
if (file_exists($file))
{
include ("$file");
}
else if (file_exists($staff)) 
{
include ("$staff");
}
else
{
include ("./pages/home.php");
}
}
}
else if ($_SESSION['ban'] > "0")
{
// show a banned text and prevent other pages from opening
function showpage()
{
echo ("we are sorry , but your account is banned");
}
}
else
{
// show normal pages only
function showpage()
{
$file = "./pages/".$_GET['page'].".php";
if (file_exists($file))
{
include ("$file");
}
else
{
include ("./pages/home.php");
}
}
}

//our settings hotlink
function settings($file)
{
include ("./settings/$file.php");
}

//our main template hotlink
function template($file)
{
include ("./pages/template/$file.php");
}
 
//our admin template hotlink
function admin($file)
{
include ("./pages/admin/$file.php");
}

//our donation template
if ($valid =="1" || $valid =="2")
{
function donate($payment)
{
//show start page for paypal
if ($payment == "paypalstart"){	
$settings = db_array("SELECT * FROM power_settings");
$file = dirname($_SERVER['PHP_SELF']);
if ($file != "/")
{
$file = dirname($_SERVER['PHP_SELF'])."/";
}
if ($settings['paypalemail'] !="")
{
?>
<p>Donate for Points</p>
<div id = "f1">
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="payPalForm1">
<input type="hidden" name="desc" value="Donation Reward for Account <?php echo $_SESSION['username']; ?>">
<input type="hidden" name="item_number" value="<?php echo $_SESSION['id'] ?>">
<input name="item_name" type="hidden" id="item_name" value="Donation reward for Account <?php echo $_SESSION['username']; ?> ">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="no_note" value="1">
<input type="hidden" name="business" value="<?echo $settings['paypalemail']; ?>">
<input type="hidden" name="currency_code" value="<?echo $settings['paypalcurrency']; ?>">
<input type="hidden" name="return" value="<?php echo "http://".$_SERVER['HTTP_HOST'].$file."index.php?complete=1";?>">
<input type="hidden" name="cancel_return" value="<?php echo "http://".$_SERVER['HTTP_HOST'].$file."index.php?page=donate";?>">
<input type="hidden" name="notify_url" value="<?php echo "http://".$_SERVER['HTTP_HOST'].$file."settings/callback/paypal.php";?>">
<table>
<?php
}
}
//show end page for paypal
else if ($payment == "paypalend"){
$settings = db_array("SELECT * FROM power_settings");
if ($settings['paypalemail'] !="")
{	
?>
</table>
<br>
<input type="submit"  name="Submit" value="Donation for Account <?php echo $_SESSION['username']?> ">
</form>
</div>
<?
}
}
//show fortumo payment
else if ($payment == "fortumo"){
$settings = db_array("SELECT * FROM power_settings");
if ($settings['fortumorel'] !="")
{
?>	
	<script src="https://fortumo.com/javascripts/fortumopay.js" type="text/javascript"></script>
	<a id="fmp-button" href="#" rel="<?php echo $settings['fortumorel']."/".$_SESSION['id']?>">
	<img src="https://fortumo.com/images/fmp/fortumopay_96x47.png" width="96" height="47" alt="Mobile Payments by Fortumo" border="0" />
	</a>
<?
}
	}
else
{
echo " invalid payment selected";	
}
}
}
//no valid serial	
else{
function donate($payment)
{
echo " sorry , Serial is not valid to perform any donations";	
}
}

//execute the database command
function db_query($query){
    $output = mysql_query($query) or die('<h1 style="color: red;">MySQL Error:</h1>Please copy and paste between the lines and email to webmaster@powerchaos.com<br><br>------------------------------------------------------------------------------------<h3>Query:</h3><pre>' . htmlentities($query) . '</pre><h3>MySQL Error:</h3>' . mysql_error() . '<br><br>------------------------------------------------------------------------------------');
    return $output;
}

//execute a array
function db_array($file)
{
$result = db_query($file);
$output = mysql_fetch_array($result);
return $output;
}

//execute assoc
function db_assoc($file)
{
$result = db_query($file);
$output = mysql_fetch_assoc($result);
return $output;
}

//output numbers
function db_number($file)
{
$result = db_query($file);
$output = mysql_num_rows($result);
return $output;
}

if ($valid =="1" || $valid =="2")
{
function statusimage($ip,$server)
{
/* display the data */
// Dont forget the encodiung and html version, keywords yadieyadie


/* this query will get a random testimonial result */
$churl = @fsockopen($ip, 5816, $errno, $errstr, 1);
             if (!$churl){
			 //server offline
			$date = time();
            	$File = "./settings/online.txt"; 
				$Handle = fopen($File, 'w');
				$Data = " $server Server Status \n\n";
				fwrite($Handle, $Data);
				$Data = "Server under Maintenance"; 
				fwrite($Handle, $Data);
				global $start_time;
				$Data = "\n\nSignature created in ".round((microtime(true) - $start_time),3)." seconds. \n"; 
				fwrite($Handle, $Data);				
				fclose($Handle);             
				db_query("UPDATE cq_user SET last_logout='".$date."' WHERE cq_user.last_logout < cq_user.login_time");
                }
             else {
			 //server online
			 	$File = "./settings/online.txt"; 
				$Handle = fopen($File, 'w');
				$Data = " $server Status \n\n";
				fwrite($Handle, $Data);
				$sql2 = "SELECT * FROM cq_user WHERE cq_user.last_logout < cq_user.login_time";
				$sql1 = "SELECT * FROM cq_user WHERE cq_user.last_logout < cq_user.login_time AND type = '1'";
				$sql3 = "SELECT * FROM cq_user WHERE cq_user.last_logout < cq_user.login_time AND type = '0'";
				$sql4 = "SELECT * FROM cq_user WHERE cq_user.last_logout < cq_user.login_time AND name LIKE '%[PM]%'";
				$sql5 = "SELECT * FROM cq_user WHERE cq_user.last_logout < cq_user.login_time AND name LIKE '%[GM]%'";
				$players = mysql_query($sql2);
				$online = mysql_num_rows($players);
				$man = mysql_query($sql1);
				$manonline = mysql_num_rows($man);
				$main = mysql_query($sql3);
				$mainonline = mysql_num_rows($main);
				$pm = mysql_query($sql4);
				$pmonline = mysql_num_rows($pm);
				$gm = mysql_query($sql5);
				$gmonline = mysql_num_rows($gm);
				if ($online == "0")
				{
				$Data = " No Players Online"; 
				fwrite($Handle, $Data); 
 				}
			else{
				$Data = " $online Total Characters Online \n"; 
				fwrite($Handle, $Data);
				$Data = "$mainonline Total Players Online \n"; 
				fwrite($Handle, $Data);
			if ($manonline != "0")
			{
				$Data = "$manonline Mannequins Online \n"; 
				fwrite($Handle, $Data);
			}
				if ($pmonline != "0")
			{
			$Data = "$pmonline PM Characters Online \n"; 
				fwrite($Handle, $Data);
			}
				if ($gmonline != "0")
			{
				$Data = "$gmonline GM Characters Online \n"; 
				fwrite($Handle, $Data);
			}
			}
			global $start_time;
			$Data = "\n\nSignature created in ".round((microtime(true) - $start_time),3)." seconds. \n"; 
			fwrite($Handle, $Data);	
		fclose($Handle);
		 }
			
 //image code voor afbeelding te maken 

$all_quotes = file('./settings/online.txt');

if (!$all_quotes || empty($all_quotes)) exit;

foreach ($all_quotes as $myquote)
{
	
	echo nl2br ($myquote);
}
}
}
else
{
function statusimage($ip,$server)
{			
				$File = "./settings/online.txt"; 
				$Handle = fopen($File, 'w');
				$Data = " Valid Serial needed to show $server Server Status ";
				fwrite($Handle, $Data);
				fclose($Handle);
$all_quotes = file('./settings/online.txt');

if (!$all_quotes || empty($all_quotes)) exit;

foreach ($all_quotes as $myquote)
{
	
	echo nl2br ($myquote);
}
}
}

//show signature links
function showsignature($domain)
{
$file = dirname($_SERVER['PHP_SELF']);
if ($file != "/")
{
$file = dirname($_SERVER['PHP_SELF'])."/";
}
echo "html code : <br><textarea rows=\"5\" cols=\"45\">&lt;a href=\"http://$domain\"&gt; &lt;IMG SRC=\"http://powerchaos.com/quotes/q2.php?u=$domain".$file."online.php\" ALT=\"$domain Server Status\"&gt;&lt;/a&gt;</textarea><br><br>";
echo "BB Code ( forum ) : <br><textarea rows=\"5\" cols=\"45\">[url=http://$domain][img]http://powerchaos.com/quotes/q2.php?u=$domain".$file."online.php[/img][/url]</textarea><br><br>";
echo "example : <a href=\"http://$domain\"><IMG SRC=\"http://powerchaos.com/quotes/q2.php?u=$domain".$file."online.php\" ALT=\"$domain Server Status\"></a><br>";
echo "to use a color , please look at <a href=\"http://powerchaos.com/quotes/q2.php\" target=\"_blank\">The Quote generation page</a>";
}

//show server status
function serverstatus()
{
$server = db_array("SELECT * FROM power_settings");
$ip = $server['serverip'];
$server = $server['servername'];
$churl = @fsockopen($ip, 5816, $errno, $errstr, 1);
             if (!$churl){
			 //server offline
			$date = time();
            echo ("<center><font color='darkred'><b>$server is Offline</b></font><center><br>");            
				db_query("UPDATE cq_user SET last_logout='".$date."' WHERE cq_user.last_logout < cq_user.login_time");
                }
             else {
			 //server online
				echo("<center><font color='darkgreen'><b>$server is Online</b></font></center><br>");
				$online = db_number("SELECT * FROM cq_user WHERE cq_user.last_logout < cq_user.login_time");
				$manonline = db_number("SELECT * FROM cq_user WHERE cq_user.last_logout < cq_user.login_time AND type = '1'");
				$mainonline = db_number("SELECT * FROM cq_user WHERE cq_user.last_logout < cq_user.login_time AND type = '0'");
				$pmonline = db_number("SELECT * FROM cq_user WHERE cq_user.last_logout < cq_user.login_time AND name LIKE '%[PM]%'");
				$gmonline = db_number("SELECT * FROM cq_user WHERE cq_user.last_logout < cq_user.login_time AND name LIKE '%[GM]%'");
				if ($online == "0")
				{echo "<center><table border='1'><tr><td><font color='darkred'>No players online</font></td></tr></table></center><br>";}
			else{
				echo ("<center><table border='1'><tr><td>Total Characters Online </td><td><font color='blue'> ".$online."</font></td></tr>");
				echo ("<tr><td>Total Players Online </td><td><font color='red'>".$mainonline."</font></td></tr>");
			if ($manonline != "0")
			{
				echo ("<tr><td>Mannequins Online</td><td><font color='green'> ".$manonline."</font></td></tr>");
			}
				if ($pmonline != "0")
			{
				echo ("<tr><td>PM Characters Online</td><td><font color='purple'> ".$pmonline."</font></td></tr>");
			}
				if ($gmonline != "0")
			{
				echo ("<tr><td>GM Characters Online</td><td><font color='orange'> ".$gmonline."</font></td></tr>");
			}
				echo ("</table></center><br>");
			}
		 }
}

//show user status
function showtotalpoints()
{
if ($_SESSION['admin'] == "1")
{
$rank = "admin";
}
else if ($_SESSION['staff'] == "1")
{
$rank = "Staff";
}
else if ($_SESSION['ban'] > "0")
{
$rank = "Banned";
}
else 
{
$rank = "member";
}
$money = db_assoc("SELECT * FROM power_user WHERE (`account_id` LIKE '".$_SESSION['id']."') LIMIT 1");	
echo ("Account ID :<b><font color='green'> ".$_SESSION['id']."</font></b><br>");
echo ("Account:<font color='red'> ".$_SESSION['username']."</font><br>");
echo ("Rank:<font color='cyan'> ".$rank."</font><br>");
echo ("Credits :<b><font color='bleu'> ".$money['money']."</font></b><br>");
}

//settings updater
function showsettings()
{
if(isset($_POST['updateserial']) && !isset($_POST['updatesettings']))
{
include ('./settings/configcreate.php');
echo "<center>Config file updated<br><br></center>";
}
if(!isset($_POST['updateserial']) && isset($_POST['updatesettings']))
{
include ('./settings/sqlcreate.php');
echo "<center>Server Settings are updated in database<br><br></center>";
}
$serialfile = "./settings/serial.php";
if(file_exists($serialfile))
{
$serialcheck = '1'; //caching time, in seconds
$filemtime = @filemtime($serialfile);  // returns FALSE if file does not exist
$time = time() - $filemtime;
if ($time < $serialcheck){
$checkfile = file_get_contents("$serialfile");
$extract = explode("-",$checkfile);
$valid = $extract[0];
$expiredate = $extract[1];
$domain = $extract[2];
$host = $extract[3];
}
}
$data = db_array("select * from power_settings");
$select = $data['paypalcurrency'];
$expired = date("d/m/Y @ H:i:s",$expiredate);
?>
<center>
<center>
<form method="post" action="./?admin=settings">
<TABLE align="center">
<?php 
if(file_exists($serialfile)){
if ($time < $serialcheck){
?>
<tr><td align="center">Serial will expire at <?php echo "$expired" ?></td></tr>
<tr><td></td></tr>
<?php
}
}
?>
<tr><td align="center">Change Serial</tr></td>
<tr><td align="center"><input type="text" name="serial" id="serial" value="Change your serial"></tr></td>
<tr><td align="center">
<input class="Butt" type="submit" value="Change Serial" name="updateserial">
</td></tr>
</TABLE>
</form>
</center>
<br>
<form method="post" action="./?admin=settings">
<TABLE align="center">
<tr><td align="center">paypal Email ( leave emty if not used )</tr></td>
<tr><td align="center"><input type="text" name="paypalemail" id="paypalemail" value="<?php echo $data['paypalemail']; ?>"></tr></td>
<tr><td align="center">Paypal Currency</tr></td>
<tr><td align="center"><select name="paypalcurrency">
<option value ='EUR' <?php if($select==='EUR') echo 'selected';?>>Euro</option>
<option value ='USD' <?php if($select==='USD') echo 'selected';?>>US Dollar</option>
<option value ='AUD' <?php if($select==='AUD') echo 'selected';?>>Australian Dollar</option>
</select>
</tr></td>
<tr><td align="center">Fortumo Service Id (leave empty if not used )</tr></td>
<tr><td align="center"><input type="text" name="fortumorel" value="<?php echo $data['fortumorel']; ?>"></tr></td>
<tr><td align="center">Server Ip ( Your gameserver ip ) </tr></td>
<tr><td align="center"><input type="text" name="serverip" value="<?php echo $data['serverip']; ?>"></tr></td>
<tr><td align="center">Server Name ( Your Server Name ) </tr></td>
<tr><td align="center"><input type="text" name="servername" value="<?php echo $data['servername']; ?>"></tr></td>
<tr><td align="center">
<input class="Butt" type="submit" value="Complete Settings" name="updatesettings">
</td></tr>
</TABLE>
</form>
</center>
<?php
}
//execute rewards
function executerewards()
{
if(isset($_POST['addep']))
{
include ('./settings/sqlcreate.php');
echo "<center>Ep Rewards updated<br><br></center>";
}
if(isset($_POST['addsummon']))
{
include ('./settings/sqlcreate.php');
echo "<center>Summon Rewards updated<br><br></center>";
}
if(isset($_POST['addtoken']))
{
include ('./settings/sqlcreate.php');
echo "<center>Token Rewards updated<br><br></center>";
}
if(isset($_POST['addvip']))
{
include ('./settings/sqlcreate.php');
echo "<center>VIP Rewards updated<br><br></center>";
}
if(isset($_POST['addcredit']))
{
include ('./settings/sqlcreate.php');
echo "<center>Credit Rewards updated<br><br></center>";
}
if(isset($_POST['addpk']))
{
include ('./settings/sqlcreate.php');
echo "<center>Pk Remove options has beein added<br><br></center>";
}
if(isset($_POST['removereward']))
{
include ('./settings/sqlcreate.php');
echo "<center>Selected Reward has beein removed<br><br></center>";
}
}
//shutdown timer
	if ($excludetimer != 1)
	{
//show error for expired serial
if ($_SESSION['admin'] == 1){
if ($valid == "4")
{
$expired = date("d/m/Y @ H:i:s",$expiredate);
echo ("<font color=\"silver\"><b><br><br>Serial is expired at $expired<br><br>Please extend your serial at <a href=\"http://powerchaos.info\">PowerChaos.info homepage</a></b></font>");
}
}	
function my_shutdown() {
	global $start_time;
	echo "<br><P STYLE=\"font-size: xx-small;\" align=\"center\">Page loaded in ".
			round((microtime(true) - $start_time),3).
			" seconds.</P>";
}
			}		
else
{
function my_shutdown()
{}
}
register_shutdown_function('my_shutdown');
 ?>