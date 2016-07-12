<?
	/*
	 *-----------------------------
	 * Author: Amit Yadav
	 * Date reated: 03/11/2005
	 * last modified: 03/11/2005
	 *-----------------------------
	 */
	
	session_start();

    include("includefile.php");
    include(_CFG_LANGUAGE_PATH);
    include(_CFG_BUSINESS_LOGIC_PATH ."logincheck.php");

	include(_CFG_DB_PATH . _CFG_DB_CLASS_FILE);
	$dbObject = new dbClass();
	$dbObject->db_connect();

	$username = $_REQUEST["username"];
	$password = $_REQUEST["password"];

	$authenticateObject = new authenticate($username, $password);
	
	if(is_object($authenticateObject))
	{
		$isGenuine = $authenticateObject->authenticateUser();
		if($isGenuine)
		{
			echo "1";
		}else{
			
			echo _USERNAME_PASSWORD_INCORRECT;
		}
	}else{
		echo _USERNAME_PASSWORD_BLANK;
	}

	/*
	 *-----------------------------
	 * Author: Amit Yadav
	 * Date reated: 03/11/2005
	 * last modified: 03/11/2005
	 *-----------------------------
	 */
?>