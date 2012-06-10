<?php
/**
* tasks management
*/

require('./inc/config.php');

// Allowed ?
$user->checkAuthent();

$task = new Task;
$project = new Project;

// No $_POST or $_GET data -> display the list of tasks
if (!count($_POST) && !count($_GET)) {
    $smarty->assign_by_ref('arrTask', $task->get());
    $smarty->display('task.tpl');
}
// else $_GET data -> edit or add a task
elseif (count($_GET)) {
        
    // if no "add" in URL -> prefill the form
    if (empty($_GET['add'])) {
        $arrTask = $task->get($_GET['intTaskId'], true);
        if (count($arrTask) == 0) {
            displayMessage(STR_TASK_NOT_FOUND_SILLAJ);
        }
     
        $smarty->assign(                  'booEdit', true);                                 // to fill the fields
        $smarty->assign_by_ref(         'intTaskId', $_GET['intTaskId']);
        $smarty->assign_by_ref(           'strTask', $arrTask[$_GET['intTaskId']]['strTask']);
        $smarty->assign_by_ref(            'strRem', $arrTask[$_GET['intTaskId']]['strRem']);
        $smarty->assign_by_ref(          'booShare', $arrTask[$_GET['intTaskId']]['booShare']);
        $smarty->assign_by_ref(    'booUseInReport', $arrTask[$_GET['intTaskId']]['booUseInReport']);
        $smarty->assign_by_ref('arrProjectSelected', $task->getProject($_GET['intTaskId']));
        $smarty->assign(             'strPageTitle', $smarty->get_template_vars('strPageTitle') . STR_SEP_SILLAJ . $arrTask[$_GET['intTaskId']]['strTask']);              
    }
    
    $smarty->assign_by_ref('arrProject', $project->get());
    $smarty->display('edit_task.tpl');
}
// else $_POST data -> validate the form
elseif (count($_POST)) {   
    if (!empty($_POST['booDelete'])) {  
        $smarty->assign_by_ref('strMessage', $task->del());
    }
    else {
        if (empty($_POST['booEdit'])) {  
            $smarty->assign_by_ref('strMessage', $task->add());
        }
        else { 
            $smarty->assign_by_ref('strMessage', $task->set());
        }  
    }
    $smarty->assign_by_ref('arrTask', $task->get());
    $smarty->display('task.tpl');      
}

?>
