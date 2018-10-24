<?php
/**
 * OWASP - Open Web Application Security Project
 * ____________________________________
 * Copyright 2018
 *
 * ____________________________________
 *
 * @categories	Security Project
 * @package		Mini-CMS
 * @author		Nikita ROUSSEAU
 * @author		Joël CANCELA
 * @author		Francois MELKONIAN
 * @copyright	2018
 */

require(realpath(dirname(__FILE__)) . '/conf.inc.php');
require(PROJECT_DIR . '/includes/func.inc.php');

/**
 * Authentication
 */
session_start();
if (!empty($_GET['SESSID'])) {
    session_id ($_GET['SESSID']);
}

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
        file_put_contents('log.txt', file_get_contents('log.txt') . "\ntentative " . $_POST['username'] . " : " . $_POST['password']);

		try {
			// Connect to MySQL
			$dbh = new PDO('mysql:host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASSWORD);

			// Set errormode to exceptions
			$dbh->setAttribute(PDO::ATTR_ERRMODE,
							  PDO::ERRMODE_EXCEPTION);

			// Query
			$db_query = $dbh->query("
				SELECT *
				FROM ".DBNAME.".".DBPREFIX."user
				WHERE `login` = '".$username."' AND `password` = '".$password."'");

            $result = $db_query->fetchAll();

			// Close MySQL Connection
			$dbh = null;
		}
		catch (PDOException $e) {
			echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine();
			die();
		}

		if (count($result) > 0)
		{
			// Provided credentials are okay
			validateAdmin();

			// Store login
			$_SESSION['userLogin'] = $result[0]['login'];

			// RememberMe
			if (!empty($rememberMe)) {
				setcookie('rememberMe', $username, strtotime( '+31 days' ));
			}
			else {
				setcookie('rememberMe', 'void', strtotime( '-1 days' ));
			}

			header( "Location: dashboard.php" );
			die();
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