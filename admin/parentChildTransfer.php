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


	$dragId = $_REQUEST["dragId"];
	$dragType = $_REQUEST["dragType"];

	$dropId = $_REQUEST["dropId"];
	$dropType = $_REQUEST["dropType"];

	$pageObj = new pageContent();

// if Child is draged on Parent
	
	if ($dragType == "child" && $dropType == "parent")
	{
		$pageObj->childToParentTransfer($dragId,$dropId);
	}

	if ($dragType == "parent" && $dropType == "parent")
	{
		$pageObj->parentToParentTransfer($dragId,$dropId);
	}

	if ($dropType == "makeParent")
	{
		$pageObj->convertToParent($dragId);
	}


	//$pageObj->drawPagesListing();
?>
	<script>
		location.replace('adminarea.php');
	</script>
<?php
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