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
					<fieldset>
						<legend>Modification des paramètres de l'application</legend>
						<div class="row">
							<form action="process.php" method="post" role="form">
								<div class="col-md-12">
									<input type="hidden" name="task" value="config edit" />
		
									<div class="row">
										<div class="form-group col-xs-12">
											<label for="name">Nom du site</label>
											<input type="text" class="form-control" id="name" name="name" value="<?php echo TITLE; ?>">
										</div>
									</div>

									<div class="form-group">
										<label for="template">Thème</label>
										<select class="form-control" id="template" name="template">
											<optgroup label="Thèmes Disponibles">
<?php 

// Get templates

$templates = array();
$handle = opendir(TEMPLATES_DIR);

if ($handle) {
	while (false !== ($template = readdir($handle))) {
		// Strip out . and ..
		if ( ($template != '.') && ($template != '..') ) {
			$parts = explode('.', $template);
			$templates[ucfirst($parts[0])] = $template;
		}
	}

	closedir($handle);
}

// Display list

foreach ($templates as $name => $filename) {
	if ($filename == TEMPLATE) {
?>
												<option value="<?php echo $filename; ?>" selected><?php echo $name; ?></option>
<?php
	}
	else {
?>
												<option value="<?php echo $filename; ?>"><?php echo $name; ?></option>
<?php
	}
}

?>
											</optgroup>
										</select>
									</div>

									<div class="row">
										<div class="form-group col-xs-12">
											<button type="submit" class="btn btn-primary">Valider</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</fieldset>
