<?php
/**
* Send mail if login/password forgotten
*/

require('./inc/config.php');

$smarty->assign('booDisplayMenu', false);
    
// No $_POST data -> display the blank form
if (!count($_POST)) {
    $smarty->caching = true;
    if(!$smarty->is_cached('mail.tpl')) {
        $smarty->assign('strPageTitle', STR_MAIL_PAGE_TITLE_SILLAJ);
    }
    $smarty->display('mail.tpl');
}
// else $_POST data -> validate the form : update db and send the mail
else {    
    // check validity and if email exists in the database 
    $user->checkEmail($_POST['strEmail']);
    
    // Update the password in the database ; begin a db transaction
    // so if the mail fails we can rollback
    $db->query('BEGIN');
    $arrNewLogin = $user->resetPassword($_POST['strEmail'], false); 
    
    // Prepare mail with PHPMailer
    require(FN_ROOT_DIR_SILLAJ .'lib/phpmailer/class.phpmailer.php');    
    $mail = new PHPMailer();
    
    $mail->SetLanguage($_SESSION['strLocale'], FN_ROOT_DIR_SILLAJ .'lib/phpmailer/language/');
    $mail->IsSMTP();                      // telling the class to use SMTP
    $mail->Host = STR_MAIL_SERVER_SILLAJ; // SMTP server
    
    if (BOO_MAIL_SMTP_AUTHENT_SILLAJ) {
        $mail->SMTPAuth = true;                          // turn on SMTP authentication
        $mail->Username = STR_MAIL_SMTP_LOGIN_SILLAJ;    // SMTP username
        $mail->Password = STR_MAIL_SMTP_PASSWORD_SILLAJ; // SMTP password
    }
    
    // Build message
    $mail->From = STR_ADMIN_EMAIL_SILLAJ;    
    $mail->FromName = STR_SITE_NAME_SILLAJ;
    $mail->AddAddress($_POST['strEmail']);    
    $mail->Subject = '['. STR_SITE_NAME_SILLAJ .'] '. STR_MAIL_SUBJECT_SILLAJ;
    $strBody = $_POST['strEmail'] .",\n";
	
	  // loop through all accounts if the same email address has been used for several accounts
    for ($i=0;$i<count($arrNewLogin);$i++) {
        $strBody .= sprintf(STR_MAIL_BODY_SILLAJ, $arrNewLogin[$i]['strUserId'], $arrNewLogin[$i]['strPassword']) ."\n\n";
    }
    $mail->Body = $strBody ."\nhttp://". $_SERVER['SERVER_NAME'] . URL_ROOT_DIR_SILLAJ;
    
    // Send message
    if(!$mail->Send()) {
    	$db->query('ROLLBACK');
        raiseError(STR_MAIL_ERROR_SILLAJ .' '. $mail->ErrorInfo);
    }
    $db->query('COMMIT');
    $smarty->assign('strPageTitle', STR_MAIL_PAGE_TITLE_SILLAJ);
    displayMessage(STR_MAIL_SUCCESS_SILLAJ .' '. htmlspecialchars($_POST['strEmail']));
}
?>
