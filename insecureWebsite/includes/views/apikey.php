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

if (session_status() != PHP_SESSION_NONE && unserialize($_SESSION['user'])['role'] == 'Administrator') {
?>
    <div class="container">
        <div class="row">
            <div class="jumbotron" id="secret">
                <h1>API SECRET KEY</h1>
                <h3>Reserved To Administrators</h3>
                <p class="bg-info"><?php echo API_KEY; ?></p>
            </div>
        </div>
    </div>
<?php
}

?>
