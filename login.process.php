<?php
/**
 * MINI-CMS PROJECT
 * ____________________________________
 * M2105 - DUT R&T - IUT de Caen
 * Année Universitaire : 2013-2014
 * ____________________________________
 *
 * @categories	Systems Administration, Education
 * @package		Mini-CMS
 * @author		Nikita ROUSSEAU
 * @author		Simon MESNAGE
 * @copyright	2014
 */

require( realpath(dirname(__FILE__)).'/conf.inc.php' );
require( PROJECT_DIR.'/includes/func.inc.php' );

/**
 * Authentication
 */
session_start();

if (isset($_POST['task']))
{
	$TASK = $_POST['task'];
}
else if (isset($_GET['task']))
{
	$TASK = $_GET['task'];
}

switch(@$TASK)
{
	case 'processlogin':
		$username = $_POST['username'];
		$password = tripleMd5($_POST['password'], CRYPTOSALT);
		$rememberMe = @$_POST['remember'];

		try {
			// Connect to MySQL
			$dbh = new PDO('mysql:host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASSWORD);

			// Set errormode to exceptions
			$dbh->setAttribute(PDO::ATTR_ERRMODE,
							  PDO::ERRMODE_EXCEPTION);

			// Query
			$db_query = $dbh->query("
				SELECT COUNT(*)
				FROM ".DBNAME.".".DBPREFIX."admins
				WHERE `login` = ".$dbh->quote($username)." AND `password` = ".$dbh->quote($password).";");

			$rowCount = $db_query->fetchColumn();

			// Close MySQL Connection
			$dbh = null;
		}
		catch (PDOException $e) {
			echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine();
			die();
		}

		if ($rowCount == 1)
		{
			// Provided credentials are okay
			validateAdmin();

			// Store login
			$_SESSION['adminLogin'] = $username;

			// RememberMe
			if (!empty($rememberMe)) {
				setcookie('rememberMe', $username, strtotime( '+31 days' ));
			}
			else {
				setcookie('rememberMe', 'void', strtotime( '-1 days' ));
			}

			if (!empty($_SESSION['loginattempt']))
			{
				unset($_SESSION['loginattempt']);
			}
			if (!empty($_SESSION['lockout']))
			{
				unset($_SESSION['lockout']);
			}

			header( "Location: dashboard.php" );
			die();
		}

		// No rows matched
		// Login failed.

		$_SESSION['loginerror'] = TRUE;
		@$_SESSION['loginattempt']++;
		if (4 < $_SESSION['loginattempt'])
		{
			$_SESSION['lockout'] = time();
			$_SESSION['loginattempt'] = 0; //Reseting attempts as the user will be ban for 5 mins
		}

		header( "Location: login.php" );
		die();



	case 'logout':
		if (isAdminLoggedIn() == TRUE)
		{
			logout();
			header( "Location: login.php" );
			die();
		}
		else
		{
			exit('Not logged in');
		}



	default:
		exit('<h1><b>Error</b></h1>');
}

exit('<h1><b>403 Forbidden</b></h1>'); //If the task is incorrect or unspecified, we drop the user.
?>