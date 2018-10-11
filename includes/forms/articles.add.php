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

// Get available sections
$sth = $dbh->prepare("
				SELECT id, name
				FROM ".DBNAME.".".DBPREFIX."sections
				;");

$sth->execute();

$sections = $sth->fetchAll(PDO::FETCH_ASSOC);

?>
					<fieldset>
						<legend>Créer un article</legend>
						<div class="row">
							<form action="process.php" method="post" role="form">
								<div class="col-md-9">
									<input type="hidden" name="task" value="articles add" />
		
									<div class="row">
										<div class="form-group col-xs-12">
											<label for="title">Titre</label>
											<input type="text" class="form-control" id="title" name="title" value="">
										</div>
									</div>
									
									<div class="row">
										<div class="form-group col-xs-12">
											<label for="header">Header</label>
											<textarea class="form-control" rows="3" id="header" name="header"></textarea>
										</div>
									</div>
		
									<div class="row">
										<div class="form-group col-xs-12">
											<label for="body">Body</label>
											<textarea class="ckeditor" rows="10" id="body" name="body"></textarea>
										</div>
									</div>
		
									<div class="row">
										<div class="form-group col-xs-12">
											<label for="footer">Footer</label>
											<textarea class="form-control" rows="3" id="footer" name="footer"></textarea>
										</div>
									</div>
					
									<div class="row">
										<div class="form-group col-xs-12">
											<button type="submit" class="btn btn-primary">Publier</button>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="panel panel-default">
										<div class="panel-body">
											<b>Auteur :</b><br/>
											<?php echo htmlspecialchars($_SESSION['adminName']); ?><br/><br/>
											<b>Date :</b><br/>
											<?php echo date("l | F j, Y | H:i"); ?>
											<hr>
											<div class="form-group">
												<label for="section">Sections</label>
												<select class="form-control" id="section" name="section">
													<optgroup label="Aucune">
														<option value="0" >Aucune</option>
													</optgroup>
													<optgroup label="Sections Disponibles">
<?php 

if (!empty($sections)) {
	foreach ($sections as $section) {
?>
														<option value="<?php echo $section['id']; ?>" ><?php echo htmlspecialchars($section['name']); ?></option>
<?php
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
													<input name="allowComments" type="checkbox" value="1" checked>&nbsp;<b>Autoriser les Commentaires</b>
												</label>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</fieldset>
