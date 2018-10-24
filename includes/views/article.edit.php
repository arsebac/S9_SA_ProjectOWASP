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
				FROM ".DBNAME.".".DBPREFIX."article
				WHERE id = :id
				;");

$sth->bindValue(':id', $idArticle);

$sth->execute();

$thisArticle = $sth->fetch(PDO::FETCH_ASSOC);

if (empty($thisArticle)) {
	exit('Bad article specified. This should never happen.');
}

// Author
$sth = $dbh->prepare("
			SELECT *
			FROM ".DBNAME.".".DBPREFIX."user
			WHERE id = " . $thisArticle['idAuthor'] . "
			;");
$sth->execute();
$author = $sth->fetch(PDO::FETCH_ASSOC);

?>
					<fieldset>
						<legend>Editer un article</legend>
						<div class="row">
							<form action="process.php" method="post" role="form">
								<div class="col-md-9">
									<input type="hidden" name="task" value="article edit" />
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
											<textarea class="form-control" rows="10" id="body" name="body"><?php echo htmlspecialchars($thisArticle['body']); ?></textarea>
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
											<?php echo htmlspecialchars($author['login']); ?><br/><br/>
											<input type="hidden" name="idAuthor" value="<?php echo htmlspecialchars($thisArticle['idAuthor']); ?>" />
											<b>Date :</b><br/>
											<?php echo date("l | F j, Y | H:i"); ?>
										</div>
									</div>
								</div>
							</form>
						</div>
					</fieldset>
