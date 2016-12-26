<?php
if(!isset($_POST['installfiles']) && !isset($_POST['installsql']) && !isset($_POST['installconfig']) && !isset($_POST['installremove']))
{
$file = dirname($_SERVER['PHP_SELF']);
if ($file != "/")
{
$file = dirname($_SERVER['PHP_SELF'])."/";
}
if(file_exists('.config.php')){
$check = file_get_contents("./config.php");
if(strpos($check, "\$install =\"1\""))
{ 
die ("<center>You already completed a install , please remove config file to continue</center>");
}
else
{
echo "<center>a Config file exist , be sure it is cmod 777 to start instalation or delete the file<br></center>";
}
}
?>
<center>
<form method="post" action="./install.php">
<TABLE align="center">
<tr><td align="center">Serial</tr></td>
<tr><td align="center"><input type="text" name="serial" id="serial" value="Your Serial from powerchaos.info"></tr></td>
<tr><td align="center">Mysql Host</tr></td>
<tr><td align="center"><input type="text" name="host" value="localhost"></tr></td>
<tr><td align="center">Mysql password</tr></td>
<tr><td align="center"><input type="text" name="pass" value="mysql password"></tr></td>
<tr><td align="center">Mysql user</tr></td>
<tr><td align="center"><input type="text" name="user" value="mysql username"></tr></td>
<tr><td align="center">My Database ( characters) </tr></td>
<tr><td align="center"><input type="text" name="data" value="my"></tr></td>
<tr><td align="center">Account Database (login accounts)</tr></td>
<tr><td align="center"><input type="text" name="accountdb" value="account"></tr></td>
<tr><td align="center">
<input class="Butt" type="submit" value="Install Config File" name="installfiles">
</td></tr>
</TABLE>
</form>
</center>
<?php
}
if(isset($_POST['installfiles']) && !isset($_POST['installsql']) && !isset($_POST['installconfig']))
{
include ("./configcreate.php");
echo "<center>Config file created , please continue for the mysql file installation<br></center>";
?>
<center>
<form method="post" action="./install.php">
<TABLE align="center">
<tr><td align="center">
<input class="Butt" type="submit" value="Install SQL Files" name="installsql">
</td></tr>
</TABLE>
</form>
</center>
<?php
}
if(!isset($_POST['installfiles']) && isset($_POST['installsql']) && !isset($_POST['installconfig']))
{
include("./sqlcreate.php");
echo "<center>Database files are created , please continue to complete the settings</center>";
?>
<center>
<form method="post" action="./install.php">
<TABLE align="center">
<tr><td align="center">paypal Email</tr></td>
<tr><td align="center"><input type="text" name="paypalemail" id="paypalemail" value=""></tr></td>
<tr><td align="center">Paypal Currency</tr></td>
<tr><td align="center"><select name="paypalcurrency">
<option value ='EUR' selected>Euro</option>
<option value ='USD'>US Dollar</option>
<option value ='AUD'>Australian Dollar</option>
</select>
</tr></td>
<tr><td align="center">Fortumo Service Id (leave empty if not used )</tr></td>
<tr><td align="center"><input type="text" name="fortumorel" value=""></tr></td>
<tr><td align="center">Server Ip ( Your gameserver ip ) </tr></td>
<tr><td align="center"><input type="text" name="serverip" value=""></tr></td>
<tr><td align="center">Server Name ( Your Server Name ) </tr></td>
<tr><td align="center"><input type="text" name="servername" value=""></tr></td>
<tr><td align="center">
<input class="Butt" type="submit" value="Complete Settings" name="installconfig">
</td></tr>
</TABLE>
</form>
</center>
<?php
}
if(!isset($_POST['installfiles']) && !isset($_POST['installsql']) && isset($_POST['installconfig']))
{
include("./sqlcreate.php");
@chmod("./install.php", 0666);
@chmod("./installer.php", 0666);
echo "<center>All installs are complete <br><form method=\"post\" action=\"./install.php\"><input class=\"Butt\" type=\"submit\" value=\"Remove Install Files\" name=\"installremove\"></form></center>";
}

if(isset($_POST['installremove']))
{
$fileToRemove = './installer.php';
if (file_exists($fileToRemove)) {
   // yes the file does exist 

   if (@unlink($fileToRemove) === true) {
   @unlink("./install.php");
   echo "all install files are removed";
   } else {
    echo ("unable to remove the install.php and install.php file , please manual remove those 2 files for security");
   }
} else {
echo ("You shoulnd see this error , the files we try to remove does not exist so how are you opening this page ??");
}
}
?>