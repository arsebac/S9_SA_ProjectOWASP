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

//Set Install Mode
define('INSTALL_MODE', TRUE);

require( realpath(dirname(__FILE__)).'/conf.inc.php' );
require( PROJECT_DIR.'/includes.inc.php' );

?>
<!DOCTYPE html>
<html lang="fr_FR">
	<head>
		<meta charset="utf-8">
		<title>Chicken Management System</title>

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
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
			<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
			<!--[if lt IE 9]>
			  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
			<![endif]-->
		<!-- Favicon -->
			<link rel="shortcut icon" href="./bootstrap/img/favicon.ico">
			<style type="text/css">
			#logs_previous {
				margin-right: 16px;
			}
			</style>
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
	-- Structure de la table `articles`
	--
	*/

	$dbh->exec( "DROP TABLE IF EXISTS `".DBPREFIX."articles`" );
	$dbh->exec( "
CREATE TABLE IF NOT EXISTS `".DBPREFIX."articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100),
  `header` longtext,
  `body` longtext,
  `footer` longtext,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `allowComments` int(1) NOT NULL DEFAULT '1',
  `date` timestamp NULL DEFAULT NULL,
  `idAuthor` int(11) NOT NULL,
  `idSection` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
" );

	// --------------------------------------------------------

	/*
	--
	-- Structure de la table `sections`
	--
	*/

	$dbh->exec( "DROP TABLE IF EXISTS `".DBPREFIX."sections`" );
	$dbh->exec( "
CREATE TABLE IF NOT EXISTS `".DBPREFIX."sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `idParent` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
" );

	// --------------------------------------------------------

	/*
	--
	-- Structure de la table `users`
	--
	*/

	$dbh->exec( "DROP TABLE IF EXISTS `".DBPREFIX."users`" );
	$dbh->exec( "
CREATE TABLE IF NOT EXISTS `".DBPREFIX."users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(45) NOT NULL,
  `password` varchar(45) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
" );

	// --------------------------------------------------------

	/*
	--
	-- Structure de la table `admins`
	--
	*/
	
	$dbh->exec( "DROP TABLE IF EXISTS `".DBPREFIX."admins`" );
	$dbh->exec( "
CREATE TABLE IF NOT EXISTS `".DBPREFIX."admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(45) NOT NULL,
  `password` varchar(45) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
" );

	/*
	--
	-- Contenu de la table `admins`
	--
	*/

	$dbh->exec( "
INSERT INTO `".DBPREFIX."admins` (`id`, `login`, `password`, `name`, `mail`) VALUES
(1, 'admin', '6a3ac84c61d057862c987bd50b3280e9', 'Administrator', 'admin@minicms.org');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
" );

	/*
	 --
	-- Contenu de la table `config`
	--
	*/

	$dbh->exec( "
INSERT INTO `".DBPREFIX."config` (`setting`, `value`) VALUES
('TEMPLATE', 'bootstrap.min.css'),
('TITLE', 'Chicken Management System');
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
					Module M2105 - Copyright &copy; IUT Caen - Année universitaire 2013 - 2014
					<br>
					Toutes les images sont sous les licences de leurs propriétaires respectifs.
				</div>
				<div class="pull-right" style="text-align: right;">
					Réalisé par Simon MESNAGE &amp; Nikita Rousseau
					<br>
					Propulsé par
					<a target="_blank" href="http://getbootstrap.com/">Bootstrap</a>.
				</div>
			</footer>
			<!-- END: FOOTER -->
		</div><!--/container-->

	</body>
</html>
