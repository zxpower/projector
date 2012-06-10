<?php
/**
 * Used by the OSX Widget to get the list of projects
 */ 
require('./inc/config.php');
header('Content-Type: text/javascript; charset='. STR_CHARSET_SILLAJ);

$project = new Project;
$smarty->assign_by_ref('arrProject', $project->get());
$smarty->display('frmEvent_projectOption.tpl');
?>
