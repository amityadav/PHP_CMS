<?
/*
 * Coded By Amit Yadav
 * Creation Date: 02/05/2006
 * Updation Date: 02/05/2006
 * 
 * DESCRIPTION: 
 *	This is the base class in which the basic configuration of the database is to be set
 */

	class dbCongigClass
	{
		var $_CFG_DB_HOST;
		var $_CHG_DB_USER;
		var $_CFG_DB_PASS;
		var $_CFG_DB_DATABASE;

		function dbCongigClass()
		{
			$this->_CFG_DB_HOST = _CFG_DB_HOST;
			$this->_CHG_DB_USER = _CHG_DB_USER;
			$this->_CFG_DB_PASS = _CFG_DB_PASS;
			$this->_CFG_DB_DATABASE = _CFG_DB_DATABASE;
		}
	}
?>