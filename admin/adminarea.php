<?
ob_start();
	include("include.inc");
	include(_CFG_FCKEDITOR_PATH ."fckeditor.php");

	/*
	 *-----------------------------
	 * Author: Amit Yadav
	 * Date reated: 24/05/2006
	 * last modified: 31/05/2006
	 *-----------------------------
	 */
?>
<script language="javascript">
function deletePage_confirmation(id, chkParent) 
	{
	if(chkParent == 0)
	{
		if(!confirm("Do you really want to delete this page!"))
		{
			return false;
		}
	}else
	{
		if(!confirm("If you will delete this page then all its child will be deleted automatically.\nDo you really want to delete this page!"))
		{
			return false;
		}
	}
		location.href = "deletePage.php?id=" + id;		
	}
</script>
<head>
<title>
	<?=_SITE_ADMIN_TEXT?>
</title>
</head>
<body topmargin="0" leftmargin="0"  background="<?=_CFG_IMAGE_PATH?>bg.gif" >
<table width="100%" border="0">
<?
	include("header.php");
	$pageObj = new pageContent();
?>

 <tr class="title">
    <td>
		<form name="frmPageList">
		<div id="tablePages" class="title">
<?

		$k = $pageObj->drawPagesListing();
?>
		</div>
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

function moveUp(rowOrder, pageid)
{
	functXHR(rowOrder, 1, pageid);
}


function moveDown(rowOrder, pageid)
{
	functXHR(rowOrder, 0, pageid);
}


//Function to handle the order of the page
function functXHR(rowOrder,identifier, pageid)
{
	document.getElementById("tablePages").innerHTML = "Refreshing...<img src='images/ajax-loader.gif' border='0'>";
	//document.getElementById("errorTab").style.display = "none";

	var url ="changeorder.php";
	var posData = "?listOrder=" + rowOrder + "&identifier=" + identifier + "&pageId=" + pageid;

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

	http_request.onreadystatechange = function() { getTable(http_request); };
	http_request.open('GET', url + posData, true);
	http_request.send(null);
}


function getTable(http_request)
{
	if (http_request.readyState == 4) {
            if (http_request.status == 200)
			{
				resText = http_request.responseText;

				document.getElementById("tablePages").innerHTML = resText;
				//document.write(resText);

            } else {
                document.getElementById("tablePages").innerHTML = '<?=_CFG_ERROR?>';
				alert('<?=_CFG_AJAX_ERROR?>');
            }
        }
}




function check_all()
{

	if(f.checkall.checked == true)
	{
			var cnt		= f.counterRec.value;
			var k=0;
			var cnst ='';
			for(i=0;i<cnt;i++)
			{
				cnst = eval("f.checkall_" + k);
				cnst.checked =true;
				k++;
			}
	}

	if(f.checkall.checked==false)
	{
			var cnt		= f.counterRec.value;
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
	var cnt		= f.counterRec.value;
	var k=0;
	var cnst ='';
	f.checkall.checked = false;
	for(i=0;i<cnt;i++)
	{
		cnst	= eval("f.checkall_"+k);
		cnst.checked =false;
		k++;
	}
}


function enablePage()
{
	var cnt	 = f.counterRec.value;
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
	var cnt	 = f.counterRec.value;
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




function openWindow(URL)
{
	mywindow = window.open (URL,"mywindow","location=0,status=1,scrollbars=1, width=400,height=400");
	mywindow.focus();
}




function deletePage(id, chkParent) {
	if(chkParent == 1)
	{
		if(!confirm("<?=_CFG_DELETE_PARENT_MESSAGE?>"))
		{
			return false;
		}
	}else{
		if(!confirm("<?=_CFG_DELETE_MESSAGE?>"))
		{
			return false;
		}
	}

	//document.getElementById("dnd_" + id).innerHTML = "Deleting...<img src='images/ajax-loader.gif' border='0'>";

	var url ="deletePage.php";
	var posData = "?id=" + id;


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

	http_request.onreadystatechange = function() { removeTr(http_request, id); };
	http_request.open('GET', url + posData, true);
	http_request.send(null);
}

function removeTr(http_request, id){
	if (http_request.readyState == 4) {
            if (http_request.status == 200)
			{
				resText = http_request.responseText;
				fade(id);

            } else {
               alert('<?=_CFG_ERROR?>');
            }
        }
}


/*
THIS FUNCTION IS TO MAKE TRANSFER BETWEEN PARENT AND CHILD FOR DRAG AND DROP
*/


function parentChildTransfer(dragObjectId,dropObjectId,dragObjectType,dropObjectType)
{

	document.getElementById("tablePages").innerHTML = "Refreshing...<img src='images/ajax-loader.gif' border='0'>";
	var url ="parentChildTransfer.php";
	var posData = "?dragId=" + dragObjectId + "&dropId=" + dropObjectId + "&dragType=" + dragObjectType + "&dropType=" + dropObjectType;


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

	http_request.onreadystatechange = function() { getTable(http_request); };
	http_request.open('GET', url + posData, true);
	http_request.send(null);
}



var k=0;var idRow;var tid; 
function  amit2()
{
	k = k + 10;
	changeColor();
}
function fade(id)
{
  k = 0;
  idRow = "dnd_" + id ;
  clearInterval(tid);
  tid = setInterval('amit2()',10);
}

function changeColor()
{
	document.getElementById(idRow).style.background = "rgb(225, " + k + "," + k + ")";
	
	if(k > 256)
	document.getElementById(idRow).style.display = "none";
}

</script>

<?
	/*
	 *-----------------------------
	 * Author: Amit Yadav
	 * Date reated: 24/05/2006
	 * last modified: 31/05/2006
	 *-----------------------------
	 */
?>