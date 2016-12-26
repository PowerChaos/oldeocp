<?php
$server = db_array("SELECT * FROM power_settings");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="description" content="IsMyBB Multi Forum Solution" />
<meta name="keywords" content="mybb,mutli,multiforum," />
<meta name="author" content="PowerChaos" />
<title><?php echo ($server['servername']); ?></title>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>

<div id="container">

<div id="logo">
<h1><span class="blue"><?php echo ($server['servername']);?></span></h1>
</div>
<div class="br"></div>