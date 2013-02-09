<?php   


/* 
##    Simple Database Abstraction Layer 1.2.1 [lib.sdba.php] 
##    by Gabe Bauman <gabeb@canada.com> 
##    Wednesday, April 05, 2000 
##    extended by Michael Howitz <icemac@gmx.net> 
##    Thuesday, Jun 15, 2000 
## 
##    extended by Dirk Howard <dirk@idksoftware.com> 
##    Tuesday, August 28, 2001 
## 
##    Easy way to read and write to any (!)  database. 
##    Subclasses for MySQL (CDBMySQL), Oracle (CDB_OCI8) and 
##    PostgreSQL (CDB_pgsql) have been written. 
## 
##    Changes in 1.1 from 1.0: 
##      - added the optional $dbname parameter to the constructor 
##         of the base class. If specified, it calls SelectDB for you. 
##      - function results now use 1 and 0 rather than true or false. 
##      - minor efficiency fixes 
##       
##    Changes in 1.2 from 1.1: 
##      - added support for: Commit, Rollback, SetAutoCommit 
##      - added subclass for oracle (OCI8) support 
## 
##    Changes in 1.2.1 from 1.2: 
##      - added subclass for Postgresql (pgsql) support 
## 
##    Usage: 
## 
##    $sql = new CDB_OCI8 ($DB_HOST, $DB_USER, $DB_PASS); 
##    $sql -> Query("SELECT Lastname, Firstname FROM people"); 
##    while ($sql -> ReadRow()) { 
##      print $sql -> RowData["Lastname"] . "," . $sql -> RowData["Firstname"] . "<br>\n"; 
##    } 
##    $sql -> Close(); 
## 
##    If you use this software, please leave this header intact. 
##    Please send any modifications/additions to the author for 
##    merging into the distribution (like other DB subclasses!) 
*/  

$appGlobalLinkID = 0;

class CDBAbstract {   
  var $_db_linkid = 0;   
  var $_db_qresult = 0;  
  var $_auto_commit = false;  
  var $RowData = array();   
  var $NextRowNumber = 0;   
  var $RowCount = 0;  
  var $LastInsertID = 0;
  var $CurrentRow = -1;
  function CDBAbstract () {   
    die ("CDBAbstract: Do not create instances of CDBAbstract! Use a subclass.");   
  }  
  function Open ($host, $user, $pass, $db = "", $autocommit = true) {   
  }  
  function Close () {  
  }  
  function SelectDB ($dbname) {  
  }  
  function Query ($querystr) {  
  }  
  function SeekRow ($row = 0) {  
  }  
  function ReadRow () {  
  }  
  function Commit () {  
  }  
  function Rollback () {  
  }  
  function SetAutoCommit ($autocommit) {  
    $this->_auto_commit = $autocommit;  
  }  
  function _ident () {   
    return "CDBAbstract/1.2";   
  }  
}  

class cDB extends CDBAbstract {   
  function cDB ($host = "", $user = "", $pass = "", $db = "") {   
    global $appDBHost, $appDBUser, $appDBPassword, $appDBDatabase;
	$UseGlobal = false;
	if (!$host) {
		$host = $appDBHost;
		$UseGlobal = true;
	}
	if (!$user) $user = $appDBUser;
	if (!$pass) $pass = $appDBPassword;
	if (!$db) $db = $appDBDatabase;
    $this->Open ($host, $user, $pass, $UseGlobal);   
    if ($db != "")    
      $this->SelectDB($db);   
  }     
  function Open ($host = "", $user = "", $pass = "", $UseGlobal = true, $autocommit = true) {   
    global $appDBHost, $appDBUser, $appDBPassword, $appGlobalLinkID;
	if (!$host) $host = $appDBHost;
	if (!$user) $user = $appDBUser;
	if (!$pass) $pass = $appDBPassword;
	if ($UseGlobal and $appGlobalLinkID) {
		$this->_db_linkid = $appGlobalLinkID;
	} else {
	    $this->_db_linkid = mysql_connect ($host, $user, $pass);
		if ($UseGlobal) $appGlobalLinkID = $this->_db_linkid;
	}
  }     
  function Close () {   
    @mysql_free_result($this->_db_qresult);   
	if ($this->_db_linkid != $appGlobalLinkID) {
	    return mysql_close ($this->_db_linkid);   
	} else {
		$this->_db_linkid = 0;
		return true;
	}
  }     
  function SelectDB ($dbname = "") {   
  	global $appDBDatabase;
	if (!$dbname) $dbname = $appDBDatabase;
    if (@mysql_select_db ($dbname, $this->_db_linkid) == true) {   
      return 1;       
    }    
    else {   
      die( HandleError ( "MySQL: Unable to select database $dbname."));
    }      
  }      
  function  Query ($querystr) {   
    $result = mysql_query ($querystr, $this->_db_linkid);   
    if ($result == 0) {   
      die( HandleError ( "MySQL Query Error: " . @mysql_error() . "<BR><BR>Query: " . $querystr));
    }    
    else {   
      if ($this->_db_qresult) @mysql_free_result($this->_db_qresult);   
      $this->RowData = array();         
      $this->_db_qresult = $result;   
      $this->RowCount = @mysql_num_rows ($this->_db_qresult);   
	  $this->CurrentRow = -1;
      if (!$this->RowCount) {   
    		// The query was probably an INSERT/REPLACE etc. 
			$this->LastInsertID = @mysql_insert_id( $this->_db_linkid);
    		$this->RowCount = 0;   
      }    
      return 1;   
    }   
  }     
  function SeekRow ($row = 0) {   
    if ($this->RowCount) {
	    if ((!mysql_data_seek ($this->_db_qresult, $row)) or ($row > $this->RowCount-1)) {  
	      die( HandleError ("MySQL: Cannot seek to row $row."));   
	      return 0;   
	    }   
	    else {   
		  $this->CurrentRow = $row;
	      return 1;   
	    }   
	} else {
		return 1;
	}
  }       
  function ReadRow () {   
    if($this->RowData = mysql_fetch_array ($this->_db_qresult)) {   
      $this->NextRowNumber++;  
	  $this->CurrentRow++; 
      return 1;   
    }   
    else {   
      return 0;   
    }   
  }     
  function Commit () {  
    return 1;  
  }  
  function Rollback () {  
    die( HandleError ( "WARNING: Rollback is not supported by MySQL"));  
  }  
  function _ident () {   
    return "CDBMySQL/1.2";   
  }     
}   

class cSessionDB extends cDB {   
  function cSessionDB ($host = "", $user = "", $pass = "", $db = "") {   
    global $appDBHost, $appDBUser, $appDBPassword, $appSessionDatabase;
	if (!$host) $host = $appDBHost;
	if (!$user) $user = $appDBUser;
	if (!$pass) $pass = $appDBPassword;
	if (!$db) $db = $appSessionDatabase;
    $this->Open ($host, $user, $pass, false);   
    if ($db != "")    
      $this->SelectDB($db);   
  }
  function _ident () {   
    return "session db object";   
  }     
}

/* 
##                                    Example 
## $sql = new CDBMySQL("localhost", "username", "password", "dbname"); 
## $sql -> Query ("SELECT firstname, lastname FROM people"); 
## while ($sql -> ReadRow()) { 
##   echo $sql -> RowData["lastname"] . ", "; 
##   echo $sql -> RowData["firstname"] . "<br>"; 
## }     
*/ 

?>