<?
	include("include.inc");
	include(_LIB_PATH ."bl/changepassword_class.php");
	
	$oldPass = $_REQUEST["oldpass"];
	$newPass = $_REQUEST["newpassword"];
	$reNewPass = $_REQUEST["renewpassword"];
	$userid = $_SESSION["userid"];

	$changePasswordObject = new changeAdminPassword($newPass, $oldPass, $userid);

	if(is_object($changePasswordObject))
	{
		$reqult = $changePasswordObject->changePassword();

		switch($reqult)
		{
			case 1;
						$_SESSION["er"] = _DATA_MISSING;
						echo "<script>location.replace('changepassword.php')</script>";
						break;
			case 2:
						$_SESSION["er"] = _OLD_PASSWORD_INCORRECT;
						echo "<script>location.replace('changepassword.php')</script>";
						break;
			case 3:
						$_SESSION["er"] = _PASSWORD_CHANGED_SUCCESSFULLY;
						echo "<script>location.replace('changepassword.php')</script>";
						break;
		}
	}else{
			$_SESSION["er"] = _DATA_MISSING;
			echo "<script>location.replace('changepassword.php')</script>";
			break;
	}
?>