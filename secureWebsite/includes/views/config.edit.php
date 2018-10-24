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
											<input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars(TITLE, ENT_QUOTES); ?>">
										</div>
									</div>

                                    <div class="form-group">
										<label for="template">Theme</label>
                                    </div>
                                    <div class="form-row">
										<select class="form-control" id="template" name="template">
											<optgroup label="Available Themes">
<?php 

// Get templates

$templates = array();

$xmlfile = file_get_contents(CONF_DIR."conf.xml",true);
try{
$dom = new DOMDocument();
$dom->loadXML($xmlfile);
$themes = simplexml_import_dom($dom);
foreach ($themes as $theme){
    $parts = explode('.', $theme);
    $templates[ucfirst($parts[0])] = $theme;
}
    } catch (Exception $e) {
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
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


                                        <div class="col-auto">

                                            <button type="button" href="#"  data-toggle="modal" data-target="#exampleModal">Edit</button>
                                        </div>
									</div>

									<div class="row">
										<div class="form-group col-xs-12">
											<button type="submit" class="btn btn-primary">Apply</button>
										</div>
									</div>
								</div>
							</form>
						</div>
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit website style</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h2>Actual configuration</h2>
                                        <textarea name="conf" id="new-conf" cols="40" rows="15"><?php echo filter_var ( file_get_contents("conf/conf.xml"), FILTER_SANITIZE_FULL_SPECIAL_CHARS); ?></textarea>
                                        <h3>Default configuration</h3>
                                        <textarea name="conf" cols="40" rows="15" readonly><?php echo file_get_contents("conf/conf.default.xml", true); ?></textarea>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" onclick="updateConf()">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </fieldset>
                    <script>
                        function updateConf() {
                            var value = document.getElementById("new-conf").value;
                            var xhr = new XMLHttpRequest();
                            xhr.open("POST", 'template.php', true);

                            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                            xhr.onreadystatechange = function() {//Call a function when the state changes.
                                if(this.readyState == XMLHttpRequest.DONE && this.status == 200) {
                                    console.log(this.responseText );
                                    if(this.responseText === "ok"){

                                        $('#exampleModal').modal('hide');
                                    }else{
                                        alert("La configuration n'est pas conforme.");
                                    }
                                }
                            }
                            xhr.send("value="+encodeURI(value));
                        }
                    </script>