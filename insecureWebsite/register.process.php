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
    case 'user add':
        $login = $_POST['login'];
        $password = tripleMd5($_POST['password'], CRYPTOSALT);
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];

        if (empty($login) || empty($password) || empty($email)) {
            $_SESSION['msg1'] = 'Missing required args !';
            $_SESSION['msg2'] = '';
            $_SESSION['msg-type'] = 'error';
            header( "Location: register.php" );
            die();
        }

        if (empty($firstname)) {
            $firstname = '';
        }

        if (empty($lastname)) {
            $lastname = '';
        }

        try {
            // Connect to MySQL
            $dbh = new PDO('mysql:host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASSWORD);

            // Set errormode to exceptions
            $dbh->setAttribute(PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION);

            // UPDATE TITLE
            $db_query = $dbh->prepare( "
            INSERT INTO ".DBNAME.".".DBPREFIX."user
                (role, login, firstname, lastname, password, mail)
            VALUES
                (
                    'Regular',
                    :login,
                    :firstname,
                    :lastname,
                    :password,
                    :mail
                )" );

            $db_query->bindValue(':login', $login);
            $db_query->bindValue(':firstname', $firstname);
            $db_query->bindValue(':lastname', $lastname);
            $db_query->bindValue(':password', $password);
            $db_query->bindValue(':mail', $email);

            $db_query->execute();
        }
        catch (PDOException $e) {
            echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine();
            die();
        }

        // REDIRECT
        $_SESSION['msg1'] = 'New user registered !';
        $_SESSION['msg2'] = '';
        $_SESSION['msg-type'] = 'success';
        header( "Location: login.php" );
        die();

        break;

	default:
		exit('<h1><b>Error</b></h1>');
}

exit('<h1><b>403 Forbidden</b></h1>'); //If the task is incorrect or unspecified, we drop the user.
?>