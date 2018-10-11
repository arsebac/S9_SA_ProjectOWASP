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
 * @url			http://tutorialzine.com/2013/05/mini-ajax-file-upload-form/
 */

require( realpath(dirname(__FILE__)).'/conf.inc.php' );
require( PROJECT_DIR.'/includes.inc.php' );

// A list of permitted file extensions
$allowed = array('png', 'jpg', 'gif', 'zip');

if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){

	$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);

	if(!in_array(strtolower($extension), $allowed)){
		echo '{"status":"error"}';
		exit;
	}

	if(move_uploaded_file($_FILES['upl']['tmp_name'], UPLOADS_DIR . $_FILES['upl']['name'])){
		echo '{"status":"success"}';
		exit;
	}
}

exit('{"status":"error"}');