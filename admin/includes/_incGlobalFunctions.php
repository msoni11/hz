<?php

define ( 'jxRequired', true );
define ( 'jxNotRequired', false );
define ( 'jxAbortOnError', true );
define ( 'jxNoAbortOnError', false );


function PageRedirect( $thepage) {
	//if (header_sent()) {
	//	echo("<SCRIPT LANGUAGE='JavaScript'>window.location='$thepage';</script>");
	//} else {
		header( "Location: $thepage\n");
		die();
	//}
}

function HandleError( $theError = "") {
	global $appErrorPage;
	echo $theError;
	die();
	# PageRedirect ("$appErrorPage" . "?prmError=" . urlencode( "$theError"));
}

function QueryFormatSessionString( $theString) {
	if (trim( $theString) == "") {
		return "null";
	} else {
		return "'" . str_replace( "'", "''", $theString) . "'";
	}
}

function ListFind($list, $value, $delim = ",") {
	$f = 0;
	$i = 0;
	$l = $list;
	while ($i < strlen($delim)) {
		$l = explode(substr($delim,$i,1), $l);
		$i++;
	}
	foreach ($l as $j) {
		if ($j == $value) {
			$f = 1;
			break;
		}
	}
	return $f;
}

function ListGetAt($list, $pos, $delim = ",") {
	$f = "";
	$i = 0;
	$l = $list;
	while ($i < strlen($delim)) {
		$l = str_replace(substr($delim,$i,1), ",", $l);
		$i++;
	}
	$l = explode(",", $l);
	if ($pos >= 0)
		$f = $l[$pos];
	return $f;
}

function ListLen($list, $delim = ",") {
	$i = 0;
	$l = $list;

	if (strlen(trim($list)) == 0)
		return 0;

	while ($i < strlen($delim)) {
		$l = explode(substr($delim,$i,1), $l);
		$i++;
	}
	$j = count($l);
	return $j;
}

function ListFirst($list, $delim = ",") {
	$f = "";
	$i = 0;
	$l = $list;
	while ($i < strlen($delim)) {
		$l = explode(substr($delim,$i,1), $l);
		$i++;
	}
	$j = 0;
	if (count($l) > 0) $f = $l[$j];
	return $f;
}

function ListLast($list, $delim = ",") {
	$f = "";
	$i = 0;
	$l = $list;
	while ($i < strlen($delim)) {
		$l = explode(substr($delim,$i,1), $l);
		$i++;
	}
	$j = count($l)-1;
	if ($j >= 0) $f = $l[$j];
	return $f;
}

function ListAppend($list, $value, $delim = ",") {
	$delim = substr($delim,0,1);
	if ($list) return $list . $delim . $value;
	else return $value;
}

function ListValueCount($list, $value, $delim = ",") {
	$theCount = 0;
	$i = 0;
	$l = $list;
	while ($i < strlen($delim)) {
		$l = explode(substr($delim,$i,1), $l);
		$i++;
	}
	$value = trim($value);
	foreach ($l as $j) {
		$j = trim($j);
		if ($j == $value) {
			$theCount++;
		}
	}
	return $theCount;
}

function ListValueCountNoCase($list, $value, $delim = ",") {
	$theCount = 0;
	$i = 0;
	$l = $list;
	while ($i < strlen($delim)) {
		$l = explode(substr($delim,$i,1), $l);
		$i++;
	}
	$value = trim(strtolower($value));
	foreach ($l as $j) {
		$j = trim(strtolower($j));
		if ($j == $value) {
			$theCount++;
		}
	}
	return $theCount;
}

function DollarFormat($number) {
	if ($number)
		return '$' . number_format(round($number, 2), 2);
	else
		return '$0.00';
}

function Month($date) {
	$theMonth = ListGetAt($date, 1, ': -');
	$theDay = ListGetAt($date, 2, ': -');
	$theYear = ListGetAt($date, 0, ': -');

	$thestamp = mktime(0, 0, 0, $theMonth, $theDay, $theYear);
	return Date('n', $thestamp);
}

function Day($date) {
	$theMonth = ListGetAt($date, 1, ': -');
	$theDay = ListGetAt($date, 2, ': -');
	$theYear = ListGetAt($date, 0, ': -');

	$thestamp = mktime(0, 0, 0, $theMonth, $theDay, $theYear);
	return Date('j', $thestamp);
}

function DayOfWeek($date) {
	$theMonth = ListGetAt($date, 1, ': -');
	$theDay = ListGetAt($date, 2, ': -');
	$theYear = ListGetAt($date, 0, ': -');

	$thestamp = mktime(0, 0, 0, $theMonth, $theDay, $theYear);
	return Date('D', $thestamp);
}

function Year($date) {
	$theMonth = ListGetAt($date, 1, ': -');
	$theDay = ListGetAt($date, 2, ': -');
	$theYear = ListGetAt($date, 0, ': -');

	$thestamp = mktime(0, 0, 0, $theMonth, $theDay, $theYear);
	return Date('Y', $thestamp);
}

function modSearchKeyword($theField, $theString) {
	$theClause				= '';
	$theString				= trim($theString);

	$arySpecialChars		= array('\\','~','`','!','@','#','$','%','^','&','(',')','_','-','=','+','{','}','[',']','|','\\',':',';','<','>',',','.','/','?');
	$theString				= str_replace($arySpecialChars, ' ', $theString);
	$theString				= trim($theString);
	$theString				= preg_replace("(\s\s+)", " ", $theString);
	$theString				= str_replace("'", "''", $theString);
	$theString				= trim($theString);

	if ($theField and $theString) {
		$prmArr = explode(' ', $theString);
		$prmArr2 = explode(',', $theField);
		if (is_array($prmArr2)) {
			foreach ($prmArr2 as $j) {
				$j = trim($j);
				$theClause .= '(';
				if (is_array($prmArr)) {
					foreach ($prmArr as $i) {
						$i = trim($i);
						$theClause .= "LOWER($j) LIKE '%" . strtolower($i) . "%'";
						if (count($prmArr) > 1 and next($prmArr)) {
							$theClause .= ' OR ';
						}
					}
				}
				$theClause .= ')';
				if (count($prmArr2) > 1 and next($prmArr2)) {
					$theClause .= ' OR ';
				}
			}
		}
	}

	return $theClause;
}

function mod2SearchKeyword($theField, $theString) {
	$theClause				= '';
	$theString				= trim($theString);

	$arySpecialChars		= array('\\','~','`','!','@','#','$','%','^','&','(',')','_','-','=','+','{','}','[',']','|','\\',':',';','<','>',',','.','/','?');
	$theString				= str_replace($arySpecialChars, ' ', $theString);
	$theString				= trim($theString);
	$theString				= preg_replace("(\s\s+)", " ", $theString);
	$theString				= str_replace("'", "''", $theString);
	$theString				= trim($theString);

	if ($theField and $theString) {
		$prmArr = explode(' ', $theString);
		$prmArr2 = explode(',', $theField);
		if (is_array($prmArr2)) {
			foreach ($prmArr2 as $j) {
				$j = trim($j);
				$theClause .= '(';
				if (is_array($prmArr)) {
					foreach ($prmArr as $i) {
						$i = trim($i);
						$theClause .= "LOWER($j) LIKE '%" . strtolower($i) . "%'";
						if (count($prmArr) > 1 and next($prmArr)) {
							$theClause .= ' AND ';
						}
					}
				}
				$theClause .= ')';
				if (count($prmArr2) > 1 and next($prmArr2)) {
					$theClause .= ' AND ';
				}
			}
		}
	}

	return $theClause;
}



// XML Parser code
function GetChildren($vals, &$i) {
	$children = array();     // Contains node data
	/* Node has CDATA before it's children */
	if (isset($vals[$i]['value']))
		$children['VALUE'] = $vals[$i]['value'];

	/* Loop through children */
	while (++$i < count($vals)) {
		switch ($vals[$i]['type']) {
			/* Node has CDATA after one of it's children (Add to cdata found before if this is the case) */
			case 'cdata':
				if (isset($children['VALUE']))
					$children['VALUE'] .= $vals[$i]['value'];
				else
					$children['VALUE'] = $vals[$i]['value'];
			break;
			/* At end of current branch */
			case 'complete':
				if (isset($vals[$i]['attributes'])) {
					$children[$vals[$i]['tag']][]['ATTRIBUTES'] = $vals[$i]['attributes'];
					$index = count($children[$vals[$i]['tag']])-1;

					if (isset($vals[$i]['value']))
						$children[$vals[$i]['tag']][$index]['VALUE'] = $vals[$i]['value'];
					else
						$children[$vals[$i]['tag']][$index]['VALUE'] = '';
				}
				else {
					if (isset($vals[$i]['value']))
						$children[$vals[$i]['tag']][]['VALUE'] = $vals[$i]['value'];
					else
						$children[$vals[$i]['tag']][]['VALUE'] = '';
				}
			break;
			/* Node has more children */
			case 'open':
				if (isset($vals[$i]['attributes'])) {
					$children[$vals[$i]['tag']][]['ATTRIBUTES'] = $vals[$i]['attributes'];
					$index = count($children[$vals[$i]['tag']])-1;
					$children[$vals[$i]['tag']][$index] = array_merge($children[$vals[$i]['tag']][$index],GetChildren($vals, $i));
				}
				else {
					$children[$vals[$i]['tag']][] = GetChildren($vals, $i);
				}
			break;
			/* End of node, return collected data */
			case 'close':
				return $children;
		}
	}
}

/* Function will attempt to open the xmlloc as a local file, on fail it will attempt to open it as a web link */
function GetXMLTree($xmlloc) {
	if (file_exists($xmlloc))
		$data = implode('', file($xmlloc));
	else {
		$fp = fopen($xmlloc,'r');
		$data = fread($fp, 100000000);
		fclose($fp);
	}

	$parser = xml_parser_create('ISO-8859-1');
	//xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
	xml_parse_into_struct($parser, $data, $vals, $index);
	xml_parser_free($parser);

	$tree = array();
	$i = 0;

	if (isset($vals[$i]['attributes'])) {
		$tree[$vals[$i]['tag']][]['ATTRIBUTES'] = $vals[$i]['attributes'];
		$index = count($tree[$vals[$i]['tag']])-1;
		$tree[$vals[$i]['tag']][$index] =  array_merge($tree[$vals[$i]['tag']][$index], GetChildren($vals, $i));
	}
	else
	    $tree[$vals[$i]['tag']][] = GetChildren($vals, $i);

	return $tree;
}
// Here's my function for displaying complex array's /* Used to display detailed information about an array */
function printa($obj) {
	global $__level_deep;
	if (!isset($__level_deep)) $__level_deep = array();

	if (is_object($obj))
		print '[obj]';
	elseif (is_array($obj)) {
		foreach(array_keys($obj) as $keys) {
			array_push($__level_deep, "[".$keys."]");
			printa($obj[$keys]);
			array_pop($__level_deep);
		}
	}
	else print implode(" ",$__level_deep)." = $obj<BR>";
}

//***********************************************************************************************
function CreateCrumbText2($thePageID) {
//
// Called from _incPageSetup.php
// Returns breadcrumbs from intPageID
// Author:  MS 2/8/07
//***********************************************************************************************

	global $appRootURL, $appCrumbColor;
	$theCrumbText = '';
	if ($thePageID) {
		$theCrumbText = Lookup("Pages", "intPageID", "strCrumbText", $thePageID);
		$theParentID = Lookup("Pages", "intPageID", "intParentID", $thePageID);

		if ($theParentID) {
			$noClick = Lookup("Pages", "intPageID", "bitNoClick", $theParentID);
			$theParentCrumbText = Lookup("Pages", "intPageID", "strCrumbText", $theParentID);
			if ($noClick == 0) {
				$theURL = "$appRootURL/page.php/prmID/$theParentID";
				$theCrumbText = "<A CLASS=\"CrumbText\" STYLE=\"Color: $appCrumbColor;\" HREF=\"$theURL\">  $theParentCrumbText</A> > " . $theCrumbText;
				}
				else {
				$theCrumbText = $theParentCrumbText . ' > ' . $theCrumbText;
			}
		}

	if ($theParentID) {
		$theParentID = Lookup("Pages", "intPageID", "intParentID", $theParentID);

		if ($theParentID) {
			$noClick = Lookup("Pages", "intPageID", "bitNoClick", $theParentID);
			$theParentCrumbText = Lookup("Pages", "intPageID", "strCrumbText", $theParentID);
			if ($noClick == 0) {
				$theURL = "$appRootURL/page.php/prmID/$thePageID";
				$theCrumbText = "<A CLASS=\"CrumbText\" STYLE=\"Color: $appCrumbColor;\" HREF=\"$theURL\">  $theParentCrumbText</A> > " . $theCrumbText;
				}
				else {
				$theCrumbText = $theParentCrumbText . ' > ' . $theCrumbText;
			}
		}
	}

	return $theCrumbText;
	}
}


function CreateCrumbText($thePageID, $addLink = false) {
	global $appRootURL, $appCrumbColor;
	if ($thePageID) {
		$theCrumbText = Lookup("Pages", "intPageID", "strCrumbText", $thePageID);
		$theParentID = Lookup("Pages", "intPageID", "intParentID", $thePageID);
		$noClick = Lookup("Pages", "intPageID", "bitNoClick", $theParentID);

		//print $noClick;
		//exit;
		if($noClick){
			$tmp = false;
		}
		else{
			$tmp = true;
		}

		//if ($theParentID and !$noClick) {
		if ($theParentID) {
			$theGrandParent = Lookup("Pages", "intPageID", "intParentID", $theParentID);

			if ($theGrandParent) {
				//print $noClick;
				//$theCrumbText = CreateCrumbText($theParentID, true) . " &gt; $theCrumbText";

				$theCrumbText = CreateCrumbText($theParentID, $tmp) . " &gt; $theCrumbText";

			}
			else {
				$parentURL = Lookup("Pages", "intPageID", "strActualURL", $theParentID);
				$showOnMenu = Lookup("Pages", "intPageID", "bitShowOnMenu", $theParentID);

				if ($showOnMenu) {
					if ($parentURL) {
						if (substr($parentURL, 0, 4) != "http")
							$parentURL = "$appRootURL/$parentURL";
					}
					else{
						$parentURL = "$appRootURL/page.php/prmID/$theParentID";
					}
					$parentCrumb = Lookup("Pages", "intPageID", "strCrumbText", $theParentID);
					if (!$parentCrumb){
						$parentCrumb = strip_tags(Lookup("Pages", "intPageID", "strPageName", $theParentID));
					}
					if (strlen($parentCrumb) > 25){
						$parentCrumb = substr($parentCrumb, 0, 25) . "...";
					}

					$prmDisplayCrumb = Lookup("Pages","intPageID","bitDisplayCrumb", $theParentID);

						if($prmDisplayCrumb){

							$dummy = "<A CLASS=\"CrumbText\" STYLE=\"Color: $appCrumbColor;\" HREF=\"$parentURL\">  $parentCrumb  </A> ";

						}

					if ($addLink) {
						$theURL = Lookup("Pages", "intPageID", "strActualURL", $thePageID);
						if ($theUTL) {
							if (substr($theURL, 0, 4) != "http"){
								$theURL = "$appRootURL/$theURL";
							}
						}
						else{
							$theURL = "$appRootURL/page.php/prmID/$thePageID";
						}
						$dummy .= "  &gt; <A CLASS=\"CrumbText\" STYLE=\"Color: $appCrumbColor;\" HREF=\"$theURL\"> $theCrumbText</A> ";
					}
					else{

						$prmDisplayCrumb = Lookup("Pages","intPageID","bitDisplayCrumb", $thePageID);

						if($prmDisplayCrumb){

							$dummy .= " &gt; $theCrumbText" ;
						}
					}

					$theCrumbText = $dummy;

				}
			}

		}
	}
	return $theCrumbText;
}

function getActualURL($thePageID) {
	global $appUnsecurePath;
	$theURL = '';
	if ($thePageID) {
		$showOnMenu = Lookup('Pages', 'intPageID', 'bitShowOnMenu', $thePageID);
		if ($showOnMenu) {
			$theURL = Lookup('Pages', 'intPageID', 'strActualURL', $thePageID);
			$noClick = Lookup('Pages', 'intPageID', 'bitNoClick', $thePageID);
			if (!$noClick) {
				if ($theURL) {
					if (substr($theURL, 0, 4) != 'http')
						$theURL = $appUnsecurePath . '/' . $theURL;
				}
				else
					$theURL = $appUnsecurePath . '/page.php/prmID/' . $thePageID;
				if (Lookup('Pages', 'intPageID', 'bitNewWindow', $thePageID))
					$theURL .= ';target=_blank';
			}
		}
	}
	return $theURL;
}

function getActualURL2($thePageID, $addTarget=1) {
	global $appUnsecurePath;
	$theURL = '';
	if ($thePageID) {
		$theURL = Lookup('Pages', 'intPageID', 'strActualURL', $thePageID);
		if ($theURL) {
			if (substr($theURL, 0, 4) != 'http')
				$theURL = $appUnsecurePath . '/' . $theURL;
		}
		else
			$theURL = $appUnsecurePath . '/page.php/prmID/' . $thePageID;

		$theURL = '"' . $theURL . '"';

		if (Lookup('Pages', 'intPageID', 'bitNewWindow', $thePageID) and $addTarget)
			$theURL .= ' target="_blank"';
	}
	return $theURL;
}

function hasChild($theParentID) {
	if ($theParentID) {
		$db = new cDB();
		$strSQL = 'SELECT intPageID FROM Pages WHERE bitShowOnMenu = 1 AND bitArchived = 0 AND bitNoClick = 0 AND intParentID = ' . $theParentID;
		$db->Query($strSQL);
		if ($db->RowCount)
			return true;
	}
	return false;
}

function getAncestor($thePageID) {
	$theAncestor = 0;
	if ($thePageID) {
		$theParentID = Lookup('Pages', 'intPageID', 'intParentID', $thePageID );
		if ($theParentID)
			$theAncestor = getAncestor($theParentID);
		else
			$theAncestor = $thePageID;
	}
	return $theAncestor;
}

function readDirectory ( $path ) {
	$varTmpAry = Array();

	if (is_dir($path)) {
		if ( $readDir = opendir( $path ) ) {
			while ( ( $file = readdir ( $readDir ) ) ) {
				array_push( $varTmpAry, $file );
			}
		}
	}

	$junk = array_shift ( $varTmpAry );
	$junk = array_shift ( $varTmpAry );
	return $varTmpAry;
}

function getMP3List () {
 	/* Declarations */
	$getMP3ListDB = new cDB();
	$aryFileExists	= Array();

 	/* Get files already in the database */
	$getMP3ListDB->Query('
				SELECT
					intID,
					txtFile
				FROM
					MP3Links
				ORDER BY
					txtFile
				');

 	/* Create the array to contain the files */
	if ( $getMP3ListDB->RowCount ) {
		while ( $getMP3ListDB->ReadRow() ) {
			$aryFileExists[$getMP3ListDB->RowData['intID']] = $getMP3ListDB->RowData['txtFile'];
		}
	}
	return $aryFileExists;
}

/**********************************************************************************************		Created:	09-NOV-2004, 17:04
***		FILE UPLOAD FUNCTION																																	***		Updated:
***			Purpose:																																						***
***				Dynamically handles multiple file uploads																					***
***																																													***
***			Use:																																								***
***				$aryFiles		Equals the "$HTTP_POST_FILES" directive.  MUST be of type array.			***
***				$uploadDir	Is the absolute path to the directory the files will be uploaded to		***
***				$preName		Prepends the filename when being named																***
***																																													***
***			Return:																																							***
***				This function returns a multi-dimensional array with two attributes								***
***				Success			Type: Bit; Denotes status of the file upload													***
***				Filename		Type: Text; Denotes the newly created filename												***
***********************************************************************************************/
function fileUpload ( $aryFiles, $uploadDir, $preName ) {
	$aryReturn = Array();

	if ( is_array ( $aryFiles ) && count ( $aryFiles ) ) {
		foreach ( $aryFiles['userfile']['name'] as $key => $value ) {
			if ( $aryFiles['userfile']['name'][$key] ) {
				chmod($aryFiles['userfile']['tmp_name'][$key],0666);
				$newName		= FixFilename( $preName . $aryFiles['userfile']['name'][$key] );
				$uploadFile = $preName . $aryFiles['userfile']['name'][$key];
				$uploadFile = $uploadDir. $uploadFile;
				$uploadFile = FixFilename( $uploadFile );
				if ( !move_uploaded_file( $aryFiles['userfile']['tmp_name'][$key], $uploadFile ) ) {
					array_push ( $aryReturn, Array ( 'Success' => 0, 'Filename' => $newName ) );
				} else {
					array_push ( $aryReturn, Array ( 'Success' => 1, 'Filename' => $newName ) );
				}
			} else {
					array_push ( $aryReturn, Array ( 'Success' => 0, 'Filename' => $newName ) );
			}
		}
	}
	return $aryReturn;
}
/******************************   Ryan Provost   **********************************************/

function getMoreLink ( $url, $window, $indexNo ) {
	global $appPicURLPath, $appRootURL;

	if ( $url ) {
		if (substr($url, 0, 4) != 'http') {
			$url		= $appRootURL . '/' . $url;
		}
		if ( $window ) {
			$target	= ' target="_blank"';
		}
		$rollOver = " ONMOUSEOVER=\"ImageOn('readMore$indexNo'); window.status='Read More'; return true;\" ONMOUSEOUT=\"ImageOff('readMore$indexNo'); window.status=''; return true;\"";
		$link = '<a href="' . $url . '"' . $target . $rollOver . '><img NAME="readMore' . $indexNo . '" src="' . $appPicURLPath . '/btnReadMore.gif" border=0 alt="Read More" vspace="4" hspace="0"></a><SCRIPT LANGUAGE="JavaScript">ImageLoad(\'readMore' . $indexNo . '\', \'' . $appPicURLPath . '/btnReadMore_on.gif\', \'' . $appPicURLPath . '/btnReadMore.gif\');</SCRIPT>';
	}

	return $link;
}

function SendMail( $theFrom="", $theTo="", $theSubject="", $theMessage="", $theType="", $theFromName="") {
	global $appSiteName;
	if (!$theFrom or !$theTo or !$theSubject or !$theMessage) {
		return 0;
	}
	if($theFromName == ""){
		$theFromName == $appSiteName;
	}
	$headers  = "MIME-Version: 1.0\n";
	$headers .= "X-Priority: 3\n";
	$headers .= "X-MSMail-Priority: Normal\n";
	$headers .= "Message-ID: <".date("F j, Y, g:i a")." TheSystem@".$_SERVER['SERVER_NAME'].">\n";
	$headers .= "X-Mailer: PHP v".phpversion()."\n";          // These two to help avoid spam-filters
	$headers .= "From: \"$theFromName\" <".$theFrom.">\n";

	if ($theType) {
		$headers .= 'Content-type: ' . $theType . ";\n";
	}
	mail($theTo, $theSubject, $theMessage, $headers, "-f$theFrom");
}

function SendMailBCC( $theFrom="", $theTo="", $theSubject="", $theMessage="", $theBCCList="", $theType="text/plain") {
	if (!$theFrom or !$theTo or !$theSubject or !$theMessage) {
		return 0;
	}
	$headers = "From: $theFrom\n";
	if ($theType) {
		$headers .= "Content-type: $theType;\n";
		$headers .= "Bcc: $theBCCList" . "\n";
	}

	mail($theTo, $theSubject, $theMessage, $headers, "-f$theFrom");
}

function FixFilename( $theString) {
	if (trim( $theString) == "") {
		return "";
	} else {
		$theString = str_replace( ".JPG", ".jpg", $theString);
		$theString = str_replace( ".GIF", ".gif", $theString);
		$theString = str_replace( " ", "", $theString);
		$theString = str_replace( ",", "", $theString);
		$theString = str_replace( "'", "", $theString);
		$theString = stripslashes($theString);
		$theString = preg_replace('/\.(?=.*?\.)/', '', $theString);
		return $theString;
	}
}

function Lookup ($table = "", $idfield = "", $valfield = "", $idval = 0) {
	if($idval == Null){
	$idval = 0;
	}
	if (!$table) return "";
	$db = new cDB();
	$db->query( "select $valfield from $table where $idfield = $idval");
	if ($db->RowCount) {
		$db->ReadRow();
		return $db->RowData[$valfield];
	} else {
		return "";
	}
}

function QueryFormatString( $theString) {

	if (trim( $theString) == "") {
		return "''";
	} else {
		$theString = mysql_real_escape_string($theString);
		//$theString = "'" . str_replace( "'", "''", $theString) . "'";
		$theString = "'" . $theString . "'";
		return $theString;

	}
}

function QueryFormatStringNoQuote( $theString) {
	if (trim( $theString) == "") {
		return "null";
	} else {
		return str_replace( $theString, "'", "''") ;
	}
}

function QueryFormatDate( $theString) {
	if (trim( $theString) == "" or !IsDate( $theString)) {
		return "null";
	} else {
		return "'" . FormatDateTime( CDate( $theString), vbShortDate) . "'";
	}
}

function QueryLogicalToBit( $theLog) {
	if ($theLog) {
		return 1;
	} else {
		return 0;
	}
}

function QueryFormatDateTime( $theDate) {
	## used to output d/t strings from query
	if ("" . $theDate = "") {
		return "";
	} else {
		return FormatDateTime( $theDate, vbShortDate);
	}
}

function QueryFormatNumber( $theNumber = 0, $decs) {
	if (Empty($theNumber) or !is_numeric($theNumber)) {
		return "0";
	} else {
		return FormatNumber($theNumber, $decs);
	}
}

function QueryOutputDateTime( $theMySQLDate) {
	if (Empty( $theMySQLDate)) return "";
	$theDate = substr( $theMySQLDate, 5, 2) . "/" . substr( $theMySQLDate, 8, 2) . "/" . substr( $theMySQLDate, 0, 4);
	return $theDate;
}

function QueryOutputNumber( $theNumber) {
	if (Empty( $theNumber)) return "";
	$theNum = "$theNumber";
	return $theNum;
}

function QueryOutputMoney( $theNumber) {
	if (Empty( $theNumber)) return "0.00";
	if (!is_numeric($theNumber)) return "0.00";
	if (!$theNumber) return "0.00";
	return FormatNumber($theNumber, 2);
}

function FormatNumber( $theNumber, $decs) {
	$mult = 1;
	if ($decs) $mult = pow(10,$decs);
	$isneg = 0;
	if ($theNumber < 0) {
		$theNumber = $theNumber * -1;
		$isneg = 1;
	}
	if (!$theNumber) {
		$theStr = "0." . str_repeat( "0", $decs);
	} else {
		$lead = "";
		if ($theNumber < 1) $lead = "0";
		$theInt = (int)(round($theNumber,$decs) * $mult);
		$theStr = "$theInt";
		if ($decs) {
			$inspos = strlen( $theStr) - $decs;
			$a = substr( $theStr, 0, $inspos);
			$b = substr( $theStr, $inspos, $decs);
			$theStr = $a . "." . $b;
		}
	}
	if ($isneg) $theStr = "-" . $theStr;
	return $theStr;
}

# Error Checking Functions

$ErrList = "";

function ErrCheckString( $theString, $theDesc, $theLength, $IsRequired) {
	global $ErrList;
	$theError = "";
	$theString = str_replace("'", "''", trim($theString));

	if (strlen( $theString) > $theLength) {
		$theError = "is too long.  It may not exceed " . $theLength . " characters.";
	} else {
		if ($theString == "" and $IsRequired) {
			$theError = "is required.";
		}
	}
	if ($theError != "") {
		$ErrList = $ErrList . "<LI><B>" . $theDesc . "</b> " . $theError . "</LI>\n";
	}
}

function ErrCheckNumber( $theString, $theDesc, $IsRequired, $nonZero=false) {
	global $ErrList;
	$theError = "";
	$isErr=true;
	$theString = trim( $theString);
	if ($theString == "" and $IsRequired) {
		$theError = "is required.";
		$isErr=false;
	} else {
		if ($theString != "" and !is_numeric( $theString)) {
			$theError = "must be a valid number.";
		}
	}
	if ($nonZero AND $theString == 0) {
		$theError = "is required.";
		 $isErr=false;
	}
	if ($theError != "") {
		$ErrList = $ErrList . "<LI><B>" . $theDesc . "</b> " . $theError . "</LI>\n";
	}
	return $isErr;
	
}

function ErrCheckDate($theMonth, $theDay, $theYear, $theDesc, $IsRequired) {
	global $ErrList;
	$theError = "";
	$theMonth = trim($theMonth);
	$theDay = trim($theDay);
	$theYear = trim($theYear);
	if (($theMonth == "" OR $theDay == "" OR $theYear == "") and $IsRequired) {
		$theError = "is required.";
	} else {
		if (($theMonth != "" AND $theDay != "" AND $theYear != "") and !checkdate($theMonth, $theDay, $theYear)) {
			$theError = "must be a valid date.";
		}
	}
	if ($theError != "") {
		$ErrList = $ErrList . "<LI><B>" . $theDesc . "</b> " . $theError . "</LI>\n";
	}
}

function ErrCheckEmail( $theString, $theDesc, $theLength, $IsRequired) {
	global $ErrList;
	$theError = "";
	$theString = trim( $theString);
	if (strlen( $theString) > $theLength) {
		$theError = "is too long.  It may not exceed " . $theLength . " characters.";
	} else {
		if ($theString == "" and $IsRequired) {
			$theError = "is required.";
		} elseif ($theString != "") {
			/**
			 * @author craig@juxtadigital.com
			 *
			 * This first regex is validating e-mail addys like this, craig@juxtadigital..com: which is wrong
			 */
			//if (!eregi( "[A-Z0-9\.\_-]+@[A-Z0-9\.\_-]+\.[A-Z]", $theString)) {				$theError = "is not valid.  Please enter full email address in myaccount@myserver.com format.";
			$regex = '/^[A-z0-9_\-]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{2,4}$/';
			//$regex = '\^[A-Z0-9._%-]+@[A-Z0-9-]+\.[A-Z]{2,4}\$';




			//if (!preg_match($regex, $theString)) {
			if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", $theString)) {
				$theError = "is not valid.  Please enter full email address in myaccount@myserver.com format.";
			}
		}
	}
	if ($theError != "") {
		$ErrList = $ErrList . "<LI><B>" . $theDesc . "</b> " . $theError . "</LI>\n";
	}
}

function ErrCheckAddError( $fielddesc, $errordesc) {
	global $ErrList;
	$ErrList = $ErrList . "<LI><B>" . $fielddesc . "</b> " . $errordesc . "</LI>\n";
}

function ErrMessageDisp( $AbortFlag) {
	global $ErrList;
	if ($ErrList != "") {
		echo( "<P style=\"color:red;\"><B style=\"font-weight:bold;\">Please note that the following problems were encountered in your submission:</b></P>\n");
		echo( "<UL>" . $ErrList . "</ul>");
		if ($AbortFlag) {
			die();
		}
	}
}

function ErrMessageDispSamePage( $AbortFlag) {
	if ($ErrList != "") {
		echo( "<P><B>Errors found!</b><BR>$the following problems were encountered in your submission:</P>\n");
		echo( "<UL>" . $ErrList . "</ul>");
		if ($AbortFlag) {
			die();
		}
	}
}


function ShortDateFormat( $datevar) {
	if (Empty( $datevar)) {
		return "";
	} else {
		if (TypeName( $datevar) != "Date") {
			if (IsDate( $datevar)) {
				$datevar = CDate( $datevar);
				return FormatDateTime( $datevar, vbShortDate);
			} else {
				return "";
			}
		} else {
			return FormatDateTime( $datevar, vbShortDate);
		}
	}
}

function LongDateFormat( $datevar)  {
	if (Empty( $datevar)) {
		return "";
	} else {
		if (TypeName( $datevar) != "Date") {
			if (IsDate( $datevar)) {
				$datevar = CDate( $datevar);
				return "" . MonthName( Month( $datevar)) . " " . Day( $datevar) . ", " . Year( $datevar);
			} else {
				return "";
			}
		} else {
			return "" . MonthName( Month( $datevar)) . " " . Day( $datevar) . ", " . Year( $datevar);
		}
	}
}

function MonthName($month) {
	if ($month) {
		switch ($month) {
			case 1:
				return "January";
				break;
			case 2:
				return "February";
				break;
			case 3:
				return "March";
				break;
			case 4:
				return "April";
				break;
			case 5:
				return "May";
				break;
			case 6:
				return "June";
				break;
			case 7:
				return "July";
				break;
			case 8:
				return "August";
				break;
			case 9:
				return "September";
				break;
			case 10:
				return "October";
				break;
			case 11:
				return "November";
				break;
			case 12:
				return "December";
				break;
		}
	}
	else
		return '';
}

function CreateSortKey( $ParentKey = "", $ID, $Index) {
	$IDString = "$ID";
	$IDString = str_repeat( "0", 10 - strlen( $IDString)) . $IDString;
	$IndexString = "$Index";
	$IndexString = str_repeat( "0", 5 - strlen( $IndexString)) . $IndexString;
	return
	$NewKey = $ParentKey . $IDString . $IndexString;
	if (strlen($NewKey) <= 200) return $NewKey;	else return "";
}

function FormOutputDropDown ( $db, $CurID, $FormField, $AllowZero, $IDField, $DescField1, $DescField2 = "", $OnChange = "") {
	echo '<select name="' . $FormField . '"';
	if ($OnChange) echo ' onChange="' . $OnChange . '"';
	echo '>' . "\n";
	if ($AllowZero) {
		echo '<option value="0"';
		if ($CurID == 0) echo ' selected';
		if ($DescField2)
			echo '>-- Select ' . $DescField2 . ' --</option>' . "\n";
		else
			echo '>-- Select One --</option>' . "\n";
	}
	while ($db->ReadRow()) {
		echo '<option value="' . $db->RowData[$IDField] . '"';
		if ($CurID == $db->RowData[$IDField])
			echo ' selected';
		echo '>' . $db->RowData[$DescField1] . '</option>' . "\n";
	}
	echo '</select>' . "\n";
}

function Left( $theString = "", $theCount = 0) {
	$theString = trim($theString);
	if ($theString == "") return $theString;
	if ($theCount == 0) return $theString;
	if ($theCount >= strlen( $theString)) return $theString;
	return substr( $theString, 0, $theCount);
}

function Left_word($theString, $theCount = 0) {
	$theString = trim($theString);
	if ($theString == '' or $theCount == 0 or $theCount >= strlen($theString) or ($theCount + 1) >= strlen($theString))
		return $theString;
	if (substr($theString, $theCount, 1) == ' ')
		return substr( $theString, 0, $theCount);
	else {
		$thePos = strpos($theString, ' ', $theCount);
		return substr($theString, 0, $thePos);
	}
}

function Right( $theString = "", $theCount = 0) {
	$theString = trim($theString);
	if ($theString == "") return $theString;
	if ($theCount == 0) return $theString;
	if ($theCount >= strlen( $theString)) return $theString;
	return (substr( $theString, (strlen( $theString) - $theCount)));
}

function incStates ($varFieldName) {
	global ${$varFieldName};
	$varVal = ($_POST["{$varFieldName}"]) ? $_POST["{$varFieldName}"] : ${$varFieldName};
	$stateList = '';
	$stateList .= '<OPTION VALUE="">-- Select State --</OPTION>
		<OPTION VALUE="">-----United States-----</OPTION>
		<OPTION VALUE="AL"' . ( ($varVal == "AL") ? ' SELECTED' : '' ) . '>Alabama</OPTION>
		<OPTION VALUE="AK"' . ( ($varVal == "AK") ? ' SELECTED' : '' ) . '>Alaska</OPTION>
		<OPTION VALUE="AR"' . ( ($varVal == "AR") ? ' SELECTED' : '' ) . '>Arkansas</OPTION>
		<OPTION VALUE="AZ"' . ( ($varVal == "AZ") ? ' SELECTED' : '' ) . '>Arizona</OPTION>
		<OPTION VALUE="CA"' . ( ($varVal == "CA") ? ' SELECTED' : '' ) . '>California</OPTION>
		<OPTION VALUE="CO"' . ( ($varVal == "CO") ? ' SELECTED' : '' ) . '>Colorado</OPTION>
		<OPTION VALUE="CT"' . ( ($varVal == "CT") ? ' SELECTED' : '' ) . '>Connecticut</OPTION>
		<OPTION VALUE="DC"' . ( ($varVal == "DC") ? ' SELECTED' : '' ) . '>District of Columbia</OPTION>
		<OPTION VALUE="DE"' . ( ($varVal == "DE") ? ' SELECTED' : '' ) . '>Delaware</OPTION>
		<OPTION VALUE="FL"' . ( ($varVal == "FL") ? ' SELECTED' : '' ) . '>Florida</OPTION>
		<OPTION VALUE="GA"' . ( ($varVal == "GA") ? ' SELECTED' : '' ) . '>Georgia</OPTION>
		<OPTION VALUE="HI"' . ( ($varVal == "HI") ? ' SELECTED' : '' ) . '>Hawaii</OPTION>
		<OPTION VALUE="IA"' . ( ($varVal == "IA") ? ' SELECTED' : '' ) . '>Iowa</OPTION>
		<OPTION VALUE="ID"' . ( ($varVal == "ID") ? ' SELECTED' : '' ) . '>Idaho</OPTION>
		<OPTION VALUE="IL"' . ( ($varVal == "IL") ? ' SELECTED' : '' ) . '>Illinois</OPTION>
		<OPTION VALUE="IN"' . ( ($varVal == "IN") ? ' SELECTED' : '' ) . '>Indiana</OPTION>
		<OPTION VALUE="KS"' . ( ($varVal == "KS") ? ' SELECTED' : '' ) . '>Kansas</OPTION>
		<OPTION VALUE="KY"' . ( ($varVal == "KY") ? ' SELECTED' : '' ) . '>Kentucky</OPTION>
		<OPTION VALUE="LA"' . ( ($varVal == "LA") ? ' SELECTED' : '' ) . '>Louisiana</OPTION>
		<OPTION VALUE="MA"' . ( ($varVal == "MA") ? ' SELECTED' : '' ) . '>Massachusetts</OPTION>
		<OPTION VALUE="MD"' . ( ($varVal == "MD") ? ' SELECTED' : '' ) . '>Maryland</OPTION>
		<OPTION VALUE="ME"' . ( ($varVal == "ME") ? ' SELECTED' : '' ) . '>Maine</OPTION>
		<OPTION VALUE="MI"' . ( ($varVal == "MI") ? ' SELECTED' : '' ) . '>Michigan</OPTION>
		<OPTION VALUE="MN"' . ( ($varVal == "MN") ? ' SELECTED' : '' ) . '>Minnesota</OPTION>
		<OPTION VALUE="MS"' . ( ($varVal == "MS") ? ' SELECTED' : '' ) . '>Mississippi</OPTION>
		<OPTION VALUE="MO"' . ( ($varVal == "MO") ? ' SELECTED' : '' ) . '>Missouri</OPTION>
		<OPTION VALUE="MT"' . ( ($varVal == "MT") ? ' SELECTED' : '' ) . '>Montana</OPTION>
		<OPTION VALUE="NC"' . ( ($varVal == "NC") ? ' SELECTED' : '' ) . '>North Carolina</OPTION>
		<OPTION VALUE="ND"' . ( ($varVal == "ND") ? ' SELECTED' : '' ) . '>North Dakota</OPTION>
		<OPTION VALUE="NE"' . ( ($varVal == "NE") ? ' SELECTED' : '' ) . '>Nebraska</OPTION>
		<OPTION VALUE="NV"' . ( ($varVal == "NV") ? ' SELECTED' : '' ) . '>Nevada</OPTION>
		<OPTION VALUE="NH"' . ( ($varVal == "NH") ? ' SELECTED' : '' ) . '>New Hampshire</OPTION>
		<OPTION VALUE="NJ"' . ( ($varVal == "NJ") ? ' SELECTED' : '' ) . '>New Jersey</OPTION>
		<OPTION VALUE="NM"' . ( ($varVal == "NM") ? ' SELECTED' : '' ) . '>New Mexico</OPTION>
		<OPTION VALUE="NY"' . ( ($varVal == "NY") ? ' SELECTED' : '' ) . '>New York</OPTION>
		<OPTION VALUE="OH"' . ( ($varVal == "OH") ? ' SELECTED' : '' ) . '>Ohio</OPTION>
		<OPTION VALUE="OK"' . ( ($varVal == "OK") ? ' SELECTED' : '' ) . '>Oklahoma</OPTION>
		<OPTION VALUE="OR"' . ( ($varVal == "OR") ? ' SELECTED' : '' ) . '>Oregon</OPTION>
		<OPTION VALUE="PA"' . ( ($varVal == "PA") ? ' SELECTED' : '' ) . '>Pennsylvania</OPTION>
		<OPTION VALUE="RI"' . ( ($varVal == "RI") ? ' SELECTED' : '' ) . '>Rhode Island</OPTION>
		<OPTION VALUE="SC"' . ( ($varVal == "SC") ? ' SELECTED' : '' ) . '>South Carolina</OPTION>
		<OPTION VALUE="SD"' . ( ($varVal == "SD") ? ' SELECTED' : '' ) . '>South Dakota</OPTION>
		<OPTION VALUE="TN"' . ( ($varVal == "TN") ? ' SELECTED' : '' ) . '>Tennessee</OPTION>
		<OPTION VALUE="TX"' . ( ($varVal == "TX") ? ' SELECTED' : '' ) . '>Texas</OPTION>
		<OPTION VALUE="UT"' . ( ($varVal == "UT") ? ' SELECTED' : '' ) . '>Utah</OPTION>
		<OPTION VALUE="VA"' . ( ($varVal == "VA") ? ' SELECTED' : '' ) . '>Virginia</OPTION>
		<OPTION VALUE="VI"' . ( ($varVal == "VI") ? ' SELECTED' : '' ) . '>Virgin Islands</OPTION>
		<OPTION VALUE="VT"' . ( ($varVal == "VT") ? ' SELECTED' : '' ) . '>Vermont</OPTION>
		<OPTION VALUE="WA"' . ( ($varVal == "WA") ? ' SELECTED' : '' ) . '>Washington</OPTION>
		<OPTION VALUE="WI"' . ( ($varVal == "WI") ? ' SELECTED' : '' ) . '>Wisconsin</OPTION>
		<OPTION VALUE="WV"' . ( ($varVal == "WV") ? ' SELECTED' : '' ) . '>West Virginia</OPTION>
		<OPTION VALUE="WY"' . ( ($varVal == "WY") ? ' SELECTED' : '' ) . '>Wyoming</OPTION>
		<OPTION VALUE=""></OPTION>
		<OPTION VALUE="">-----Canada-----</OPTION>
		<option value="AB"' . ( ($varVal == "AB") ? ' SELECTED' : '' ) . '>Alberta</option>
		<option value="BC"' . ( ($varVal == "BC") ? ' SELECTED' : '' ) . '>British Columbia</option>
		<option value="MB"' . ( ($varVal == "MB") ? ' SELECTED' : '' ) . '>Manitoba</option>
		<option value="NB"' . ( ($varVal == "NB") ? ' SELECTED' : '' ) . '>New Brunswick</option>
		<option value="NL"' . ( ($varVal == "NL") ? ' SELECTED' : '' ) . '>Newfoundland and Labrador</option>
		<option value="NT"' . ( ($varVal == "NT") ? ' SELECTED' : '' ) . '>Northwest Territories</option>
		<option value="NS"' . ( ($varVal == "NS") ? ' SELECTED' : '' ) . '>Nova Scotia</option>
		<option value="NU"' . ( ($varVal == "NU") ? ' SELECTED' : '' ) . '>Nunavut</option>
		<option value="ON"' . ( ($varVal == "ON") ? ' SELECTED' : '' ) . '>Ontario</option>
		<option value="PE"' . ( ($varVal == "PE") ? ' SELECTED' : '' ) . '>Prince Edward Island</option>
		<option value="PQ"' . ( ($varVal == "PQ") ? ' SELECTED' : '' ) . '>Quebec</option>
		<option value="SK"' . ( ($varVal == "SK") ? ' SELECTED' : '' ) . '>Saskatchewan</option>
		<option value="YU"' . ( ($varVal == "YU") ? ' SELECTED' : '' ) . '>Yukon</option>
		<OPTION VALUE=""></OPTION>
		<OPTION VALUE="Other"' . ( ($varVal == "Other") ? ' SELECTED' : '' ) . '>Other</OPTION>';
	return $stateList;
}

function incCountries ($varFieldName) {
	global ${$varFieldName};
	$varVal = ($_POST["{$varFieldName}"]) ? $_POST["{$varFieldName}"] : ${$varFieldName};
	$countryList = '';
	$countryList .= '<OPTION VALUE="">-- Select Country --</OPTION>
		<option value="Afghanistan"' . ( ($varVal == 'Afghanistan') ? ' SELECTED' : '' ) . '>Afghanistan</option>
		<option value="Albania"' . ( ($varVal == 'Albania') ? ' SELECTED' : '' ) . '>Albania</option>
		<option value="Algeria"' . ( ($varVal == 'Algeria') ? ' SELECTED' : '' ) . '>Algeria</option>
		<option value="Andorra"' . ( ($varVal == 'Andorra') ? ' SELECTED' : '' ) . '>Andorra</option>
		<option value="Angola"' . ( ($varVal == 'Angola') ? ' SELECTED' : '' ) . '>Angola</option>
		<option value="Antigua"' . ( ($varVal == 'Antigua') ? ' SELECTED' : '' ) . '>Antigua</option>
		<option value="Argentina"' . ( ($varVal == 'Argentina') ? ' SELECTED' : '' ) . '>Argentina</option>
		<option value="Armenia"' . ( ($varVal == 'Armenia') ? ' SELECTED' : '' ) . '>Armenia</option>
		<option value="Aruba"' . ( ($varVal == 'Aruba') ? ' SELECTED' : '' ) . '>Aruba</option>
		<option value="Australia"' . ( ($varVal == 'Australia') ? ' SELECTED' : '' ) . '>Australia</option>
		<option value="Austria"' . ( ($varVal == 'Austria') ? ' SELECTED' : '' ) . '>Austria</option>
		<option value="Azerbaijan"' . ( ($varVal == 'Azerbaijan') ? ' SELECTED' : '' ) . '>Azerbaijan</option>
		<option value="Azores"' . ( ($varVal == 'Azores') ? ' SELECTED' : '' ) . '>Azores</option>
		<option value="Bahamas"' . ( ($varVal == 'Bahamas') ? ' SELECTED' : '' ) . '>Bahamas</option>
		<option value="Bahrain"' . ( ($varVal == 'Bahrain') ? ' SELECTED' : '' ) . '>Bahrain</option>
		<option value="Bangladesh"' . ( ($varVal == 'Bangladesh') ? ' SELECTED' : '' ) . '>Bangladesh</option>
		<option value="Barbados"' . ( ($varVal == 'Barbados') ? ' SELECTED' : '' ) . '>Barbados</option>
		<option value="Belarus"' . ( ($varVal == 'Belarus') ? ' SELECTED' : '' ) . '>Belarus</option>
		<option value="Belgium"' . ( ($varVal == 'Belgium') ? ' SELECTED' : '' ) . '>Belgium</option>
		<option value="Belize"' . ( ($varVal == 'Belize') ? ' SELECTED' : '' ) . '>Belize</option>
		<option value="Benin"' . ( ($varVal == 'Benin') ? ' SELECTED' : '' ) . '>Benin</option>
		<option value="Bermuda"' . ( ($varVal == 'Bermuda') ? ' SELECTED' : '' ) . '>Bermuda</option>
		<option value="Bhutan"' . ( ($varVal == 'Bhutan') ? ' SELECTED' : '' ) . '>Bhutan</option>
		<option value="Bolivia"' . ( ($varVal == 'Bolivia') ? ' SELECTED' : '' ) . '>Bolivia</option>
		<option value="Bosnia"' . ( ($varVal == 'Bosnia') ? ' SELECTED' : '' ) . '>Bosnia</option>
		<option value="Botswana"' . ( ($varVal == 'Botswana') ? ' SELECTED' : '' ) . '>Botswana</option>
		<option value="Brazil"' . ( ($varVal == 'Brazil') ? ' SELECTED' : '' ) . '>Brazil</option>
		<option value="Brunei"' . ( ($varVal == 'Brunei') ? ' SELECTED' : '' ) . '>Brunei</option>
		<option value="Bulgaria"' . ( ($varVal == 'Bulgaria') ? ' SELECTED' : '' ) . '>Bulgaria</option>
		<option value="Burkina Faso"' . ( ($varVal == 'Burkina Faso') ? ' SELECTED' : '' ) . '>Burkina Faso</option>
		<option value="Burundi"' . ( ($varVal == 'Burundi') ? ' SELECTED' : '' ) . '>Burundi</option>
		<option value="Brit W Indies"' . ( ($varVal == 'Brit W Indies') ? ' SELECTED' : '' ) . '>Brit W Indies</option>
		<option value="Cambodia"' . ( ($varVal == 'Cambodia') ? ' SELECTED' : '' ) . '>Cambodia</option>
		<option value="Cameroon"' . ( ($varVal == 'Cameroon') ? ' SELECTED' : '' ) . '>Cameroon</option>
		<option value="CA"' . ( ($varVal == 'CA') ? ' SELECTED' : '' ) . '>Canada</option>
		<option value="Cape Verde"' . ( ($varVal == 'Cape Verde') ? ' SELECTED' : '' ) . '>Cape Verde</option>
		<option value="Centrl Afr Rep"' . ( ($varVal == 'Centrl Afr Rep') ? ' SELECTED' : '' ) . '>Centrl Afr Rep</option>
		<option value="Cayman Island"' . ( ($varVal == 'Cayman Island') ? ' SELECTED' : '' ) . '>Cayman Island</option>
		<option value="Chad"' . ( ($varVal == 'Chad') ? ' SELECTED' : '' ) . '>Chad</option>
		<option value="Chile"' . ( ($varVal == 'Chile') ? ' SELECTED' : '' ) . '>Chile</option>
		<option value="China"' . ( ($varVal == 'China') ? ' SELECTED' : '' ) . '>China</option>
		<option value="Colombia"' . ( ($varVal == 'Colombia') ? ' SELECTED' : '' ) . '>Colombia</option>
		<option value="Congo"' . ( ($varVal == 'Congo') ? ' SELECTED' : '' ) . '>Congo</option>
		<option value="Cook Islands"' . ( ($varVal == 'Cook Islands') ? ' SELECTED' : '' ) . '>Cook Islands</option>
		<option value="Corsica"' . ( ($varVal == 'Corsica') ? ' SELECTED' : '' ) . '>Corsica</option>
		<option value="Costa Rica"' . ( ($varVal == 'Costa Rica') ? ' SELECTED' : '' ) . '>Costa Rica</option>
		<option value="Cote D Ivoire"' . ( ($varVal == 'Cote D Ivoire') ? ' SELECTED' : '' ) . '>Cote D Ivoire</option>
		<option value="Croatia"' . ( ($varVal == 'Croatia') ? ' SELECTED' : '' ) . '>Croatia</option>
		<option value="Cuba"' . ( ($varVal == 'Cuba') ? ' SELECTED' : '' ) . '>Cuba</option>
		<option value="Cyprus"' . ( ($varVal == 'Cyprus') ? ' SELECTED' : '' ) . '>Cyprus</option>
		<option value="Czech Republic"' . ( ($varVal == 'Czech Republic') ? ' SELECTED' : '' ) . '>Czech Republic</option>
		<option value="Denmark"' . ( ($varVal == 'Denmark') ? ' SELECTED' : '' ) . '>Denmark</option>
		<option value="Dominican Rep"' . ( ($varVal == 'Dominican Rep') ? ' SELECTED' : '' ) . '>Dominican Rep</option>
		<option value="Ecuador"' . ( ($varVal == 'Ecuador') ? ' SELECTED' : '' ) . '>Ecuador</option>
		<option value="Egypt"' . ( ($varVal == 'Egypt') ? ' SELECTED' : '' ) . '>Egypt</option>
		<option value="El Salvador"' . ( ($varVal == 'El Salvador') ? ' SELECTED' : '' ) . '>El Salvador</option>
		<option value="England"' . ( ($varVal == 'England') ? ' SELECTED' : '' ) . '>England</option>
		<option value="Eritrea"' . ( ($varVal == 'Eritrea') ? ' SELECTED' : '' ) . '>Eritrea</option>
		<option value="Estonia"' . ( ($varVal == 'Estonia') ? ' SELECTED' : '' ) . '>Estonia</option>
		<option value="Ethiopia"' . ( ($varVal == 'Ethiopia') ? ' SELECTED' : '' ) . '>Ethiopia</option>
		<option value="East Timor"' . ( ($varVal == 'East Timor') ? ' SELECTED' : '' ) . '>East Timor</option>
		<option value="Falkland Islds"' . ( ($varVal == 'Falkland Islds') ? ' SELECTED' : '' ) . '>Falkland Islds</option>
		<option value="French Guiana"' . ( ($varVal == 'French Guiana') ? ' SELECTED' : '' ) . '>French Guiana</option>
		<option value="Fiji"' . ( ($varVal == 'Fiji') ? ' SELECTED' : '' ) . '>Fiji</option>
		<option value="Finland"' . ( ($varVal == 'Finland') ? ' SELECTED' : '' ) . '>Finland</option>
		<option value="Fr Polynesia"' . ( ($varVal == 'Fr Polynesia') ? ' SELECTED' : '' ) . '>Fr Polynesia</option>
		<option value="France"' . ( ($varVal == 'France') ? ' SELECTED' : '' ) . '>France</option>
		<option value="Gabon"' . ( ($varVal == 'Gabon') ? ' SELECTED' : '' ) . '>Gabon</option>
		<option value="Gambia"' . ( ($varVal == 'Gambia') ? ' SELECTED' : '' ) . '>Gambia</option>
		<option value="Georgia"' . ( ($varVal == 'Georgia') ? ' SELECTED' : '' ) . '>Georgia</option>
		<option value="Germany"' . ( ($varVal == 'Germany') ? ' SELECTED' : '' ) . '>Germany</option>
		<option value="Ghana"' . ( ($varVal == 'Ghana') ? ' SELECTED' : '' ) . '>Ghana</option>
		<option value="Gibraltar"' . ( ($varVal == 'Gibraltar') ? ' SELECTED' : '' ) . '>Gibraltar</option>
		<option value="Greece"' . ( ($varVal == 'Greece') ? ' SELECTED' : '' ) . '>Greece</option>
		<option value="Greenland"' . ( ($varVal == 'Greenland') ? ' SELECTED' : '' ) . '>Greenland</option>
		<option value="Grenada"' . ( ($varVal == 'Grenada') ? ' SELECTED' : '' ) . '>Grenada</option>
		<option value="Guadeloupe"' . ( ($varVal == 'Guadeloupe') ? ' SELECTED' : '' ) . '>Guadeloupe</option>
		<option value="Guatemala"' . ( ($varVal == 'Guatemala') ? ' SELECTED' : '' ) . '>Guatemala</option>
		<option value="Guinea"' . ( ($varVal == 'Guinea') ? ' SELECTED' : '' ) . '>Guinea</option>
		<option value="Guyana"' . ( ($varVal == 'Guyana') ? ' SELECTED' : '' ) . '>Guyana</option>
		<option value="Haiti"' . ( ($varVal == 'Haiti') ? ' SELECTED' : '' ) . '>Haiti</option>
		<option value="Honduras"' . ( ($varVal == 'Honduras') ? ' SELECTED' : '' ) . '>Honduras</option>
		<option value="Hong Kong"' . ( ($varVal == 'Hong Kong') ? ' SELECTED' : '' ) . '>Hong Kong</option>
		<option value="Hungary"' . ( ($varVal == 'Hungary') ? ' SELECTED' : '' ) . '>Hungary</option>
		<option value="Iceland"' . ( ($varVal == 'Iceland') ? ' SELECTED' : '' ) . '>Iceland</option>
		<option value="India"' . ( ($varVal == 'India') ? ' SELECTED' : '' ) . '>India</option>
		<option value="Indonesia"' . ( ($varVal == 'Indonesia') ? ' SELECTED' : '' ) . '>Indonesia</option>
		<option value="Iran"' . ( ($varVal == 'Iran') ? ' SELECTED' : '' ) . '>Iran</option>
		<option value="Iraq"' . ( ($varVal == 'Iraq') ? ' SELECTED' : '' ) . '>Iraq</option>
		<option value="Ireland"' . ( ($varVal == 'Ireland') ? ' SELECTED' : '' ) . '>Ireland</option>
		<option value="Israel"' . ( ($varVal == 'Israel') ? ' SELECTED' : '' ) . '>Israel</option>
		<option value="Italy"' . ( ($varVal == 'Italy') ? ' SELECTED' : '' ) . '>Italy</option>
		<option value="Jamaica"' . ( ($varVal == 'Jamaica') ? ' SELECTED' : '' ) . '>Jamaica</option>
		<option value="Japan"' . ( ($varVal == 'Japan') ? ' SELECTED' : '' ) . '>Japan</option>
		<option value="Jordan"' . ( ($varVal == 'Jordan') ? ' SELECTED' : '' ) . '>Jordan</option>
		<option value="Kazakhstan"' . ( ($varVal == 'Kazakhstan') ? ' SELECTED' : '' ) . '>Kazakhstan</option>
		<option value="Kenya"' . ( ($varVal == 'Kenya') ? ' SELECTED' : '' ) . '>Kenya</option>
		<option value="Kiribati"' . ( ($varVal == 'Kiribati') ? ' SELECTED' : '' ) . '>Kiribati</option>
		<option value="Kosovo"' . ( ($varVal == 'Kosovo') ? ' SELECTED' : '' ) . '>Kosovo</option>
		<option value="Kuwait"' . ( ($varVal == 'Kuwait') ? ' SELECTED' : '' ) . '>Kuwait</option>
		<option value="Kyrgyzstan"' . ( ($varVal == 'Kyrgyzstan') ? ' SELECTED' : '' ) . '>Kyrgyzstan</option>
		<option value="Laos"' . ( ($varVal == 'Laos') ? ' SELECTED' : '' ) . '>Laos</option>
		<option value="Latvia"' . ( ($varVal == 'Latvia') ? ' SELECTED' : '' ) . '>Latvia</option>
		<option value="Lebanon"' . ( ($varVal == 'Lebanon') ? ' SELECTED' : '' ) . '>Lebanon</option>
		<option value="Lesotho"' . ( ($varVal == 'Lesotho') ? ' SELECTED' : '' ) . '>Lesotho</option>
		<option value="Liberia"' . ( ($varVal == 'Liberia') ? ' SELECTED' : '' ) . '>Liberia</option>
		<option value="Libya"' . ( ($varVal == 'Libya') ? ' SELECTED' : '' ) . '>Libya</option>
		<option value="Lichtenstein"' . ( ($varVal == 'Lichtenstein') ? ' SELECTED' : '' ) . '>Lichtenstein</option>
		<option value="Lithuania"' . ( ($varVal == 'Lithuania') ? ' SELECTED' : '' ) . '>Lithuania</option>
		<option value="Luxembourg"' . ( ($varVal == 'Luxembourg') ? ' SELECTED' : '' ) . '>Luxembourg</option>
		<option value="Macao"' . ( ($varVal == 'Macao') ? ' SELECTED' : '' ) . '>Macao</option>
		<option value="Macedonia"' . ( ($varVal == 'Macedonia') ? ' SELECTED' : '' ) . '>Macedonia</option>
		<option value="Madagascar"' . ( ($varVal == 'Madagascar') ? ' SELECTED' : '' ) . '>Madagascar</option>
		<option value="Madeira Islds"' . ( ($varVal == 'Madeira Islds') ? ' SELECTED' : '' ) . '>Madeira Islds</option>
		<option value="Maldives"' . ( ($varVal == 'Maldives') ? ' SELECTED' : '' ) . '>Maldives</option>
		<option value="Mali"' . ( ($varVal == 'Mali') ? ' SELECTED' : '' ) . '>Mali</option>
		<option value="Malaysia"' . ( ($varVal == 'Malaysia') ? ' SELECTED' : '' ) . '>Malaysia</option>
		<option value="Malta"' . ( ($varVal == 'Malta') ? ' SELECTED' : '' ) . '>Malta</option>
		<option value="Malawi"' . ( ($varVal == 'Malawi') ? ' SELECTED' : '' ) . '>Malawi</option>
		<option value="Martinique"' . ( ($varVal == 'Martinique') ? ' SELECTED' : '' ) . '>Martinique</option>
		<option value="Mexico"' . ( ($varVal == 'Mexico') ? ' SELECTED' : '' ) . '>Mexico</option>
		<option value="Moldavia"' . ( ($varVal == 'Moldavia') ? ' SELECTED' : '' ) . '>Moldavia</option>
		<option value="Monaco"' . ( ($varVal == 'Monaco') ? ' SELECTED' : '' ) . '>Monaco</option>
		<option value="Mongolia"' . ( ($varVal == 'Mongolia') ? ' SELECTED' : '' ) . '>Mongolia</option>
		<option value="Montserrat"' . ( ($varVal == 'Montserrat') ? ' SELECTED' : '' ) . '>Montserrat</option>
		<option value="Montenegro"' . ( ($varVal == 'Montenegro') ? ' SELECTED' : '' ) . '>Montenegro</option>
		<option value="Morocco"' . ( ($varVal == 'Morocco') ? ' SELECTED' : '' ) . '>Morocco</option>
		<option value="Mozambique"' . ( ($varVal == 'Mozambique') ? ' SELECTED' : '' ) . '>Mozambique</option>
		<option value="Mauritania"' . ( ($varVal == 'Mauritania') ? ' SELECTED' : '' ) . '>Mauritania</option>
		<option value="Mauritius"' . ( ($varVal == 'Mauritius') ? ' SELECTED' : '' ) . '>Mauritius</option>
		<option value="Myanmar"' . ( ($varVal == 'Myanmar') ? ' SELECTED' : '' ) . '>Myanmar</option>
		<option value="Namibia"' . ( ($varVal == 'Namibia') ? ' SELECTED' : '' ) . '>Namibia</option>
		<option value="Nauru"' . ( ($varVal == 'Nauru') ? ' SELECTED' : '' ) . '>Nauru</option>
		<option value="Nepal"' . ( ($varVal == 'Nepal') ? ' SELECTED' : '' ) . '>Nepal</option>
		<option value="Neth Antilles"' . ( ($varVal == 'Neth Antilles') ? ' SELECTED' : '' ) . '>Neth Antilles</option>
		<option value="Netherlands"' . ( ($varVal == 'Netherlands') ? ' SELECTED' : '' ) . '>Netherlands</option>
		<option value="New Caledonia"' . ( ($varVal == 'New Caledonia') ? ' SELECTED' : '' ) . '>New Caledonia</option>
		<option value="New Zealand"' . ( ($varVal == 'New Zealand') ? ' SELECTED' : '' ) . '>New Zealand</option>
		<option value="New Guinea"' . ( ($varVal == 'New Guinea') ? ' SELECTED' : '' ) . '>New Guinea</option>
		<option value="Nicaragua"' . ( ($varVal == 'Nicaragua') ? ' SELECTED' : '' ) . '>Nicaragua</option>
		<option value="Nigeria"' . ( ($varVal == 'Nigeria') ? ' SELECTED' : '' ) . '>Nigeria</option>
		<option value="Niger"' . ( ($varVal == 'Niger') ? ' SELECTED' : '' ) . '>Niger</option>
		<option value="N Ireland"' . ( ($varVal == 'N Ireland') ? ' SELECTED' : '' ) . '>N Ireland</option>
		<option value="Dem Rep Korea"' . ( ($varVal == 'Dem Rep Korea') ? ' SELECTED' : '' ) . '>Dem Rep Korea</option>
		<option value="Norway"' . ( ($varVal == 'Norway') ? ' SELECTED' : '' ) . '>Norway</option>
		<option value="Oman"' . ( ($varVal == 'Oman') ? ' SELECTED' : '' ) . '>Oman</option>
		<option value="Pakistan"' . ( ($varVal == 'Pakistan') ? ' SELECTED' : '' ) . '>Pakistan</option>
		<option value="Palau"' . ( ($varVal == 'Palau') ? ' SELECTED' : '' ) . '>Palau</option>
		<option value="Panama"' . ( ($varVal == 'Panama') ? ' SELECTED' : '' ) . '>Panama</option>
		<option value="Pap New Guinea"' . ( ($varVal == 'Pap New Guinea') ? ' SELECTED' : '' ) . '>Pap New Guinea</option>
		<option value="Paraguay"' . ( ($varVal == 'Paraguay') ? ' SELECTED' : '' ) . '>Paraguay</option>
		<option value="Peru"' . ( ($varVal == 'Peru') ? ' SELECTED' : '' ) . '>Peru</option>
		<option value="Philippines"' . ( ($varVal == 'Philippines') ? ' SELECTED' : '' ) . '>Philippines</option>
		<option value="Poland"' . ( ($varVal == 'Poland') ? ' SELECTED' : '' ) . '>Poland</option>
		<option value="Portugal"' . ( ($varVal == 'Portugal') ? ' SELECTED' : '' ) . '>Portugal</option>
		<option value="Qatar"' . ( ($varVal == 'Qatar') ? ' SELECTED' : '' ) . '>Qatar</option>
		<option value="Rep Of Vanuatu"' . ( ($varVal == 'Rep Of Vanuatu') ? ' SELECTED' : '' ) . '>Rep Of Vanuatu</option>
		<option value="Romania"' . ( ($varVal == 'Romania') ? ' SELECTED' : '' ) . '>Romania</option>
		<option value="Russia"' . ( ($varVal == 'Russia') ? ' SELECTED' : '' ) . '>Russia</option>
		<option value="Rwanda"' . ( ($varVal == 'Rwanda') ? ' SELECTED' : '' ) . '>Rwanda</option>
		<option value="South Africa"' . ( ($varVal == 'South Africa') ? ' SELECTED' : '' ) . '>South Africa</option>
		<option value="Saudi Arabia"' . ( ($varVal == 'Saudi Arabia') ? ' SELECTED' : '' ) . '>Saudi Arabia</option>
		<option value="Scotland"' . ( ($varVal == 'Scotland') ? ' SELECTED' : '' ) . '>Scotland</option>
		<option value="Senegal"' . ( ($varVal == 'Senegal') ? ' SELECTED' : '' ) . '>Senegal</option>
		<option value="Serbia"' . ( ($varVal == 'Serbia') ? ' SELECTED' : '' ) . '>Serbia</option>
		<option value="Seychelles"' . ( ($varVal == 'Seychelles') ? ' SELECTED' : '' ) . '>Seychelles</option>
		<option value="Sierra Leone"' . ( ($varVal == 'Sierra Leone') ? ' SELECTED' : '' ) . '>Sierra Leone</option>
		<option value="Singapore"' . ( ($varVal == 'Singapore') ? ' SELECTED' : '' ) . '>Singapore</option>
		<option value="South Korea"' . ( ($varVal == 'South Korea') ? ' SELECTED' : '' ) . '>South Korea</option>
		<option value="Slovenia"' . ( ($varVal == 'Slovenia') ? ' SELECTED' : '' ) . '>Slovenia</option>
		<option value="Slovakia"' . ( ($varVal == 'Slovakia') ? ' SELECTED' : '' ) . '>Slovakia</option>
		<option value="Solomon Islnds"' . ( ($varVal == 'Solomon Islnds') ? ' SELECTED' : '' ) . '>Solomon Islnds</option>
		<option value="Somalia"' . ( ($varVal == 'Somalia') ? ' SELECTED' : '' ) . '>Somalia</option>
		<option value="Spain"' . ( ($varVal == 'Spain') ? ' SELECTED' : '' ) . '>Spain</option>
		<option value="Sri Lanka"' . ( ($varVal == 'Sri Lanka') ? ' SELECTED' : '' ) . '>Sri Lanka</option>
		<option value="Saint Helena"' . ( ($varVal == 'Saint Helena') ? ' SELECTED' : '' ) . '>Saint Helena</option>
		<option value="Sudan"' . ( ($varVal == 'Sudan') ? ' SELECTED' : '' ) . '>Sudan</option>
		<option value="Suriname"' . ( ($varVal == 'Suriname') ? ' SELECTED' : '' ) . '>Suriname</option>
		<option value="Swaziland"' . ( ($varVal == 'Swaziland') ? ' SELECTED' : '' ) . '>Swaziland</option>
		<option value="Sweden"' . ( ($varVal == 'Sweden') ? ' SELECTED' : '' ) . '>Sweden</option>
		<option value="Switzerland"' . ( ($varVal == 'Switzerland') ? ' SELECTED' : '' ) . '>Switzerland</option>
		<option value="Syria"' . ( ($varVal == 'Syria') ? ' SELECTED' : '' ) . '>Syria</option>
		<option value="Tahiti"' . ( ($varVal == 'Tahiti') ? ' SELECTED' : '' ) . '>Tahiti</option>
		<option value="Taiwan"' . ( ($varVal == 'Taiwan') ? ' SELECTED' : '' ) . '>Taiwan</option>
		<option value="Tajikistan"' . ( ($varVal == 'Tajikistan') ? ' SELECTED' : '' ) . '>Tajikistan</option>
		<option value="Tanzania"' . ( ($varVal == 'Tanzania') ? ' SELECTED' : '' ) . '>Tanzania</option>
		<option value="Thailand"' . ( ($varVal == 'Thailand') ? ' SELECTED' : '' ) . '>Thailand</option>
		<option value="Togo"' . ( ($varVal == 'Togo') ? ' SELECTED' : '' ) . '>Togo</option>
		<option value="Tonga"' . ( ($varVal == 'Tonga') ? ' SELECTED' : '' ) . '>Tonga</option>
		<option value="Trinidad Tobago"' . ( ($varVal == 'Trinidad Tobago') ? ' SELECTED' : '' ) . '>Trinidad Tobago</option>
		<option value="Turkmenistan"' . ( ($varVal == 'Turkmenistan') ? ' SELECTED' : '' ) . '>Turkmenistan</option>
		<option value="Turkey"' . ( ($varVal == 'Turkey') ? ' SELECTED' : '' ) . '>Turkey</option>
		<option value="Tunisia"' . ( ($varVal == 'Tunisia') ? ' SELECTED' : '' ) . '>Tunisia</option>
		<option value="Tuvalu"' . ( ($varVal == 'Tuvalu') ? ' SELECTED' : '' ) . '>Tuvalu</option>


		<option value="U.A.R"' . ( ($varVal == 'U.A.R') ? ' SELECTED' : '' ) . '>U.A.R</option>
		<option value="Uganda"' . ( ($varVal == 'Uganda') ? ' SELECTED' : '' ) . '>Uganda</option>
		<option value="Untd Arab Emir"' . ( ($varVal == 'Untd Arab Emir') ? ' SELECTED' : '' ) . '>Untd Arab Emir</option>
		<option value="UK"' . ( ($varVal == 'UK') ? ' SELECTED' : '' ) . '>United Kingdom</option>
		<option value="US"' . ( ($varVal == 'US') ? ' SELECTED' : '' ) . '>United States</option>
		<option value="Ukraine"' . ( ($varVal == 'Ukraine') ? ' SELECTED' : '' ) . '>Ukraine</option>
		<option value="Uruguay"' . ( ($varVal == 'Uruguay') ? ' SELECTED' : '' ) . '>Uruguay</option>

		<option value="Uzbekistan"' . ( ($varVal == 'Uzbekistan') ? ' SELECTED' : '' ) . '>Uzbekistan</option>
		<option value="Vatican City"' . ( ($varVal == 'Vatican City') ? ' SELECTED' : '' ) . '>Vatican City</option>
		<option value="Venezuela"' . ( ($varVal == 'Venezuela') ? ' SELECTED' : '' ) . '>Venezuela</option>
		<option value="Vietnam"' . ( ($varVal == 'Vietnam') ? ' SELECTED' : '' ) . '>Vietnam</option>
		<option value="Wales"' . ( ($varVal == 'Wales') ? ' SELECTED' : '' ) . '>Wales</option>
		<option value="West Indies"' . ( ($varVal == 'West Indies') ? ' SELECTED' : '' ) . '>West Indies</option>
		<option value="Western Samoa"' . ( ($varVal == 'Western Samoa') ? ' SELECTED' : '' ) . '>Western Samoa</option>
		<option value="Yemen"' . ( ($varVal == 'Yemen') ? ' SELECTED' : '' ) . '>Yemen</option>
		<option value="Yugoslavia"' . ( ($varVal == 'Yugoslavia') ? ' SELECTED' : '' ) . '>Yugoslavia</option>
		<option value="Zaire"' . ( ($varVal == 'Zaire') ? ' SELECTED' : '' ) . '>Zaire</option>
		<option value="Zambia"' . ( ($varVal == 'Zambia') ? ' SELECTED' : '' ) . '>Zambia</option>
		<option value="Zimbabwe"' . ( ($varVal == 'Zimbabwe') ? ' SELECTED' : '' ) . '>Zimbabwe</option>';
	return $countryList;
}

function lookupState($theState) {
	switch ($theState) {
		case 'AL':
			return 'Alabama';
			break;
		case 'AK':
			return 'Alaska';
			break;
		case 'AZ':
			return 'Arizona';
			break;
		case 'AR':
			return 'Arkansas';
			break;
		case 'CA':
			return 'California';
			break;
		case 'CO':
			return 'Colorado';
			break;
		case 'CT':
			return 'Connecticut';
			break;
		case 'DE':
			return 'Delaware';
			break;
		case 'DC':
			return 'District of Columbia';
			break;
		case 'FL':
			return 'Florida';
			break;
		case 'GA':
			return 'Georgia';
			break;
		case 'HI':
			return 'Hawaii';
			break;
		case 'ID':
			return 'Idaho';
			break;
		case 'IL':
			return 'Illinois';
			break;
		case 'IN':
			return 'Indiana';
			break;
		case 'IA':
			return 'Iowa';
			break;
		case 'KS':
			return 'Kansas';
			break;
		case 'KY':
			return 'Kentucky';
			break;
		case 'LA':
			return 'Louisiana';
			break;
		case 'MA':
			return 'Massachusetts';
			break;
		case 'MD':
			return 'Maryland';
			break;
		case 'ME':
			return 'Maine';
			break;
		case 'MI':
			return 'Michigan';
			break;
		case 'MN':
			return 'Minnesota';
			break;
		case 'MO':
			return 'Missouri';
			break;
		case 'MS':
			return 'Mississippi';
			break;
		case 'MT':
			return 'Montana';
			break;
		case 'NC':
			return 'North Carolina';
			break;
		case 'ND':
			return 'North Dakota';
			break;
		case 'NE':
			return 'Nebraska';
			break;
		case 'NV':
			return 'Nevada';
			break;
		case 'NH':
			return 'New Hampshire';
			break;
		case 'NJ':
			return 'New Jersey';
			break;
		case 'NM':
			return 'New Mexico';
			break;
		case 'NY':
			return 'New York';
			break;
		case 'OH':
			return 'Ohio';
			break;
		case 'OK':
			return 'Oklahoma';
			break;
		case 'OR':
			return 'Oregon';
			break;
		case 'PA':
			return 'Pennsylvania';
			break;
		case 'RI':
			return 'Rhode Island';
			break;
		case 'SC':
			return 'South Carolina';
			break;
		case 'SD':
			return 'South Dakota';
			break;
		case 'TN':
			return 'Tennessee';
			break;
		case 'TX':
			return 'Texas';
			break;
		case 'UT':
			return 'Utah';
			break;
		case 'VT':
			return 'Vermont';
			break;
		case 'VI':
			return 'Virgin Islands';
			break;
		case 'VA':
			return 'Virginia';
			break;
		case 'WA':
			return 'Washington';
			break;
		case 'WI':
			return 'Wisconsin';
			break;
		case 'WV':
			return 'West Virginia';
			break;
		case 'WY':
			return 'Wyoming';
			break;
	}
}

function getNewsletterHTML($varImageFile, $varHTMLContent, $varHTMLContent2, $varTintColor, $varDate) {
	global $appUnsecurePath, $appSiteName, $appOutlineColor, $appHeaderColor;

	$theText = '';
	$theText .= '
		<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" WIDTH="591" ALIGN="center" BGCOLOR="#FFFFFF">
		<TR><TD WIDTH="1" BGCOLOR="#' . $appOutlineColor . '"><IMG SRC="' . $appUnsecurePath . '/images/spacer.gif" BORDER="0" WIDTH="1" HEIGHT="1" ALT=""></TD>
			<TD WIDTH="162" BGCOLOR="#' . $appOutlineColor . '"><IMG SRC="' . $appUnsecurePath . '/images/spacer.gif" BORDER="0" WIDTH="162" HEIGHT="1" ALT=""></TD>
			<TD WIDTH="1" BGCOLOR="#' . $appOutlineColor . '"><IMG SRC="' . $appUnsecurePath . '/images/spacer.gif" BORDER="0" WIDTH="1" HEIGHT="1" ALT=""></TD>
			<TD WIDTH="426" BGCOLOR="#' . $appOutlineColor . '"><IMG SRC="' . $appUnsecurePath . '/images/spacer.gif" BORDER="0" WIDTH="426" HEIGHT="1" ALT=""></TD>
			<TD WIDTH="1" BGCOLOR="#' . $appOutlineColor . '"><IMG SRC="' . $appUnsecurePath . '/images/spacer.gif" BORDER="0" WIDTH="1" HEIGHT="1" ALT=""></TD>
		</TR>' . "\n";
	if ($varImageFile) {
		$theText .= '
		<TR><TD WIDTH="1" BGCOLOR="#' . $appOutlineColor . '"><IMG SRC="' . $appUnsecurePath . '/images/spacer.gif" BORDER="0" WIDTH="1" HEIGHT="1" ALT=""></TD>
			<TD COLSPAN="3"><A HREF="' . $appUnsecurePath . '/" TARGET="_blank"><IMG SRC="' . $appUnsecurePath . '/images/newsletter/' . $varImageFile . '" BORDER="0" WIDTH="660" ALT="' . $appSiteName . '"></A></TD>
			<TD WIDTH="1" BGCOLOR="#' . $appOutlineColor . '"><IMG SRC="' . $appUnsecurePath . '/images/spacer.gif" BORDER="0" WIDTH="1" HEIGHT="1" ALT=""></TD>
		</TR>' . "\n";
	}
	$theText .= '
		<tr><TD WIDTH="1" BGCOLOR="#' . $appOutlineColor . '"><IMG SRC="' . $appUnsecurePath . '/images/spacer.gif" BORDER="0" WIDTH="1" HEIGHT="1" ALT=""></TD>
			<TD COLSPAN="3" BGCOLOR="#' . $appHeaderColor . '"><IMG SRC="' . $appUnsecurePath . '/images/spacer.gif" BORDER="0" WIDTH="1" HEIGHT="4" ALT=""></TD>
			<TD WIDTH="1" BGCOLOR="#' . $appOutlineColor . '"><IMG SRC="' . $appUnsecurePath . '/images/spacer.gif" BORDER="0" WIDTH="1" HEIGHT="1" ALT=""></TD>
		</TR>
		<TR><TD WIDTH="1" BGCOLOR="#' . $appOutlineColor . '"><IMG SRC="' . $appUnsecurePath . '/images/spacer.gif" BORDER="0" WIDTH="1" HEIGHT="1" ALT=""></TD>
			<TD VALIGN="top" BGCOLOR="' . $varTintColor . '">
			<TABLE BORDER="0" CELLPADDING="1" CELLSPACING="0" WIDTH="100%">
			<TR><TD><IMG SRC="' . $appUnsecurePath . '/images/spacer.gif" BORDER="0" WIDTH="10" HEIGHT="1" ALT=""></TD>
				<TD><BR>' . $varHTMLContent . '</TD>
				<TD><IMG SRC="' . $appUnsecurePath . '/images/spacer.gif" BORDER="0" WIDTH="10" HEIGHT="1" ALT=""></TD>
			</TR>
			</TABLE><BR>
			</TD>
			<TD WIDTH="1" BGCOLOR="#' . $appOutlineColor . '"><IMG SRC="' . $appUnsecurePath . '/images/spacer.gif" BORDER="0" WIDTH="1" HEIGHT="1" ALT=""></TD>
			<TD VALIGN="top">
			<TABLE BORDER="0" CELLPADDING="1" CELLSPACING="0" WIDTH="100%">
			<TR><TD><IMG SRC="' . $appUnsecurePath . '/images/spacer.gif" BORDER="0" WIDTH="10" HEIGHT="1" ALT=""></TD>
				<TD><BR>' . $varHTMLContent2 . '</TD>
				<TD><IMG SRC="' . $appUnsecurePath . '/images/spacer.gif" BORDER="0" WIDTH="10" HEIGHT="1" ALT=""></TD>
			</TR>
			</TABLE><BR>
			</TD>
			<TD WIDTH="1" BGCOLOR="#' . $appOutlineColor . '"><IMG SRC="' . $appUnsecurePath . '/images/spacer.gif" BORDER="0" WIDTH="1" HEIGHT="1" ALT=""></TD>
		</TR>
		<TR><TD WIDTH="1" BGCOLOR="#' . $appOutlineColor . '"><IMG SRC="' . $appUnsecurePath . '/images/spacer.gif" BORDER="0" WIDTH="1" HEIGHT="1" ALT=""></TD>
			<TD VALIGN="top" BGCOLOR="' . $varTintColor . '"><IMG SRC="' . $appUnsecurePath . '/images/spacer.gif" BORDER="0" WIDTH="1" HEIGHT="1" ALT=""></TD>
			<TD WIDTH="1" BGCOLOR="#' . $appOutlineColor . '"><IMG SRC="' . $appUnsecurePath . '/images/spacer.gif" BORDER="0" WIDTH="1" HEIGHT="1" ALT=""></TD>
			<TD STYLE="padding: 1pt;">
			<TABLE BORDER="0" CELLPADDING="1" CELLSPACING="0" WIDTH="100%">
			<TR><TD><IMG SRC="' . $appUnsecurePath . '/images/spacer.gif" BORDER="0" WIDTH="10" HEIGHT="1" ALT=""></TD>
				<TD><BR>To remove yourself from this newsletter, <A HREF="' . $appUnsecurePath . '/unsub.php">click here</a>.  To subscribe to this newsletter, <A HREF="' . $appUnsecurePath . '/register.php?prmReturn=/page.php/prmID/305" TARGET="_blank">click here</A>.</TD>
				<TD><IMG SRC="' . $appUnsecurePath . '/images/spacer.gif" BORDER="0" WIDTH="10" HEIGHT="1" ALT=""></TD>
			</TR>
			</TABLE><BR>
			</TD>
			<TD WIDTH="1" BGCOLOR="#' . $appOutlineColor . '"><IMG SRC="' . $appUnsecurePath . '/images/spacer.gif" BORDER="0" WIDTH="1" HEIGHT="1" ALT=""></TD>
		</TR>
		<TR><TD COLSPAN="5" BGCOLOR="#' . $appOutlineColor . '"><IMG SRC="' . $appUnsecurePath . '/images/spacer.gif" BORDER="0" WIDTH="1" HEIGHT="1" ALT=""></TD>
		</TR>' . "\n";

	$theText .= '</TABLE>' . "\n";

	return $theText;
}

function calcShipping($theOrderID, $theShipType=1) {
	if (!$theOrderID) {
		return 0;
	}

	$calcdb = new cDB();

	$varFedexGroundRate = 0;
	$varUSPSIntlRate = 0;
	$varAddtlFedexGroundRate = 0;
	$varAddtlUSPSIntlRate = 0;
	$varOvernightRate = 0;
	$varAddtlOvernightRate = 0;

	$varShipping = 0;
	$varIntlShipping = 0;

	// calculate domestic shipping cost
	$strSQL = 'SELECT b.intMediaTypeID, b.mnyFedexGroundShip, b.mnyFedexGroundMultiShip, b.mnyUSPSIntlShip, b.mnyUSPSIntlMultiShip, b.mnyOvernightShip, b.mnyOvernightMultiShip, a.intQuantity FROM OrderDetails a, MediaLibrary b WHERE a.intMediaID = b.intMediaID AND a.intOrderID = ' . $theOrderID;
	$calcdb->query($strSQL);

	if ($calcdb->RowCount) {
		$varCount = 0;

		while ($calcdb->ReadRow()) {
			$varFedexGroundRate = $calcdb->RowData['mnyFedexGroundShip'];
			$varUSPSIntlRate = $calcdb->RowData['mnyUSPSIntlShip'];
			$varOvernightRate = $calcdb->RowData['mnyOvernightShip'];

			$varAddtlFedexGroundRate = $calcdb->RowData['mnyFedexGroundMultiShip'];
			$varAddtlUSPSIntlRate = $calcdb->RowData['mnyUSPSIntlMultiShip'];
			$varAddtlOvernightRate = $calcdb->RowData['mnyOvernightMultiShip'];

			$varQuantity = $calcdb->RowData['intQuantity'];

			switch ($theShipType) {
				case 1:
					$varShipping = $varFedexGroundRate + ($varQuantity - 1) * $varAddtlFedexGroundRate;
					break;
				case 2:
					$varShipping = $varUSPSIntlRate + ($varQuantity - 1) * $varAddtlUSPSIntlRate;
					break;
				case 3:
					$varShipping = $varOvernightRate + ($varQuantity - 1) * $varAddtlOvernightRate;
					break;
			}


			$varShipping += $varShipRate;
		}
	}

	$varIntlShipping = $varShipping;

	$calcdb->query("UPDATE Orders SET intRateID = $theShipType, mnyShipping = $varShipping, mnyIntlShipping = $varIntlShipping WHERE intOrderID = $theOrderID");
}

function GetParentSection($thePageID){
	$theParentID = Lookup("Pages", "intPageID", "intParentID", $thePageID);
	if($theParentID){
		$theParentID2 = Lookup("Pages", "intPageID", "intParentID", $theParentID);
		if($theParentID2){
			$theCrumbText = Lookup("Pages", "intPageID", "strPageName", $theParentID2);
		}else{
			$theCrumbText = Lookup("Pages", "intPageID", "strPageName", $theParentID);
		}
	}else{
		$theCrumbText = Lookup("Pages", "intPageID", "strPageName", $thePageID);
	}

	return $theCrumbText;
}

function GetParentSectionID($thePageID){

	$theParentID = Lookup("Pages", "intPageID", "intParentID", $thePageID);

	if($theParentID){
		$theParentID2 = Lookup("Pages", "intPageID", "intParentID", $theParentID);
		if($theParentID2){
			$theParentSectionID = $theParentID2;
		}else{
			$theParentSectionID = $theParentID;
		}
	}else{
		$theParentSectionID = $thePageID;
	}

	return $theParentSectionID;
}

function getEmailLists($prmCatID, $prmShowCheckboxes=1){
		$dbList = new cDB();
		$strSQL = "SELECT e.*, p.strName as GroupName FROM EmailLists e, PermissionGroups p WHERE p.intGroupID = e.intCategoryID AND e.intCategoryID = $prmCatID ORDER BY e.intCategoryID";
		$dbList->query( stripslashes($strSQL));
		if ($dbList->RowCount) {

				while ($dbList->ReadRow() ) {
					$prmListID	= 	$dbList->RowData['intEmailListID'];
					$prmListName	= $dbList->RowData['strName'];
					$prmCatID 		= $dbList->RowData['intCategoryID'];
					$prmDescription = $dbList->RowData['txtNotes'];
					$prmGroupName   = $dbList->RowData['GroupName'];
					if ($prmShowCheckboxes == 1){
						echo "<input type=\"checkbox\" name=\"prmEmailList[]\" value=\"".$prmListID."\">";
					}
					echo "<span onmouseover=\"Tip('$prmDescription', WIDTH, 250)\" class=\"listname\">" .$prmListName."</span><BR>";
				}

		}
}
function getHasEmailLists($prmCatID){
		$dbList = new cDB();
		$strSQL = "SELECT e.*, p.strName as GroupName FROM EmailLists e, PermissionGroups p WHERE p.intGroupID = e.intCategoryID AND e.intCategoryID = $prmCatID ORDER BY e.intCategoryID";
		$dbList->query( stripslashes($strSQL));
		if ($dbList->RowCount) {

			$hasLists = 1;

		}else{
			$hasLists = 0;
		}
	return $hasLists;
}

function dateDiff($dformat, $endDate, $beginDate)
{
$date_parts1=explode($dformat, $beginDate);
$date_parts2=explode($dformat, $endDate);
$start_date=gregoriantojd($date_parts1[0], $date_parts1[1], $date_parts1[2]);
$end_date=gregoriantojd($date_parts2[0], $date_parts2[1], $date_parts2[2]);
return $end_date - $start_date;
}


function showMenuList($prmMenuParentID, $menuName = ""){
	$menuDB = new cDB();
	$submenuDB = new cDB();
	$strSQL = "SELECT intPageID, strPageName, intLayoutID, bitPopUp, strFriendlyURL FROM Pages WHERE intParentID = $prmMenuParentID AND bitShowOnMenu = 1 AND bitArchived = 0 ORDER BY strSortKey";
	$menuDB->Query($strSQL);

	$theText = "";
	if ($menuDB->RowCount) {
		?>
		<ul <? if($menuName != ""){ echo "id=\"".$menuName."\""; }?>>
		<?
		while ($menuDB->ReadRow()) {
			$strSQL = "SELECT intPageID, strPageName, strActualURL, bitNoClick FROM Pages WHERE intParentID = " . $menuDB->RowData["intPageID"] . " AND bitShowOnMenu = 1 AND bitArchived = 0 ORDER BY strSortKey";
			$submenuDB->Query($strSQL);
			?>
			<li><a href="<?=$appUnsecurePath?>/<?=$menuDB->RowData["strFriendlyURL"]?>"><?=$menuDB->RowData["strPageName"];?></a>
			<?//get children
			if ($submenuDB->RowCount) {
				?>
				<ul>
				<?
				while ($submenuDB->ReadRow()) {
				?>
					<li><a href="<?=$appUnsecurePath?>/<?=$submenuDB->RowData["strFriendlyURL"]?>"><?=$submenuDB->RowData["strPageName"];?></a></li>
				<?
				}
				?>

				</ul>
				<?
			?>

			<?

			}
			?>
			</li>
			<?
		}
		?>
		</ul>
		<?
	}
}


function printJQueryMenu($menuNum, $divID){

?>
$(function () {
  $('#wrapper').each(function () {
    // options
    var distance = 1;
    var time = 250;
    var hideDelay = 500;

    var hideDelayTimer = null;

    // tracker
    var beingShown = false;
    var shown = false;

    var trigger<?=$menuNum?> = $('.trigger<?=$menuNum?>', this);
    var popup<?=$menuNum?> = $('#<?=$divID?>', this).css('opacity', 100);


	   // set the mouseover and mouseout on both element
    $([trigger<?=$menuNum?>.get(0), popup<?=$menuNum?>.get(0)]).mouseover(function () {
      // stops the hide event if we move from the trigger to the popup element
      if (hideDelayTimer) clearTimeout(hideDelayTimer);

      // don't trigger the animation again if we're being shown, or already visible
      if (beingShown || shown) {
        return;
      } else {
        beingShown = true;



		//popup<?=$menuNum?>.show("clip", { direction: "vertical" }, 500);
		popup<?=$menuNum?>.slideToggle();

        // reset position of popup box
        popup<?=$menuNum?>.css({
          //top: -100,
          //left: -33,
		  opacity: 1,
          display: 'block' // brings the popup back in to view
        })

        // (we're using chaining on the popup) now animate it's opacity and position
		//$(".popup").show("clip", { direction: "vertical" }, 1000);
		  beingShown = false;
          shown = true;

      }
    }).mouseout(function () {
      // reset the timer if we get fired again - avoids double animations
      if (hideDelayTimer) clearTimeout(hideDelayTimer);

      // store the timer so that it can be cleared in the mouseover if required
      hideDelayTimer = setTimeout(function () {
        hideDelayTimer = null;
		//popup<?=$menuNum?>.hide("clip", { direction: "vertical" }, 1000);
		popup<?=$menuNum?>.slideUp();
        popup<?=$menuNum?>.animate({
          //top: '-=' + distance + 'px',
          opacity: 0
        }, time, 'swing', function () {
          // once the animate is complete, set the tracker variables
          shown = false;
          // hide the popup entirely after the effect (opacity alone doesn't do the job)
          popup<?=$menuNum?>.css('display', 'none');
        });
      }, hideDelay);
    });
  });
});
<?
}


function inStr ($needle, $haystack)
{
  $needlechars = strlen($needle); //gets the number of characters in our needle
  $i = 0;
  for($i=0; $i < strlen($haystack); $i++) //creates a loop for the number of characters in our haystack
  {
    if(substr($haystack, $i, $needlechars) == $needle) //checks to see if the needle is in this segment of the haystack
    {
      return TRUE; //if it is return true
    }
  }
  return FALSE; //if not, return false
}


function dateconvert($date,$func) {
	if ($func == 1){ //insert conversion
		list($month, $day, $year) = split('[/.-]', $date);
		$date = "$year-$month-$day";
		return $date;
	}
	if ($func == 2){ //output conversion
		$date = left($date, 10);
		list($year, $month, $day) = split('[-.]', $date);
		$date = "$month/$day/$year";

		if ($date == '00/00/0000' or $date == '00-00-0000') {
			$date = '';
		}

		return $date;
	}
}

if (!function_exists("stripos")) {
    function stripos($haystack, $needle, $offset=0) {
        return strpos(strtolower($haystack), strtolower($needle), $offset);
    }
}

function cutText($string, $setlength) {
    $length = $setlength;
    if($length<strlen($string)){
        while (($string{$length} != " ") AND ($length > 0)) {
            $length--;
        }
        if ($length == 0) return substr($string, 0, $setlength);
        else return substr($string, 0, $length);
    }else return $string;
}

function textLimit($string, $length, $replacer = '...')
{
  if(strlen($string) > $length)
  return (preg_match('/^(.*)\W.*$/', substr($string, 0, $length+1), $matches) ? $matches[1] : substr($string, 0, $length)) . $replacer;

  return $string;
}

function highlightkeywords($text, $word){
	$word = str_replace('"', '', stripslashes($word));
	$word = str_replace('+', ' ', stripslashes($word));


	$color = "red";
	$text = strip_tags($text, "<b>,<i>,<u>");

	//get the position of where the keyword appears
	$position = stripos($text, $word);
	$strLength = strlen($text);

	//if position > 30 then that is the start position, else start position is 0
	if ($position > 30){
		$start_pos = $position - 30;
	}else{
		$start_pos = 0;
	}

	//get the end position. if length < the start position + 70 (30 chars before keyword and 40 chars after) then end position is the length of the string, else end position is start+90
	if ($strLength < ($start_pos + 70)){
		$end_pos = $strLength;
	}else{
		$end_pos = ($start_pos + 70);
	}

	//get the text from start to end position
	$text = substr($text, $start_pos, $end_pos);

	//echo "start:".$start_pos."<BR>";
	//echo "end:".$end_pos."<BR>";

	//if word is cut off in the middle, cut off last word on left
	if($start_pos > 0){
		//cut off left until space
		$isSpace = 0;
		$i = 0;
		$newStart = 0;
		while ($isSpace == 0){
			if(substr($text, $i, 1) == " "){
				$isSpace = 1; //set isSpace to true
				$newStart = $i;
			}
			$i++;
		}
		$text = "...".substr($text,$newStart,strlen($text));
	}

	//if word is cut off in middle, cut right
	//$text = textLimit($text, 90);
	$text = cutText($text, 70);

	//highlight the keyword
	$text = preg_replace("|($word)|Ui" , "<span style=\"font-weight: bold;\"><b>$1</b></span>" , $text );

	return $text;
}

function getTimePeriod($prmSelectedTime){

	switch($prmSelectedTime)
	{
	case 1:
	  $prmTimeTitle = "6AM to 9AM";
	  break;
	case 2:
	  $prmTimeTitle = "9AM to 12PM";
	  break;
	case 3:
	  $prmTimeTitle = "12PM to 3PM";
	  break;
	case 4:
	  $prmTimeTitle = "3PM to 6PM";
	  break;
	case 5:
	  $prmTimeTitle = "6PM to 9PM";
	  break;
	case 6:
	  $prmTimeTitle = "9PM to 6AM";
	  break;
	default:
	  $prmTimeTitle = "6AM to 9AM";
	}
	return $prmTimeTitle;
}

function getSelectedType($prmSelectedType){

	switch($prmSelectedType)
	{
	case 1:
	  $prmTimeTitle = "Body";
	  break;
	case 2:
	  $prmTimeTitle = "Mind";
	  break;
	case 3:
	  $prmTimeTitle = "Care";
	  break;
	}
	return $prmDisplayType;
}


	function createthumb($name,$filename,$new_w,$new_h,$dstx=0,$dsty=0,$restrain=0){
		$system=explode(".",$name);
		if (preg_match("/jpg|jpeg/",$system[1])){$src_img=imagecreatefromjpeg($name);}
		if (preg_match("/JPG|JPEG/",$system[1])){$src_img=imagecreatefromjpeg($name);}
		if (preg_match("/png/",$system[1])){$src_img=imagecreatefrompng($name);}
		if (preg_match("/PNG/",$system[1])){$src_img=imagecreatefrompng($name);}
		if (preg_match("/gif/",$system[1])){$src_img=imagecreatefromgif($name);}
		if (preg_match("/GIF/",$system[1])){$src_img=imagecreatefromgif($name);}

		$old_x=imageSX($src_img);
		$old_y=imageSY($src_img);

		if($restrain == 0){
			if ($old_x > $old_y)
			{
				$thumb_w=$new_w;
				$thumb_h=$old_y*($new_h/$old_x);
			}
			if ($old_x < $old_y)
			{
				$thumb_w=$old_x*($new_w/$old_y);
				$thumb_h=$new_h;
			}
			if ($old_x == $old_y)
			{
				$thumb_w=$new_w;
				$thumb_h=$new_h;
			}
		}else{
			$thumb_w=$new_w;
			$thumb_h=$new_h;
		}
		$dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);

		imagecopyresampled($dst_img,$src_img,0,0,$dstx,$dsty,$thumb_w,$thumb_h,$old_x,$old_y);


		if (preg_match("/png/",$system[1]))
		{
			imagepng($dst_img,$filename,100);
		} else if (preg_match("/gif/",$system[1])){
			imagegif($dst_img,$filename,100);
		} else {
			imagejpeg($dst_img,$filename,100);
		}
		imagedestroy($dst_img);
		imagedestroy($src_img);
	}

class cropImage{
		var $imgSrc,$myImage,$cropHeight,$cropWidth,$x,$y,$thumb,$imgDest;

	function setImage($image, $imageDest, $mycropwidth, $mycropheight, $myX = 0, $myY = 0)
	{
		global $sessUserID;

		//Your Image
			   $this->imgSrc = $image;
			   $this->imgDest = $imageDest;
				

				
		//getting the image dimensions
			   list($width, $height) = getimagesize($this->imgSrc);
			
		//create image from the jpeg
				$system=explode(".",$this->imgSrc);
				
				if (preg_match("/gif/",$system[1])){
					$this->myImage = imagecreatefromgif($this->imgSrc) or die("Error: Cannot find image!");
				}else if (preg_match("/png/",$system[1])){
					$this->myImage = imagecreatefrompng($this->imgSrc) or die("Error: Cannot find image!");
				}else{
					

					$this->myImage = imagecreatefromjpeg($this->imgSrc) or die("Error: Cannot find image!");

				}
			
				if($sessUserID == 430){
					echo "past";
				}
			       if($width > $height) $biggestSide = $width; //find biggest length
			       else $biggestSide = $height;

		//The crop size will be half that of the largest side
			   $cropPercent = .5; // This will zoom in to 50% zoom (crop)
			   $this->cropWidth   = $mycropwidth; //$biggestSide*$cropPercent;
			   $this->cropHeight  = $mycropheight; //$biggestSide*$cropPercent;


		//getting the top left coordinate
			   $this->x =  $myX; //($width-$this->cropWidth)/2;
			   $this->y =  $myY; //($height-$this->cropHeight)/2;

	}

	function createThumb()
	{

	  $thumbSize = 100; // will create a 250 x 250 thumb
	  $this->thumb = imagecreatetruecolor($this->cropWidth, $this->cropHeight);

	  imagecopyresampled($this->thumb, $this->myImage, 0, 0,$this->x, $this->y, $this->cropWidth, $this->cropHeight, $this->cropWidth, $this->cropHeight);
	  $system=explode(".",$this->imgDest);

		if (preg_match("/png/",$system[1]))
		{
			imagepng($this->thumb,$this->imgDest,100);
		}else if(preg_match("/gif/",$system[1])){
			imagegif($this->thumb,$this->imgDest,100);
		
		} else {
			imagejpeg($this->thumb,$this->imgDest,100);
		}

	}
}


function isDateBetween($dt_start, $dt_check, $dt_end){
  if(strtotime($dt_check) >= strtotime($dt_start) && strtotime($dt_check) <= strtotime($dt_end)) {
    return true;
  }
  return false;
}

/****Generate random string for Doctor BMI patient lookup**/
function random_string( )
  {
    $character_set_array = array( );
    // $character_set_array[ ] = array( 'count' => 4, 'characters' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' );
    $character_set_array[ ] = array( 'count' => 10, 'characters' => '0123456789' );
    $temp_array = array( );
    foreach ( $character_set_array as $character_set )
    {
      for ( $i = 0; $i < $character_set[ 'count' ]; $i++ )
      {
        $temp_array[ ] = $character_set[ 'characters' ][ rand( 0, strlen( $character_set[ 'characters' ] ) - 1 ) ];
      }
    }
	var_dump($temp_array );
    shuffle( $temp_array );
var_dump($temp_array );
    return implode( '', $temp_array );
}

function getMaxCalories($prmHeight, $prmWeight, $prmAge, $prmSex, $prmActivityLevel = 1.2){
	if($prmSex == "M"){
		$prmSexVar = 5;
	}else{
		$prmSexVar = -161;
	}
	$prmWeightCalc = (($prmWeight * 0.45) * 9.99); //weight in lbs
	$prmHeightCalc = (($prmHeight * 2.54) * 6.25); //pass height in inches
	$prmAgeCalc = ($prmAge * 4.92); //age in years




	$P = (($prmHeightCalc + $prmWeightCalc - $prmAgeCalc + $prmSexVar) * $prmActivityLevel) * 1.1;
	return ceil($P);
}

function getTotalInches($prmFeet, $prmInches){
	$valTotalInches = $prmInches + ($prmFeet * 12);
	return $valTotalInches;
}

function getBMI($valWeight, $varTotalInches){
	$varBMI = 0;
	if ( $varTotalInches > 0){
		$varBMI = round(($valWeight / ($varTotalInches * $varTotalInches)) * 703, 2);
	}
	
	return $varBMI;
}

function timeFrom($theTime)
{
	$now = strtotime("now");
	$theTime = strtotime($theTime);

	$timeFrom =  $now - $theTime;

	if($timeFrom > 0)
	{
	$years = floor($timeFrom/60/60/24/31/12);
	$months = floor($timeFrom/60/60/24/31);
	$days = floor($timeFrom/60/60/24);
	$hours = $timeFrom/60/60%24;
	$mins = $timeFrom/60%60;
	$secs = $timeFrom%60;

	$showPlural = "";

	if($years)
	{
		if($years > 1){
			$showPlural = "s";
		}
		$theText = $years.' year'.$showPlural.' ago ';

	}
	elseif($months)
	{
		if($months > 1){
			$showPlural = "s";
		}
		$theText = ''.$months.' month'.$showPlural.' ago ';

	}
	elseif($days)
	{
		if($days > 1){
			$showPlural = "s";
		}
		$theText = ''.$days.' day'.$showPlural.' ago ';

	}
	elseif($hours)
	{
		if($hours > 1){
			$showPlural = "s";
		}
		$theText = ''.$hours.' hour'.$showPlural.' ago ';
	}
	elseif($mins)
	{
		if($mins > 1){
			$showPlural = "s";
		}
		$theText = ''.$mins.' minute'.$showPlural.' ago ';

	}
	elseif($secs)
	{
		if($secs > 1){
			$showPlural = "s";
		}
		$theText = ''.$secs.' second'.$showPlural.' ago';
	}
	}
	else
	{
	$theText = "1 second ago";
	}

	return $theText;
}

function stripText($text)
{
	$text = strtolower(trim($text));
	// replace all white space sections with a dash
	$text = str_replace(' ', '-', $text);
	// strip all non alphanum or -
	$clean = ereg_replace("[^A-Za-z0-9\-]", "", $text);

	return $clean;
}

function createDateRangeArray($strDateFrom,$strDateTo) {
  // takes two dates formatted as YYYY-MM-DD and creates an
  // inclusive array of the dates between the from and to dates.

  // could test validity of dates here but I'm already doing
  // that in the main script

  $aryRange=array();

  $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
  $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

  if ($iDateTo>=$iDateFrom) {
    array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry

    while ($iDateFrom<$iDateTo) {
      $iDateFrom+=86400; // add 24 hours
      array_push($aryRange,date('Y-m-d',$iDateFrom));
    }
  }
  return $aryRange;
}

function getFriendsByUserID($prmUserID,  $prmAddUserID = 0){
	$db = new cDB();
	$strSQL = "SELECT * FROM Xref WHERE intTypeID = 75 AND intValue = 1 AND (intPrimaryID = $prmUserID OR intLinkID = $prmUserID)";

	$db->Query($strSQL);

	$prmFriendList = "";
	if($db->RowCount){
		$ctr = 0;

		while($db->ReadRow()){
			$prmFriendID = 0;
			$prmPrimaryID = $db->RowData["intPrimaryID"];
			$prmLinkID = $db->RowData["intLinkID"];
			if($prmUserID == $prmPrimaryID){
				$prmFriendID = $prmLinkID;
			}else{
				$prmFriendID = $prmPrimaryID;
			}

			if($prmFriendID > 0){
				if($ctr > 0){
					$prmFriendList .= ",";
				}
				$prmFriendList .= $prmFriendID;
			}
			$ctr++;
		}
		if($prmAddUserID){
			$prmFriendList .= ",$prmUserID";
		}
	}else{
		if($prmAddUserID){
			$prmFriendList = "$prmUserID";
		}
	}

	return $prmFriendList;
}

function getTimeByintTimeZone($intTimeZone){
	if($intTimeZone == 1){
		$prmTime = "06:00:00";
	}else if($intTimeZone == 2){
		$prmTime = "09:00:00";
	}else if($intTimeZone == 3){
		$prmTime = "12:00:00";
	}else if($intTimeZone == 4){
		$prmTime = "15:00:00";
	}else if($intTimeZone == 5){
		$prmTime = "18:00:00";
	}else if($intTimeZone == 6){
		$prmTime = "21:00:00";
	}else{
		$prmTime = "06:00:00";
	}
	return $prmTime;
}


    function sort2d ($array, $index, $order='asc', $natsort=true, $case_sensitive=FALSE)
    {
        if(is_array($array) && count($array)>0)
        {
           foreach(array_keys($array) as $key) {
               $temp[$key]=$array[$key][$index];
			   //echo $temp[$key] . "<BR>";
			   }
               if(!$natsort)
                   ($order=='asc')? asort($temp) : arsort($temp);
              else
              {
                 ($case_sensitive)? natsort($temp) : natcasesort($temp);
                 if($order!='asc')
                     $temp=array_reverse($temp,TRUE);
           }
           foreach(array_keys($temp) as $key){
               (is_numeric($key))? $sorted[]=$array[$key] : $sorted[$key]=$array[$key];
			}

           return $sorted;
      }
      return $array;
    }
	
function cleanseString($prmString){
	preg_match('!(<script>)(.*)(</script>)!', $prmString, $output);
	$output = str_replace($output[2],"",$output);
	$output = str_replace("<script>","",$output);
	$output = str_replace("</script>","",$output);
}

function startPageLoadTime(){
	$starttime1 = microtime();
	$startarray = explode(" ", $starttime1);
	$starttime1 = $startarray[1] + $startarray[0];	
	return $starttime1;
}
function endPageLoadTime($starttime1){
	$endtime = microtime();
	$endarray = explode(" ", $endtime);
	$endtime = $endarray[1] + $endarray[0];
	$totaltime = $endtime - $starttime1;
	$totaltime = round($totaltime,5);
	return $totaltime;
}


function browser_info($agent=null) {
  // Declare known browsers to look for
  $known = array('msie', 'firefox', 'safari', 'webkit', 'opera', 'netscape',
    'konqueror', 'gecko');

  // Clean up agent and build regex that matches phrases for known browsers
  // (e.g. "Firefox/2.0" or "MSIE 6.0" (This only matches the major and minor
  // version numbers.  E.g. "2.0.0.6" is parsed as simply "2.0"
  $agent = strtolower($agent ? $agent : $_SERVER['HTTP_USER_AGENT']);
  $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9]+(?:\.[0-9]+)?)#';

  // Find all phrases (or return empty array if none found)
  if (!preg_match_all($pattern, $agent, $matches)) return array();

  // Since some UAs have more than one phrase (e.g Firefox has a Gecko phrase,
  // Opera 7,8 have a MSIE phrase), use the last one found (the right-most one
  // in the UA).  That's usually the most correct.
  $i = count($matches['browser'])-1;
  return array($matches['browser'][$i] => $matches['version'][$i]);
}


function addLoginRecord($userId) {
		$db = new cDB();
		$strSQL = "INSERT INTO  `UserLoginRecord` (  `id` ,  `intUserId` ,  `IP` ,  `date` ) VALUES (NULL , $userId ,  '" . $_SERVER['REMOTE_ADDR'] . "', NOW())";
		$db->Query($strSQL);
}



/**
 * This function queries CV, Users table and return most recent weight and height (and date) of given user
 *
 */
function getRecentHeightWeight($userId){

	$db = new cDB();

	$db->Query("
		select c1.intValue as weight, c2.intValue as hightFeet, c3.intValue as hightInches, d.dtmDoctorVerifiedStartUp as date from Codes c1, Codes c2, Codes c3,
		((
		select strStartWeight, intHeight, intHeightInches, dtmDoctorVerifiedStartUp
		from ChallengeVerification where intuserid  = $userId
		order by dtmDoctorVerifiedStartUp desc limit 1
		)union(
		select intWeight, intHeightFeet, intHeightInches, dtmCreated from Users where intuserid = $userId
		))d
		where c1.intCodeid = d.strStartWeight and c2.intCodeid = d.intHeight and c3.intCodeid = d.intHeightInches
	");
	$row = Array();

	if ( $db->RowCount ) {
		if ( $db->ReadRow() ) {
			return $db->RowData;
		}else{
			// may not happen as users table will always return the result
		}
	}else{
		// may not happen as users table will always return the result
	}
	
	return null;
}

/**
 * This function tries to calculate BMI of a given user with most recent data
 *
 */
function getRecentBMI($userId){
	$recentDetail = getRecentHeightWeight($userId);	
	if ( $recentDetail != null){
			$varTotalInches = (12 * $recentDetail['hightFeet']) + $recentDetail['hightInches'];
			if ($varTotalInches > 0){
				return getBMI( $recentDetail['weight'], $varTotalInches);
			}else{
				// Handle height = 0
			}
	}
}
	/**
	* This function tries to Insert BMI of a given user with most recent data
	*
	*/
function getUpdateBMI($bmi,$userId){
	$updateQuery = "UPDATE Users SET fltBMI = $bmi where intUserId = $userId";
	$db = new cDB();
	$db->query($updateQuery);
	return;
}

function getLatestHeight($userId){

	$db = new cDB();

	$db->Query("
			SELECT c2.intValue AS hightFeet, c3.intValue AS hightInches, d.date
			FROM Codes c2, Codes c3, (
			(
			
			SELECT intHeight, intHeightInches, dtmDoctorVerifiedStartUp AS date
			FROM ChallengeVerification
			WHERE intuserid =$userId
			ORDER BY dtmDoctorVerifiedStartUp DESC
			)
			UNION (
			
			SELECT intHeightFeet, intHeightInches, dtmCreated AS date
			FROM Users
			WHERE intuserid =$userId
			ORDER BY dtmCreated DESC
			)
			)d
			WHERE c2.intCodeid = d.intHeight
			AND c3.intCodeid = d.intHeightInches
			ORDER BY d.date DESC
			LIMIT 1 ");
	$row = Array();
	
	if ( $db->RowCount ) {
		if ( $db->ReadRow() ) {
			return $db->RowData;
		}else{
			// may not happen as users table will always return the result
		}
	}else{
		// may not happen as users table will always return the result
	}
	
	return null;
}
	
/**
	* This function queries CV, Users table and return most recent weight (and date) of given user
	*
	*/
	function getLatestWeight($userId){
		$db = new cDB();
		$db->Query("SELECT cv2.dtmPostDate2, cv2.Weight
		FROM (
		(
		
		SELECT cv.strStartVisitDate AS dtmPostDate2, c1.intValue AS Weight
		FROM `ChallengeVerification` cv, Codes c1
		WHERE intUserID =$userId
		AND cv.strStartWeight !=0
		AND c1.intCodeid = cv.strStartWeight
		)
		UNION (
		
		SELECT dtmPostDate AS dtmPostDate2, cast( fltValue AS DECIMAL( 10, 0 ) )
		FROM `Journal` j
		WHERE intUserID =$userId
		AND intTypeID =8
		AND intSourceID =5
		AND fltValue !=0
		)
		union(
		select  u.dtmCreated,c2.intValue AS Weight from Users u, Codes c2 where u.intuserid = $userId
		AND c2.intCodeid = u.intWeight
		)
		)cv2
		ORDER BY cv2.dtmPostDate2 DESC LIMIT 1");
		$row = Array();
		
		if ( $db->RowCount ) {
			if ( $db->ReadRow() ) {
				return $db->RowData;
			}else{
				// may not happen as users table will always return the result
			}
		}else{
			// may not happen as users table will always return the result
		}
		
		return null;
}

function getlatestBMI($userId){
	$recentDetailweight = getLatestWeight($userId);
	$recentDetailheight = getLatestHeight($userId);
	if ( $recentDetailweight != null && $recentDetailheight != null){
		$varTotalInches = (12 * $recentDetailheight['hightFeet']) + $recentDetailheight['hightInches'];
		if ($varTotalInches > 0){
			return  getBMI( $recentDetailweight['Weight'], $varTotalInches);
		}else{
			// Handle height = 0
		}
	}
}
		
?>