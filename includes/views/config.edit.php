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

//Prevent direct access
if (!defined('LICENSE'))
{
	exit('Access Denied');
}

?>
					<fieldset>
						<legend>Application settings</legend>
						<div class="row">
							<form action="process.php" method="post" role="form">
								<div class="col-md-12">
									<input type="hidden" name="task" value="config edit" />
		
									<div class="row">
										<div class="form-group col-xs-12">
											<label for="name">Website Title</label>
											<input type="text" class="form-control" id="name" name="name" value="<?php echo TITLE; ?>">
										</div>
									</div>

									<div class="form-group">
										<label for="template">Theme</label>
										<select class="form-control" id="template" name="template">
											<optgroup label="Available Themes">
<?php 

// Get templates

$templates = array();
$handle = opendir(TEMPLATES_DIR);

if ($handle) {
	while (false !== ($template = readdir($handle))) {
		// Strip out . and ..
		if ( ($template != '.') && ($template != '..') ) {
			$parts = explode('.', $template);
			if (strpos($template, ".map")) {
                continue;
            }
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
											<button type="submit" class="btn btn-primary">Apply</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</fieldset>
