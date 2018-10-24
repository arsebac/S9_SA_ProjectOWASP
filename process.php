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

require( realpath(dirname(__FILE__)).'/conf.inc.php' );
require( PROJECT_DIR.'/includes.inc.php' );

if (isset($_POST['task']))
{
	$TASK = $_POST['task'];
}
else if (isset($_GET['task']))
{
	$TASK = $_GET['task'];
}
else {
	$TASK = FALSE;
}

switch($TASK)
{
	case 'config edit':
		$name = $_POST['name'];

		if (empty($name)) {
			$name = 'OWASP - Open Web Application Security Project';
		}

		if (empty($template)) {
			$template = 'bootstrap.min.css';
		}

		// UPDATE TITLE
		$db_query = $dbh->prepare( "
		UPDATE ".DBNAME.".".DBPREFIX."config
	  	SET
			value		= :value
	 	WHERE
			setting = :setting" );
	
		$db_query->bindValue(':value', $name);
		$db_query->bindValue(':setting', 'TITLE');
	
		$db_query->execute();

		// UPDATE TEMPLATE
		$db_query = $dbh->prepare( "
		UPDATE ".DBNAME.".".DBPREFIX."config
	  	SET
			value		= :value
	 	WHERE
			setting = :setting" );

		$db_query->bindValue(':value', $template);
		$db_query->bindValue(':setting', 'TEMPLATE');

		$db_query->execute();

		// REDIRECT
		$_SESSION['msg1'] = 'New configuration applied !';
		$_SESSION['msg2'] = '';
		$_SESSION['msg-type'] = 'success';
		header( "Location: dashboard.php?view="."config" );
		die();
	
		break;

	//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

	default:
		exit('<h1><b>Error: unknown task !</b></h1>');
}

?>