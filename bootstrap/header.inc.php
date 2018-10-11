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
			<script src="./bootstrap/ckeditor/ckeditor.js"></script>
			<script src="./bootstrap/js/jquery.knob.js"></script>
			<script src="./bootstrap/js/jquery.ui.widget.js"></script>
			<script src="./bootstrap/js/jquery.iframe-transport.js"></script>
			<script src="./bootstrap/js/jquery.fileupload.js"></script>
			<script src="./bootstrap/js/uploader.js"></script>
		<!-- Style -->
			<!-- Boostrap -->
			<link href="./bootstrap/css/themes/<?php echo TEMPLATE; ?>" rel="stylesheet">
			<link href="./bootstrap/css/dashboard.css" rel="stylesheet">
			<link href="./bootstrap/css/go-to-top.css" rel="stylesheet">
			<link href="./bootstrap/css/ckeditor.css" rel="stylesheet">
			<link href="./bootstrap/css/uploader.css" rel="stylesheet">
		<!-- Google web fonts -->
			<link href="http://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700" rel='stylesheet'>
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
		<nav class="navbar navbar-default" role="navigation">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-bgpanel">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Chicken.Management.System</a>
			</div>

			<!-- START: navbar-collapse -->

			<div class="collapse navbar-collapse" id="navbar-bgpanel">
<?php

/**
 * "Navigation Bar"
 */
if ($PAGE != 'login')
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

					<li <?php
	if (($PAGE == 'dashboard') && ($VIEW == 'utilisateurs'))
	{
		echo "class=\"active\"";
	}
?>><?php echo generateNavigationLi('utilisateurs', 'glyphicon-user'); ?></li>

					<li <?php
	if (($PAGE == 'dashboard') && ($VIEW == 'articles'))
	{
		echo "class=\"active\"";
	}
?>><?php echo generateNavigationLi('articles', 'glyphicon-file'); ?></li>

					<li <?php
	if (($PAGE == 'dashboard') && ($VIEW == 'sections'))
	{
		echo "class=\"active\"";
	}
?>><?php echo generateNavigationLi('sections', 'glyphicon-th'); ?></li>

					<li <?php
	if (($PAGE == 'dashboard') && ($VIEW == 'commentaires'))
	{
		echo "class=\"active\"";
	}
?>><?php echo generateNavigationLi('commentaires', 'glyphicon-comment'); ?></li>

					<li <?php
	if (($PAGE == 'dashboard') && ($VIEW == 'medias'))
	{
		echo "class=\"active\"";
	}
?>><?php echo generateNavigationLi('medias', 'glyphicon-film'); ?></li>

					<li <?php
	if (($PAGE == 'dashboard') && ($VIEW == 'configuration'))
	{
		echo "class=\"active\"";
	}
?>><?php echo generateNavigationLi('configuration', 'glyphicon-wrench'); ?></li>

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
if ($PAGE != 'login')
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

<?php

/*
 * SIDEBAR
 */
if ($PAGE != 'login')
{
?>
				<!-- Start: Sidebar -->

				<div class="col-md-3">
					<div id="sidebar" data-spy="affix" data-offset-top="50" data-offset-bottom="200">
						<div class="panel panel-primary">
							<div class="panel-heading"><span class="glyphicon glyphicon-th-list"></span>&nbsp;Sidebar</div>					
							<div class="panel-body">
								<ul class="nav nav-pills nav-stacked">
									<li>
									  	<a href="dashboard.php?view=utilisateurs&amp;task=add">
											<span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;&nbsp;Ajouter un utilisateur
										</a>
									</li>
									<li>
									 	<a href="dashboard.php?view=articles&amp;task=add">
											<span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;&nbsp;Ajouter un article
										</a>
									</li>
									<li>
										<a href="dashboard.php?view=sections&amp;task=add">
											<span class="glyphicon glyphicon-th-large"></span>&nbsp;&nbsp;&nbsp;Ajouter une section
										</a>
									</li>
									<li>
										<a href="dashboard.php?view=medias&amp;task=add">
											<span class="glyphicon glyphicon-picture"></span>&nbsp;&nbsp;&nbsp;Ajouter un media
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>

				<!-- End: Sidebar -->

<?php
}
/*
 * END: SIDEBAR
 */

?>

				<!--
				  - -
				  - - START: CONTENTS
				  - -
				  -->

<?php

if ($PAGE != 'login') {
?>
				<div class="col-md-9">
<?php
}
else {
?>
				<div class="col-md-12">
<?php
}

?>
					<div class="page-header">
						<h1><?php if (!empty($TITLE)) { echo $TITLE; } ?>&nbsp;<small><?php if (!empty($SUBTITLE)) { echo $SUBTITLE; } ?></small></h1>
					</div>

