<?php
if ($_SESSION['id'] != "" AND $_POST['action'] != "changepass")
{
?>
<form method="post" action="./index.php?page=changepass">
<input type="hidden" name="action" value="changepass" />
<script type="text/javascript" src="./settings/md5.js"></script>
<TABLE align="center">
<br />
Enter the correct info and your password will be changed.
<tr><td align="center">Current Password:</tr></td>
<tr><td align="center"><input type="hidden" name="hash1">
<input type="password" size="20" name="oldpass" onBlur="hash1.value=login(oldpass.value)"/></tr></td>
<tr><td align="center">New Password:</td></tr>
<tr><td align="center"><input type="password" size="20" name="newpass"/></td></tr>
<tr><td align="center">Retype New Password:</td></tr>
<tr><td align="center"><input type="password" size="20" name="renew"/></td></tr>
<tr><td align="center">
<input type="hidden" name="hash"><input class=Butt type=submit onClick="hash.value = login(newpass.value)" value="Change Password" name="changepass">
</td></tr>
</TABLE>
</form>

<?php

}
if ($_SESSION['id'] != "" AND $_POST['action'] == "changepass")
{
					$check = $_SESSION['passwort'];
					$oldpass = mysql_real_escape_string($_POST['hash1']);
					$newpasscheck = trim($_POST['newpass']);
					$newpassretype = trim($_POST['renew']);
					$hash=$_POST['hash'];
				
				if($check != $oldpass)
					{
						echo "Your current password was typed wrong ( ".$_POST['oldpass']." )<br> <a href=\"./index.php?page=changepass\">click here to retry</a>";
					}
					else{
					if($newpasscheck != $newpassretype)
					{
						echo "Your New paswords dont match <br>first pass :".$newpasscheck." <br> second pass : ".$newpassretype." <br> <a href=\"./index.php?page=changepass\">click here to retry</a>";
					}
					else{
					accdb();
					db_query ("UPDATE account SET password='".$hash."' WHERE id='".$_SESSION['id']."'");

									echo "Password Changed correctly to ".$newpasscheck." <br><meta http-equiv='refresh' content='3'> Please relog with your new pass";
							session_destroy();

					}


					}

}
else if ($_SESSION['id'] == "")
{
echo ("Please login before you can see this page");
}
?>