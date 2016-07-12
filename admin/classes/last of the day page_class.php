<?
	//page_class.php
	// This class is used to server the pages with the contents from the database

	class pageContent
	{
		var $page;
		var $pageId;
		var $colorCounter = 0;


		function pageContent()
		{
			//Constructor of the class
		}

		function setPageName($pageId)
		{
			$this->page = $pageId;
		}



		function getPageName()
		{
			return $this->page;
		}

		function setPageId($pageId)
		{
			$this->pageId = $pageId;
		}



		function getPageId()
		{
			return $this->pageId;
		}



		function getAllParentPage()
		{
			global $dbObject;

			$strQuery = "SELECT * FROM tblcontents WHERE parentid = '0'";
			$dbObject->send_query($strQuery);
			
			if($dbObject->num_rows)
			{
				return $dbObject->dbarray();
			}else{
				return array();
			}
		}


		function addNewPage($pageName, $page_title, $meta_keywords, $meta_tags, $content, $listorder)
		{
			global $dbObject;

			$strQuery = "SELECT COUNT(*) AS cnt FROM tblcontents WHERE parentid='0'";
			$dbObject->send_query($strQuery);
			$tmpArray = $dbObject->dbarray();
			$lstOrder = $tmpArray[0]["cnt"] + 1;
			$dt = date("Y-m-d");
			$query="SELECT max( listorder ) as count FROM `tblcontents` WHERE parentid='0'";
			$res= mysql_query($query);
			$query_data = mysql_fetch_array($res);
			$listorder = $query_data["count"] + 1;

			$strQuery = "INSERT INTO tblcontents (contentname, pagetitle, metakeywords, metatags, content, listorder, createdate, updatedate, isActive, parentid, child_listorder) values('$pageName', '$page_title', '$meta_keywords', '$meta_tags', '$content', '$listorder', '$dt', '$dt', '1', '0', '-1')";
			$dbObject->send_query($strQuery);
		}



		function addNewSubPage($pageName, $page_title, $meta_keywords, $meta_tags, $content, $listorder, $parentId)
		{
			global $dbObject;

			$strQuery = "SELECT COUNT(*) AS cnt FROM tblcontents WHERE parentid!='0'";
			$dbObject->send_query($strQuery);
			$tmpArray = $dbObject->dbarray();
			$lstOrder = $tmpArray[0]["cnt"] + 1;
			$dt = date("Y-m-d");

			$strQuery = "SELECT max( child_listorder ) as count FROM `tblcontents` WHERE parentid = '$parentId'";
			$res= mysql_query($strQuery);
			$query_data = mysql_fetch_array($res);
			$listorder = $query_data["count"] + 1;

			$strQuery = "INSERT INTO tblcontents (contentname, pagetitle, metakeywords, metatags, content, listorder, createdate, updatedate, isActive, parentid, child_listorder) values('$pageName', '$page_title', '$meta_keywords', '$meta_tags', '$content', '-1', '$dt', '$dt', '1', '$parentId', '$listorder')";
			$dbObject->send_query($strQuery);
		}


		function updatePage($contentName, $FCKeditor1, $pageTitle, $metaKeywords, $metaTags)
		{
			global $dbObject;

			$strQuery = "UPDATE tblcontents SET contentname = '$contentName', content = '$FCKeditor1', pagetitle='$pageTitle', metakeywords='$metaKeywords', metatags='$metaTags' WHERE contentid = '" . $this->pageId . "'";
			$dbObject->send_query($strQuery);
		}



		function getAllPageName($isInternal = "", $isActive = "1")
		{
			global $dbObject;

			$strQuery = "SELECT contentname, contentid FROM tblcontents WHERE isActive = '" . $isActive . "'";

			$dbObject->send_query($strQuery);

			if($dbObject->num_rows > 0)
			{
				$pageArray = $dbObject->dbarray();
				return $pageArray;
			}
		}



		function getPageContent()
		{
			global $dbObject;

			$strQuery = "SELECT * FROM tblcontents WHERE contentid = '" . $this->page . "'";
			$dbObject->send_query($strQuery);

			if($dbObject->num_rows > 0)
			{
				$contentArray = $dbObject->dbarray();
				return $contentArray;
			}
		}


		function getPageContentById()
		{
			global $dbObject;

			$strQuery = "SELECT * FROM tblcontents WHERE isActive = '1' AND contentid = '" . $this->pageId . "'";
			$dbObject->send_query($strQuery);

			if($dbObject->num_rows > 0)
			{
				$contentArray = $dbObject->dbarray();
				return $contentArray;
			}
		}



		function changePageOrder($identifier, $listOrder)
		{
			global $dbObject;

			$table= "tblcontents";

			if($identifier == 0)
			{
				$strQuery = "SELECT contentid FROM " . $table . " WHERE listorder > '$listOrder' AND listorder != '-1' ORDER BY listorder";
				$dbObject->send_query($strQuery);
				$tmpArray = $dbObject->dbarray();
				$id = $tmpArray[0]["contentid"];

				$strQuery = "UPDATE ".$table." SET listorder = listorder +1 WHERE contentid = '" . $this->pageId . "'";
				$dbObject->send_query($strQuery);

				$strQuery = "UPDATE ".$table." SET listorder = listorder - 1 WHERE contentid = '$id'";
				$dbObject->send_query($strQuery);

			}else{
				$strQuery = "SELECT contentid FROM ".$table." WHERE listorder < '$listOrder' ORDER BY listorder DESC";
				$dbObject->send_query($strQuery);
				$tmpArray = $dbObject->dbarray();
				$id = $tmpArray[0]["contentid"];

				$strQuery = "UPDATE ".$table." SET listorder = listorder - 1 WHERE contentid = '" . $this->pageId . "'";
				$dbObject->send_query($strQuery);

				$strQuery = "UPDATE ".$table." SET listorder = listorder + 1 WHERE contentid = '$id'";
				$dbObject->send_query($strQuery);
			}
		}



		function deletePage()
		{
			global $dbObject;

			$strQuery = "SELECT listorder, child_listorder, parentid FROM tblcontents WHERE contentid = '" . $this->pageId . "'";
			$dbObject->send_query($strQuery);
			$tmpArray = $dbObject->dbarray();
			$listorder = $tmpArray[0]["listorder"];
			$child_listorder = $tmpArray[0]["child_listorder"];
			$parentid = $tmpArray[0]["parentid"];

			if($listorder == -1)
				$listorder = $child_listorder;
			
			if($parentid == 0)
				$parentid = $this->pageId;

			$strQuery = "DELETE FROM tblcontents WHERE contentid = '" . $this->pageId . "'";
			$dbObject->send_query($strQuery);
			
			if($child_listorder != -1)
				$this->reorderSubPages($parentid, $listorder);
			else
				$this->reorderPages($listorder);
			
			$subPages = $this->getAllSubPage($this->pageId);
			if(is_array($subPages) && count($subPages) > 0)
			{
				foreach($subPages as $subPageId)
				{
					$strQuery = "DELETE FROM tblcontents WHERE contentid = '" . $subPageId["contentid"] . "'";
					$dbObject->send_query($strQuery);
				}
				
				$this->reorderSubPages($parentid, $listorder);
			}
		}



		function reorderPages($listOrder)
		{
			global $dbObject;

			$strQuery = "SELECT count(*) as totalRec FROM tblcontents";
			$dbObject->send_query($strQuery);
			$tmpArray = $dbObject->dbarray();
			$totalRec = $tmpArray[0]["totalRec"];

			for($i = $listOrder + 1; $i <= $totalRec+1; $i++)
			{
				$strQuery = "UPDATE tblcontents SET listorder = listorder - 1 WHERE listorder = '$i'";
				$dbObject->send_query($strQuery);
			}
		}


		function reorderSubPages($parentId, $listOrder)
		{
			global $dbObject;

			$strQuery = "SELECT count(*) as totalRec FROM tblcontents WHERE parentid = '$parentId'";
			$dbObject->send_query($strQuery);
			$tmpArray = $dbObject->dbarray();
			$totalRec = $tmpArray[0]["totalRec"];

			for($i = $listOrder + 1; $i <= $totalRec+1; $i++)
			{
				$strQuery = "UPDATE tblcontents SET child_listorder = child_listorder - 1 WHERE child_listorder = '$i' AND parentid = '$parentId'";
				$dbObject->send_query($strQuery);
			}
		}




		function drawPagesListing()
		{
			global $dbObject, $rms_status;

			$tableString = "";

			$tableString .= '<table width="97%" border="0" cellpadding="4" cellspacing="0" style="border: 1px solid #CFCFCF" align="center"><tr valign="top">';

			if($rms_status=="on")
			{
				$tableString .= '<td class="trRed">' . _CFG_STATUS . '</td>
					<td class="trRed"><input type="checkbox" name="checkall" onClick="javascript:check_all();"></td>';
			}

			$tableString .= '<td class="trRed">' . _CFG_PAGE_TITLE . '</td>';

			if($rms_status=="on")
			{
				$tableString .= '<td  class="trRed">' . _CFG_DISPLAY_ORDER . '</td>';
			}

			$tableString .= '<td colspan="1" class="trRed">' . _CFG_ACTION . '</td>';
			if($rms_status=="on")
			{
				$tableString .= '<td colspan="1" class="trRed">' . _CFG_DELETE . '</td>';
			}

			$tableString .= '<td colspan="1" class="trRed">' . _CFG_PREVIEW . '</td></tr><tr><td colspan="10"><DIV style="align="center" id="droptable">';

			$strQuery = "SELECT * FROM tblcontents WHERE parentid='0' ORDER BY listorder";
			$dbObject->send_query($strQuery);
			if($dbObject->num_rows > 0)
			{
				$contentArray = $dbObject->dbarray();

				for($k=0;$k<count($contentArray);$k++)
				{
					if($this->colorCounter % 2 == 0)
						$class = "trEven";
					else
						$class = "trOdd";
					$pageId = $contentArray[$k]["contentid"];

					$tableString .= '<span rowType="parent"  id="dragDrop' . $pageId . '" class="' . $class . '">';

					if($rms_status=="on")
					{
						$tableString .= '<code  id="isActive' . $pageId . '"><font color="red">' . showStatus($contentArray[$k]["isActive"]) . '</font></code><input type="checkbox" id="checkall_' . $this->colorCounter . '"  name="checkall_' . $this->colorCounter . '" value="' . $pageId . '" >';
					}
					
					$this->colorCounter++;
					$tableString .= '<font color="red"><b>' . $contentArray[$k]["contentname"] . '</b></font>';

					if($rms_status=="on")
					{
						$tableString .= '';

						if($k != 0)
						{

						$tableString .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="changeorder.php?listOrder=' . $contentArray[$k]['listorder'] . '&identifier=1&pageId=' . $pageId . '">	<img border="0" src="images/up.png" title="' . _CFG_MOVE_UP . '"></a>';

						}

						$tableString .= '';

						if($k != count($contentArray) - 1)
						{
							$tableString .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="changeorder.php?listOrder=' . $contentArray[$k]['listorder'] . '&identifier=0&pageId=' . $pageId . '"><img  border="0" src="images/down.png" title="' . _CFG_MOVE_DOWN . '"></a>';
						}

						$tableString .= '';
					}

					$tableString .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href = "editcontent.php?content=' . $pageId . '&from=m" style="text-decoration:none" class="' . $class . '" title="' . _CFG_TITLE_EDIT_PAGE . '"><img src="images/b_edit.png" border="0"></a>';

					if($rms_status=="on")
					{
					$tableString .= '<a href="javascript:void(0);"onClick="deletePage(\'' . $pageId . '\', \'1\')" title="' . _CFG_TITLE_DELETE_PAGE . '"><img src="images/trash.gif" border="0" alt="'. _CFG_TITLE_DELETE_PAGE .'"></a>';
					 }

					$tableString .= '<a href ="../index.php?_p_=' . $contentArray[$k]["contentid"] . '" class="' . $class . '" style="text-decoration:none" target="_blank" title="' . _CFG_PREVIEW . '"><img src="images/preview.gif" border="0" alt="'. _CFG_PREVIEW .'"></a><br></span>';

					$tableString .= $this->drawSubPageListing($pageId);
				}
			}

			$tableString .= '</DIV></td></tr><tr valign="top" class="trRed" >';

			if($rms_status=="on")
			{
				$tableString .= '<td colspan="7" class="trRed"><a href="javascript:enablePage()" title="' . _CFG_ENABLE . '"><font color="#FFFFFF">' . _CFG_ENABLE . '</font></a> || <a href="javascript:disablePage()" title="' . _CFG_DISABLE . '"><font color="#FFFFFF">' . _CFG_DISABLE  . '</font></a></td>';
			}

			$tableString .= '</tr></table><input type="hidden" name="counterRec" value="' . $this->colorCounter . '">';

			echo $tableString;
			return $this->colorCounter; //Return the total number of records
		}
		//END OF THE FUNCTION




		function drawSubPageListing($parentId)
		{
			global $dbObject, $rms_status;
			
			$strQuery = "SELECT * FROM tblcontents WHERE parentid='$parentId' ORDER BY child_listorder";
			//echo $strQuery;
			$dbObject->send_query($strQuery);
			if($dbObject->num_rows > 0)
			{
				$subContentArray = $dbObject->dbarray();
				for($amt=0;$amt<count($subContentArray);$amt++)
				{
					if($this->colorCounter % 2 == 0)
						$class = "trEven";
					else
						$class = "trOdd";
					
					$subPageId = $subContentArray[$amt]["contentid"];

					$subPageTableString .= '<span  rowType="child" id="dragDrop' . $subPageId . '" class="' . $class . '">';

					if($rms_status=="on")
					{
						$subPageTableString .= '<code  id="isActive' . $subPageId . '">' . showStatus($subContentArray[$amt]["isActive"]) . '</code><input type="checkbox" id="checkall_' . $this->colorCounter . '"  name="checkall_' . $this->colorCounter . '" value="' . $subPageId . '" >';
					}
					
					$this->colorCounter++;

					$subPageTableString .= '&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/right.jpg" border="0">&nbsp;&nbsp;' . $subContentArray[$amt]["contentname"] . '';

					if($rms_status == "on")
					{
						$subPageTableString .= '';

						if($amt != 0)
						{
							$subPageTableString .= '<a href="changeorder.php?child_listOrder=' . $subContentArray[$amt]['child_listorder'] . '&identifier=1&pageId=' . $subPageId . '">	<img border="0" src="images/up.jpg" title="' . _CFG_MOVE_UP . '"></a>';
						}

						$subPageTableString .= '';

						if($amt != count($subContentArray)-1)
						{
							$subPageTableString .= '<a href="changeorder.php?child_listOrder=' . $subContentArray[$amt]['child_listorder'] . '&identifier=0&pageId=' . $subPageId . '"><img  border="0" src="images/down.jpg" title="' . _CFG_MOVE_DOWN . '"></a>';
						}

						$subPageTableString .= '';
					}

					$subPageTableString .= '<a href = "editsubpagecontent.php?content=' . $subPageId . '&from=m" style="text-decoration:none" class="' . $class . '" title="' . _CFG_TITLE_EDIT_PAGE . '"><img src="images/b_edit.png" border="0"></a>';

					if($rms_status == "on")
					{
						$subPageTableString .= '<a href="javascript:void(0);"onClick="deletePage(\'' . $subPageId . '\', \'0\')" title="' . _CFG_TITLE_DELETE_PAGE . '"><img src="images/trash.gif" border="0" alt="'. _CFG_TITLE_DELETE_PAGE .'"></a>';
					 }

					$subPageTableString .= '<a href ="../index.php?_p_=' . $subContentArray[$amt]["contentid"] . '" class="' . $class . '" style="text-decoration:none" target="_blank" title="' . _CFG_PREVIEW . '"><img src="images/preview.gif" border="0" alt="'. _CFG_PREVIEW .'"></a><br></span>';
				}

				return $subPageTableString;
			}
		}


		function updateSubPage($contentName, $FCKeditor1, $pageTitle, $metaKeywords, $metaTags, $parentId)
		{
			global $dbObject;

			$strQuery = "UPDATE tblcontents SET contentname = '$contentName', content = '$FCKeditor1', pagetitle='$pageTitle', metakeywords='$metaKeywords', metatags='$metaTags', parentid = '$parentId' WHERE contentid = '" . $this->pageId . "'";
			$dbObject->send_query($strQuery);
		}



		function changeSubPageOrder($identifier, $child_listOrder)
		{
			global $dbObject;

			$table= "tblcontents";

			if($identifier == 0)
			{
				$strQuery = "SELECT contentid FROM " . $table . " WHERE child_listorder > '$child_listOrder' ORDER BY child_listorder";
				$dbObject->send_query($strQuery);
				$tmpArray = $dbObject->dbarray();
				$id = $tmpArray[0]["contentid"];

				$strQuery = "UPDATE ".$table." SET child_listorder = child_listorder +1 WHERE contentid = '" . $this->pageId . "'";
				$dbObject->send_query($strQuery);

				$strQuery = "UPDATE ".$table." SET child_listorder = child_listorder - 1 WHERE contentid = '$id'";
				$dbObject->send_query($strQuery);

			}else{
				$strQuery = "SELECT contentid FROM ".$table." WHERE child_listorder < '$child_listOrder' AND child_listorder != '-1' ORDER BY child_listorder DESC";
				
				$dbObject->send_query($strQuery);
				$tmpArray = $dbObject->dbarray();
				$id = $tmpArray[0]["contentid"];

				$strQuery = "UPDATE ".$table." SET child_listorder = child_listorder - 1 WHERE contentid = '" . $this->pageId . "'";
				$dbObject->send_query($strQuery);

				$strQuery = "UPDATE ".$table." SET child_listorder = child_listorder + 1 WHERE contentid = '$id'";
				$dbObject->send_query($strQuery);
			}
		}


		function getAllSubPage($parentId)
		{
			global $dbObject;

			$strQuery = "SELECT contentid FROM tblcontents WHERE parentid = '$parentId'";
			$dbObject->send_query($strQuery);
			$tmpArray = $dbObject->dbarray();
			return $tmpArray;
		}


		function isSubPage($pageId)
		{
			global $dbObject;

			$strQuery = "SELECT parentid FROM tblcontents WHERE contentid = '$pageId'";
			$dbObject->send_query($strQuery);
			$tmpArray = $dbObject->dbarray();
			
			if($tmpArray[0]["parentid"] == 0)
				return 0;
			else
				return $tmpArray[0]["parentid"];
		}

	}
	//END OF THE PAGE CLASS
?>