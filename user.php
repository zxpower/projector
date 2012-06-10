<?php
/**
* user preferences and user creation
*/

require('./inc/config.php');

// No $_POST data or not logged -> display the blank form
if (!count($_POST) && (empty($_SESSION['strUserId'])) && BOO_ALLOW_REGISTER) {
    
    $smarty->assign(    'booDisplayMenu', false);                       // no need to display the menu (we're not logged)
    $smarty->assign_by_ref('arrTemplate', $sillaj->getTemplate());      // get default template
    $smarty->assign_by_ref('arrLanguage', $sillaj->getLanguage(true));  // get default language
    
    $smarty->display('user.tpl');
}

// else $_GET data -> edit the account -> pre-fill the form
elseif (!count($_POST) && (!empty($_SESSION['strUserId']))) {
    // Allowed to edit ?
    $user->checkAuthent();
        
    // if no user info concerning language and theme (old accounts), use session info
    $arrUser = $user->get($_SESSION['strUserId']);
    if ($arrUser['strLanguage'] == '') {
        $arrUser['strLanguage'] = $_SESSION['strLocale'];
    }
    if ($arrUser['strTemplate'] == '') {
        $arrUser['strTemplate'] = $_SESSION['strThemeName'];
    }
    
    $smarty->assign(           'booEdit', true);                                 // to fill the fields
    $smarty->assign_by_ref(    'arrUser', $arrUser);
    $smarty->assign_by_ref('arrTemplate', $sillaj->getTemplate());
    $smarty->assign_by_ref('arrLanguage', $sillaj->getLanguage(true));
    
    $smarty->display('user.tpl');
}

// else $_POST data -> validate the form
elseif (count($_POST)) {    
    if (empty($_POST['booEdit'])) { // we're creating a new user   
        $smarty->assign('strMessage', $user->add());        
        $user->execAuthent(false); // Authentication without redirect
        header('Location: ./');
    }
    else {
        // Allowed to edit ?
        // We must be authenticated...
        $user->checkAuthent();
        
        // ... and the user in the session must match the account to edit
        if ($_SESSION['strUserId'] != $_REQUEST['strUserId']) {
            raiseError(STR_EDIT_ACCOUNT_NOT_ALLOWED_SILLAJ);
        }

        displayMessage($user->set());
    }
}

elseif (!BOO_ALLOW_REGISTER) {
	header('Location: index.php');
	exit();
}
?>
