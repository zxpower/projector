<?php
/**
* show all events for a project or a task
*/

require('./inc/config.php');

// Allowed ?
$user->checkAuthent();

// No $_POST or $_GET data -> display the list of projects
if (!empty($_GET['intProjectId'])) {
    $project = new Project;
    $arrEvent = $project->getEvent($_GET['intProjectId']);
    $smarty->assign_by_ref('datLastEvent', $arrEvent[0]['datEvent']);
    $smarty->assign_by_ref('arrEvent', $arrEvent);
    $smarty->assign_by_ref(  'strSum', $project->getSum($_GET['intProjectId']));
    $smarty->assign('booProject', true);
    $smarty->assign_by_ref('intObjId', $_GET['intProjectId']);
}
elseif (!empty($_GET['intTaskId'])) {
    $task = new Task;
    $arrEvent = $task->getEvent($_GET['intTaskId']);
    $smarty->assign_by_ref('datLastEvent', $arrEvent[0]['datEvent']);
    $smarty->assign_by_ref('arrEvent', $arrEvent);
    $smarty->assign_by_ref(  'strSum', $task->getSum($_GET['intTaskId']));
    $smarty->assign('booProject', false);
    $smarty->assign_by_ref('intObjId', $_GET['intTaskId']);
}
else {
    raiseError(STR_PROJECTTASK_EVENT_NOT_FOUND_SILLAJ);
}
$smarty->display('event.tpl'); 
 

?>