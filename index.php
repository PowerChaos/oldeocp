<?php
//Our functions to show the pages and other things, so do not remove
require ("./settings/functions.php");
//first we include our sesions , else users can not login , so do not remove :D
sesions();
//here we show the header , feel free to adjust to fit your own template (pages/template/)
template("header");
//my sidebar , depending on template you need it or not ( pages/template/)
template("sidebar");
//here you can start your content based on pages , just put your page in /pages/ and call it like /?page=home
showpage();
//Here is the footer -> remove and script will NOT work -> read the footer.php file in "/pages/template/"
/*Forced Footer*/ template("footer"); /*forced footer*/
//this is the version checker , remove if you do not want to be informed about new versions
version();
?>