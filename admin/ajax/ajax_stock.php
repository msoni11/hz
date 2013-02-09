<?php 
include '../includes/Application.php';

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array('department','hardware','type', 'make', 'model', 'invoiceno','orderdate','partyname','receivername', 'quantity', 'rate', 'otherstatus','id');
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "hs.id";
	
	/* DB table to use */
	//$sTable = "hz_stock";
	
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
				$sOrder .= "`".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."` ".
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
	$sWhere = "WHERE";
	if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
	{
		//$sWhere = "WHERE (";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ($aColumns[$i] == 'id') {
			} else if ($aColumns[$i] == 'quantity') {
				$sWhere .= "`".$aColumns[$i]."` = '".mysql_real_escape_string( $_GET['sSearch'] )."' OR ";
			} else if ($aColumns[$i] == 'department') {
			} else if ($aColumns[$i] == 'hardware') {
			} else if ($aColumns[$i] == 'type') {
			} else if ($aColumns[$i] == 'id') {
			} else if ($aColumns[$i] == 'make') {
			} else if ($aColumns[$i] == 'model') {
			} else {
				$sWhere .= "`".$aColumns[$i]."` LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
			}
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ' AND';
	}
	
	/* Individual column filtering */
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		{
			$sWhere .= "`".$aColumns[$i]."` = '".mysql_real_escape_string($_GET['sSearch_'.$i])."' ";
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
		}
	}
	
	
	/*
	 * SQL queries
	 * Get data to display
	 */
	 $sQuery = "
		SELECT c.department department , c.hardware hardware , 
c.type type  ,  
c.make make , 
c.model model , 
c.invoiceno invoiceno , 
c.orderdate orderdate , 
c.partyname  partyname  , 
c.receivername  receivername  ,  
c.quantity quantity  ,  
c.rate rate  ,  
c.otherstatus otherstatus  ,
c.id id  

FROM ((SELECT hd.name department, hh.name hardware, type , hm.name make, hmo.modelname model, hs.invoiceno invoiceno, hs.orderdate orderdate, hs.partyname partyname, hs.receivername receivername, hs.quantity quantity, hs.rate rate, hs.otherstatus otherstatus, hs.id id
			FROM `hz_stock` hs
			LEFT OUTER JOIN hz_departments hd ON ( hs.department = hd.id )
			LEFT OUTER JOIN hz_hardware hh ON ( hs.hardware = hh.id )
			LEFT OUTER JOIN hz_make hm ON ( hs.make = hm.id )
			LEFT OUTER JOIN hz_model hmo ON ( hs.model = hmo.id ) $sWhere hardware != 3)
		UNION
		(SELECT hd.name department, hh.name hardware, hpt.printertype type , hm.name make, hpmo.printermodel model, hs.invoiceno invoiceno, hs.orderdate orderdate, hs.partyname partyname, hs.receivername receivername, hs.quantity quantity, hs.rate rate, hs.otherstatus otherstatus, hs.id id
			FROM `hz_stock` hs
			LEFT OUTER JOIN hz_departments hd ON ( hs.department = hd.id )
			LEFT OUTER JOIN hz_hardware hh ON ( hs.hardware = hh.id )
			LEFT OUTER JOIN hz_printertype hpt ON ( hs.type = hpt.id )
			LEFT OUTER JOIN hz_make hm ON ( hs.make = hm.id )
			LEFT OUTER JOIN hz_printermodel hpmo ON ( hs.model = hpmo.id ) $sWhere hardware = 3))c
		
		$sOrder
		$sLimit
		";
	$rResult = mysql_query( $sQuery, $gaSql['link'] ) or fatal_error( 'MySQL Error: ' . mysql_errno() );
	
	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS()
	";
	$rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or fatal_error( 'MySQL Error: ' . mysql_errno() );
	$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
	$iFilteredTotal = $aResultFilterTotal[0];
	
	/* Total data set length */
	$sQuery = "
		SELECT COUNT(*)
			FROM `hz_stock` hs
			LEFT OUTER JOIN hz_departments hd ON ( hs.department = hd.id )
			LEFT OUTER JOIN hz_hardware hh ON ( hs.hardware = hh.id )
			LEFT OUTER JOIN hz_printertype hpt ON ( hs.type = hpt.id )
			LEFT OUTER JOIN hz_make hm ON ( hs.make = hm.id )
			LEFT OUTER JOIN hz_model hmo ON ( hs.model = hmo.id )  
	";
	$rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or fatal_error( 'MySQL Error: ' . mysql_errno() );
	$aResultTotal = mysql_fetch_array($rResultTotal);
	$iTotal = $aResultTotal[0];
	
	
	/*
	 * Output
	 */
	$output = array(
		//"sEcho" => intval($_GET['sEcho']),
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
			else if ($aColumns[$i] == "orderdate" ) {
				$dateArray = getdate($aRow[ $aColumns[$i] ]);
				$row[] = $dateArray['mday'].'/'.$dateArray['mon'].'/'.$dateArray['year'];
			}
			else if ($aColumns[$i] == "id" ) {
			}
			else if ($aColumns[$i] == "type" ) {
				if ($aRow[$aColumns[$i]] == '' || $aRow[$aColumns[$i]] == NULL || $aRow[$aColumns[$i]] == '0') {
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
		$row[] = '<a href="../editStock.php?id='.base64_encode($aRow[ $aColumns[12] ]).'" title="click to edit""><img src="../images/edit-icon.png" style="border:none; display:inline" /></a>&nbsp;<span class="deletestock" style="cursor:pointer"><input type="hidden" class="delstockid" value="'.$aRow[ $aColumns[12] ].'" ><img src="../images/delete-icon.png" alt="Click to delete" title="Click to delete" /><img src="images/ajax-loader.gif" class="loader" style="display:none" /></span>';
		$output['aaData'][] = $row;
	}
	
	echo json_encode( $output );
?>