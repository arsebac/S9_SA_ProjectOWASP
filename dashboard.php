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
	case 'utilisateurs':
		switch ($TASK)
		{
			case 'add':
				require(FORMS_DIR.'utilisateurs'.'.'.'add'.'.php');
				break;
			
			case 'edit':
				break;

			default:
				break;
		}
		break;

	//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

	case 'articles':
		switch ($TASK)
		{
			case 'add':
				require(FORMS_DIR.'articles'.'.'.'add'.'.php');
				break;
					
			case 'edit':
				require(FORMS_DIR.'articles'.'.'.'edit'.'.php');
				break;
		
			default:
				// Display management panel
				
				// Get articles
				$sth = $dbh->prepare("
				SELECT id, title, published, allowComments, date, idAuthor, idSection
				FROM ".DBNAME.".".DBPREFIX."articles
				;");
				
				$sth->execute();
				
				$articles = $sth->fetchAll(PDO::FETCH_ASSOC);
?>
					<div class="table-responsive">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th width="48">#</th>
									<th>Titre</th>
									<th>Date</th>
									<th>Auteur</th>
									<th>Section</th>
									<th>Autoriser les commentaires</th>
									<th width="32">Publié</th>
									<th width="160">Actions</th>
								</tr>
							</thead>
							<tbody>
<?php 

				if (!empty($articles))
				{
					foreach ($articles as $article)
					{
						// Get author, assoc section, comments and publication policy

						// Author
						$sth = $dbh->prepare("
							SELECT name
							FROM ".DBNAME.".".DBPREFIX."admins
							WHERE id = " . $article['idAuthor'] . "
							;");
						$sth->execute();
						$author = $sth->fetch(PDO::FETCH_ASSOC);

						// Section
						$sth = $dbh->prepare("
							SELECT name
							FROM ".DBNAME.".".DBPREFIX."sections
							WHERE id = " . $article['idSection'] . "
							;");
						$sth->execute();
						$section = $sth->fetch(PDO::FETCH_ASSOC);

						if ($section['name'] == FALSE) {
							$section['name'] = 'Aucune';
						}

						// Comments policy
						if ($article['allowComments'] == '1') {
							$comments = 'Oui';
						}
						else {
							$comments = 'Non';
						}
						
						// Publication policy
						if ($article['published'] == '1') {
							$pub = 'Oui';
						}
						else {
							$pub = 'Non';
						}
						
?>
								<tr>
									<td><?php echo $article['id']; ?></td>
									<td><?php echo htmlspecialchars($article['title']); ?></td>
									<td><?php echo htmlspecialchars($article['date']); ?></td>
									<td><?php echo htmlspecialchars($author['name']); ?></td>
									<td><?php echo htmlspecialchars($section['name']); ?></td>
									<td><?php echo htmlspecialchars($comments); ?></td>
									<td><?php echo htmlspecialchars($pub); ?></td>
									<td>
										<a href="dashboard.php?view=articles&amp;task=edit&amp;id=<?php echo $article['id']; ?>" type="button" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit"></span>&nbsp;Editer</a>&nbsp;
										<a href="#" onclick="deleteArticle('<?php echo $article['id']; ?>', '<?php echo htmlspecialchars($article['title']); ?>')" type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span>&nbsp;Supprimer</a>
									</td>
								</tr>
<?php
					}
				}

				unset($articles);

?>
							</tbody>
						</table>
					</div>

					<script>
					function deleteArticle( id, name )
					{
						if (confirm("Supprimer "+name+" ?"))
						{
							window.location.href='process.php?task=articles%20del&id='+id;
						}
					}
					</script>

<?php
				break;
		}
		break;

	//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
	
	case 'sections':
		switch ($TASK)
		{
			case 'add':
				require(FORMS_DIR.'sections'.'.'.'add'.'.php');
				break;
					
			case 'edit':
				require(FORMS_DIR.'sections'.'.'.'edit'.'.php');
				break;
		
			default:
				// Display management panel

				// Get parents sections
				$sth = $dbh->prepare("
				SELECT id, name, description, idParent
				FROM ".DBNAME.".".DBPREFIX."sections
				WHERE idParent IS NULL OR idParent = 0
				;");
				
				$sth->execute();

				$sections = $sth->fetchAll(PDO::FETCH_ASSOC);
?>
					<div class="table-responsive">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th width="100">Arbre Hiérarchique</th>
									<th width="48">#</th>
									<th>Nom</th>
									<th>Description</th>
									<th width="160">Actions</th>
								</tr>
							</thead>
							<tbody>
<?php 

				if (!empty($sections))
				{
					foreach ($sections as $section)
					{
						// Display parent first
?>
								<!-- Parent -->
								<tr>
									<td><span class="glyphicon glyphicon-tree-deciduous"></span></td>
									<td><?php echo $section['id']; ?></td>
									<td><?php echo htmlspecialchars($section['name']); ?></td>
									<td><?php echo htmlspecialchars($section['description']); ?></td>
									<td>
										<a href="dashboard.php?view=sections&amp;task=edit&amp;id=<?php echo $section['id']; ?>" type="button" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit"></span>&nbsp;Editer</a>&nbsp;
										<a href="#" onclick="deleteSection('<?php echo $section['id']; ?>', '<?php echo htmlspecialchars($section['name']); ?>')" type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span>&nbsp;Supprimer</a>
									</td>
								</tr>
								<!-- End: Parent -->
<?php

						#################

						// Display childs
						$sth = $dbh->prepare("
										SELECT id, name, description
										FROM ".DBNAME.".".DBPREFIX."sections
										WHERE idParent = " . $section['id'] . "
										;");
						
						$sth->execute();

						$childs = $sth->fetchAll(PDO::FETCH_ASSOC);

						if (!empty($childs))
						{
							foreach ($childs as $child)
							{
?>
								<!-- Child -->
								<tr>
									<td><span style="margin-left: 5px;">|--</span></span><span class="glyphicon glyphicon glyphicon-leaf"></span></td>
									<td><?php echo $child['id']; ?></td>
									<td><?php echo htmlspecialchars($child['name']); ?></td>
									<td><?php echo htmlspecialchars($child['description']); ?></td>
									<td>
										<a href="dashboard.php?view=sections&amp;task=edit&amp;id=<?php echo $child['id']; ?>" type="button" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit"></span>&nbsp;Editer</a>&nbsp;
										<a href="#" onclick="deleteSection('<?php echo $child['id']; ?>', '<?php echo htmlspecialchars($child['name']); ?>')" type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span>&nbsp;Supprimer</a>
									</td>
								</tr>
								<!-- End: Child -->
<?php
							}
						}

						unset($childs);
					}
				}

				unset($sections);

?>
							</tbody>
						</table>
					</div>

					<script>
					function deleteSection( id, name )
					{
						if (confirm("Supprimer "+name+" ?"))
						{
							window.location.href='process.php?task=sections%20del&id='+id;
						}
					}
					</script>

<?php
				break;
		}
		break;

	//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
	
	case 'commentaires':
		switch ($TASK)
		{
			case 'edit':
				break;
		
			default:
				break;
		}
		break;

	//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
	
	case 'medias':
		switch ($TASK)
		{
			case 'add':
				require(FORMS_DIR.'medias'.'.'.'add'.'.php');
				break;
		
			default:
				// Display management panel

				// Get uploaded files
				
				$files = array();
				$handle = opendir(UPLOADS_DIR);
				
				if ($handle) {
					while (false !== ($file = readdir($handle))) {
						// Strip out . and ..
						if ( ($file != '.') && ($file != '..') && ($file != 'index.html') ) {
							$files[] = $file;
						}
					}
				
					closedir($handle);
				}				
?>
					<div class="table-responsive">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th width="16"></th>
									<th>Nom du Fichier</th>
									<th>URL</th>
									<th width="160">Actions</th>
								</tr>
							</thead>
							<tbody>
<?php

				if (!empty($files))
				{
					foreach ($files as $key => $filename)
					{
						// Get File Extension
						$extension = pathinfo(UPLOADS_DIR . $filename, PATHINFO_EXTENSION);

						// Select correct glyphicon
						switch ($extension)
						{
							case 'png':
							case 'jpg':
							case 'gif':
								$icon = 'glyphicon glyphicon-picture';
								break;
							
							default:
								$icon = 'glyphicon glyphicon-file';
								break;
						}

						// Build real URL
						$pageURL = 'http';
						
						if (@$_SERVER["HTTPS"] == "on")
						{
							$pageURL .= "s";
						}
						
						$pageURL .= "://";
						
						if ($_SERVER["SERVER_PORT"] != "80")
						{
							$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
						}
						else
						{
							$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
						}
						
						$url = substr($pageURL, 0, -25);
						$url = $url . 'uploads/' . $filename;
?>
								<tr>
									<td><span class="<?php echo $icon; ?>"></span></td>
									<td><?php echo $filename; ?></td>
									<td><a href="<?php echo $url; ?>"><?php echo $filename; ?></a></td>
									<td>
										<a href="#" onclick="deleteMedia('<?php echo $filename; ?>')" type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span>&nbsp;Supprimer</a>
									</td>
								</tr>
<?php
					}
				}

				unset($files);

?>
							</tbody>
						</table>
					</div>

					<script>
					function deleteMedia( filename )
					{
						if (confirm("Supprimer "+filename+" ?"))
						{
							window.location.href='process.php?task=medias%20del&filename='+filename;
						}
					}
					</script>

<?php
				break;
		}
		break;

	//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
	
	case 'configuration':
		require(FORMS_DIR.'config'.'.'.'edit'.'.php');
		break;

	//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
				
	// Default dashboard
	// Home
	default:
?>

					<div>
						<legend>
							<img src="./bootstrap/img/chicken-icon.png" width="32px">
							&nbsp;Bienvenue sur <i>Chicken Management System</i>, <a href="#"><?php echo htmlspecialchars($_SESSION['adminName']); ?></a>
						</legend>
					</div>

					<div class="bs-glyphicons">
						<ul class="bs-glyphicons-list">
							<li href="#" onclick="dashboardLocation('utilisateurs')" type="button">
								<span class="glyphicon glyphicon-user"></span>
								<span class="glyphicon-class">Gestion des utilisateurs</span>
							</li>
							<li href="#" onclick="dashboardLocation('articles')" type="button">
								<span class="glyphicon glyphicon-globe"></span>
								<span class="glyphicon-class">Gestion des publications</span>
							</li>
							<li href="#" onclick="dashboardLocation('sections')" type="button">
								<span class="glyphicon glyphicon-th-large"></span>
								<span class="glyphicon-class">Gestion des sections</span>
							</li>
							<li href="#" onclick="dashboardLocation('commentaires')" type="button">
								<span class="glyphicon glyphicon-comment"></span>
								<span class="glyphicon-class">Modération des commentaires</span>
							</li>
							<li href="#" onclick="dashboardLocation('medias')" type="button">
								<span class="glyphicon glyphicon-film"></span>
								<span class="glyphicon-class">Gestionnaire de médias</span>
							</li>
							<li href="#" onclick="dashboardLocation('configuration')" type="button">
								<span class="glyphicon glyphicon-wrench"></span>
								<span class="glyphicon-class">Panneau de configuration</span>
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