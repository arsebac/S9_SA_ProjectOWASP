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

require( realpath(dirname(__FILE__)).'/conf.inc.php' );
require( PROJECT_DIR.'/includes.inc.php' );
$themes = new SimpleXMLElement(urldecode($_POST["value"]));
foreach ($themes->theme as $theme) {
    if(strpos($theme, '/') !== false || strpos($theme, '..') !== false  || !file_exists(TEMPLATES_DIR .$theme )){
        echo "ERROR";
        exit(1);
    }
}
echo "ok";
file_put_contents(CONF_DIR."conf.xml", $themes);