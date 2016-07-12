<?
	include("include.php");
	$pageObject = new pageContent();
	
	$pageName = urldecode($_REQUEST["_p_"]);

	if ($pageName == "") $pageName = "1";
	$pageObject->setPageName($pageName);
	$pageArray = $pageObject->getPageContent();
	
	$_P_CONTENT = $pageArray[0]["content"];

	if($_P_CONTENT == "")
	{
		$_P_CONTENT = "";//_404_PAGE_NOT_FOUND;
	}
	$pageTitle = $pageArray[0]["pagetitle"];

	$content = $_P_CONTENT;
	
	$metaInfo = "<META NAME='description' CONTENT=".$pageArray[0]['metatags']."><META NAME='KEYWORDS' CONTENT=".$pageArray[0]['metakeywords'].">"; 
	
	
?>

