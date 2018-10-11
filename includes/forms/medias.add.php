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
						<legend>
							Extensions autorisées : 'png', 'jpg', 'gif', 'zip'
						</legend>
						<form id="upload" method="post" action="upload.process.php" enctype="multipart/form-data">
							<div id="drop">
								Drop Here
				
								<a>Browse</a>
								<input type="file" name="upl" multiple />
							</div>
				
							<ul>
								<!-- The file uploads will be shown here -->
							</ul>
						</form>
