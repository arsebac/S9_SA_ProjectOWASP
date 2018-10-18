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

###################################################################################################
/**
 * AUTH FUNCTIONS
 */
###################################################################################################

/**
 * Validating a User
 *
 * http://tinsology.net/2009/06/creating-a-secure-login-system-the-right-way/
 */
function validateAdmin()
{
	//this is a security measure
	session_regenerate_id();

	$_SESSION['isLoggedIn'] = TRUE;
}

/**
 * Checking if a User is Logged In
 *
 * http://tinsology.net/2009/06/creating-a-secure-login-system-the-right-way/
 */
function isAdminLoggedIn()
{
	if (isset($_SESSION['isLoggedIn']) && ($_SESSION['isLoggedIn'] === TRUE))
	{
		return TRUE;
	}
	return FALSE;
}

/**
 * Logging Out
 *
 * http://tinsology.net/2009/06/creating-a-secure-login-system-the-right-way/
 */
function logout()
{
	$_SESSION = array(); //Destroy session variables
	session_destroy();
}

###################################################################################################
/**
 * MISC FUNCTIONS
 */
###################################################################################################

/**
 * Header Tab Generation
 * 
 * @param string $view
 * @param string $icon
 */
function generateNavigationLi($view = '', $icon = '') {
	$view = strtolower($view);

	?><a href="dashboard.php?view=<?php echo urlencode($view); ?>"><span class="glyphicon <?php echo htmlspecialchars($icon); ?>"></span>&nbsp;<?php echo htmlspecialchars(ucfirst($view)); ?></a><?php

}

/**
 * My Triple MD5 Function
 * 
 * @param string $string
 * @param string $salt
 */
function tripleMd5($string = '', $salt = 'AgPu_o5x--ZER!') {
	return md5(md5(md5($string . $salt) . $salt) . $salt);
}