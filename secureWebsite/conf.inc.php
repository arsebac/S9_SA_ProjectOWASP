<?php
//*************************************************************************************************

	### REQUIRED SETTINGS ###

	// <DO NOT CHANGE>
	define('LICENSE', 'GNU GENERAL PUBLIC LICENSE - Version 3, 29 June 2007');
	// </DO NOT CHANGE>

	// <DO NOT CHANGE>
	define('PROJECT_DIR', realpath(dirname(__FILE__)));
	define('CONF_DIR', PROJECT_DIR.'/conf/');
	define('STYLE_DIR', PROJECT_DIR.'/bootstrap/');
	define('TEMPLATES_DIR', STYLE_DIR.'/css/themes/');
	define('VIEWS_DIR', PROJECT_DIR.'/includes/views/');
	define('UPLOADS_DIR', PROJECT_DIR.'/uploads/');
	// </DO NOT CHANGE>

    /**
     * SECRET API KEY
     */
    define('API_KEY', 'b0955e13a8fb37eced8cee17a5ecd51f');

    /**
     * CMS General Configuration
     */
    // Salt used by the crypt function
    define('CRYPTOSALT', "Aqwn-jklm_p098!TGB1*23");

    /**
     * MySQL Configuration
     */
    // DBHOST is the MySQL Database Hostname
    define('DBHOST', "localhost");
    // DBNAME is the MySQL Database Name
    define('DBNAME', "owasp");
    // DBUSER is the MySQL Database Username
    define('DBUSER', "root");
    // DBPASSWORD is the MySQL Database Password
    define('DBPASSWORD', "");
    // DBPREFIX is the MySQL Table Prefix
    define('DBPREFIX', "cms_");

	/**
	 * DATE Configuration
	 * Sets the default timezone used by all date/time functions
	 * @link: http://php.net/manual/en/timezones.php
	 */
	date_default_timezone_set('Europe/Paris'); // Default: "Europe/London"

	/**
	 * ERROR Handling
	 * Sets which PHP errors are reported
	 * @link: http://php.net/manual/en/function.error-reporting.php
	 *
	 * Turn off all error reporting:
	 * error_reporting(0);
	 *
	 * Report all PHP errors:
	 * error_reporting(E_ALL);
	 */
	error_reporting(E_ALL);

//*************************************************************************************************
