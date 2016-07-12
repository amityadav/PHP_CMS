<?
	/*
	 *-----------------------------
	 * Author: Amit Yadav
	 * Date reated: 24/05/2006
	 * last modified: 29/05/2006
	 *-----------------------------
	 */
   	include("includefile.php");
	include(_CFG_DB_PATH . _CFG_DB_CLASS_FILE);
	$dbObject = new dbClass();
	$dbObject->db_connect();

	include(_CFG_CLASSES_PATH ."page_class.php");
	
	include(_CFG_LANGUAGE_PATH);
	$listOrder			= $_REQUEST["listOrder"];
	$child_listOrder	= $_REQUEST["child_listOrder"];
	$identifier			= $_REQUEST["identifier"];
	$pageId				= $_REQUEST["pageId"];
	$table				= "tblcontents";

	$pageObj = new pageContent();
	$pageObj->setPageId($pageId);

	if($child_listOrder != "")
		$pageObj->changeSubPageOrder($identifier, $child_listOrder);
	else
		$pageObj->changePageOrder($identifier, $listOrder);
	header("Location:adminarea.php");
	/*
	 *-----------------------------
	 * Author: Amit Yadav
	 * Date reated: 24/05/2006
	 * last modified: 29/05/2006
	 *-----------------------------
	 */
?>