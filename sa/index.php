<?php

	require_once('./config.php');

	if(!defined('SA_BASE')) {
		echo 'Admin not configured!';
		exit();
	}
	
	require_once('gluephp/glue.php');
	
	$urls = array(
		SA_BASE => 'index',
		SA_BASE.'login' => 'login'
	);

	global $is_logged_in;
	$is_logged_in = false;

	class index {
		function GET() {
			global $is_Logged_in;
			if($is_logged_in) {
				echo "Hello, World!";
			} else {
				header('Location: '.SA_BASE.'login/');
				exit();
			}
		}
	}
	
	class login {
		function GET() {
			echo 'Login!';
		}
		function POST() {
			global $is_Logged_in;
			$is_logged_in = true;
		}
	}

	glue::stick($urls);
?>