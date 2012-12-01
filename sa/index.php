<?php
	$lifetime=3600;
	session_start();
	setcookie(session_name(),session_id(),time()+$lifetime);

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
					'allusers' => $allUsers,
					'userId' => $_SESSION['user_id']
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
					'userData' => $userData,
					'errormsg' => $_SESSION['errormsg'],
					'loggedUserId' => $_SESSION['user_id']
				);
				$_SESSION['errormsg'] = '';
				echo $_SESSION['twig']->render('addedit.html', $options);
			} else {
				header('Location: '.SA_BASE.'login/');
				exit();
			}
		}
		function POST() {
			if($_SESSION['is_logged_in']) {
				if(isset($_POST['new']) && !empty($_POST['new'])) {
					if($_POST['new'] == 'true') {
						$newStatus = 1;
					} else {
						$newStatus = 0;
					}
				} else {
					$_SESSION['errormsg'] = 'Form contains hidden errors!';
					header('Location: '.SA_BASE.'edit/new');
					exit();
				}
				if(isset($_POST['userId']) && empty($_POST['userId']) && $newStatus && 
					isset($_POST['strUserId']) && !empty($_POST['strUserId'])) {
					$userId = getField($_POST['strUserId']);
				} elseif(isset($_POST['userId']) && !empty($_POST['userId']) && !$newStatus ) {
					$userId = getField($_POST['userId']);
				} else {
					$_SESSION['errormsg'] = 'Missing login!';
					header('Location: '.SA_BASE.'edit/new');
					exit();
				}
				$userIdCheck = $_SESSION['db']->line("select * from sillaj_user where strUserId = '".$userId."'");
				if(!empty($userIdCheck) && $userIdCheck['strUserId'] == $userId && $newStatus) {
					$_SESSION['errormsg'] = 'User with such login already exists!';
					header('Location: '.SA_BASE.'edit/new');
					exit();
				}
				if(isset($_POST['strName'])) {
					$name = getField($_POST['strName']);
				} else {
					$name = '';
				}
				if(isset($_POST['strFirstname'])) {
					$firstname = getField($_POST['strFirstname']);
				} else {
					$firstname = '';
				}
				if(isset($_POST['strPassword']) && !empty($_POST['strPassword'])) {
					$md5password = md5($_POST['strPassword']);
				} else {
					$md5password = '';
				}
				if(empty($md5password) && $newStatus) {
					$_SESSION['errormsg'] = 'Password missing!';
					header('Location: '.SA_BASE.'edit/new');
					exit();
				}
				if(isset($_POST['strEmail']) && !empty($_POST['strEmail'])) {
					$email = getField($_POST['strEmail']);
				} else {
					$_SESSION['errormsg'] = 'E-mail missing!';
					if($newStatus) {
						header('Location: '.SA_BASE.'edit/new');
					} else {
						header('Location: '.SA_BASE.'edit/'.$userId);
					}
					exit();
				}
				$emailCheck = $_SESSION['db']->line("select * from sillaj_user where strEmail = '".$email."'");
				if(!empty($emailCheck) && $emailCheck['strEmail'] == $email && $newStatus) {
					$_SESSION['errormsg'] = 'User with such e-mail address already exists!';
					header('Location: '.SA_BASE.'edit/new');
					exit();
				} elseif(!empty($emailCheck) && $emailCheck['strEmail'] == $email && $userId != $emailCheck['strUserId'] && !$newStatus) {
					$_SESSION['errormsg'] = 'User with such e-mail address already exists!';
					header('Location: '.SA_BASE.'edit/'.$userId);
					exit();
				}
				if(isset($_POST['cbxActive'])) {
					$active = 1;
				} else {
					$active = 0;
				}
				if(isset($_POST['cbxUseShare'])) {
					$useShare = 1;
				} else {
					$useShare = 0;
				}
				if(isset($_POST['cbxAllowOther'])) {
					$allowOther = 1;
				} else {
					$allowOther = 0;
				}
				if(isset($_POST['cbxAdmin'])) {
					$admin = 1;
				} else {
					$admin = 0;
				}
				if(isset($_POST['strLanguage'])) {
					$language = $_POST['strLanguage'];
				} else {
					$language = 'en';
				}
				if(isset($_POST['strTemplate'])) {
					$template = $_POST['strTemplate'];
				} else {
					$template = 'default';
				}
				
				if( $newStatus ) {
					$_SESSION['db']->s("
						insert into sillaj_user 
							(strUserId, strName, strFirstname, strEmail, strPassword, booActive, booUseShare, booAllowOther, booAdmin, strLanguage, strTemplate)
						values
							('".$userId."', '".$name."', '".$firstname."', '".$email."', '".$password."', '".$active."', '".$useShare."', '".$allowOther."', '".$admin."', '".$language."', '".$template."')");
				} else {
					if(!empty($md5password)) {
						$password = "strPassword = '".$md5password."',";
					}
					$_SESSION['db']->s("
						update sillaj_user set
							strName = '".$name."',
							strFirstname = '".$firstname."',
							strEmail = '".$email."',
							".$password."
							booActive = '".$active."',
							booUseShare = '".$useShare."',
							booAllowOther = '".$allowOther."',
							booAdmin = '".$admin."',
							strLanguage = '".$language."',
							strTemplate = '".$template."'
						where strUserId = '".$userId."'");
				}

				header('Location: '.SA_BASE);
				exit();
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
				$_SESSION['user_id'] = $line['strUserId'];
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
			$_SESSION['user_id'] = '';
			header('Location: '.SA_BASE.'login/');
			exit();
		}
	}

	glue::stick($urls);
?>