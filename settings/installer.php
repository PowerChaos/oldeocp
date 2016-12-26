<?php
if(isset($_POST['installsql']) || isset($_POST['installconfig']))
{
include ('./config.php');
if (!$con = mysql_connect("$mysqlhost", "$mysqluser", "$mysqlpass")) {
die('<h1 style="color: red;">MySQL Error:</h1>Please copy and paste between the lines and email to webmaster@powerchaos.com<br><br>------------------------------------------------------------------------------------<h3>Query:</h3><pre>' . htmlentities($query) . '</pre><h3>MySQL Error:</h3>' . mysql_error() . '<br><br>------------------------------------------------------------------------------------');
}

if (!mysql_select_db("$mysqldata")) {
die('<h1 style="color: red;">MySQL Error:</h1>Please copy and paste between the lines and email to webmaster@powerchaos.com<br><br>------------------------------------------------------------------------------------<h3>Query:</h3><pre>' . htmlentities($query) . '</pre><h3>MySQL Error:</h3>' . mysql_error() . '<br><br>------------------------------------------------------------------------------------');
}
function db_query($query){
    $output = mysql_query($query) or die('<h1 style="color: red;">MySQL Error:</h1>Please copy and paste between the lines and email to webmaster@powerchaos.com<br><br>------------------------------------------------------------------------------------<h3>Query:</h3><pre>' . htmlentities($query) . '</pre><h3>MySQL Error:</h3>' . mysql_error() . '<br><br>------------------------------------------------------------------------------------');
    return $output;
}
}
else
{
echo"This file is a installer config file , please remove AFTER succesfull instalation";
}
?>