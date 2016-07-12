<?
	include("include.inc");
	include(_CFG_FCKEDITOR_PATH ."fckeditor.php");
?>

<head>
<title>
	<?=_SITE_ADMIN_TEXT?>
</title>
</head>
<body topmargin="0" leftmargin="0"  background="<?=_CFG_IMAGE_PATH?>bg.gif">
<table width="100%" border="0">
<?
	include("header.php");
?>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <?
  		if(@$_SESSION["er"] != "")
		{
  ?>
		  <table width="100%" border="0">
			<tr>
			  <td height="39" class="titleboldRed" align="center"><?=$_SESSION["er"]?></td>
			</tr>
		  </table>
  <?
  		$_SESSION["er"] = "";
  		}
  ?>
  <tr class="title">
    <td>
		<form name="frmPageList">
		<table width="97%" border="0" cellpadding="4" cellspacing="0" style="border: 1px solid #666666" align="center">
			<tr valign="top">
				<td class="trRed"><?=_CFG_STATUS?></td>
				<td class="trRed"><input type="checkbox" name="checkall" onClick="javascript:check_all();"></td>
				<td class="trRed"><?=_CFG_PAGE_TITLE?></td>
				<td colspan="3" class="trRed"><?=_CFG_ACTION?></td>
			</tr>

			<?
					$strQuery = "SELECT * FROM tblcontents WHERE isInternal ='1' ORDER BY contentId";
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
			?>
							<tr valign="top" class="<?=$class?>">
								<td width="15%" id="isActive<?=$pageId?>"><?=showStatus($contentArray[$k]["isActive"])?></td>
								<td width="5%"><input type="checkbox" name="checkall_<?=$k?>" value="<?=$pageId?>" ></td>
								<td width="40%"><?=$contentArray[$k]["contentname"]?></td>
								<td width="15%"><a href = "editcontent.php?content=<?=$pageId?>&from=i" style="text-decoration:none" class="<?=$class?>" title="Edit Contents"><?=_CFG_EDIT?></a></td>
								<td width="15%"><a href ="_page.php?_p_=<?=$contentArray[$k]["contentname"]?>" class="<?=$class?>" style="text-decoration:none" target="_blank"><?=_CFG_PREVIEW?></a></td>
								<td width="10%"></td>
							</tr>
			<?
						}
					}
			?>
							<tr valign="top" class="trWhiteOdd">
								<td colspan="6"><a href="javascript:enablePage()"><?=_CFG_ENABLE?></a> || <a href="javascript:disablePage()"><?=_CFG_DISABLE?></a></td>
							</tr>
		</table>
		</form>
    </td>
  </tr>
</table>
<?
	include("footer.php");
?>
</body>

<?
	function showStatus($activeBit)
	{
		if($activeBit == 1)
			return _CFG_ENABLE;
		else
			return _CFG_DISABLE;
	}
?>

<script>
var f = document.frmPageList;

function check_all()
{
	
	if(f.checkall.checked==true)
	{
			var cnt		= '<?=$k?>';
			var k=0;
			var cnst ='';	
			for(i=0;i<cnt;i++)
			{
				cnst	= eval("f.checkall_"+k);	
				cnst.checked =true;
				k++;
			}
	}

	if(f.checkall.checked==false)
	{
			var cnt		= '<?=$k?>';
			var k=0;
			var cnst ='';	
			for(i=0;i<cnt;i++)
			{
				cnst	= eval("f.checkall_"+k);	
				cnst.checked =false;
				k++;
			}
	}
}

function uncheck()
{
	var cnt		= '<?=$k?>';
	var k=0;
	var cnst ='';	
	for(i=0;i<cnt;i++)
	{
		cnst	= eval("f.checkall_"+k);	
		cnst.checked =false;
		k++;
	}
}


function enablePage()
{
	var cnt	 = '<?=$k?>';
	var k=0;
	var cnst ='';	
	var str = "";
	var flag = 0;
	
	for(i=0; i < cnt; i++)
	{
		cnst = eval("f.checkall_" + k);
		if(cnst.checked == true)
		{
			
			if(str == "")
			{
				str = cnst.value;
			}else
			{
				str = str + "," + cnst.value;
			}
			flag = 1;
		}
		k++;
	}

	if(flag == 1)
		xmlhttpPost(str, 1);
	else
		alert('<?=_CFG_SELECT_PAGE?>');
}


function disablePage()
{
	var cnt	 = '<?=$k?>';
	var k=0;
	var cnst ='';	
	var str = "";
	var flag = 0;

	for(i=0; i < cnt; i++)
	{
		cnst = eval("f.checkall_" + k);
		if(cnst.checked == true)
		{
			
			if(str == "")
			{
				str = cnst.value;
			}else
			{
				str = str + "," + cnst.value;
			}
			flag = 1;
		}
		k++;
	}

	if(flag == 1)
		xmlhttpPost(str, 0);
	else
		alert('<?=_CFG_SELECT_PAGE?>');
}


function xmlhttpPost(id, status) {	
	var strId = id;
	
	uncheck();
	strArray1 = strId.split(",");
	for(j=0; j < strArray1.length; j++)
	{
		document.getElementById("isActive" + strArray1[j]).innerHTML = "Refreshing...<img src='images/ajax-loader.gif' border='0'>";
	}
	
	var url ="changestatus.php";
	var posData = "?id=" + id + "&_e=" + status;


	if (window.XMLHttpRequest) { // Mozilla, Safari,...
		http_request = new XMLHttpRequest();
		if (http_request.overrideMimeType) {
			http_request.overrideMimeType('text/xml');
		}
	} else if (window.ActiveXObject) { // IE
		try {
			http_request = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				http_request = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {}
		}
	}

	http_request.onreadystatechange = function() { GetState(http_request); };
	http_request.open('GET', url + posData, true);
	http_request.send(null);
}



function GetState(http_request){
	
	if (http_request.readyState == 4) {
            if (http_request.status == 200) 
			{
				resText = http_request.responseText;
				strArray = resText.split(",");
				
				if(strArray[0] == "e")
					lbl = '<?=_CFG_ENABLE?>';
				else
					lbl = '<?=_CFG_DISABLE?>';
				
				for(i=1; i < strArray.length; i++)
				{
					document.getElementById("isActive" + strArray[i]).innerHTML = lbl
				}
				
            } else {
                document.getElementById("isActive" + id).innerHTML = '<?=_CFG_ERROR?>';
				alert('<?=_CFG_AJAX_ERROR?>');
            }
        }
}

</script>