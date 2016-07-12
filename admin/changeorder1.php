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

	$listOrder = $_REQUEST["listOrder"];
	$identifier = $_REQUEST["identifier"];
	$pageId = $_REQUEST["pageId"];

	
	//0 = Down
	//1 = Up
	if($identifier == 0)
	{
		$strQuery = "SELECT contentid FROM tblcontents WHERE isInternal='0' AND listorder > '".$listOrder."' ORDER BY listorder";
		$dbObject->send_query($strQuery);
		$tmpArray = $dbObject->dbarray();
		$id = $tmpArray[0]["contentid"];
		
		$strQuery = "UPDATE tblcontents SET listorder = listorder +1 WHERE contentid = '".$pageId."'";
		$dbObject->send_query($strQuery);

		$strQuery = "UPDATE tblcontents SET listorder = listorder - 1 WHERE contentid = '".$id."'";
		$dbObject->send_query($strQuery);

	}else{
		$strQuery = "SELECT contentid FROM tblcontents WHERE isInternal='0' AND listorder < '".$listOrder."' ORDER BY listorder DESC";
		$dbObject->send_query($strQuery);
		$tmpArray = $dbObject->dbarray();
		$id = $tmpArray[0]["contentid"];
		
		$strQuery = "UPDATE tblcontents SET listorder = listorder - 1 WHERE contentid = '".$pageId."'";
		$dbObject->send_query($strQuery);

		$strQuery = "UPDATE tblcontents SET listorder = listorder + 1 WHERE contentid = '".$id."'";
		$dbObject->send_query($strQuery);
	}

			?>
			<table width="97%" border="0" cellpadding="4" cellspacing="0" style="border: 1px solid #666666" align="center">
			<tr valign="top">
				<td class="trRed"><?=_CFG_STATUS?></td>
				<td class="trRed"><input type="checkbox" name="checkall" onClick="javascript:check_all();"></td>
				<td class="trRed"><?=_CFG_PAGE_TITLE?></td>
				<td  class="trRed"><?=_CFG_DISPLAY_ORDER?></td>
				<td colspan="1" class="trRed"><?=_CFG_ACTION?></td>
				<td colspan="1" class="trRed"><?=_CFG_DELETE?></td>
				<td colspan="1" class="trRed"><?=_CFG_PREVIEW?></td>
			</tr>
			<?
			$strQuery = "SELECT * FROM tblcontents WHERE isInternal ='0' ORDER BY listorder";
			$dbObject->send_query($strQuery);
			if($dbObject->num_rows > 0)
			{
				$contentArray = $dbObject->dbarray();
				for($k=0;$k<count($contentArray);$k++)
				{
					if($k % 2 == 0)
						$class = "trEven";
					else
						$class = "trOdd";
					$pageId = $contentArray[$k]["contentid"];
			?><tr valign="top" class="<?=$class?>">
								<td width="15%" id="isActive<?=$pageId?>"><?=showStatus($contentArray[$k]["isActive"])?></td>
								<td width="5%"><input type="checkbox" name="checkall_<?=$k?>" value="<?=$pageId?>" ></td>
								<td width="40%"><?=$contentArray[$k]["contentname"]?></td>
								<td width="15%">
								<table width="40%" border="0">
								<tr>
								<td width="50%" class="<?=$class?>">
								<?
									if($k != 0)
									{
								?>	
										<img src="images/up.png" title="<?=_CFG_MOVE_UP?>" onClick="moveUp('<?=$contentArray[$k][listorder]?>','<?=$pageId?>')">
								<?
									}
								?>
								</td>
								<td width="50%" class="<?=$class?>">
								<?
									if($k != count($contentArray)-1)
									{
								?>	
										<img src="images/down.png" title="<?=_CFG_MOVE_DOWN?>" onClick="moveDown('<?=$contentArray[$k][listorder]?>','<?=$pageId?>')">
								<?
									}
								?>	
								</td>
								</tr>
								</table>
								</td>
								<td width="15%"><a href = "editcontent.php?content=<?=$pageId?>&from=m" style="text-decoration:none" class="<?=$class?>" title="Edit Contents"><img src="images/b_edit.png" border="0"></a></td>
								<td width="15%"><img src="images/trash.gif" border="0" onClick="deletePage('<?=$pageId?>')"></td>
								<td width="10%"><a href ="_page.php?_p_=<?=$contentArray[$k]["contentname"]?>" class="<?=$class?>" style="text-decoration:none" target="_blank" title="<?=_CFG_PREVIEW?>"><?=_CFG_PREVIEW?></a></td>
							</tr>
			<?
						}
					}

			?>
				<tr valign="top" class="trWhiteOdd">
								<td colspan="7"><a href="javascript:enablePage()"><?=_CFG_ENABLE?></a> || <a href="javascript:disablePage()"><?=_CFG_DISABLE?></a></td>
							</tr>
							</table>
			<?

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