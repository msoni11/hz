<?php
set_time_limit(300); 
include 'includes/_incHeader.php';
$db = new cDB();
if (!isset($_SESSION['username']) || !$_SESSION['isadmin'] == 1) {
	header("Location:logout.php");
}

function csv_file_to_mysql_table($source_file, $target_table, $max_line_length=10000) {
    $db = new cDB();
    if (($handle = fopen("$source_file", "r")) !== FALSE) { 
        $columns = fgetcsv($handle, $max_line_length, ","); 
        foreach ($columns as &$column) { 
            $column = str_replace(".","",$column); 
        } 
        $insert_query_prefix = "INSERT INTO $target_table \nVALUES"; 
        while (($data = fgetcsv($handle, $max_line_length, ",")) !== FALSE) { 
            while (count($data)<count($columns)) 
                array_push($data, NULL); 
            $query = "$insert_query_prefix ('',".join(",",quote_all_array($data)).");"; 
            $db->Query($query); 
        } 
        fclose($handle); 
    } 
} 

function quote_all_array($values) { 
    foreach ($values as $key=>$value) 
        if (is_array($value)) 
            $values[$key] = quote_all_array($value); 
        else 
            $values[$key] = quote_all($value); 
    return ($values); 
} 

function quote_all($value) { 
    if (is_null($value)) 
        return "NONE"; 

    $value = "'" . mysql_real_escape_string(strtoupper($value)) . "'"; 
    return ($value); 
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
				<div class="text-box-name">Choose CSV File:</div>
				<div class="text-box-field">
					<input type="file" name="file" id="file" class="form-text" size="30" maxlength="2048" style="border:none"/>
				</div>
				<div class="text-box-field"></div>
				<br />
				<br />
				<input type="submit" name="csvupload" id="csvupload" value="Upload" style="width:80px; height:30px;margin-left:130px" /> 
				<?php 
				echo "<br />";
				echo "<br />";
				if (isset($_POST['csvupload'])) {
					$temp = false;
					if ($_FILES["file"]["name"] == '' || empty($_FILES["file"]["name"])) {
						echo "Choose file please!";
					} else {
						$allowedExts = array("csv");
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
								} else {
  								        move_uploaded_file($_FILES["file"]["tmp_name"],
								        "upload/" . $_FILES["file"]["name"]);
									$db->Query("INSERT INTO hz_import(filename) VALUES ('".$_FILES["file"]["name"]."')");
									if ($db->LastInsertID) {
									} else {
										echo "<b>Error inserting into database! Rename the file and try again later</b>"; //status true.Show success message
										die();
									}
									$temp = true;
								}
							}
							if ($temp) {

								$db->Query("SELECT filename FROM hz_import WHERE filename='".$_FILES["file"]["name"]."'");
								$databasetable = "hz_employees";
								if ($db->RowCount) {
									if ($db->ReadRow()) {
										$csvfile = dirname(__FILE__)."/upload/".$db->RowData['filename'];
									}
								} else {
									echo "File not found in database! Try again later";
									die;
								}
								csv_file_to_mysql_table($csvfile, $databasetable);
								echo "<br />";
								echo "<br />";
								echo "<b>File imported successfully</b>";
							
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