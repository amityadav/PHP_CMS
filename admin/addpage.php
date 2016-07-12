<?
	ob_start();
	include("include.inc");	
	

	/*
	 *-----------------------------
	 * Author: Amit Yadav
	 * Date reated: 15/05/2006
	 * last modified: 31/05/2006
	 *-----------------------------
	 */
?>

<head>
<title>
	<?=_SITE_ADMIN_TEXT?>
</title>
<script language="javascript" type="text/javascript" src="tiny_mce/tiny_mce.js"></script>

</head>
<?
	if($_REQUEST["isPosted"] == 1)
	{
		$pageName = $_REQUEST["pageName"];
		$page_title = $_REQUEST["page_title"];
		$meta_keywords = $_REQUEST["meta_keywords"];
		$meta_tags = $_REQUEST["meta_tags"];
		$content = $_REQUEST["FCKeditor1"];

		$pageObj = new pageContent();
		$pageObj->addNewPage($pageName, $page_title, $meta_keywords, $meta_tags, $content, $listorder);
		
		
		
		$_SESSION["er"] = _CFG_PAGE_ADD_SUCCESS;
		$con_id = mysql_insert_id();
		header("Location: editcontent.php?content=".$con_id."&from=m");
		exit;
	}
?>
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
  ?><tr>
	<td>
	<div id="addPageTable" class="title">
	<form name="frmAddPage" action="addpage.php" method="post" onSubmit="return validate()">
		<table width="97%" border="0" cellpadding="4" cellspacing="0" style="border: 1px solid #666666" align="center">
			<input type="hidden" name="isPosted" value="1"><tr>
				<td class="trRed">
					Add New Page
				</td>
			</tr><tr valign="top">
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="8">
						<tr>
							<td>
							  <input type="submit" name="submit" value="<?=_ADD_CONTENT_BUTTON_TEXT?>" class="commonbutton">	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="button" name="back" value="<?=_BACK_CONTENT_BUTTON_TEXT?>" class="commonbutton" onClick="window.location='adminarea.php'">
							</td>
						</tr>	
						<tr class="trblueOdd">
						  <td width="100%" height="26" class="titlebold"><div align="right">
							<table width="100%" border="0" cellpadding="8" cellspacing="0">
							  <tr>
								<td><span class="titlebold"><?=_CONTENT_PAGE_TEXT?></span>&nbsp;<span class="title">
								  <input type="text" name="pageName" value="" class="textfield">
								</span></td>
							  </tr>
							  
							  <tr>
								<td><span class="titlebold"><?=_CONTENT_?></span></td>
							  </tr>
							  <tr>
								<td style="nowrap:true">
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
							  </tr>
							  
							  <tr>
								<td class="titlebold">
									<?=_CONTENT_PAGE_TITLE?>
								</td>
							  </tr>

							  <tr>
								<td>
									<input type="text" class="textField" name="page_title" size="137">
								</td>
							  </tr>

							  <tr>
								<td class="titlebold">
									<?=_CFG_META_KEYWORDS?>
								</td>
							  </tr>

							  <tr>
								<td valign="top">
									<textarea class="textField" rows="12" cols="134" name="meta_keywords"><?=$metakeywords?></textarea> 
									<a href="help/hlp_meta_keywords.php" target="popup" onClick="touWindow=window.open('help/hlp_meta_keywords.php','touWindow','status=yes,scrollbars=1,toolbar=no,menubar=no,location=no,width=500,height=450');touWindow.focus(); return false;" class="title">Help[?]</a>
								</td>
							  
							  <tr>
								<td class="titlebold">
									<?=_CFG_META_TAGS?>
								</td>
							  </tr>

							  <tr>
								<td valign="top">
									<textarea class="textField" rows="12" cols="134" name="meta_tags"><?=$metatags?></textarea>
									<a href="help/hlp_meta_tags.php" target="popup" onClick="touWindow=window.open('help/hlp_meta_tags.php','touWindow','status=yes,scrollbars=1,toolbar=no,menubar=no,location=no,width=500,height=300');touWindow.focus(); return false;" class="title">Help[?]</a>
								</td>
							  </tr>


							  <tr>
								<td>
								  <input type="submit" name="submit" value="<?=_ADD_CONTENT_BUTTON_TEXT?>" class="commonbutton">	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="button" name="back" value="<?=_BACK_CONTENT_BUTTON_TEXT?>" class="commonbutton" onClick="window.location='adminarea.php'">
								</td>
							  </tr>
						</table>
					</td>
				</tr>
			</table>
		</form>
	</div>
	</td>
  </tr>
  </table>
  </body>

<script>
function validate()
{
	var f = document.frmAddPage;

	if(f.pageName.value == "")
	{
		alert('<?=_CFG_PAGE_ADD_ERROR?>');
		f.pageName.focus();
		return false;
	}
	
	/*if(f.page_title.value == "")
	{
		alert("");
		f..focus();
		return false;
	}

	if(f.meta_keywords.value == "")
	{
		alert("");
		f..focus();
		return false;
	}

	if(f.meta_tags.value == "")
	{
		alert("");
		f..focus();
		return false;
	}*/

	return true;
}
</script>
<?
	/*
	 *-----------------------------
	 * Author: Amit Yadav
	 * Date reated: 15/05/2006
	 * last modified: 31/05/2006
	 *-----------------------------
	 */
?>