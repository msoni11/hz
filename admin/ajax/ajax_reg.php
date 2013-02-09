<?php 
include '../../includes/Application.php';
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array( 'empid', 'empname', 'unit', 'department', 'designation', 'hardware', 'printertype', 'make', 'model', 'cpuno', 'monitortype', 'monitorno', 'sysconfig', 'cartage', 'assetcode', 'ipaddr', 'officever', 'licensesoft', 'internet', 'internettype', 'warnorvendor', 'date', 'otheritasset', 'status', 'id' );
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "he.empid";
	
	/* DB table to use */
	//$sTable = "hz_registration hr LEFT OUTER JOIN hz_employees he";
	
	/* Database connection information */
	$gaSql['user']       = $appDBUser;
	$gaSql['password']   = $appDBPassword;
	$gaSql['db']         = $appDBDatabase;
	$gaSql['server']     = $appDBHost;
	
	/* REMOVE THIS LINE (it just includes my SQL connection user/pass) */
	//include( $_SERVER['DOCUMENT_ROOT']."/datatables/mysql.php" );
	
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * If you just want to use the basic configuration for DataTables with PHP server-side, there is
	 * no need to edit below this line
	 */
	
	/* 
	 * Local functions
	 */
	function fatal_error ( $sErrorMessage = '' )
	{
		header( $_SERVER['SERVER_PROTOCOL'] .' 500 Internal Server Error' );
		die( $sErrorMessage );
	}

	
	/* 
	 * MySQL connection
	 */
	if ( ! $gaSql['link'] = mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) )
	{
		fatal_error( 'Could not open connection to server' );
	}

	if ( ! mysql_select_db( $gaSql['db'], $gaSql['link'] ) )
	{
		fatal_error( 'Could not select database ' );
	}
	
	
	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".
			mysql_real_escape_string( $_GET['iDisplayLength'] );
	}
	
	
	/*
	 * Ordering
	 */
	$sOrder = "";
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
				 	mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
	
	/* 
	 * Filtering
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here, but concerned about efficiency
	 * on very large tables, and MySQL's regex functionality is very limited
	 */
	$sWhere = "";
	if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
	{
		$sWhere = "WHERE (";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ($aColumns[$i] == 'empid') {
				$sWhere .= "empid = '".mysql_real_escape_string( $_GET['sSearch'] )."' OR ";
			} else if ($aColumns[$i] == 'id') {
				//$sWhere .= ""he.id" LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
			} else {
				$sWhere .= "".$aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
			}
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	
	/* Individual column filtering */
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= "".$aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
		}
	}
	
	
	/*
	 * SQL queries
	 * Get data to display
	 */
	$sQuery = "
		SELECT 
		a.empid empid,
		a.empname empname,
		a.unit unit,
		a.department department,
		a.designation designation,
		a.hardware hardware,
		if (a.printertype='0','NONE', a.printertype) printertype,
		a.make make, 
		a.model model, 
		a.cpuno cpuno, 
		a.monitortype monitortype, 
		a.monitorno monitorno, 
		a.sysconfig sysconfig, 
		a.cartage cartage, 
		a.assetcode assetcode, 
		a.ipaddr ipaddr, 
		a.officever officever, 
		a.licensesoft licensesoft, 
		a.internet internet, 
		a.internettype internettype, 
		a.warnorvendor warnorvendor, 
		a.date date, 
		a.otheritasset otheritasset, 
		a.status status, 
		a.id id	FROM 
		((SELECT he.empid as empid, empname, unit, department, designation, hh.name hardware, printertype, hm.name make, hmo.modelname model, cpuno, monitortype, monitorno, sysconfig, cartage, assetcode, ipaddr, officever, licensesoft, internet, internettype, warnorvendor, date, otheritasset, status, hr.id as id
			FROM hz_registration hr 
			LEFT OUTER JOIN hz_employees he ON (hr.empid = he.empid)
			LEFT OUTER JOIN hz_hardware hh ON ( hr.hardware = hh.id )
			LEFT OUTER JOIN hz_make hm ON ( hr.make = hm.id )
			LEFT OUTER JOIN hz_model hmo ON ( hr.model = hmo.id ) WHERE hardware != 3 AND activestatus='A')
		UNION 
		(SELECT he.empid as empid, empname, unit, department, designation, hh.name hardware, hpt.printertype printertype, hm.name make, hpmo.printermodel model, cpuno, monitortype, monitorno, sysconfig, hcar.cartage cartage, assetcode, ipaddr, officever, licensesoft, internet, internettype, warnorvendor, date, otheritasset, status, hr.id as id
		FROM hz_registration hr 
			LEFT OUTER JOIN hz_employees he ON (hr.empid = he.empid)
			LEFT OUTER JOIN hz_hardware hh ON ( hr.hardware = hh.id )
			LEFT OUTER JOIN hz_cartage hcar ON ( hr.cartage = hcar.id )
			LEFT OUTER JOIN hz_printertype hpt ON ( hr.printertype = hpt.id )
			LEFT OUTER JOIN hz_make hm ON ( hr.make = hm.id )
			LEFT OUTER JOIN hz_printermodel hpmo ON ( hr.model = hpmo.id ) WHERE hardware = 3 AND activestatus='A'))a
		
		$sWhere
		$sOrder
		$sLimit
		";
	$rResult = mysql_query( $sQuery, $gaSql['link'] ) or fatal_error( 'MySQL Error: ' . mysql_errno() );
	
	/* Data set length after filtering */
	$sQuery = "
SELECT 
		count(*) FROM 
		((SELECT he.empid as empid, empname, unit, department, designation, hh.name hardware, printertype, hm.name make, hmo.modelname model, cpuno, monitortype, monitorno, hc.config sysconfig, cartage, assetcode, ipaddr, officever, licensesoft, internet, internettype, warnorvendor, date, otheritasset, status, hr.id as id
			FROM hz_registration hr 
			LEFT OUTER JOIN hz_employees he ON (hr.empid = he.empid)
			LEFT OUTER JOIN hz_hardware hh ON ( hr.hardware = hh.id )
			LEFT OUTER JOIN hz_make hm ON ( hr.make = hm.id )
			LEFT OUTER JOIN hz_configuration hc ON ( hr.make = hc.id )
			LEFT OUTER JOIN hz_model hmo ON ( hr.model = hmo.id ) WHERE hardware != 3 AND activestatus='A')
		UNION 
		(SELECT he.empid as empid, empname, unit, department, designation, hh.name hardware, hpt.printertype printertype, hm.name make, hpmo.printermodel model, cpuno, monitortype, monitorno, sysconfig, hcar.cartage cartage, assetcode, ipaddr, officever, licensesoft, internet, internettype, warnorvendor, date, otheritasset, status, hr.id as id
		FROM hz_registration hr 
			LEFT OUTER JOIN hz_employees he ON (hr.empid = he.empid)
			LEFT OUTER JOIN hz_hardware hh ON ( hr.hardware = hh.id )
			LEFT OUTER JOIN hz_cartage hcar ON ( hr.cartage = hcar.id )
			LEFT OUTER JOIN hz_printertype hpt ON ( hr.printertype = hpt.id )
			LEFT OUTER JOIN hz_make hm ON ( hr.make = hm.id )
			LEFT OUTER JOIN hz_configuration hc ON ( hr.make = hc.id )
			LEFT OUTER JOIN hz_printermodel hpmo ON ( hr.model = hpmo.id ) WHERE hardware = 3 AND activestatus='A'))a
		
		$sWhere	";
	$rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or fatal_error( 'MySQL Error: ' . mysql_errno() );
	$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
	$iFilteredTotal = $aResultFilterTotal[0];
	
	/* Total data set length */
	$sQuery = "
		SELECT 
		count(*) FROM 
		((SELECT he.empid as empid, empname, unit, department, designation, hh.name hardware, printertype, hm.name make, hmo.modelname model, cpuno, monitortype, monitorno, hc.config sysconfig, cartage, assetcode, ipaddr, officever, licensesoft, internet, internettype, warnorvendor, date, otheritasset, status, hr.id as id
			FROM hz_registration hr 
			LEFT OUTER JOIN hz_employees he ON (hr.empid = he.empid)
			LEFT OUTER JOIN hz_hardware hh ON ( hr.hardware = hh.id )
			LEFT OUTER JOIN hz_make hm ON ( hr.make = hm.id )
			LEFT OUTER JOIN hz_configuration hc ON ( hr.make = hc.id )
			LEFT OUTER JOIN hz_model hmo ON ( hr.model = hmo.id ) WHERE hardware != 3 AND activestatus='A')
		UNION 
		(SELECT he.empid as empid, empname, unit, department, designation, hh.name hardware, hpt.printertype printertype, hm.name make, hpmo.printermodel model, cpuno, monitortype, monitorno, sysconfig, hcar.cartage cartage, assetcode, ipaddr, officever, licensesoft, internet, internettype, warnorvendor, date, otheritasset, status, hr.id as id
		FROM hz_registration hr 
			LEFT OUTER JOIN hz_employees he ON (hr.empid = he.empid)
			LEFT OUTER JOIN hz_hardware hh ON ( hr.hardware = hh.id )
			LEFT OUTER JOIN hz_cartage hcar ON ( hr.cartage = hcar.id )
			LEFT OUTER JOIN hz_printertype hpt ON ( hr.printertype = hpt.id )
			LEFT OUTER JOIN hz_make hm ON ( hr.make = hm.id )
			LEFT OUTER JOIN hz_configuration hc ON ( hr.make = hc.id )
			LEFT OUTER JOIN hz_printermodel hpmo ON ( hr.model = hpmo.id ) WHERE hardware = 3 AND activestatus='A'))a
	";
	$rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or fatal_error( 'MySQL Error: ' . mysql_errno() );
	$aResultTotal = mysql_fetch_array($rResultTotal);
	$iTotal = $aResultTotal[0];
	
	
	/*
	 * Output
	 */
	$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
		$row = array();
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] == "version" )
			{
				/* Special output formatting for 'version' column */
				$row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
			}
			else if ($aColumns[$i] == "warnorvendor" ) {
				if ($aColumns[$i-1] == "internettype" ) {
					if ($aRow[$aColumns[$i-1]] == "AMC") {
						$row[] = $aRow[ $aColumns[$i] ];
					} else if ($aRow[$aColumns[$i-1]] == "WAR") {
						$warnDateArray = getdate($aRow[ $aColumns[$i] ]);
						$row[] = $warnDateArray['mday'].'/'.$warnDateArray['mon'].'/'.$warnDateArray['year'];
					}
				}
			}
			else if ($aColumns[$i] == "cpuno") {
				$row[] = "'".trim($aRow[ $aColumns[$i]])."'";
			}
			else if ($aColumns[$i] == "date" ) {
				$dateArray = getdate($aRow[ $aColumns[$i] ]);
				$row[] = $dateArray['mday'].'/'.$dateArray['mon'].'/'.$dateArray['year'];
			}
			else if ($aColumns[$i] == "id" ) {
			}
			else if ($aColumns[$i] == "cartage") {
				if ($aRow[ $aColumns[$i] ] == '') {
					$row[] = 'NONE';
				} else {
					$row[] = $aRow[ $aColumns[$i] ];
				}
			}
			else if ( $aColumns[$i] != ' ' )
			{
				/* General output */
				$row[] = $aRow[ $aColumns[$i] ];
			}
		}
		$row[] = '<a href="../editRegistration.php?id='.base64_encode($aRow[ $aColumns[24] ]).'" title="click to edit""><img src="../images/edit-icon.png" style="border:none; display:inline" /></a>&nbsp;<span class="deletereg" style="cursor:pointer"><input type="hidden" class="delregid" value="'.$aRow[ $aColumns[24] ].'" ><img src="../images/delete-icon.png" alt="Click to delete" title="Click to delete" /><img src="images/ajax-loader.gif" class="loader" style="display:none" /></span>&nbsp;<span class="transferreg" style="cursor:pointer"><input type="hidden" class="transferregid" value="'.$aRow[ $aColumns[24] ].'" ><img src="../images/move-icon.png" alt="Click to transfer" title="Click to transfer" /><img src="images/ajax-loader.gif" class="loader" style="display:none" /></span>';
		$output['aaData'][] = $row;
	}
	
	echo json_encode( $output );
?>