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


// Task
if (isset($_GET['id']))
{
	$idArticle = $_GET['id'];
}
else {
	exit('Invalid ArticleID');
}


// Get this article
$sth = $dbh->prepare("
				SELECT *
				FROM ".DBNAME.".".DBPREFIX."articles
				WHERE id = :id
				;");

$sth->bindValue(':id', $idArticle);

$sth->execute();

$thisArticle = $sth->fetch(PDO::FETCH_ASSOC);

if (empty($thisArticle)) {
	exit('Bad article specified. This should never happen.');
}

// Get author, assoc section, comments and publication policy

// Author
$sth = $dbh->prepare("
			SELECT name
			FROM ".DBNAME.".".DBPREFIX."admins
			WHERE id = " . $thisArticle['idAuthor'] . "
			;");
$sth->execute();
$author = $sth->fetch(PDO::FETCH_ASSOC);

// Get available sections
$sth = $dbh->prepare("
				SELECT id, name
				FROM ".DBNAME.".".DBPREFIX."sections
				;");
$sth->execute();
$sections = $sth->fetchAll(PDO::FETCH_ASSOC);

// Comments policy
if ($thisArticle['allowComments'] == '1') {
	$comments = TRUE;
}
else {
	$comments = FALSE;
}

// Publication policy
if ($thisArticle['published'] == '1') {
	$pub = TRUE;
}
else {
	$pub = FALSE;
}


?>
					<fieldset>
						<legend>Editer un article</legend>
						<div class="row">
							<form action="process.php" method="post" role="form">
								<div class="col-md-9">
									<input type="hidden" name="task" value="articles edit" />
									<input type="hidden" name="idArticle" value="<?php echo htmlspecialchars($thisArticle['id']); ?>" />

									<div class="row">
										<div class="form-group col-xs-12">
											<label for="title">Titre</label>
											<input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($thisArticle['title']); ?>">
										</div>
									</div>
									
									<div class="row">
										<div class="form-group col-xs-12">
											<label for="header">Header</label>
											<textarea class="form-control" rows="3" id="header" name="header"><?php echo htmlspecialchars($thisArticle['header']); ?></textarea>
										</div>
									</div>
		
									<div class="row">
										<div class="form-group col-xs-12">
											<label for="body">Body</label>
											<textarea class="ckeditor" rows="10" id="body" name="body"><?php echo htmlspecialchars($thisArticle['body']); ?></textarea>
										</div>
									</div>
		
									<div class="row">
										<div class="form-group col-xs-12">
											<label for="footer">Footer</label>
											<textarea class="form-control" rows="3" id="footer" name="footer"><?php echo htmlspecialchars($thisArticle['footer']); ?></textarea>
										</div>
									</div>
					
									<div class="row">
										<div class="form-group col-xs-12">
											<button type="submit" class="btn btn-primary">Editer</button>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="panel panel-default">
										<div class="panel-body">
											<b>Auteur :</b><br/>
											<?php echo htmlspecialchars($author['name']); ?><br/><br/>
											<input type="hidden" name="idAuthor" value="<?php echo htmlspecialchars($thisArticle['idAuthor']); ?>" />
											<b>Date :</b><br/>
											<?php echo date("l | F j, Y | H:i"); ?>
											<hr>
											<div class="form-group">
												<label for="section">Sections</label>
												<select class="form-control" id="section" name="section">
													<optgroup label="Aucune">
<?php 

if ($thisArticle['idSection'] == FALSE) {
?>
														<option value="0" selected>Aucune</option>
<?php
}
else {
?>
														<option value="0">Aucune</option>
<?php
}


?>
													</optgroup>
													<optgroup label="Sections Disponibles">
<?php 

if (!empty($sections)) {
	foreach ($sections as $section) {

		if ($section['id'] == $thisArticle['idSection']) {
?>
														<option value="<?php echo $section['id']; ?>" selected><?php echo htmlspecialchars($section['name']); ?></option>
<?php
		}
		else {
?>
														<option value="<?php echo $section['id']; ?>"><?php echo htmlspecialchars($section['name']); ?></option>
<?php
		}

	}
}
unset($sections);

?>
													</optgroup>
												</select>
											</div>
											<hr>
											<div class="checkbox">
												<label>
<?php

// Comments policy

if ($comments) {
?>
													<input name="allowComments" type="checkbox" value="1" checked>&nbsp;<b>Autoriser les Commentaires</b>													
<?php 
}
else {
?>
													<input name="allowComments" type="checkbox" value="0">&nbsp;<b>Autoriser les Commentaires</b>	
<?php
}

?>
												</label>
											</div>
											<div class="checkbox">
												<label>
<?php

// Publication policy

if ($pub) {
?>
													<input name="published" type="checkbox" value="1" checked>&nbsp;<b>Autoriser la Publication</b>											
<?php 
}
else {
?>
													<input name="published" type="checkbox" value="0">&nbsp;<b>Autoriser la Publication</b>
<?php
}

?>
												</label>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</fieldset>
