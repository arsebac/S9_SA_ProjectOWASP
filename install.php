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

//Set Install Mode
define('INSTALL_MODE', TRUE);

require( realpath(dirname(__FILE__)).'/conf.inc.php' );
require( PROJECT_DIR.'/includes.inc.php' );

?>
<!DOCTYPE html>
<html lang="fr_FR">
	<head>
		<meta charset="utf-8">
		<title>OWASP - Open Web Application Security Project - INSTALLER</title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Javascript -->
			<script src="./bootstrap/js/jquery.js"></script>
			<script src="./bootstrap/js/bootstrap.min.js"></script>
			<script src="./bootstrap/js/jquery.dataTables.min.js"></script>
			<script src="./bootstrap/js/go-to-top.js"></script>
		<!-- Style -->
			<!-- Boostrap -->
			<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
			<link href="./bootstrap/css/go-to-top.css" rel="stylesheet">
		<!-- Favicon -->
			<link rel="shortcut icon" href="./bootstrap/img/favicon.ico">
	</head>

	<body>
		<div class="container">
			<div class="page-header">
				<h1>CMS INSTALL SCRIPT&nbsp;<small></small></h1>
			</div>

			<!-- CONTENTS -->
			<div class="alert alert-block">
				<h4 class="alert-heading">MySQL</h4>
<?php

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

// Generate MySQL Scheme

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

try {
	// Connect to MySQL
	$dbh = new PDO('mysql:host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASSWORD);

	// Set ERRORMODE to exceptions
	$dbh->setAttribute(PDO::ATTR_ERRMODE,
					  PDO::ERRMODE_EXCEPTION);

	// --------------------------------------------------------

	/*
	--
	-- Structure de la table `user`
	--
	*/
	
	$dbh->exec( "DROP TABLE IF EXISTS `".DBPREFIX."user`" );
	$dbh->exec( "
CREATE TABLE IF NOT EXISTS `".DBPREFIX."user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(45) NOT NULL,
  `login` varchar(45) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
" );

	/*
	--
	-- Contenu de la table `user`
	--
	*/

	$dbh->exec( "
INSERT INTO `".DBPREFIX."user` (`id`, `role`,`login`, `firstname`, `lastname`, `password`, `mail`) VALUES
(1, 'Administrator', 'admin', '', '', 'password', 'admin@localdomain');
" );

    $dbh->exec( "
INSERT INTO `".DBPREFIX."user` (`id`, `role`,`login`, `firstname`, `lastname`, `password`, `mail`) VALUES
(2, 'Administrator', 'alice', 'Alice', '', 'password', 'alice@localdomain');
" );

    $dbh->exec( "
INSERT INTO `".DBPREFIX."user` (`id`, `role`,`login`, `firstname`, `lastname`, `password`, `mail`) VALUES
(3, 'Regular', 'bob', 'Bob', '', 'password', 'bob@localdomain');
" );

    // --------------------------------------------------------

	/*
	--
	-- Structure de la table `config`
	--
	*/

	$dbh->exec( "DROP TABLE IF EXISTS `".DBPREFIX."config`" );
	$dbh->exec( "
CREATE TABLE IF NOT EXISTS `".DBPREFIX."config` (
  `setting` varchar(64) NOT NULL,
  `value` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`setting`),
  UNIQUE KEY `setting` (`setting`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
" );

	/*
	 --
	-- Contenu de la table `config`
	--
	*/

	$dbh->exec( "
INSERT INTO `".DBPREFIX."config` (`setting`, `value`) VALUES
('TEMPLATE', 'bootstrap.min.css'),
('TITLE', 'OWASP - Open Web Application Security Project');
" );
	
	// --------------------------------------------------------

	// Close file db connection
	$dbh = null;

	echo "Status: Ready !";
}
catch (PDOException $e) {
    echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine();
    die();
}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

?>
			</div>
			<!-- END: CONTENTS -->

			<!-- FOOTER -->
			<hr>
			<a href="#" class="go-top"><span class="glyphicon glyphicon-arrow-up"></span>&nbsp;Go Top</a>
            <footer>
                <div class="pull-left">
                    OWASP - Open Web Application Security Project - Copyright &copy; 2018
                </div>
                <div class="pull-right" style="text-align: right;">
					Joël CANCELA, Nikita ROUSSEAU, Francois MELKONIAN
                    <br>
                    Built with&nbsp;
                    <a target="_blank" href="http://getbootstrap.com/">Bootstrap</a>.
                </div>
            </footer>
			<!-- END: FOOTER -->
		</div><!--/container-->

	</body>
</html>
