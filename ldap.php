<form id="login" name="login" action="<?php echo $PHP_SELF; ?>" method="POST">
	<fieldset>
		<legend>Login Credientials</legend>
		<label for="username">Username:</label>
		<input type="text" id="username" name="username" />
		<label for="password">Password:</label>
		<input type="password" id="password" name="password" />
		<input type="submit" id="submit" name="submit" value="Login" />
		<input type="reset" id="reset" name="reset" value="Reset" />
	</fieldset>
</form>

<?php
function ldap_auth($username, $password)
{
	// basic sequence with LDAP is connect, bind, search, interpret search
	// result, close connection

	echo "<h3>LDAP Connection Test</h3>";
	echo "Connecting ...";

	$ldapconn = ldap_connect("ldap.unfcsd.unf.edu");  // must be a valid LDAP server!
	if ($ldapconn) 
	{
		echo "Connected.<br />";
		echo "Binding ...";

		$sdn 		= 'CN='.$username.',OU=Employees,OU=UNFUsers,DC=unfcsd,DC=unf,DC=edu';
		$ldaprdn 	= 'CN='.$username.',OU=Employees,OU=UNFUsers,DC=unfcsd,DC=unf,DC=edu'; 
		$ldappass 	= $password;
		$ldapbind 	= ldap_bind($ldapconn, $ldaprdn, $ldappass);
		if ($ldapbind) 
		{
			echo "Bound successfully.<br />";
			
			$filter		= "objectclass=*"; 
			$justthese 	= array("ou", "sn", "givenname", "mail"); 

			$sr 	= ldap_read($ldapconn, $sdn, $filter, $justthese);
			$entry 	= ldap_get_entries($ldapconn, $sr);
			
			echo "Name: ".$entry[0]["sn"][0]."<br />";
			echo "Email address: ".$entry[0]["mail"][0]."<br />";
		} 
		else 
		{
			echo "LDAP conn ok...";
		}

		echo "Closing connection";
		ldap_close($ldapconn);
	} 
	else 
	{
		echo "<h4>Unable to connect to LDAP server</h4>";
	}
}

// Main page entry
$username = $_POST["username"];
$password = $_POST["password"];

if ($username && $password)
{
	ldap_auth($username, $password);
}

?>