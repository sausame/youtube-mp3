<?php

session_start();

if (isset($_SESSION['url'])) {
	$url = $_SESSION['url'];

	$config = parse_ini_file('config.ini');
	$envPath = $config['env-path'];

	$cmd = "export PATH=$envPath".':$PATH && youtube-dl "' . $url . '"';
	$output = system($cmd, $retval);

	echo($output);

	unset($_SESSION['url']);
} else {
	http_response_code(302);
}
?>

