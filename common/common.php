<?php 
function hz_encode($str) { 
	return base64_encode($str);
}
function hz_decode($str) { 
	return base64_decode($str);
}

?>