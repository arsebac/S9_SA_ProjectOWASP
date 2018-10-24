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

    case 'article add':
        $title = $_POST['title'];
        $header = $_POST['header'];
        $body = $_POST['body'];
        $footer = $_POST['footer'];
        $publisherId = $_POST['idAuthor'];

        // VERIFY INPUTS
        if (empty($title)) {
            $_SESSION['msg1'] = 'Erreur lors de la saisie du formulaire !';
            $_SESSION['msg2'] = '';
            $_SESSION['msg-type'] = 'warning';
            header( "Location: dashboard.php?view=".'article'.'&task='.'add' );
            die();
        }

        // INSET INTO DATABASE
        $db_query = $dbh->prepare( "INSERT INTO ".DBNAME.".".DBPREFIX."article
						(title, header, body, footer, idAuthor)
					   VALUES
						(:title, :header, :body, :footer, :idAuthor) " );

        $db_query->bindValue(':title', $title);
        $db_query->bindValue(':header', $header);
        $db_query->bindValue(':body', $body);
        $db_query->bindValue(':footer', $footer);
        $db_query->bindValue(':idAuthor', $publisherId);

        $db_query->execute();

        // REDIRECT
        $_SESSION['msg1'] = 'Article Ajouté !';
        $_SESSION['msg2'] = "";
        $_SESSION['msg-type'] = 'success';
        header( "Location: dashboard.php?view="."article" );
        die();

        break;

    //--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

    case 'article edit':
        $idArticle = $_POST['idArticle'];
        $title = $_POST['title'];
        $header = $_POST['header'];
        $body = $_POST['body'];
        $footer = $_POST['footer'];
        $publisherId = $_POST['idAuthor'];

        // VERIFY INPUTS
        if (empty($title) || empty($idArticle)) {
            $_SESSION['msg1'] = 'Erreur lors de la saisie du formulaire !';
            $_SESSION['msg2'] = '';
            $_SESSION['msg-type'] = 'warning';
            header( "Location: dashboard.php?view=".'article'.'&task='.'edit' );
            die();
        }

        // INSET INTO DATABASE
        $db_query = $dbh->prepare( "UPDATE ".DBNAME.".".DBPREFIX."article
	  	SET
			title		  = :title,
			header		  = :header,
			body		  = :body,
			footer		  = :footer,
			idAuthor	  = :idAuthor
	 	WHERE
			id = :id" );

        $db_query->bindValue(':id', $idArticle);
        $db_query->bindValue(':title', $title);
        $db_query->bindValue(':header', $header);
        $db_query->bindValue(':body', $body);
        $db_query->bindValue(':footer', $footer);
        $db_query->bindValue(':idAuthor', $publisherId);

        $db_query->execute();

        // REDIRECT
        $_SESSION['msg1'] = 'Article Modifié !';
        $_SESSION['msg2'] = "";
        $_SESSION['msg-type'] = 'success';
        header( "Location: dashboard.php?view="."article" );
        die();

        break;

    //--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

    case 'article del':
        $idArticle = $_GET['id'];

        // Ready for deletion

        $db_query = $dbh->prepare( "DELETE FROM ".DBNAME.".".DBPREFIX."article WHERE id = :id" );
        $db_query->bindValue(':id', $idArticle);
        $db_query->execute();

        // REDIRECT
        $_SESSION['msg1'] = 'Article Supprimé !';
        $_SESSION['msg2'] = '';
        $_SESSION['msg-type'] = 'success';
        header( "Location: dashboard.php?view="."article" );
        die();

        break;

    //--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

    default:
		exit('<h1><b>Error: unknown task !</b></h1>');
}

?>