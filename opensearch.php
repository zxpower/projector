<?php
/**
* output the Opensearch form
*/
require('./inc/config.php');
header('Content-Type: application/opensearchdescription+xml');
$smarty->caching = true;
$smarty->display('opensearch.tpl'); 
?>
