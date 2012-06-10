<?php
/**
* project management
*/

require('./inc/config.php');

// Allowed ?
$user->checkAuthent();

$project = new Project;
$task = new Task;

// No $_POST or $_GET data -> display the list of projects
if (!count($_POST) && !count($_GET)) {
    $smarty->assign_by_ref('arrProject', $project->get());
    $smarty->display('project.tpl');
}
// else $_GET data -> edit or add a project
elseif (count($_GET)) {
        
    // if no "add" in URL -> prefill the form
    if (empty($_GET['add'])) {
        $arrProject = $project->get($_GET['intProjectId'], true);
        if (count($arrProject) == 0) {
            displayMessage(STR_PROJECT_NOT_FOUND_SILLAJ);
        }
        
        $smarty->assign(               'booEdit', true);                                 // to fill the fields
        $smarty->assign_by_ref(   'intProjectId', $_GET['intProjectId']);
        $smarty->assign_by_ref(     'strProject', $arrProject[$_GET['intProjectId']]['strProject']);
        $smarty->assign_by_ref(         'strRem', $arrProject[$_GET['intProjectId']]['strRem']);
        $smarty->assign_by_ref(       'booShare', $arrProject[$_GET['intProjectId']]['booShare']);
        $smarty->assign_by_ref( 'booUseInReport', $arrProject[$_GET['intProjectId']]['booUseInReport']);
        $smarty->assign_by_ref('arrTaskSelected', $project->getTask($_GET['intProjectId'])); 
        $smarty->assign(          'strPageTitle', $smarty->get_template_vars('strPageTitle') . STR_SEP_SILLAJ . $arrProject[$_GET['intProjectId']]['strProject']);       
    }
    
    $smarty->assign_by_ref('arrTask', $task->get());
    $smarty->display('edit_project.tpl');
}
// else $_POST data -> validate the form
elseif (count($_POST)) {   
    
    // todo : allow to migrate events from one task to another (or delete) if a project 
    // doesn't link to the task anymore
    
    if (!empty($_POST['booDelete'])) {  
        $smarty->assign_by_ref('strMessage', $project->del());
    }
    else {
        if (empty($_POST['booEdit'])) {  
            $smarty->assign_by_ref('strMessage', $project->add());
        }
        else { 
            $smarty->assign_by_ref('strMessage', $project->set());
        }  
    } 
    $smarty->assign_by_ref('arrProject', $project->get());
    $smarty->display('project.tpl');     
}

?>
