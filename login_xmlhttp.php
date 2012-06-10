<?php
/**
 * used to login for the OSX Widget
 * Normal login.php doesnt work since
 * it redirects and uppon redirects it seems the XMLHTTPRequest forgets the
 * cookies so I can never get a hold on the PHPSESSID cookie)
 *   
 */
header('Content-Type: text/javascript; charset='. STR_CHARSET_SILLAJ);
require('./inc/config.php');
// Validate form
if (count($_POST)) {
    $user->execAuthent(false);
}
?>


