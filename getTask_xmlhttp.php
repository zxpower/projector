<?php
/**
* called in /js/sillaj.js by frmEvent_intProjectId_onchange() (xmlhttprequest) from index.tpl
* to produce a javascript array of all tasks depending on the currently selected project
*/

require('./inc/config.php');
header('Content-Type: text/javascript; charset='. STR_CHARSET_SILLAJ);

$project = new Project;
$smarty->assign_by_ref('arrTask', $project->getTask($_GET['intProjectId'], true));
$smarty->display('frmEvent_taskOption.tpl');
?>
