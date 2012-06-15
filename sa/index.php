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
		SA_BASE.'add' => 'addUser',
		SA_BASE.'edit/[a-zA-Z0-9]+' => 'editUser',
		SA_BASE.'delete/[a-zA-Z0-9]+' => 'index',
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

	function debugVar($var) {
		echo "<pre>";
		print_r($var);
		echo "</pre>";
	}

	class index {
		function GET() {
			if($_SESSION['is_logged_in']) {
				$allUsers = $_SESSION['db']->selectAll('sillaj_user');
				//debugVar($allUsers);
				$options = array(
					'installpath' => SA_BASE,
					'pageheader' => 'User Manager',
					'menu' => true,
					'allusers' => $allUsers
				);
				echo $_SESSION['twig']->render('index.html', $options);
			} else {
				header('Location: '.SA_BASE.'login/');
				exit();
			}
		}
	}
	
	class addUser {
		function GET() {
			if($_SESSION['is_logged_in']) {
				header('Location: '.SA_BASE.'edit/new/');
				exit();
			} else {
				header('Location: '.SA_BASE.'login/');
				exit();
			}
		}
	}
	
	class editUser {
		function GET($variables) {
			if($_SESSION['is_logged_in']) {
				$variables = preg_split('/\//',$variables[0],-1,PREG_SPLIT_NO_EMPTY);
				$userId = end($variables);
				$userData = $_SESSION['db']->line("select * from sillaj_user where strUserId = '".$userId."'");
				if(!empty($userData)) {
					$headerText = 'Edit';
					$newStatus = 0;
				} else {
					$headerText = 'Add';
					$newStatus = 1;
				}
				$options = array(
					'installpath' => SA_BASE,
					'pageheader' => $headerText.' User',
					'menu' => 1,
					'new' => $newStatus,
					'userId' => $userId,
					'userData' => $userData
				);
				echo $_SESSION['twig']->render('addedit.html', $options);
			} else {
				header('Location: '.SA_BASE.'login/');
				exit();
			}
		}
		function POST() {
			if($_SESSION['is_logged_in']) {
				debugVar($_POST);
				echo '<a href="'.SA_BASE.'">Back</a>';
				//header('Location: '.SA_BASE);
				//exit();
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
						'installpath' => SA_BASE,
						'pageheader' => 'Login to system',
						'menu' => false,
						'errormsg' => $_SESSION['errormsg']
					);
					$_SESSION['errormsg'] = '';
				} else {
					$options = array(
						'installpath' => SA_BASE,
						'pageheader' => 'Login to system',
						'menu' => false
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