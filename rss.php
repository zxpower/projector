<?php
/**
* Build a RSS feed
*/
if (empty($_GET['strUserId'])) {
    exit;
}
require('./inc/config.php');
header('Content-Type: application/rss+xml');
$smarty->caching = true;
if (!$smarty->is_cached('rss.tpl', $_GET['strUserId'])) {
    $event = new Event;    
    $smarty->assign_by_ref('strUserId', $_GET['strUserId']);
    $smarty->assign_by_ref(   'arrRss', $event->getLastItems($_GET['strUserId']));
}
$smarty->display('rss.tpl', $_GET['strUserId']);
?>
