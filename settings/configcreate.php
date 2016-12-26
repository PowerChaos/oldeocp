<?php
//config file instalation
if(isset($_POST['installfiles']))
{
$installfile = './config.php'; 
$install = @fopen($installfile, 'w') or die ("please cmod the folder \"settings\"  to 777 ");
		 $write ="<?php
//Serial Settings
\$serial = \"".$_POST['serial']."\"; // Your serial , or script wont work		 
		 
//database settings
\$mysqlhost = \"".$_POST['host']."\"; // your host name -> mostly localhost
\$mysqluser = \"".$_POST['user']."\"; // Your database username 
\$mysqlpass = \"".$_POST['pass']."\"; // mostly setted up with the database
\$mysqldata = \"".$_POST['data']."\"; // This is your database
\$accountdb = \"".$_POST['accountdb']."\"; //This is the account DB in case you use 2 databases

//install is complete
\$install =\"1\";
?>
";
fwrite($install, $write); 
fclose($install);
chmod($installfile, 0666);

$onlinefile = './online.txt';
$online = @fopen($onlinefile, 'w') or die ("please cmod the folder \"settings\"  to 777 ");
$onlinewrite ="Here will you see the dynamic generated image text
";
fwrite($online, $onlinewrite); 
fclose($online);
chmod($onlinefile, 0666);
}
if(isset($_POST['updateserial']))
{
include("./settings/config.php");
$newserial = $_POST['serial'];
$file = file_get_contents('./settings/config.php');
$file = str_replace("\$serial = \"".$serial."\"","\$serial = \"".$newserial."\"", $file);
file_put_contents("./settings/config.php", $file);
}
if(!isset($_POST))
{
echo ("Post Value is missing");
}
 ?>