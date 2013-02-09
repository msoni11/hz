<?php
function HandleError( $theError = "") {
	global $appErrorPage;
	echo $theError;
	die();
}
?>