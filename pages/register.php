<?php
if ($_POST['action'] == "register" AND $_SESSION['id'] == "")
{
					$userid = trim($_POST['user']);
					$newpasscheck = trim($_POST['pass']);
					$newpassretype = trim($_POST['repass']);
					$email = $_POST['email'];
					$ip = $_POST['ip'];
					$hash=$_POST['hash'];
					if(!ereg("^[0-9a-z]{4,12}$",$userid))
					{
					$error = 1;
						echo "Only letters from \"a\" to \"z\" and numbers, lenght of 4 to 12 characters Allowed <br> <a href=\"./index.php?page=register\">click here to retry</a>";
					}
					if($newpasscheck != $newpassretype)
					{
					$error = 1;
					echo "Your paswords dont match <br>first pass :".$newpasscheck." <br> second pass : ".$newpassretype." <br> <a href=\"./index.php?page=register\">click here to retry</a>";
					}
					if ($error != 1)
					{
					$res = db_number("select * from account where name = '".$userid."' order by id desc");
					if($res == 0 )
					{
					accdb();
									db_query("insert into account (name,Password,Reg_date,netbar_ip,email) values ('".$userid."','".$hash."','".date("y-m-d H:i:s", time())."','".$ip."','".$email."')");
									echo "Account registered successfully. , please note that everything is <font color='red'> LOWERCASE </font> <br> You can now login with following information <br> username: ".$_POST['user']." <br>password : ".$_POST['pass']."";
					}
					else
					{
									echo "Account Already exists in database <br> <a href=\"./index.php?page=register\">click here to retry</a>";
					}
					}

}
if ($_SESSION['id'] == "" AND $_POST['action'] != "register")
{
gamedb();
$server = db_array("SELECT * FROM power_settings");
?>
<script language="javascript" type="text/javascript">
function pulsar(e,obj) {
tecla = (document.all) ? e.keyCode : e.which;
//alert(tecla);
if (tecla!="8" && tecla!="0"){
obj.value += String.fromCharCode(tecla).toLowerCase();
return false;
}else{
return true;
}
} 
</script>
<form method="post" action="./index.php?page=register">
<input type="hidden" name="action" value="register" />
<script type="text/javascript" src="./settings/md5.js"></script>
<TABLE align="center">
<br />
<center>Register a Game account for <?php echo $server['servername'] ?></center>
<tr><td align="center">Account Name:</td></tr>
<tr><td align="center"><input type="text" onkeypress="return pulsar(event,this)" size="12" name="user"/></td></tr>
<tr><td align="center">Password:</td></tr>
<tr><td align="center"><input type="password" onkeypress="return pulsar(event,this)" size="20" name="pass"/></td></tr>
<tr><td align="center">Retype Password:</td></tr>
<tr><td align="center"><input type="password" onkeypress="return pulsar(event,this)" size="20" name="repass"/></td></tr>
<tr><td align="center">email</td></tr>
<tr><td align="center"><input type="email" onkeypress="return pulsar(event,this)"  name="email"/></td></tr>
<tr><td align="center">IP Adress:</td></tr>
<input type="hidden" name="ip" id="ip" value="<?php echo $_SERVER['REMOTE_ADDR'] ?>">
<tr><td align="center"><?php echo $_SERVER['REMOTE_ADDR'] ?></td></tr>
<tr><td align="center">
<input type="hidden" name="hash"><input class=Butt type=submit onClick="hash.value = login(pass.value)" value="Register Account on <?php echo $server['servername'] ?> " name="Register">
</td></tr>
</TABLE>
</form>

<?php

}
if ($_SESSION['id'] != "")
{
echo ("You got to be kidding me, You are already registered");
}
?>