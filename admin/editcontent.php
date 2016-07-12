<?
	include("include.inc");
	/*
	 *-----------------------------
	 * Author: Amit Yadav
	 * Date reated: 29/05/2006
	 * Last modified: 29/05/2006
	 *-----------------------------
	 */


	$contentId = @$_REQUEST["content"];
	$userid = $_SESSION["userid"];
	$type = $_SESSION["type"];
?>

<head>
<title>
	<?=_SITE_ADMIN_TEXT?>
</title>

</head>
<?
	$hasContent = false;

	$pageObj = new pageContent();

	//Set The page id in to the object
	$pageObj->setPageId($contentId);
	$pageArray = $pageObj->getPageContentById($contentId);

	if(count($pageArray) > 0)
	{
		$contentArray = $pageArray;
		$contentName = $contentArray[0]["contentname"];
		 $content = $contentArray[0]["content"];
		$pagetitle = $contentArray[0]["pagetitle"];
		$metakeywords = $contentArray[0]["metakeywords"];
		$metatags = $contentArray[0]["metatags"];
		$hasContent = true;
	}
?>
<!--<script src="FCKeditor/fckeditor.js"></script>
<script src="FCKeditor/editor/_source/internals/fckundo_ie.js"></script>-->
<script src="md5.js"></script>
<script>
var ch_val = "";
var oEditor ="";
//var FCK = FCKeditorAPI.GetInstance('FCKeditor1') ;
// FCKeditor_OnComplete is a special function that is called when an editor
// instance is loaded ad available to the API. It must be named exactly in
// this way.
function FCKeditor_OnComplete( editorInstance )
{
	oEditor = FCKeditorAPI.GetInstance('FCKeditor1') ;
	ch_val = FCKeditorAPI.GetInstance('FCKeditor1') ;
	ch_val = oEditor.GetXHTML( true ) ;		// "true" means you want it formatted.
	//return  ch_val;
}

</script>
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
		  <table width="100%" border="0" id="errorTab">
			<tr>
			  <td height="39" class="titleboldRed" align="center"><?=$_SESSION["er"]?></td>
			</tr>
		  </table>
  <?
  		$_SESSION["er"] = "";
  		}
  ?>
  <tr>
    <td>
        <table width="95%" height="132" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px solid #666666">
          <tr class="trblueOdd">
            <td align="left" bgcolor="666666" class="titlebold" colspan="3"><font color="#FFFFFF"><?=_EDIT_PAGE_CONTENT_TEXT?></font></td>
          </tr>
		  <tr class="trblueOdd">
            <td height="26">&nbsp;</td>
            <td class="titlebold" height="26">
            <td>&nbsp;</td>
          </tr>

		  
		 <form name="frmEditContent" method="post" action="savecontent.php" >
		 <input type="hidden" value="<?=$contentName?>" name="contentname_ch">
		 <input type="hidden" value="<?=$pagetitle;?>" name="pagetitle_ch">
		 <input type="hidden" value="<?=$metakeywords;?>" name="metakeywords_ch">
		 <input type="hidden" value="<?=$metatags;?>" name="metatags_ch">
		 <input type="hidden" value="<? echo (htmlentities($content, ENT_QUOTES)); ?>" name="content_ch">
          <?
			if($contentId != "")
			{
		  ?>
						  <tr>
							<td>&nbsp;</td>
							<td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="8">
								<tr class="trblueOdd">
								  <td width="100%" height="26" class="titlebold"><div align="right">
									<table width="100%" border="0" cellpadding="8" cellspacing="0">
									  <tr>
										<td><span class="titlebold"><?=_CONTENT_PAGE_TEXT?></span>&nbsp;<span class="title">
										 <input type="text" value="<?=$contentName?>" name="contentname1" class="textField">
										</span></td>
									  </tr>

									  <tr>
										<td><span class="titlebold"><?=_CONTENT_?></span></td>
									  </tr>
									  <tr>
										<td>
												<!----------------------------------------->
										<!--Start Addition By Vineet -->
												<?php
												switch($editor)
												{
													case "FCKEditor":
														?><div align="right"><a href="help/User_Maual_for_fck.pdf" target="popup" onClick="touWindow=window.open('help/User_Maual_for_fck.pdf','touWindow','status=yes,scrollbars=1,toolbar=no,menubar=no,location=no,width=550,height=450,resizable=yes');touWindow.focus(); return false;" class="title">Help[?]</a></div><?php
														include(_CFG_FCKEDITOR_PATH ."fckeditor.php");
														$oFCKeditor = new FCKeditor('FCKeditor1');
														$oFCKeditor->BasePath = "FCKeditor/";
														$oFCKeditor->Value = $content;

														$oFCKeditor->Width  = '90%';
														$oFCKeditor->Height = '440';
														$oFCKeditor->Create();
														break;
													case "TinyMCE":
														?><div align="right"><a href="help/Operational_manual_TinyMCE.pdf" target="popup" onClick="touWindow=window.open('help/Operational_manual_TinyMCE.pdf','touWindow','status=yes,scrollbars=1,toolbar=no,menubar=no,location=no,width=550,height=450,resizable=yes');touWindow.focus(); return false;" class="title">Help[?]</a></div>
														<script language="javascript" type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
														<script language="javascript" type="text/javascript">
															tinyMCE.init({
																		mode : "exact",
																		elements : "FCKeditor1",
																		theme : "advanced",
																		plugins : "style,layer,table,save,advhr,advimage,ibrowser,advlink,emotions,iespell,insertdatetime,preview,flash,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,zoom",
																		//theme_advanced_buttons1_add_before : "save,newdocument,separator",
																		theme_advanced_buttons1_add : "fontselect,fontsizeselect",
																		theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,zoom,separator,forecolor,backcolor",
																		theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator,search,replace,separator",
																		theme_advanced_buttons3_add_before : "tablecontrols,separator",
																		theme_advanced_buttons3_add : "emotions,iespell,flash,advhr,separator,print,separator,ltr,rtl,separator,fullscreen",
																		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops",
																		theme_advanced_toolbar_location : "top",
																		theme_advanced_toolbar_align : "left",
																		theme_advanced_path_location : "bottom",
																		content_css : "example_full.css",
																		plugin_insertdate_dateFormat : "%Y-%m-%d",
																		plugin_insertdate_timeFormat : "%H:%M:%S",
																		extended_valid_elements : "hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
																		external_image_list_url : "example_image_list.js",
																		flash_external_list_url : "example_flash_list.js",
																		theme_advanced_resize_horizontal : false,
																		theme_advanced_source_editor_wrap:false,
																		theme_advanced_styles : "Style Class 1=styleClass1;Style Class 2=styleClass2;Style Class 3=styleClass3",
																		theme_advanced_buttons3_add : "ibrowser",
																		theme_advanced_resizing : true,
																		verify_html : false,
																		relative_urls : false
																	});
												</script>
												<textarea name="FCKeditor1" style="WIDTH: 90%; HEIGHT: 500px"><?=$content;?></textarea>
												<?php
												break;
											default:
												?>
													<textarea name="FCKeditor1" style="WIDTH: 90%; HEIGHT: 500px"><?=$content;?></textarea>
												<?php
												break;
												}
												?>
												<!--End Addition By Vineet -->
												<!----------------------------------------->
										</td>
										<script>
											// FCKeditor_OnComplete();
										</script>
									  </tr>

									  <tr>
										<td class="titlebold">
											<?=_CONTENT_PAGE_TITLE?>
										</td>
									  </tr>

									  <tr>
										<td>
											<input type="text" class="textField" name="page_title" size="135" value="<?=$pagetitle?>">
										</td>
									  </tr>

									  <tr>
										<td class="titlebold">
											<?=_CFG_META_KEYWORDS?>
										</td>
									  </tr>

									  <tr>
										<td valign="top">
											<textarea class="textField" rows="12" cols="132" name="meta_keywords"><?=$metakeywords?></textarea>
											<a href="help/hlp_meta_keywords.php" target="popup" onClick="touWindow=window.open('help/hlp_meta_keywords.php','touWindow','status=yes,scrollbars=1,toolbar=no,menubar=no,location=no,width=500,height=450');touWindow.focus(); return false;" class="title">Help[?]</a>
										</td>


									  <tr>
										<td class="titlebold">
											<?=_CFG_META_TAGS?>
										</td>
									  </tr>

									  <tr>
										<td valign="top">
											<textarea class="textField" rows="12" cols="132" name="meta_tags"><?=$metatags?></textarea>
											<a href="help/hlp_meta_tags.php" target="popup" onClick="touWindow=window.open('help/hlp_meta_tags.php','touWindow','status=yes,scrollbars=1,toolbar=no,menubar=no,location=no,width=500,height=300');touWindow.focus(); return false;" class="title">Help[?]</a>
										</td>
									  </tr>


									  <tr>
										<td>
										  <input type="submit" name="submit" value="<?=_SAVE_CONTENT_BUTTON_TEXT?>" class="commonbutton">	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<?
												if($_REQUEST['from'] == "m")
												{
											?>
													<input type="submit" name="back" value="<?=_BACK_CONTENT_BUTTON_TEXT?>" class="commonbutton">
													<!-- <input type="submit" name="back" value="<?=_BACK_CONTENT_BUTTON_TEXT?>" class="commonbutton" onClick="return check_confirm();">onClick="window.location='adminarea.php'">-->
											<?
												}else{
											?>
													<input type="button" name="back" value="<?=_BACK_CONTENT_BUTTON_TEXT?>" class="commonbutton" onClick="window.location='listinternalpages.php'">
											<?
												}
											?>
										</td>
									  </tr>
									  <INPUT TYPE="hidden" name="contentId" value="<?=$contentId?>">
									</table>
								  </div>
								  </td>
								</tr>

							  </table>
							</td>
							<td>&nbsp;</td>
						  </tr>
		  <?
			}else{
		  ?>          <tr class="trblueOdd" align="center" height="26">
                        <td>&nbsp;</td>
						<td>
						<?
							if($_REQUEST['from'] == "m")
							{
						?>
								<input type="button" name="back" value="<?=_BACK_TO_ADMIN?>" class="commonbutton" onClick="return check_confirm();">
						<?
							}else{
						?>
								<input type="button" name="back" value="<?=_BACK_TO_ADMIN?>" class="commonbutton" onClick="return check_confirm();">
						<?
							}
						?>
                        </td>
						<td>&nbsp;</td>
                      </tr>
		  <?
			}
		   ?>
      </table>
		<input type="hidden" name="from" value="<?=$_REQUEST['from']?>">
      </form>
    </td>
  </tr>
</table>
<?
	include("footer.php");
?>
</body>


<script>
var no_load;
var change = "";
function fcFun()
{

	FCK = FCKeditorAPI.GetInstance('FCKeditor1') ;
	// Get the Actual HTML.
	var sHtml = FCK.EditorDocument.body.innerHTML ;
	alert(no_load);
	alert(sHtml);
	// Cancel operation if the new step is identical to the previous one.
	if ( FCKUndo.CurrentIndex >= 0 && sHtml == FCKUndo.SavedData[ FCKUndo.CurrentIndex ][0] )
		{
			//alert("hi");
		}
		else
		{
			//alert("test working");
		}
}

var hash1 = "";
var hash2 = "";
function GetContents()
{
	// Get the editor instance that we want to interact with.
    var fv = document.frmEditContent.content_ch.value;
}
var i=0;
function change()
{
i = i + 1;
alert(i);
}

var cond1 = 0;
function openWindow(URL)
{
	mywindow = window.open (URL,"mywindow","location=0,status=1,scrollbars=1,resizable=1, width=400,height=400");
	mywindow.focus();
}

function check_confirm()
{
change =  oEditor.GetXHTML( true ) ;
var frm = document.frmEditContent;
if(frm.contentname_ch.value != frm.contentname1.value || frm.pagetitle_ch.value != frm.page_title.value || frm.metakeywords_ch.value != frm.meta_keywords.value || frm.metatags_ch.value != frm.meta_tags.value || ch_val != change)
{
	if(!confirm("Would You Like To Save The Changes!"))
		{

			window.location='adminarea.php';
			return false;
		}
	else
		{
			return true;
		}
}
else
{
window.location='adminarea.php';
return false;
}
}

function xmlhttpPost(strMd5) {
	var url ="checkstatus.php";
	var posData = "?str=" + strMd5;


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
				cond1 = http_request.responseText;

            } else {
                document.getElementById("isActive" + id).innerHTML = '<?=_CFG_ERROR?>';
				alert('<?=_CFG_AJAX_ERROR?>');
            }
        }
}




function xmlhttpPost(strURL,callerFunction) {
    var xmlHttpReq = false;
    var self = this;
    // Mozilla/Safari
    if (window.XMLHttpRequest) {
        self.xmlHttpReq = new XMLHttpRequest();
    }
    // IE
    else if (window.ActiveXObject) {
        self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
    }
    self.xmlHttpReq.open('get', strURL, true);
    self.xmlHttpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    self.xmlHttpReq.onreadystatechange = function() {
        if (self.xmlHttpReq.readyState == 4) {
            switch(callerFunction)
			{
				case 1 : updatediv(self.xmlHttpReq.responseText); break;
			}
        }
    }
    self.xmlHttpReq.send(null);
}
function checkdate()
{
alert(hash1)
alert(hash2)
return false;
}


function updatediv(val)
{

var str = val.split("/");


document.getElementById("date_update").innerHTML = str[0];

document.frmProgram.sd.value = document.newdate.dc2.value;

document.frmProgram.time_lft.value = str[1];

}
</script>


<?
	/*
	 *-----------------------------
	 * Author: Amit Yadav
	 * Date reated: 29/05/2006
	 * Last modified: 29/05/2006
	 *-----------------------------
	 */
?>