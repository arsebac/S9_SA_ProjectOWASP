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

/**
 * Notifications
 */
if (isset($_SESSION['msg1']) && isset($_SESSION['msg2']) && isset($_SESSION['msg-type']))
{
?>
			<div class="alert alert-<?php
	switch ($_SESSION['msg-type'])
	{
		case 'warning':
			echo 'warning';
			break;

		case 'danger':
		case 'error':
			echo 'danger';
			break;

		case 'success':
			echo 'success';
			break;

		case 'info':
			echo 'info';
			break;
	}
?> alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<strong><?php echo htmlspecialchars($_SESSION['msg1'], ENT_QUOTES); ?></strong><br />
				<?php echo htmlspecialchars($_SESSION['msg2'], ENT_QUOTES); ?>
			</div>
<?php
	unset($_SESSION['msg1']);
	unset($_SESSION['msg2']);
	unset($_SESSION['msg-type']);
}
/**
 */


?>