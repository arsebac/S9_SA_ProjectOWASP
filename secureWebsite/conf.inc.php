<?php
//*************************************************************************************************

	### REQUIRED SETTINGS ###

	// <DO NOT CHANGE>
	define('LICENSE', 'GNU GENERAL PUBLIC LICENSE - Version 3, 29 June 2007');
	// </DO NOT CHANGE>

	// <DO NOT CHANGE>
	define('PROJECT_DIR', realpath(dirname(__FILE__)));
	define('CONF_DIR', PROJECT_DIR.'/conf/');
	define('CONF_FILE', CONF_DIR.'/conf.ini');
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
	 * Global Configuration
	 */
	$CONFIG = parse_ini_file( CONF_FILE, TRUE );

	/**
	 * General CMS Configuration
	 *
	 *	CRYPTOSALT
	 */
	foreach ($CONFIG['General'] as $setting => $value) {
		define( $setting, $value );
	}

	/**
	 * MySQL Configuration
	 *
	 * 	DBHOST
	 *	DBNAME
	 *	DBUSER
	 *	DBPASSWORD
	 *	DBPREFIX
	 */
	foreach ($CONFIG['Database'] as $setting => $value) {
		define( $setting, $value );
	}

	// Clean
	unset($CONFIG);

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
