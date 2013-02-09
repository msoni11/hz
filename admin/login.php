<?php session_start(); ?>
<?php 
// Authnticate user login
include 'includes/Application.php';
$db = new cDB();
if (isset($_POST['txtlogin'])) {
    $txtusername = $_POST['txtusername'];
    $txtpassword = $_POST['txtpassword'];
	$query = "SELECT * FROM employees WHERE hz_empusername='".$txtusername."' AND hz_emppassword='".$txtpassword."'";
    $db->Query($query);
    if ($db->RowCount) {
        $_SESSION['username'] = $txtusername;
		header("Location:admin_home.php");
    } else {
	    header("Location:index.php");
    }
}

?>