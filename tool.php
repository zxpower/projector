<?php
/**
* report form and build report
*/

require('./inc/config.php');

// Allowed ?
$user->checkAuthent();

// No $_POST or $_GET data -> display the form
if (count($_GET) == 0) {
    $smarty->caching = true;
    if(!$smarty->is_cached('frmTool.tpl', $_SESSION['strUserId'])) {
        $project = new Project;
        $task = new Task;
        
        $smarty->assign_by_ref(   'arrProject', $project->get());   // to fill the projects dropdown list
        $smarty->assign_by_ref(      'arrTask', $task->get());      // to fill the tasks dropdown list
    }
    $smarty->display('frmTool.tpl', $_SESSION['strUserId']);
}

// else $_GET data -> execut action 
else {
  
    $smarty->assign_by_ref('strMessage', $sillaj->move());
    $smarty->display('frmReport.tpl');
}

?>
