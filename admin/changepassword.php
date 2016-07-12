<?
	include("include.inc");
?>

<html>
<head>
<title><?=_ADMIN_CHANGE_PASSWORD?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body topmargin="0" leftmargin="0"  background="<?=_CFG_IMAGE_PATH?>bg.gif">

<form name="frmChangePassword" method="post" action="changepasswordfinal.php" onSubmit="return validate()">
<table width="100%" border="0" cellpadding="0" cellspacing="0"   background="<?=_CFG_IMAGE_PATH?>bg.gif">
  <tr>
    <td>
<?
	include("header.php");
?>
	<br><br>
    </td>
  </tr>
  <tr>
    <td>
	<p align="center">
	<?
		if($_SESSION["er"] != "")
		{
	  ?>
		  <table width="43%" border="0">
			<tr>
			  <td height="39" class="titleboldRed" align="center"><?=$_SESSION["er"]?></td>
			</tr>
		  </table>
	  <?
	  		$_SESSION["er"] = "";
	  	}
	  ?>
	  </p>
	  <table width="48%" height="150" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px solid #CFCFCF">
	  <tr>
	  <td>
	  <table width="100%" height="150" border="0" align="center" cellpadding="0" cellspacing="0">
      
      <tr class="trblueOdd">
       
        <td class="titlebold" bgcolor="#A3B181" valign="middle"><FONT COLOR="#FFFFFF"><?=_ADMIN_CHANGE_PASSWORD?></FONT></td>
      </tr>
      
      <tr>
       
        <td valign="top">
          <table width="100%" border="0" cellspacing="1" cellpadding="8">

            <tr class="trblueOdd">
              <td width="33%" height="26"><div align="right"><?=_ADMIN_OLD_PASSWORD?></div></td>
              <td width="2%">&nbsp;</td>
              <td width="65%"><input name="oldpass" type="password" class="textfield" id="oldpass"></td>
            </tr>

            <tr class="trblueOdd">
              <td width="33%" height="26"><div align="right"><?=_ADMIN_NEW_PASSWORD?></div></td>
              <td width="2%" height="26">&nbsp;</td>
              <td width="65%" height="26"><input name="newpassword" type="password" class="textfield" id="newpassword"></td>
            </tr>
            
            <tr class="trblueOdd">
              <td width="33%" height="26"><div align="right"><?=_ADMIN_RE_NEW_PASSWORD?></div></td>
              <td width="2%" height="26">&nbsp;</td>
              <td width="65%" height="26"><input name="renewpassword" type="password" class="textfield" id="renewpassword"></td>
            </tr>
            
			
			<tr class="trblueOdd">
              <td height="26"><div align="center">                </div></td>
              <td height="26">&nbsp;</td>
              <td height="26">
                <div align="left">
  <input type="submit" name="Submit" value="<?=_ADMIN_CHANGE_PASSWORD?>" class="commonbutton">
&nbsp;&nbsp;&nbsp;
  <input type="button" name="Submit2" value="<?=_BACK_CONTENT_BUTTON_TEXT?>" class="commonbutton" onClick="window.location='adminarea.php'">
                </div></td>
			</tr>
            
          </table>
        </td>
       
      </tr>
      
    </table></td>
  </tr>
</table>
</td>
  </tr>
</table>
</form>
</body>
</html>

<?
	include("footer.php");
?>

<script>
function validate()
{
	var f = document.frmChangePassword;
	var flg = 0;
	var msg = "<?=_JAVASCRIPT_START_LINE?>";

	if(f.oldpass.value == "")
	{
		msg += "<?=_ADMIN_OLD_PASSWORD_BLANK?>";
		flg = 1;
	}
	
	if(f.newpassword.value == "")
	{
		msg += "<?=_ADMIN_NEW_PASSWORD_BLANK?>";
		flg = 1;
	}else{
		if(f.newpassword.value.length < 6)
		{
			msg += "<?=_ADMIN_PASSWORD_CONDITION?>";
			flg = 1;
		}
	}
	
	if(f.renewpassword.value == "")
	{
		msg += "<?=_ADMIN_RE_PASSWORD_BLANK?>";
		flg = 1;
	}
	
	if(f.newpassword.value != "" && f.renewpassword.value != "")
	{
		if(f.newpassword.value != f.renewpassword.value)
		{
			msg += "<?=_ADMIN_PASSWORD_NOT_MATCH?>";
			flg = 1;
		}
	}
	
	if(flg == 1)
	{
		 alert(msg);
		 return false;
	}
	else
	{
		return true;
	}
}
</script>