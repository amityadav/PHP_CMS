<?
/*
 *-----------------------------
 * Author: Amit Yadav
 * Date Created: 05/05/2006
 * Last Modified: 05/05/2006
 *-----------------------------
 */

	// local path of web root
	if (!defined("_PATH_USER"))
		define("_PATH_USER", $_SERVER['DOCUMENT_ROOT']);								

	// local path of web folder
	if (!defined("_LIB_PATH_USER"))
		define("_LIB_PATH_USER", _PATH_USER . "/DND_CMS/");

	// URL of web root
	if (!defined("_WWWROOT_USER"))
		define("_WWWROOT_USER", "http://" . $_SERVER['SERVER_NAME'] . "/DND_CMS/");			

 ?>

<?
	//This file contains all the basic configurations for the site
	include(_LIB_PATH_USER . "admin/config/config.php");
	include(_LIB_PATH_USER . "admin/classes/page_class.php");
	

	include(_CFG_DB_PATH . _CFG_DB_CLASS_FILE);
	$dbObject = new dbClass();
	$dbObject->db_connect();
	
	include(_LIB_PATH_USER . "language/en_EN.php");
?>