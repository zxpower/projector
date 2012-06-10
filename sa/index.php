<?php

	require_once 'config.php';

	if(!defined('SA_BASE')) {
		echo 'Admin not configured!';
		exit();
	}
	
	require_once 'gluephp/glue.php';
	
	$urls = array(
		SA_BASE => 'index',
		SA_BASE.'login' => 'login'
	);

	require_once 'Twig/Autoloader.php';
	Twig_Autoloader::register();
	
	global $twig;
	$loader = new Twig_Loader_Filesystem('./templates');
	$twig = new Twig_Environment($loader); /*, array(
	    'cache' => './templates/cache',
	));*/

	global $is_logged_in;
	$is_logged_in = false;

	class index {
		function GET() {
			global $is_Logged_in, $twig;
			if($is_logged_in) {
				echo "Hello, World!";
				echo $twig->render('index.html', array('name' => 'Tests'));
			} else {
				header('Location: '.SA_BASE.'login/');
				exit();
			}
		}
	}
	
	class login {
		function GET() {
			global $is_logged_in, $twig;
			if($is_logged_in) {
				header('Location: '.SA_BASE);
				exit();
			} else {
				echo $twig->render('login.html', array('name' => 'Users'));
			}
		}
		function POST() {
			global $is_Logged_in;
			$is_logged_in = true;
		}
	}

	glue::stick($urls);
?>