<?
	session_start();
	/*
	 *-----------------------------
	 * Author: Amit Yadav
	 * Date reated: 03/11/2005
	 * last modified: 03/11/2005
	 *-----------------------------
	 */
	include("includefile.php");
    include(_CFG_LANGUAGE_PATH);
?>

<head>
<title>
	<?=_SITE_ADMIN_TEXT?>
</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body topmargin="0" leftmargin="0"  background="<?=_CFG_IMAGE_PATH?>bg.jpg" onLoad="document.login.username.focus();">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <?
	include("header.php");
?>
  <tr>
    <td><div align="center">
      <form name="login" method="post" action="logincheck.php" onSubmit="return validate()">
      <?
		if($_SESSION["er"] != "")
		{
	  ?>
		  <table width="43%" border="0">
			<tr>
			  <td height="39" class="fontRed" align="center"><?=$_SESSION["er"]?></td>
			</tr>
		  </table>
	  <?
	  		$_SESSION["er"] = "";
	  	}
	  ?>

	  <table width="23%" border="0" style="display:none" id="error_table">
		<tr>
		  <td height="39" class="fontRed" align="center" id="error_show"></td>
		</tr>
	  </table>
	
<table width="70%" border="0" cellpadding="0" cellspacing="0" bgcolor="">
        <tr>
			<td >&nbsp;</td>
			<td class="titlebold"><div align="center">Please Login (Username / Password => <font color="blue">admin / admin12</font>)</div></td>
			<td >&nbsp;</td>
		</tr> 
</table>

      <table width="30%" height="174" border="0" cellpadding="0" cellspacing="0" bgcolor="">
        <tr>
			<td height="23">&nbsp;</td>
			<td class="titlebold"><div align="center"><?=_PLEASE_LOGIN?></div></td>
			<td >&nbsp;</td>
		</tr> 
		<tr>
			<td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="8">
              <tr>
                <td width="39%" height="26" class="trblueOdd"><?=_USER_NAME?></td>
                <td width="2%" class="trblueOdd">&nbsp;</td>
                <td width="59%" class="trblueOdd"><input name="username" type="text" class="textField" id="username"></td>
              </tr>
              
              <tr>
                <td width="39%" height="26" class="trblueOdd"><?=_USER_PASSWORD?></td>
                <td width="2%" height="26" class="trblueOdd">&nbsp;</td>
                <td width="59%" height="26" class="trblueOdd"><input name="password" type="password" class="textField" id="password2" onkeypress="getKeyCode(event)"></td>
              </tr>
              
              <tr>
                <td width="39%" height="26" class="trblueOdd">&nbsp;</td>
                <td width="2%" height="26" class="trblueOdd">&nbsp;</td>
                <td width="59%" height="26" class="trblueOdd"><input type="button" name="Submit" value="<?=_BTN_SUBMIT?>" class="commonButton" onClick="validate()"></td>
              </tr>
            </table></td>
		</tr>
		</table>
      </form>
    </div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?
	include("footer.php");
?>

<script>
function validate()
{
	var f = document.login;
	var flg = 0;
		
	var msg = "<?=_JAVASCRIPT_START_LINE?>";
	if(f.username.value == "")
	{
		msg += "<?=_USERNAME_BLANK?>";
		flg = 1;
	}
	
	if(f.password.value == "")
	{
		msg += "<?=_PASSWORD_BLANK?>";
		flg = 1;
	}
	
	if(flg == 1)
	{
		 alert(msg);
		 return false;
	}
	else
	{
		xmlhttpPost(document.login.username.value, document.login.password.value);
	}
	
}


function xmlhttpPost(username, password) {	

	document.getElementById("error_table").style.display = "block" ;
	document.getElementById("error_show").innerHTML = "Logging in...<img src='images/ajax-loader.gif' border='0'>";

	var url ="logincheck.php";
	var posData = "?username=" + username + "&password=" + password;


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

	http_request.onreadystatechange = function() { checkLogin(http_request); };
	http_request.open('GET', url + posData, true);
	http_request.send(null);
}



function checkLogin(http_request){
	
	if (http_request.readyState == 4) {
            if (http_request.status == 200) 
			{
				resText = http_request.responseText;
				if(resText == 1)
				{
					window.location = "adminarea.php";
				}else{
					showError(resText);
				}
				
            } else {
                document.getElementById("error_show").innerHTML = '<?=_CFG_ERROR_LOGIN?>';
            }
        }
}

function showError(resText)
{
	document.getElementById("error_show").innerHTML = resText;
}


function onKeyPressBlockNumbers(e)
{
	var key = window.event ? e.keyCode : e.which;
	var keychar = String.fromCharCode(key);
	alert(key);
	reg = /\d/;
	return !reg.test(keychar);
}

function getKeyCode(e)
{
	var key = window.event ? e.keyCode : e.which;
	if(key == 13)
	{
		if(validate())
			document.login.submit();
	}
}

</script>
<?
	/*
	 *-----------------------------
	 * Author: Amit Yadav
	 * Date reated: 03/11/2005
	 * last modified: 03/11/2005
	 *-----------------------------
	 */
?>