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

//Prevent direct access
if (!defined('LICENSE'))
{
	exit('Access Denied');
}


require( PROJECT_DIR.'/includes/func.inc.php' );


if (!defined('INSTALL_MODE')) {

	/**
	 * Authentication
	 */
	session_start();

	if (isAdminLoggedIn() == FALSE) //Check if the user have wanted to access to a protected resource without being logged in
	{
		header( "Location: login.php" );
		die();
	}

	/**
	 * MySQL connection as a persistent connection
	 */
	try {
		// Connect to MySQL
		$dbh = new PDO('mysql:host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASSWORD,
			array(PDO::ATTR_PERSISTENT => true));

		// Set errormode to exceptions
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (PDOException $e) {
		echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine();
		die();
	}

	/**
	 * Retrive more configuration settings from the MySQL database
	 */
	try {
		$sth = $dbh->prepare("
				SELECT *
				FROM ".DBNAME.".".DBPREFIX."config
				;");

		$sth->execute();
		$settings = $sth->fetchAll(PDO::FETCH_ASSOC);

		foreach ($settings as $setting) {
				define( $setting['setting'], $setting['value'] );
		}

		unset($settings);
	}
	catch (PDOException $e) {
		echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine();
		die();
	}

	/**
	 * $_SESSION Vars as Env Vars
	 */
	// Get admin information
	try {
		$sth = $dbh->prepare("
				SELECT id, name
				FROM ".DBNAME.".".DBPREFIX."admins
				WHERE `login` = ".$dbh->quote($_SESSION['adminLogin'])."
				;");
	
		$sth->execute();
		$admin = $sth->fetch(PDO::FETCH_ASSOC);
		
		$_SESSION['adminId'] = $admin['id'];
		$_SESSION['adminName'] = $admin['name'];
	}
	catch (PDOException $e) {
		echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine();
		die();
	}


}