<?php
/*
 *-----------------------------
 * Author: Amit Yadav
 * Date created: 02/05/2006
 * last modified: 02/05/2006
 *-----------------------------
 *
 * DESCRIPTION:
 *	This class holds all the function required to communicate with the database
 */

require_once("dbConfig.inc");
$connected=false;

class dbClass extends dbCongigClass
{

	var $num_rows;
	var $sql_result;

function send_dbmail($var) {
  $from = "amit.yadav@catchurmate.com";
  //mail("amit.yadav@catchurmate.com","DB Connection Error","$var","From: $from");
}

function db_pconnect() {
  $this->db_connect(1);
}

function db_connect($persist=0) {
   global $connection;
   global $connected;
   global $ki;
   global $whichfile;
   
   $whichfile = "dbConfig.inc";
   if (!($connected===true)) {
      $try=1;
      $tries=3;
      $wait=30;
      $connection=false;
      while ($try<=$tries && !$connection) {
         if (!$persist) $connection = mysql_connect($this->_CFG_DB_HOST, $this->_CHG_DB_USER, $this->_CFG_DB_PASS);
         else $connection = mysql_pconnect($this->_CFG_DB_HOST, $this->_CHG_DB_USER, $this->_CFG_DB_PASS);
         if (!$connection) {
            $this->send_dbmail("cannot connect with user " . $this->_CHG_DB_USER . " in $whichfile try $try of $tries persist:$persist");
            sleep($wait);
            $try++;
         } else {
            $this->select_db();
            $connected=true;
         }
      }
      if (!$connection) {
         $this->send_dbmail("Cannot connect with user $uname in $tries tries wait:$wait in $whichfile");
         $this->goback("Connect Error.");
      } elseif ($try>1) { $this->send_dbmail("$uname selected on try:".$try); }
   }
}





function select_db($dbnamevar="") {
   global $connection;
   global $whichfile;
   global $dbname;

   $dbname = $this->_CFG_DB_DATABASE;
   $try=1;
   $tries=3;
   $wait=3;
   $db=false;
   if (!$dbname) $this->goback("missing dbname");
   while ($try<=$tries && !$db) 
	{
  	      $db = mysql_select_db($dbname);
	      if (!$db) {
			echo "cannot select $dbname in $whichfile try $try of $tries<br>";
			$this->send_dbmail("cannot select $dbname in $whichfile try $try of $tries");
			sleep($wait);
			$try++;
	      }
	}

   if (!$db) 
   {
	$this->send_dbmail("cannot select $dbname in $tries tries wait:$wait in $whichfile");
	$this->goback("Select Error.");
   } 
   elseif ($try>1) 
	{ 
		$this->send_dbmail("$dbname selected on try:".($try-1)); 
	}
}





function send_query($sql,$numids=0) {
   global $connection;
   global $whichfile;
   global $err;
   global $connected;
   $this->num_rows=0;
   if (!$connected) 
		$this->db_pconnect();
   $this->sql_result = mysql_query($sql);
   #echo $sql . "<br>";
   if(!$this->sql_result){
	$this->num_rows = 0;
	echo "<br>" . $sql." : ". mysql_error();
   }else{
        $this->check_num_rows();
   }
}




function goback($txt)
{
	print($txt);
	die("Further execution halted");
}




function dbarray() {
global $resultset;
$i=0;
$resultset = "";
if($this->sql_result){
	while($arr = mysql_fetch_assoc($this->sql_result))
		{
			foreach($arr as $field => $fieldValue)
				{
					$resultset[$i][$field]=$fieldValue;
				}
			$i++;
		}
	   return $resultset;
}else{
		echo "Cannot fetch data from the table.";
	die();
}
}



function check_num_rows() {
   $this->num_rows = @mysql_num_rows($this->sql_result);
}



function send_update($sql) {
   global $connection;
   global $whichfile;
   global $err;
   global $connected;
   global $error_num;
   if (!$connected) 
		$this->db_pconnect();
   $this->sql_result = mysql_query($sql);
   //echo $sql . "<br>";
   if(mysql_errno() > 0 ){
	return 0;
   }else{
	return mysql_affected_rows() ;
   }
}




function send_delete($sql) {
   global $connection;
   global $whichfile;
   global $err;
   global $connected;
   if (!$connected) 
		$this->db_pconnect();
   $this->sql_result = mysql_query($sql);
   if(mysql_errno() > 0 ){
	return 0;
   }else{
	return mysql_affected_rows() ;
   }
}





function send_insert($sql) {
   global $connection;
   global $whichfile;
   global $err;
   global $connected;
   global $error_num;
   if (!$connected) 
		$this->db_pconnect();
   $this->sql_result = mysql_query($sql);
   echo mysql_error();
   if(mysql_errno() > 0 ){
	return 0;
   }else{
	return mysql_affected_rows() ;
   }
}

function get_last_inserted(){
   return mysql_insert_id();
}

}//End of the databse class

?>