<?php
################################################## 
# Start the session                              # 
################################################## 

//ini_set("session.gc_maxlifetime", 14440);
ini_set('session.cookie_lifetime', 0); 
ini_set('session.cache_expire', 0); 
date_default_timezone_set('Asia/Calcutta');
session_start();   

error_reporting(0);
//error_reporting(E_ALL ^ E_NOTICE);


// Set Database Parameters
$appDBHost					= 'localhost';
$appDBUser					= 'root';
$appDBPassword				= '';
$appDBDatabase				= 'inventory';

require '_incClass_mySQL.php';
require '_incGlobalFunctions.php';
//Include active directory class library
require_once('adLdap/adLDAP.php');
$ldap = true;
if ($ldap) {
	$CFG = new stdClass();
}


################################################## 
#          Registration form string              #
################################################## 

/**
 * put value here seperated by comma to list in dropdown of registration form @hardware
 */ 
$db = new cDB();
$db->Query("SELECT * FROM hz_hardware WHERE ctype = 'A'");
$i = 0;
$total =  $db->RowCount;
while ($db->ReadRow()){
	$i++;
	$hardware .= $db->RowData['name'];
	if ($i < $total){
		$hardware .= ",";
	}
}
//$hardware = 'DESKTOP,LAPTOP,PRINTER,SCANNER';

/**
 * put value here seperated by comma to list in dropdown of registration form @make
 */ 
$make = 'HP,DELL,LENOVO,SONY';

/**
 * put value here seperated by comma to list in dropdown of registration form @monitor
 */ 
$monitor = 'CRT,TFT';

/**
 * put value here seperated by comma to list in dropdown of registration form @assetcode
 */ 
$assetcode = 'SER,WS,DTP,MTR,LT,LP,DMP,DJP,LJP,SCNR,PLTR,NETSWT,MEDCVT,RTR,KVMSW,DIGTR,ELECT COPY BOARD,PRJTR,VCS';

/**
 * put value here seperated by comma to list in dropdown of registration form @msoffice
 */ 
$msoffice = '2003,2007,2010,NONE';

/**
 * put value here seperated by comma to list in dropdown of registration form @AMC/WAR
 */ 
$amcwar = 'AMC,WAR';


################################################## 
#              Network form string               #
################################################## 


/**
 * put value here seperated by comma to list in dropdown of registration form @make
 */ 
$ntwmake = 'CISCO,D-LINK';

################################################## 
#              Critical asset form string        #
################################################## 

/**
 * Available critical hardware list
 */
$db->Query("SELECT * FROM hz_hardware WHERE ctype = 'C'");
$i = 0;
$total =  $db->RowCount;
while ($db->ReadRow()){
	$i++;
	$criticalhardware .= $db->RowData['name'];
	if ($i < $total){
		$criticalhardware .= ",";
	}
}
//$criticalhardware = 'SERVER,ROUTER,FIREWALL,RF,WIRELESS,CORE SWITCH,IP CAMERA';

 
/**
 * put value here seperated by comma to list in dropdown of critical asset form @assetcode
 */
$criticalassetcode = 'SER,NETSWT,RTR,FLX';

/**
 * put value here seperated by hash(#) to list in dropdown of critical asset form @location
 */
$criticallocation = 'HZL,CZ'; 

/**
 * put value here seperated by comma(,) to list in dropdown of critical asset form @ip address / subnet
 */
$ipsubnet = '10.101.22.6/255.255.252.0,10.101.22.7/255.255.252.0,10.101.23.48/255.255.252.0,10.101.23.10/255.255.252.0,10.101.23.8/255.255.252.0,10.101.23.101/255.255.252.0,10.101.22.50/255.255.252.0,10.101.23.100/255.255.252.0,10.101.22.28/255.255.252.0,192.168.96.2 /255.255.252.0';

//Configuration
/**
 * put value here seperated by comma(,) to list in dropdown of critical asset form @Processor
 */
$configprocessor = 'XEON INTEL 3.00 GHZ,XEON INTEL 1.60GHZ,QUAD CORE XN 3.00 GHZ,2X QUAD CORE XN E5620 2.4 GHZ,XEON E5410 2.33 GHZ,64 RISC';

/**
 * put value here seperated by hash(,) to list in dropdown of critical asset form @ram
 */
$configram = '256MB,1GB,2GB,3GB,4GB,8GB';

 /**
 * put value here seperated by hash(#) to list in dropdown of critical asset form @hdd
 */
$confighdd = '160GB#240GB#140GB#360GB#280GB#300GB#8x146 SAS SFF HOT CHECKLIST PLUG#4X4GB SCSI#146GBx3 SAS SFF HOT PLUG HDD#146GBx3,72x3 SAS SFF HOT PLUG HDD';

/**
 * put value here seperated by comma(,) to list in dropdown of critical asset form @cdrom
 */
$configcdrom = 'CD-ROM,DVD RW,CD-RW,DVD COMBO,CD-RW/DVD COMBO DRIVE';

//Software
/**
 * put value here seperated by comma(,) to list in dropdown of critical asset form @cdrom
 */
$swOs = 'WIN SERVER 2003 STD EDITION SP2,WIN SERVER 2008 R2 STANDARD,TRU64 UNIX';


################################################## 
#              Other IT Asset form string        #
################################################## 

$db->Query("SELECT * FROM hz_hardware WHERE ctype = 'OA'");
$i = 0;
$total =  $db->RowCount;
while ($db->ReadRow()){
	$i++;
	$otherhardware .= $db->RowData['name'];
	if ($i < $total){
		$otherhardware .= ",";
	}
}
//$otherhardware = 'LAPTOP BATTERY,CARTAGE,DVD,MOUSE,KEYBOARD';


//Active Directory code FRom Msoni
$CFG = new stdClass();
$cfgDB = new cDB();
$cfgDB->Query('SELECT * FROM config');
if ($cfgDB->RowCount) {
	while ($cfgDB->ReadRow()) {
		$name = $cfgDB->RowData['name'];
		$CFG->$name = $cfgDB->RowData['value'];
	}
}
?>