<?
	ob_start();
	include("include.inc");
	/*
	 *-----------------------------
	 * Author: Amit Yadav
	 * Date reated: 03/11/2005
	 * last modified: 03/11/2005
	 *-----------------------------
	 */
	$contentId		= $_REQUEST["contentId"];
	$FCKeditor1		= $_REQUEST["FCKeditor1"];
	$pageTitle		= $_REQUEST["page_title"];
	$metaKeywords	= $_REQUEST["meta_keywords"];
	$metaTags		= $_REQUEST["meta_tags"];
	$contentName	= $_REQUEST["contentname1"];
	$from			= $_REQUEST["from"];
	$parentPage		= $_REQUEST["parentPage"];

	$pageObj = new pageContent();
	$pageObj->setPageId($contentId);
	
	if($parentPage != "")
		$pageObj->updateSubPage($contentName, $FCKeditor1, $pageTitle, $metaKeywords, $metaTags, $parentPage);
	else
		$pageObj->updatePage($contentName, $FCKeditor1, $pageTitle, $metaKeywords, $metaTags);

	$_SESSION["er"] = _CFG_SUGGESSFUL;
	if($parentPage != "")
		header("Location: editsubpagecontent.php?content=".$contentId."&from=m");
	else
		header("Location: editcontent.php?content=".$contentId."&from=m");

	/*
	 *-----------------------------
	 * Author: Amit Yadav
	 * Date reated: 03/11/2005
	 * last modified: 03/11/2005
	 *-----------------------------
	 */
?>