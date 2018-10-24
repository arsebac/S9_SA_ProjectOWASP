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
						<legend>Créer un article</legend>
						<div class="row">
							<form action="process.php" method="post" role="form">
								<div class="col-md-9">
									<input type="hidden" name="task" value="article add" />
                                    <input type="hidden" name="idAuthor" value="<?php echo htmlspecialchars(unserialize($_SESSION['user'])['id'], ENT_QUOTES); ?>" />
		
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
											<textarea class="form-control" rows="10" id="body" name="body"></textarea>
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
											<?php echo htmlspecialchars(unserialize($_SESSION['user'])['login'], ENT_QUOTES); ?><br/><br/>
											<b>Date :</b><br/>
											<?php echo date("l | F j, Y | H:i"); ?>
										</div>
									</div>
								</div>
							</form>
						</div>
					</fieldset>
