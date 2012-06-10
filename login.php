<?php
/**
* login the user
*/

require('./inc/config.php');

// Validate form
if (count($_POST)) {
    $user->execAuthent();
}

// else display form
$_SESSION['strNonce'] = $sillaj->getRandom();

if (!empty($_GET['urlDest'])) {
    $smarty->assign('urlDest', $_GET['urlDest']);
}

$smarty->assign_by_ref('strNonce', $_SESSION['strNonce']);               
$smarty->assign( 'booDisplayMenu', false);
$smarty->assign(   'strPageTitle', STR_LOGIN_PAGE_TITLE_SILLAJ);    

$smarty->display('login.tpl');
?>
