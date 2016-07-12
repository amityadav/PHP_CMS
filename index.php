<?php
include("_page.php");
if(!isset($_REQUEST["_p_"]) || empty($_REQUEST["_p_"]))
{
	$pg_id = "1";
}

else
{
	$pg_id = $_REQUEST["_p_"];
}	

	$query1 = "select * from tblcontents where isActive = '1' and contentid = '".$pg_id."'order by listorder";
	$result=mysql_query($query1);
	$pg_name = mysql_fetch_array($result);
	
include("leftmenu.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $pageTitle?></title>
<link rel=stylesheet type="text/css" href="admin/FCKeditor/editor/css/fck_editorarea.css">
<link href="tools/style.css" rel="stylesheet" type="text/css" />
<?=$metaInfo;?>

<script language="JavaScript1.2" src="tools/coolmenus4.js"></script>
</head>
<body>
<?
	$query = "select * from tblcontents where isActive = '1' order by listorder";
	$result=mysql_query($query);
	?>

<table width="756" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="5" class="sdw-left"><img src="images/left_sdw.gif" alt="" width="5" height="5" /></td>
    <td class="main-bg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="75" class="logo"><img src="images/logo.gif" alt="" width="220" height="75" border="0" /></td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="307" valign="top" style="position:relative"><div id="divMenu"></div>
						<?php echo $menuTxt?>
					</td>
                <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><img src="images/ban_home.jpg" alt="" width="538" height="223" /></td>
                    </tr>
                    <tr>
                      <td class="head"><?=$pg_name["contentname"]?></td>
                    </tr>
                    <tr>
                      <td height="190" valign="top" class="container"><!--Content part start here-->
                       <?=$content;?> 
                        <!--Content part start here-->
                      </td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td height="18" align="right" class="copyright">&copy; <a href="http://amityadav.name">Amityadav.name</a></td>
        </tr>
        <tr>
          <td style="height:12px;"></td>
        </tr>
      </table></td>
    <td width="5" class="sdw-right"><img src="images/right_sdw.gif" alt="" width="5" height="4" /></td>
  </tr>
</table>
</body>
</html>
