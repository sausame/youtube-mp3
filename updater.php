<?php

session_start();

if (isset($_SESSION['url'])) {
	http_response_code(302);
}
?>

