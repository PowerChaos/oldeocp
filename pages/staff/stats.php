<p>Full Server Status Page</p>
        <table border='1'>
<tr>
            <tr>
                <td width="40%" align="left">Total Accounts</td>
                <td width="58%"><?php
				accdb();
            $val = db_array("SELECT count(*) FROM account;");        
            echo "<font style='color: #FF0000'>$val[0]<br />";
            ?></td>
            </tr>
            <tr>
                <td width="40%" align="left">Total Characters</td>
                <td width="58%"><?php
				gamedb();
            $val = db_array("SELECT count(*) FROM cq_user;");            
            echo "<font style='color: #FF0000'>$val[0]<br />";
            ?></td>
            </tr>
			<tr>
                <td width="40%" align="left">Total Jailed Characters</td>
                <td width="58%"><?php
            $val = db_array("SELECT count(*) FROM cq_user WHERE cheat_time >=1;");
            echo "<font style='color: #FF0000'>$val[0]<br />";
            ?></td>
            </tr>
            <tr>
                <td width="40%" align="left">Total Magicians</td>
                <td width="58%"><?php
            $val = db_array("SELECT count(*) FROM cq_user WHERE profession=10;");           
            echo "<font style='color: #FF0000'>$val[0]<br />";
            ?></td>
            </tr>
            <tr>
                <td width="40%" align="left">Total Warriors</td>
                <td width="58%"><?php
            $val = db_array("SELECT count(*) FROM cq_user WHERE profession=20;");
            echo "<font style='color: #FF0000'>$val[0]<br />";
            ?></td>
            </tr>
            <tr>
                <td width="40%" align="left">Total Paladin</td>
                <td width="58%"><?php
            $val = db_array("SELECT count(*) FROM cq_user WHERE profession=30;");
            echo "<font style='color: #FF0000'>$val[0]<br />";
            ?></td>
            </tr>
			<tr>
                <td width="40%" align="left">Total Vampires</td>
                <td width="58%"><?php
            $val = db_array("SELECT count(*) FROM cq_user WHERE profession=50;");
            echo "<font style='color: #FF0000'>$val[0]<br />";
            ?></td>
            </tr>
            <tr>
                <td width="40%" align="left">Total Legions</td>
                <td width="58%"><?php
            $val = db_array("SELECT count(*) FROM cq_syndicate;");
            echo "<font style='color: #FF0000'>$val[0]<br />";
            ?></td>
            </tr>
            <tr>
                <td width="40%" align="left">Total Families</td>
                <td width="58%"><?php
            $val = db_array("SELECT count(*) FROM cq_family;");
            echo "<font style='color: #FF0000'>$val[0]<br />";
            ?></td>
            </tr>
            <tr>
                <td width="40%" align="left">Total Items</td>
                <td width="58%"><?php	
            $val = db_array("SELECT count(*) FROM cq_item;");
            echo "<font style='color: #FF0000'>$val[0]<br />";
            ?></td>
            </tr>
            <tr>
                <td width="40%" align="left">Total Pets</td>
                <td width="58%"><?php
            $val = db_array("SELECT count(*) FROM cq_eudemon;");
            echo "<font style='color: #FF0000'>$val[0]<br />";
            ?></td>
            </tr>
            <tr>
                <td width="40%" align="left">Total VIP-0</td>
                <td width="58%"><?php
				accdb();
            $val = db_array("SELECT count(*) FROM account WHERE VIP=0;");
            echo "<font style='color: #FF0000'>$val[0]<br />";
            ?></td>
            </tr>
            <tr>
                <td width="40%" align="left">Total VIP-1</td>
                <td width="58%"><?php
            $val = db_array("SELECT count(*) FROM account WHERE VIP=1;");
            echo "<font style='color: #FF0000'>$val[0]<br />";
            ?></td>
            </tr>
            <tr>
                <td width="40%" align="left">Total VIP-2</td>
                <td width="58%"><?php
            $val = db_array("SELECT count(*) FROM account WHERE VIP=2;");
            echo "<font style='color: #FF0000'>$val[0]<br />";
            ?></td>
            </tr>
			            <tr>
                <td width="40%" align="left">Total VIP-3</td>
                <td width="58%"><?php			
            $val = db_array("SELECT count(*) FROM account WHERE VIP=3;");
            echo "<font style='color: #FF0000'>$val[0]<br />";
            ?></td>
            </tr>
            <tr>
                <td width="40%" align="left">Total VIP-4</td>
                <td width="58%"><?php
            $val = db_array("SELECT count(*) FROM account WHERE VIP=4;");
            echo "<font style='color: #FF0000'>$val[0]<br />";
            ?></td>
            </tr>
            <tr>
				<td width="40%" align="left">Total VIP-5</td>
                <td width="58%"><?php
            $val = db_array("SELECT count(*) FROM account WHERE VIP=5;");
            echo "<font style='color: #FF0000'>$val[0]<br />";
            ?></td>
            </tr>
			            <tr>
                <td width="40%" align="left">Total VIP-6</td>
                <td width="58%"><?php
            $val = db_array("SELECT count(*) FROM account WHERE VIP=6;");
            echo "<font style='color: #FF0000'>$val[0]<br />";
            ?></td>
            </tr>
            <tr>
                <td width="40%" align="left">Total VIP-7</td>
                <td width="58%"><?php
            $val = db_array("SELECT count(*) FROM account WHERE VIP=7;");
            echo "<font style='color: #FF0000'>$val[0]<br />";
            ?></td>
            </tr>
            <tr>
                <td width="40%" align="left">Total VIP Accounts</td>
                <td width="58%"><?php
            $val = db_array("SELECT count(*) FROM account WHERE VIP<=7;");
            echo "<font style='color: #FF0000'>$val[0]<br />";
            ?></td>
            </tr>
				<tr>
                <td width="40%" align="left">Total Banned Accounts</td>
                <td width="58%"><?php
            $val = db_array("SELECT count(*) FROM account WHERE online >=1;");
            echo "<font style='color: #FF0000'>$val[0]<br />";
            ?></td>
            </tr>
</table>
</tr>