<?php

	define('SA_BASE', $_SERVER["REQUEST_URI"]);
	
	require_once('gluephp/glue.php');
	
	$urls = array(
		SA_BASE => 'index'
	);

	class index {
		function GET() {
			echo "Hello, World!";
		}
	}

	glue::stick($urls);
?>