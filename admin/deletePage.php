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
	
	include(_CFG_CLASSES_PATH ."page_class.php");


	$id = $_REQUEST["id"];

	$pageObj = new pageContent();
	$pageObj->setPageId($id);
	$pageObj->deletePage();
	//$pageObj->drawPagesListing();
	echo "<script>location.replace('adminarea.php')</script>";


	function showStatus($activeBit)
	{
		if($activeBit == 1)
			return _CFG_ENABLE;
		else
			return _CFG_DISABLE;
	}

	/*
	 *-----------------------------
	 * Author: Amit Yadav
	 * Date reated: 03/11/2005
	 * last modified: 03/11/2005
	 *-----------------------------
	 */
?>