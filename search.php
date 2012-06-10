<?php
/**
* search engine
*/

require('./inc/config.php');

// Allowed ?
$user->checkAuthent();

if (!empty($_GET['strKeyword'])) {
    $event = new Event;
    $smarty->assign_by_ref(  'arrEvent', $event->find($_GET['strKeyword']));
    $smarty->assign_by_ref('strKeyword', $_GET['strKeyword']);
}
else {
    raiseError(STR_KEYWORD_NOT_FOUND_SILLAJ);
}
$smarty->display('search.tpl'); 
 

?>