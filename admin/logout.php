<?
	 include("include.inc");
	 include(_CFG_BUSINESS_LOGIC_PATH . "logout_class.php");
	 $logoutObj = new adminLogout();
?>
	 <script>
		location.replace("index.php");
	 </script>
<?
	 die();
?>
