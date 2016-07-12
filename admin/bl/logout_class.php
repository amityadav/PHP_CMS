<?
	//This is used to logout the admin from the admin area

	class adminLogout
	{
		function adminLogout()
		{
			session_start();
			session_unset();
			session_destroy();	
		}

	}//End of the class
?>