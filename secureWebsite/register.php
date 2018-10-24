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

$TITLE = 'User Registration';
$SUBTITLE = '';
$PAGE = 'register';

require( realpath(dirname(__FILE__)).'/conf.inc.php' );
require( PROJECT_DIR.'/includes/func.inc.php' );

/**
 * MySQL connection
 */
try {
    // Connect to MySQL
    $dbh = new PDO('mysql:host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASSWORD);

    // Set errormode to exceptions
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine();
    die();
}

/**
 * Retrieve more configuration settings from the MySQL database
 */
try {
    $sth = $dbh->prepare("
			SELECT *
			FROM ".DBNAME.".".DBPREFIX."config
			;");

    $sth->execute();
    $settings = $sth->fetchAll(PDO::FETCH_ASSOC);

    foreach ($settings as $setting) {
        define( $setting['setting'], $setting['value'] );
    }

    unset($settings, $dbh);
}
catch (PDOException $e) {
    echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine();
    die();
}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

require( STYLE_DIR.'/header.inc.php' );

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

?>
                    <fieldset>
						<legend>Register as a new user</legend>
						<div class="row">
							<form action="register.process.php" method="post" role="form">
								<div class="col-md-9">
									<input type="hidden" name="task" value="user add" />

									<div class="row">
										<div class="form-group col-xs-12">
											<label for="login">Login</label>
											<input type="text" class="form-control" id="login" name="login" value="" required>
										</div>
									</div>

                                    <div class="row">
                                        <div class="form-group col-xs-12">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" value="" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-xs-12">
                                            <label for="firstname">Firstname</label>
                                            <input type="text" class="form-control" id="firstname" name="firstname" value="">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-xs-12">
                                            <label for="lastname">Lastname</label>
                                            <input type="text" class="form-control" id="lastname" name="lastname" value="">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-xs-12">
                                            <label for="email">Email</label>
                                            <input type="text" class="form-control" id="email" name="email" value="" required>
                                        </div>
                                    </div>

									<div class="row">
										<div class="form-group col-xs-12">
											<button type="submit" class="btn btn-primary">Register</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</fieldset>

<?php


//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

require( STYLE_DIR.'/footer.inc.php' );

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

?>