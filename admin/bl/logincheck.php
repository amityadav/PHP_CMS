<?
//Admin login check class

class authenticate
{
	var $userName;
	var $userPassword;

	function authenticate($user, $password)
	{
		
		if($user != "" && $password != "")
		{
			$this->userName = $user;
			$this->userPassword = $password;
		}else{
			return NULL;
		}
	}

	function authenticateUser()
	{
		global $dbObject;

		$strQuery = "SELECT * FROM tblusers WHERE username = '" . $this->userName . "' AND password = '" . $this->userPassword . "'";
		$dbObject->send_query($strQuery);
		
		if($dbObject->num_rows > 0)
		{
			$userArray = $dbObject->dbarray();
			
			$_SESSION['userid'] = $userArray[0]['userid'];
			$_SESSION['type'] = $userArray[0]['type'];
			$_SESSION['admin'] = '1';
			return true;
		}else{
			return false;
		}
	}
}
?>