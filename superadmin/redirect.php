<?php 
// Authnticate user login
include 'includes/Application.php';
$db = new cDB();
$_SESSION['status'] = array();
if (isset($_POST['txtsubmit'])) {
    $txtusername = strtolower($_POST['txtusername']);
    $txtpassword = $_POST['txtpassword'];

    if (empty($txtusername) || empty($txtpassword)) {
        $_SESSION['status'][] = 'All fields are required';
    }
	
	if (empty($_SESSION['status'])) {
		$query = "SELECT * FROM hz_users WHERE username='".$txtusername."' AND password='".$txtpassword."' AND isadmin=2";
		$db->Query($query);
		if ($db->RowCount) {
			if ($db->ReadRow()) {
				if ($db->RowData['username'] === $txtusername && $db->RowData['password'] === $txtpassword) {
						$_SESSION['username'] = $txtusername;
						$_SESSION['isadmin']  = $db->RowData['isadmin'];
						header("Location:settings.php");
				} else {
					$_SESSION['status'][] = 'User doesn\'t exist! Enter valid username & password';
					header("Location:index.php");
				}
			}
		} else {
			$_SESSION['status'][] = 'User doesn\'t exist! Enter valid username & password';
			header("Location:index.php");
		}
    } else {
		header("Location:index.php");
    }
}

?>