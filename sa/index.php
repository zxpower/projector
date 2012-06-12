<?php
	session_start();

	require_once 'config.php';

	if(!defined('SA_BASE')) {
		echo 'Admin not configured!';
		exit();
	}
	
	require_once 'lib/gluephp/glue.php';
	
	$urls = array(
		SA_BASE => 'index',
		SA_BASE.'login' => 'login',
		SA_BASE.'logout' => 'logout',
		SA_BASE.'projects' => 'index',
		SA_BASE.'tasks' => 'index'
	);

	require_once 'lib/edb-class/edb.class.php';

	$_SESSION['db'] = new edb($db_data);

	require_once 'lib/Twig/Autoloader.php';
	Twig_Autoloader::register();
	
	$loader = new Twig_Loader_Filesystem('./templates');
	$_SESSION['twig'] = new Twig_Environment($loader); /*, array(
	    'cache' => './templates/cache',
	));*/

	if(!isset($_SESSION['is_logged_in'])) {
		$_SESSION['is_logged_in'] = false;
	}
	//$_SESSION['is_logged_in'] = false;
	
	if(!isset($_SESSION['errormsg'])) {
		$_SESSION['errormsg'] = '';
	}
	
	function getField($input) { 
	    $input = strip_tags($input); 
	    $input = str_replace("<","<",$input); 
	    $input = str_replace(">",">",$input); 
	    $input = str_replace("#","%23",$input); 
	    $input = str_replace("'","`",$input); 
	    $input = str_replace(";","%3B",$input); 
	    $input = str_replace("script","",$input); 
	    $input = str_replace("%3c","",$input); 
	    $input = str_replace("%3e","",$input); 
	    $input = trim($input); 
	    return $input; 
	}

	class index {
		function GET() {
			if($_SESSION['is_logged_in']) {
				echo $_SESSION['twig']->render('index.html', array('name' => 'Tests', 'installpath' => SA_BASE, 'pageheader' => 'User manager'));
			} else {
				header('Location: '.SA_BASE.'login/');
				exit();
			}
		}
	}
	
	class login {
		function GET() {
			if($_SESSION['is_logged_in']) {
				header('Location: '.SA_BASE);
				exit();
			} else {
				if(!empty($_SESSION['errormsg'])) {
					$options = array(
						'name' => 'Users',
						'installpath' => SA_BASE,
						'pageheader' => 'Login to system',
						'errormsg' => $_SESSION['errormsg']
					);
					$_SESSION['errormsg'] = '';
				} else {
					$options = array(
						'name' => 'Users',
						'installpath' => SA_BASE,
						'pageheader' => 'Login to system'
					);
				}
				echo $_SESSION['twig']->render('login.html', $options);
			}
		}
		function POST() {
			if(isset($_POST['username']) && !empty($_POST['username'])) {
				$username = getField($_POST['username']);
			} else {
				$_SESSION['errormsg'] = 'Username must be filled in!';
				header('Location: '.SA_BASE.'login/');
				exit();
			}
			if(isset($_POST['password']) && !empty($_POST['password'])) {
				$password = md5($_POST['password']);
			} else {
				$_SESSION['errormsg'] = 'Password must be filled in!';
				header('Location: '.SA_BASE.'login/');
				exit();
			}
			$line = $_SESSION['db']->line("select * from sillaj_user where strUserId = '".$username."' and strPassword = '".$password."' and booAdmin = '1'");
			if(!empty($line)) {
				$_SESSION['is_logged_in'] = true;
				header('Location: '.SA_BASE);
				exit();
			} else {
				$_SESSION['errormsg'] = 'Username/password does not match or you are not an administrator!';
				header('Location: '.SA_BASE.'login/');
				exit();
			}
		}
	}
	
	class logout {
		function GET() {
			$_SESSION['is_logged_in'] = false;
			header('Location: '.SA_BASE.'login/');
			exit();
		}
	}

	glue::stick($urls);
?>