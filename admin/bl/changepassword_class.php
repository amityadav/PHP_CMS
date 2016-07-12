<?
//This class is used to change the password for admin

class changeAdminPassword
{
	var $newPassword;
	var $oldPassword;
	var $userId;

	function changeAdminPassword($newPass, $oldPass, $userId)
	{
		if($newPass != "" && $oldPass != "" &&  $userId != "")
		{
			$this->newPassword = $newPass;
			$this->oldPassword = $oldPass;
			$this->userId = $userId;
		}else{
			return NULL;
		}
	}


	function changePassword()
	{
		global $dbObject;

		if($this->matchOldPassword())
		{
			$strQuery = "UPDATE tblusers SET password = '" . $this->newPassword . "' WHERE userid = '" . $this->userId . "'";
			$dbObject->send_query($strQuery);

			return 3;
		}else{
			return 2;
		}
	}


	function getUserOldPassword()
	{
		global $dbObject;
		
		$strQuery = "SELECT password from tblusers WHERE userid = '" . $this->userId . "'";
		$dbObject->send_query($strQuery);

		if($dbObject->num_rows > 0)
		{
			$testArray = $dbObject->dbarray();
			return $oPassword = $testArray[0]["password"];
		}
	}

	function matchOldPassword()
	{
		$oldPass = $this->getUserOldPassword();

		if($oldPass == $this->oldPassword)
		{
			return true;
		}else{
			return false;
		}
	}
}
?>