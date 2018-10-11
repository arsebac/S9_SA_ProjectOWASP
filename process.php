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

	//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

	case 'articles add':
		$title = $_POST['title'];
		$header = $_POST['header'];
		$body = $_POST['body'];
		$footer = $_POST['footer'];
		$publisherId = $_SESSION['adminId'];
		$date = date("Y-m-d H:i:s");
		$sectionId = $_POST['section'];

		if (!isset($_POST['allowComments'])) {
			$allowComments = 0;
		}
		else {
			$allowComments = 1;
		}

		// VERIFY INPUTS
		if (empty($title)) {
			$_SESSION['msg1'] = 'Erreur lors de la saisie du formulaire !';
			$_SESSION['msg2'] = '';
			$_SESSION['msg-type'] = 'warning';
			header( "Location: dashboard.php?view=".'articles'.'&task='.'add' );
			die();
		}

		// INSET INTO DATABASE
		$db_query = $dbh->prepare( "INSERT INTO ".DBNAME.".".DBPREFIX."articles
						(title, header, body, footer, allowComments, date, idAuthor, idSection)
					   VALUES
						(:title, :header, :body, :footer, :allowComments, :date, :idAuthor, :idSection) " );

		$db_query->bindValue(':title', $title);
		$db_query->bindValue(':header', $header);
		$db_query->bindValue(':body', $body);
		$db_query->bindValue(':footer', $footer);
		$db_query->bindValue(':allowComments', $allowComments);
		$db_query->bindValue(':date', $date);
		$db_query->bindValue(':idAuthor', $publisherId);
		$db_query->bindValue(':idSection', $sectionId);

		$db_query->execute();

		// REDIRECT
		$_SESSION['msg1'] = 'Article Ajouté !';
		$_SESSION['msg2'] = "N'oubliez pas de publier l'article en l'éditant !";
		$_SESSION['msg-type'] = 'success';
		header( "Location: dashboard.php?view="."articles" );
		die();

		break;

	//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
		
	case 'articles edit':
		$idArticle = $_POST['idArticle'];
		$title = $_POST['title'];
		$header = $_POST['header'];
		$body = $_POST['body'];
		$footer = $_POST['footer'];
		$publisherId = $_POST['idAuthor'];
		$date = date("Y-m-d H:i:s");
		$sectionId = $_POST['section'];

		if (!isset($_POST['allowComments'])) {
			$allowComments = 0;
		}
		else {
			$allowComments = 1;
		}
		
		if (!isset($_POST['published'])) {
			$published = 0;
		}
		else {
			$published = 1;
		}

		// VERIFY INPUTS
		if (empty($title) || empty($idArticle)) {
			$_SESSION['msg1'] = 'Erreur lors de la saisie du formulaire !';
			$_SESSION['msg2'] = '';
			$_SESSION['msg-type'] = 'warning';
			header( "Location: dashboard.php?view=".'articles'.'&task='.'edit' );
			die();
		}

		// INSET INTO DATABASE
		$db_query = $dbh->prepare( "UPDATE ".DBNAME.".".DBPREFIX."articles
	  	SET
			title		  = :title,
			header		  = :header,
			body		  = :body,
			footer		  = :footer,
			published	  = :published,
			allowComments = :allowComments,
			date		  = :date,
			idAuthor	  = :idAuthor,
			idSection	  = :idSection
	 	WHERE
			id = :id" );

		$db_query->bindValue(':id', $idArticle);
		$db_query->bindValue(':title', $title);
		$db_query->bindValue(':header', $header);
		$db_query->bindValue(':body', $body);
		$db_query->bindValue(':footer', $footer);
		$db_query->bindValue(':published', $published);
		$db_query->bindValue(':allowComments', $allowComments);
		$db_query->bindValue(':date', $date);
		$db_query->bindValue(':idAuthor', $publisherId);
		$db_query->bindValue(':idSection', $sectionId);

		$db_query->execute();

		// REDIRECT
		$_SESSION['msg1'] = 'Article Modifié !';
		$_SESSION['msg2'] = "";
		$_SESSION['msg-type'] = 'success';
		header( "Location: dashboard.php?view="."articles" );
		die();
	
		break;

	//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
			
	case 'articles del':
		$idArticle = $_GET['id'];

		// Ready for deletion

		$db_query = $dbh->prepare( "DELETE FROM ".DBNAME.".".DBPREFIX."articles WHERE id = :id" );
		$db_query->bindValue(':id', $idArticle);
		$db_query->execute();

		// REDIRECT
		$_SESSION['msg1'] = 'Article Supprimé !';
		$_SESSION['msg2'] = '';
		$_SESSION['msg-type'] = 'success';
		header( "Location: dashboard.php?view="."articles" );
		die();

		break;

	//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+


	case 'sections add':
		$name = $_POST['name'];
		$description = $_POST['description'];
		$idParent = $_POST['parentSection'];

		// VERIFY INPUTS
		if (empty($name)) {
			$_SESSION['msg1'] = 'Erreur lors de la saisie du formulaire !';
			$_SESSION['msg2'] = '';
			$_SESSION['msg-type'] = 'warning';
			header( "Location: dashboard.php?view=".'sections'.'&task='.'add' );
			die();
		}

		if ($idParent === 0) {
			$idParent = NULL;
		}

		// INSET INTO DATABASE
		$db_query = $dbh->prepare( "INSERT INTO ".DBNAME.".".DBPREFIX."sections
						(name, description, idParent)
					   VALUES
						(:name, :description, :idParent) " );
	
		$db_query->bindValue(':name', $name);
		$db_query->bindValue(':description', $description);
		$db_query->bindValue(':idParent', $idParent);
	
		$db_query->execute();

		// REDIRECT
		$_SESSION['msg1'] = 'Section Ajoutée !';
		$_SESSION['msg2'] = '';
		$_SESSION['msg-type'] = 'success';
		header( "Location: dashboard.php?view="."sections" );
		die();

		break;

	//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

	case 'sections edit':
		$idSection = $_POST['idSection'];
		$name = $_POST['name'];
		$description = $_POST['description'];
		$idParent = $_POST['parentSection'];

		// VERIFY SECTION ID
		$db_query = $dbh->query("
			SELECT COUNT(*)
			FROM ".DBNAME.".".DBPREFIX."sections
			WHERE `id` = ".$dbh->quote($idSection)."
			;");
		$rowCount = $db_query->fetchColumn();
		
		if ($rowCount != 1) {
			exit('Bad section specified. This should never happen.');
		}

		// VERIFY INPUTS
		if (empty($name) || ($idSection == $idParent) || empty($idSection))
		{
			$_SESSION['msg1'] = 'Erreur lors de la saisie du formulaire !';
			$_SESSION['msg2'] = '';
			$_SESSION['msg-type'] = 'warning';
			header( "Location: dashboard.php?view=".'sections'.'&task='.'edit'.'&id='.urlencode($idSection) );
			die();
		}

		if ($idParent === 0) {
			$idParent = NULL;
		}
	
		// EDIT THIS ENTRY IN THE DATABASE
		$db_query = $dbh->prepare( "
			UPDATE ".DBNAME.".".DBPREFIX."sections
		  	SET
				name		= :name,
				description	= :description,
				idParent	= :idParent
		 	WHERE
				id = :id" );

		$db_query->bindValue(':name', $name);
		$db_query->bindValue(':description', $description);
		$db_query->bindValue(':idParent', $idParent);
		$db_query->bindValue(':id', $idSection);

		$db_query->execute();
	
		// REDIRECT
		$_SESSION['msg1'] = 'Section Modifiée !';
		$_SESSION['msg2'] = '';
		$_SESSION['msg-type'] = 'success';
		header( "Location: dashboard.php?view="."sections" );
		die();
	
		break;
	
	//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

	case 'sections del':
		$idSection = $_GET['id'];

		// Test if this section has no childs linked
		// Maybe think about an orphanhood ? [JOKE]

		$db_query = $dbh->query("
			SELECT COUNT(*)
			FROM ".DBNAME.".".DBPREFIX."sections
			WHERE `idParent` = ".$dbh->quote($idSection)."
			;");

		$rowCount = $db_query->fetchColumn();

		if ($rowCount >= 1) {
			$_SESSION['msg1'] = 'Erreur lors de la suppression !';
			$_SESSION['msg2'] = 'Une ou plusieurs sections sont associées à celle-ci et doivent être auparavant supprimées.';
			$_SESSION['msg-type'] = 'danger';
			header( "Location: dashboard.php?view=".'sections' );
			die();		
		}

		// Test if there are no articles linked to this section

		$db_query = $dbh->query("
			SELECT COUNT(*)
			FROM ".DBNAME.".".DBPREFIX."articles
			WHERE `idSection` = ".$dbh->quote($idSection)."
			;");

		$rowCount = $db_query->fetchColumn();

		if ($rowCount >= 1) {
			$_SESSION['msg1'] = 'Erreur lors de la suppression !';
			$_SESSION['msg2'] = 'Un ou plusieurs articles sont liés à cette section et doivent être auparavant changés de section.';
			$_SESSION['msg-type'] = 'danger';
			header( "Location: dashboard.php?view=".'sections' );
			die();
		}

		// Tests successfully passed
		// Ready for deletion

		$db_query = $dbh->prepare( "DELETE FROM ".DBNAME.".".DBPREFIX."sections WHERE id = :id" );
		$db_query->bindValue(':id', $idSection);
		$db_query->execute();

		// REDIRECT
		$_SESSION['msg1'] = 'Section Supprimée !';
		$_SESSION['msg2'] = '';
		$_SESSION['msg-type'] = 'success';
		header( "Location: dashboard.php?view="."sections" );
		die();

		break;

	//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

	case 'medias del':
		$filename = $_GET['filename'];
	
		if (!empty($filename)) {
			if (file_exists(UPLOADS_DIR . $filename)) {
				// http://fr2.php.net/manual/en/function.unlink.php#85938
				
				$cwd = getcwd(); // Save the current directory
				chdir( UPLOADS_DIR );
				unlink( $filename ); // Delete the file
				chdir( $cwd ); // Restore the old working directory
				unset($cwd);
			}
		}
	
		// REDIRECT
		$_SESSION['msg1'] = 'Fichier supprimé !';
		$_SESSION['msg2'] = '';
		$_SESSION['msg-type'] = 'success';
		header( "Location: dashboard.php?view="."medias" );
		die();
	
		break;
	
		//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+


	case 'config edit':
		$name = $_POST['name'];
		$template = $_POST['template'];

		if (empty($name)) {
			$name = 'Chicken Management System';
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
		$_SESSION['msg1'] = 'Nouvelle configuration appliquée !';
		$_SESSION['msg2'] = '';
		$_SESSION['msg-type'] = 'success';
		header( "Location: dashboard.php?view="."configuration" );
		die();
	
		break;

	//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

	default:
		exit('<h1><b>Error: unknown task !</b></h1>');
}

?>