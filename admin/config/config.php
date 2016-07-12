<?

// 1= debug mode 0= production mode
if(!defined("_CFG_DEBUG"))
	define("_CFG_DEBUG", 1);				

// local path of web root
if (!defined("_PATH"))
	define("_PATH", $_SERVER['DOCUMENT_ROOT']);								

// local path of web folder
if (!defined("_LIB_PATH"))
	define("_LIB_PATH", _PATH . "/DND_CMS/admin/");									

// URL of web root
if (!defined("_WWWROOT"))
	define("_WWWROOT", "http://" . $_SERVER['SERVER_NAME'] . "/DND_CMS/admin/");			

// where application error handler redirect when fatal error occurs
if (!defined("_ERR_FILE"))
	define("_ERR_FILE", _WWWROOT . "/error.php");							

// DB connection info
/* 	
	Which RDBMS? MYSQL MSSQL ORACLE .. change the definition but make sure class file is there 
	to support defined RDBMD
*/
if (!defined("_CFG_RDBMS"))
	define("_CFG_RDBMS", "MYSQL");											// RDBMS used for this application
if (!defined("_CFG_DB_CLASS_FILE"))
	define("_CFG_DB_CLASS_FILE", "dbMysql.php");							// Dtatbase provider class file												
if (!defined("_CFG_DB_HOST"))
	define("_CFG_DB_HOST", "localhost");									// database host
if (!defined("_CHG_DB_USER"))
	define("_CHG_DB_USER", "DB_USER_NAME"); 										// Database user
if (!defined("_CFG_DB_PASS"))
	define("_CFG_DB_PASS", "DB_USER_PASS");												// Database Password 
if (!defined("_CFG_DB_DATABASE"))
	define("_CFG_DB_DATABASE", "DB_NAME"); 									// Database name

define("_CFG_CLASSES_PATH", _LIB_PATH . "classes/");
define("_CFG_LANGUAGE_PATH", _LIB_PATH . "language/en_EN.php");
define("_CFG_INCLUDE_PATH", _LIB_PATH . "includes/");
define("_CFG_EMAIL_PATH", _LIB_PATH . "email/");
define("_CFG_IMAGE_PATH", _WWWROOT . "images/");
define("_CFG_DB_PATH", _LIB_PATH . "classes/db/");
define("_CFG_MAILCLASS_PATH", _LIB_PATH . "classes/mailclass/");
define("_CFG_FCKEDITOR_PATH", _LIB_PATH . "FCKeditor/");
define("_CFG_BUSINESS_LOGIC_PATH", _LIB_PATH . "bl/");

define("_CFG_WORKSHOP_PATH", _WWWROOT . "/");

?>