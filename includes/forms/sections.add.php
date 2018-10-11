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


// Get available parents sections
$sth = $dbh->prepare("
				SELECT id, name, idParent
				FROM ".DBNAME.".".DBPREFIX."sections
				WHERE idParent IS NULL OR idParent = 0
				;");

$sth->execute();

$sections = $sth->fetchAll(PDO::FETCH_ASSOC);

?>
					<fieldset>
						<legend>Créer une section</legend>
						<div class="row">
							<form action="process.php" method="post" role="form">
								<div class="col-md-9">
									<input type="hidden" name="task" value="sections add" />
		
									<div class="row">
										<div class="form-group col-xs-12">
											<label for="name">Nom</label>
											<input type="text" class="form-control" id="name" name="name" value="">
										</div>
									</div>
									
									<div class="row">
										<div class="form-group col-xs-12">
											<label for="description">Description</label>
											<textarea class="form-control" rows="3" id="description" name="description"></textarea>
										</div>
									</div>
					
									<div class="row">
										<div class="form-group col-xs-12">
											<button type="submit" class="btn btn-primary">Soumettre</button>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="panel panel-default">
										<div class="panel-body">
											<div class="form-group">
												<label for="parentSection">Section Parente</label>
												<select class="form-control" id="parentSection" name="parentSection">
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
										</div>
									</div>
								</div>
							</form>
						</div>
					</fieldset>
