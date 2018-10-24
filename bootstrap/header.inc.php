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

//Prevent direct access
if (!defined('LICENSE'))
{
	exit('Access Denied');
}

?>
<!DOCTYPE html>
<html lang="fr_FR">
	<head>
		<meta charset="utf-8">
		<title><?php echo TITLE; ?></title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Javascript -->
			<script src="./bootstrap/js/jquery.js"></script>
			<script src="./bootstrap/js/bootstrap.min.js"></script>
			<script src="./bootstrap/js/jquery.dataTables.min.js"></script>
			<script src="./bootstrap/js/go-to-top.js"></script>
		<!-- Style -->
			<!-- Boostrap -->
			<link href="./bootstrap/css/themes/<?php echo TEMPLATE; ?>" rel="stylesheet">
			<link href="./bootstrap/css/dashboard.css" rel="stylesheet">
			<link href="./bootstrap/css/go-to-top.css" rel="stylesheet">
		<!-- Favicon -->
			<link rel="shortcut icon" href="./bootstrap/img/favicon.ico">
	</head>


	<body>
		<nav class="navbar navbar-default" role="navigation">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-bgpanel">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="./">OWASP - Open Web Application Security Project</a>
			</div>

			<!-- START: navbar-collapse -->

			<div class="collapse navbar-collapse" id="navbar-bgpanel">
<?php

/**
 * "Navigation Bar"
 */
if ($PAGE != 'login' && $PAGE != 'register')
{
?>
				<ul class="nav navbar-nav">
					<li <?php
	if (($PAGE == 'dashboard') && (empty($VIEW)))
	{
		echo "class=\"active\"";
	}
?>>
						<a href="dashboard.php">
							<span class="glyphicon glyphicon-dashboard"></span>
							&nbsp;Dashboard
						</a>
					</li>
                    <?php

                    if (session_status() != PHP_SESSION_NONE && unserialize($_SESSION['user'])['role'] == 'Administrator') {
                    ?>
                    <li>
                        <?php echo generateNavigationLi('apikey', 'glyphicon-pushpin'); ?>
                    </li>
                    <li <?php
                    if (($PAGE == 'dashboard') && ($VIEW == 'config'))
                    {
                        echo "class=\"active\"";
                    }
                    ?>><?php echo generateNavigationLi('config', 'glyphicon-wrench'); ?></li>
                    <?php
                    }

                    ?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="login.process.php?task=logout"><span class="glyphicon glyphicon-off"></span>&nbsp;Sign Out</a>
					</li>
				</ul>
<?php
}

/**
 * End of "Navigation Bar"
 */

?>
			</div>

			<!-- END: navbar-collapse -->

		</nav>

		<!--
		  - -
		  - - MAIN-CONTAINER
		  - -
		  -->

		<div class="container" style="width: 1366px;">

<?php

/**
 * "Breadcrumb"
 */
if ($PAGE != 'login' && $PAGE != 'register')
{
?>

			<!-- Start: Breadcrumb (navigation) -->

			<ol class="breadcrumb">
				<li><a href="dashboard.php">Home</a></li>
<?php 

	// Level 2 - Category
	if (!empty($VIEW))
	{
		echo "\t\t\t\t<li><a href=\"dashboard.php?view=" . urlencode($VIEW) . "\">". htmlspecialchars( ucfirst( $VIEW ) )."</a></li>\r\n";
	}

	// Level 3 - Action
	if (!empty($VIEW) && !empty($TASK))
	{
		echo "\t\t\t\t<li class=\"active\"><a href=\"dashboard.php?view=" . urlencode($VIEW) . "&amp;task=" . urlencode($TASK) . "\">". htmlspecialchars( ucfirst( $TASK ) )."</a></li>\r\n";
	}

}
/**
 * End of "Breadcrumb"
 */

?>
			</ol>

			<!-- End: Breadcrumb (navigation) -->

			<div class="row">

				<!--
				  - -
				  - - START: CONTENTS
				  - -
				  -->

				<div class="col-md-12">

					<div class="page-header">
						<h1><?php if (!empty($TITLE)) { echo $TITLE; } ?>&nbsp;<small><?php if (!empty($SUBTITLE)) { echo $SUBTITLE; } ?></small></h1>
					</div>

