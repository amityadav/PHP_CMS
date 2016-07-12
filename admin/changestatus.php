<?
	/*
	 *-----------------------------
	 * Author: Amit Yadav
	 * Date reated: 03/11/2005
	 * last modified: 03/11/2005
	 *-----------------------------
	 */

	include("includefile.php");
	include(_CFG_DB_PATH . _CFG_DB_CLASS_FILE);
	$dbObject = new dbClass();
	$dbObject->db_connect();
	
	include(_CFG_LANGUAGE_PATH);

	$contentId = explode(",", $_REQUEST["id"]);
	$_e = $_REQUEST["_e"];
	$st = "";
	
	if($_e == 1)
	{
		$st = "e";
	}else
	{
		$st = "d";
	}


	if($contentId != "" && is_array($contentId))
	{
		foreach($contentId as $content)
		{
			if($_e == 1)
			{
				$strQuery = "UPDATE tblcontents SET isActive = '1' WHERE contentid = '$content'";
				$dbObject->send_query($strQuery);
			}
			else
			{
				$strQuery = "UPDATE tblcontents SET isActive = '0' WHERE contentid = '$content'";
				$dbObject->send_query($strQuery);
			}
			
				$st .= "," . $content ;
		}
	}else{
		$st = "";
	}

	echo $st;
	

	/*
	 *-----------------------------
	 * Author: Amit Yadav
	 * Date reated: 03/11/2005
	 * last modified: 03/11/2005
	 *-----------------------------
	 */
?>