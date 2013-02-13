<?php

function HandleError( $theError = "") {
	global $appErrorPage;
	echo $theError;
	die();
	# PageRedirect ("$appErrorPage" . "?prmError=" . urlencode( "$theError"));
}

?>