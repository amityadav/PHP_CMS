<?
	include("include.inc");
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<?
	$pageObject = new pageContent();
	
	$pageName = urldecode($_REQUEST["_p_"]);

	$pageObject->setPageName($pageName);
	$pageArray = $pageObject->getPageContent();
	
	$_P_CONTENT = $pageArray[0]["content"];

	if($_P_CONTENT == "")
	{
		$pageName = "404 ERROR";
		$_P_CONTENT = _404_PAGE_NOT_FOUND;
	}
?>
<table>
<tr>
<td width="100%" valign="top" class="trClass">
<div id="content">
	<?=$_P_CONTENT?>
</div>
</td>
</tr>
</table>