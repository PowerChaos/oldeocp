<?php
$excludetimer = "1"; // prevent generation of the debug info on direct call
require ("./settings/functions.php");
$server = db_array("SELECT * FROM power_settings");
statusimage($server['serverip'],$server['servername']);
?>