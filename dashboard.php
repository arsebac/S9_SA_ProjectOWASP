<?php
/**
 * OWASAP - Open Web Application Security Project
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

$TITLE = 'Admin Dashboard';
$SUBTITLE = '';
$PAGE = 'dashboard';

require( realpath(dirname(__FILE__)).'/conf.inc.php' );
require( PROJECT_DIR.'/includes.inc.php' );

// Page
if (isset($_GET['view']))
{
	$VIEW = $_GET['view'];
	$SUBTITLE = ucfirst($VIEW);
}
else {
	$VIEW = '';
}

// Task
if (isset($_GET['task']))
{
	$TASK = $_GET['task'];
}
else {
	$TASK = '';
}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

require( STYLE_DIR.'/header.inc.php' );
require( STYLE_DIR.'/notifications.inc.php' );

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

switch ($VIEW)
{
    //--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

	case 'config':
		require(VIEWS_DIR.'config'.'.'.'edit'.'.php');
		break;

	//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
				
	// Default dashboard
	// Home
	default:
?>

					<div>
						<legend>
							&nbsp;Welcome on <i>OWASAP - Open Web Application Security Project</i>, <a href="#"><?php echo htmlspecialchars($_SESSION['adminName']); ?></a>
						</legend>
					</div>

					<div class="bs-glyphicons">
						<ul class="bs-glyphicons-list">
							<li href="#" onclick="dashboardLocation('config')" type="button">
								<span class="glyphicon glyphicon-wrench"></span>
								<span class="glyphicon-class">Configuration Panel</span>
							</li>
						</ul>
					</div>

					<script>
					function dashboardLocation( location )
					{
						window.location.href='dashboard.php?view='+location;
					}
					</script>

<?php
		break;

}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

require( STYLE_DIR.'/footer.inc.php' );

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

?>