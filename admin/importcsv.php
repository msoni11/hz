<?php
set_time_limit(300); 
include 'includes/_incHeader.php';
include_once 'excelreader/Classes/PHPExcel/IOFactory.php';
date_default_timezone_set('Asia/Kolkata');
$db = new cDB();
if (!isset($_SESSION['username']) || !$_SESSION['isadmin'] == 1) {
	header("Location:logout.php");
}

?>
<!-- Content start -->
<div id="container" class="box1">
	<div id="obsah" class="content box1">
		<div id="center">
			<form name="importform" action="importcsv.php" method="post" enctype="multipart/form-data" onsubmit="javascript:$('#loader').show()">
				<fieldset><legend>Add Employee</legend>
				<div style="height:20px;margin:0 0 0 200px; "><img src="images/ajax-loader.gif" id="loader" style="display:none" /></div>
				<div id="msg"><?php echo $msg; ?></div>
				<div class="text-box-name">Choose File:</div>
				<div class="text-box-field">
					<input type="file" name="file" id="file" class="form-text" size="30" maxlength="2048" style="border:none"/>
				</div>
				<div class="text-box-field"></div>
				
				<div class="text-box-name">Import into:</div>
				<div class="text-box-field">
				<select name="tablename" id = "tablename"  class="form-text" style="width:91%" >
					<option value="hz_employees">Employees</option>
					<option value="hz_registration">IT Asset</option>
				</select>
				</div>
				<div class="text-box-field"></div>
				<br />
				<br />
				<input type="submit" name="csvupload" id="csvupload" value="Upload" style="width:80px; height:30px;margin-left:130px" /> 
				<br />
				<br />
				<br />
				<br />
				<br />
				<br />
<?php 
echo "<br />";
echo "<br />";
if (isset($_POST['csvupload'])) {
	$tablename = $_REQUEST['tablename'];
	$temp = false;
	if ($_FILES["file"]["name"] == '' || empty($_FILES["file"]["name"])) {
		echo "Choose file please!";
	} else {
		$allowedExts = array("csv","xls","xlsx");
		$extension = end(explode(".", $_FILES["file"]["name"]));
		if (in_array($extension, $allowedExts)) {
			if ($_FILES["file"]["error"] > 0) {
				echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
			} else {
				echo "File Name: " . $_FILES["file"]["name"] . "<br />";
				echo "File Type: " . $_FILES["file"]["type"] . "<br />";
				echo "File Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";

				if (file_exists("upload/" . $_FILES["file"]["name"])) {
					echo "<br />";
					echo "<b>You have imported this file already. If you still want to import, Rename the file name and try again later.</b>";
					die();
				} else {move_uploaded_file($_FILES["file"]["tmp_name"],
					"upload/" . $_FILES["file"]["name"]);
					$db->Query("INSERT INTO hz_import(filename,tablename) VALUES ('".$_FILES["file"]["name"]."','".$tablename."')");
					if ($db->LastInsertID) {
					} else {
						echo "<b>Error inserting into database! Rename the file and try again later</b>"; //status true.Show success message
						die();
					}
					$temp = true;
				}
			}
			if ($temp) {
				$db->Query("SELECT * FROM hz_import WHERE filename='".$_FILES["file"]["name"]."' ORDER BY id DESC");
				if ($db->RowCount) {
					if ($db->ReadRow()) {
						$excelfile = dirname(__FILE__)."/upload/".$db->RowData['filename'];
						$databasetable = $db->RowData['tablename'];
					}
				} else {
					echo "File not found in database! Try again later";
					die;
				}

				$objPHPExcel = PHPExcel_IOFactory::load($excelfile);

				$sheetData = $objPHPExcel->getActiveSheet()->toArray();
				$columns = implode(",", $sheetData[0]);
				
				$lines = 0;
				$errors = 0;
				for ($i=1; $i<count($sheetData); $i++) {
					$lines++;
					$values = array();
					for ($j=0; $j<count($sheetData[$i]); $j++ ) {
						if (trim($sheetData[$i][$j]) == '' || trim($sheetData[$i][$j]) == NULL) {
							$values[$j] = 'NONE';
						}else if (strtolower(trim($sheetData[0][$j])) == 'date'){
							$date = explode("-",$sheetData[$i][$j]);
							$timestamp = mktime(0,0,0,(int)(trim($date[0])),(int)(trim($date[1])),(int)(trim($date[2])));
							$values[$j] = $timestamp;
						} else if (trim($sheetData[$i][$j-1]) == 'AMC'){
							$values[$j] = strtoupper(trim($sheetData[$i][$j]));
						} else if (trim($sheetData[$i][$j-1]) == 'WAR'){
							$datewar = explode("-",$sheetData[$i][$j]);
							$timestampwar = mktime(0,0,0,(int)(trim($datewar[0])),(int)(trim($datewar[1])),(int)(trim($datewar[2])));
							$values[$j] = $timestampwar;
						} else {
							$values[$j] = strtoupper(trim($sheetData[$i][$j]));
						}
					}
					$values = implode("','",$values);
					$db->Query("INSERT INTO ".$databasetable."(".strtolower($columns).") VALUES('".$values."')");
					if (!$db->LastInsertID) {
						$errors++;
					}
					unset($values);
				}
				echo "<br />";
				echo "<br />";
				echo "<b>File imported successfully</b>";
				echo "<br />";
				echo "<b>$lines record(s) inserted</b>";
				echo "<br />";
				echo "<b>$errors error(s) found</b>";
			
			} else {
				echo "Error Importing file! Try again later";
				die;
			}
		} else {
			echo "<br />";
			echo "<br />";
			echo "Invalid file! Only csv extension allowed";
		}
	}
}
?>

				</fieldset>
			</form>
		</div>
	</div>
</div>
<?php
include 'includes/_incFooter.php';
?>