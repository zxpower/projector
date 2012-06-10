<?php
/**
 * Display a Gantt chart for a project (showing its tasks) or a task 
 * (showing the projects it belongs to)
 */

require('./inc/config.php');

// Graph must be enabled in config.php and GD too in php.ini
if (!BOO_ENABLE_GRAPH_SILLAJ || !extension_loaded('gd')) {
    raiseError(STR_GRAPH_DISABLED_SILLAJ);
}

// Check if we are authenticated (else go to login page)
$user->checkAuthent();

// Get data : project/task info and associated events
if (!empty($_GET['intProjectId'])) {
    $project = new Project;
    $arrProject = $project->get($_GET['intProjectId'], true);
    $arrSub = $project->getGantt($_GET['intProjectId']);
    $arrSubDetails = $project->getEvent($_GET['intProjectId'], true);
    $strTitle = $arrProject[$_GET['intProjectId']]['strProject'];
    $strType = STR_PROJECT_SILLAJ;
    $intObjId = $_GET['intProjectId'];
    $strMain = 'intProjectId';
    $strSub = 'intTaskId';
    $strAlt = STR_GANTT_CSIM_ALT_TASK_SILLAJ;
}
elseif (!empty($_GET['intTaskId'])) {
    $task = new Task;
    $arrTask = $task->get($_GET['intTaskId'], true);
    $arrSub = $task->getGantt($_GET['intTaskId']);
    $arrSubDetails = $task->getEvent($_GET['intTaskId'], true);
    $strTitle = $arrTask[$_GET['intTaskId']]['strTask'];
    $strType = STR_TASK_SILLAJ;
    $intObjId = $_GET['intTaskId'];
    $strMain = 'intTaskId';
    $strSub = 'intProjectId';
    $strAlt = STR_GANTT_CSIM_ALT_PROJECT_SILLAJ;
}
else {
    raiseError(STR_PROJECTTASK_EVENT_NOT_FOUND_SILLAJ);
}

/* We limit the visible part of the chart to the last 3 months by default, beginning now.
   we can overrride this setting if we add datEndGantt and datStartGantt as 
   parameters in the URL as YYYY-MM-DD
*/
// The default Gantt span is 3 months
$intSpan = empty($_GET['intSpan']) ? INT_GANTT_SPAN_SILLAJ : $_GET['intSpan'];

// find beginning and ending dates
$datEndGantt = empty($_GET['datEndGantt']) ? date('Y-m-d') : $_GET['datEndGantt'];
validIsoDate($datEndGantt); 
$arrEndGantt = explode('-', $datEndGantt); 
  
$datStartGantt = empty($_GET['datStartGantt']) ? date('Y-m-d', mktime(0, 0, 0, $arrEndGantt[1] - $intSpan, $arrEndGantt[2], $arrEndGantt[0])) : $_GET['datStartGantt'];
validIsoDate($datStartGantt); 

// build a unique filename for the image
$fnImage = md5($_SESSION['strUserId'] . $strType . $intObjId . $datStartGantt . $datEndGantt . $_SESSION['strLocale']) .'.png';

// check if the file is in cache or if we should rebuild the image
// we don't use jpgraph builtin CSIM cache mechanism because of the problem
// caused by Smarty (ie : jpgraph would output directly the image so we 
// can't embed it in the Smarty template)
if (!file_exists(FN_CACHE_SILLAJ . $fnImage) 
    || (Event::getDateLastUpdate() > filemtime(FN_CACHE_SILLAJ . $fnImage))) {

    // Use the Jpgraph library
    include('./lib/jpgraph/jpgraph.php');
    include('./lib/jpgraph/jpgraph_gantt.php');
    
    // Begin building graph
    $graph = new GanttGraph(0, 0, 'auto');
    
    // set local date 
    $graph->scale->SetDateLocale(STR_PHP_LOCALE_SILLAJ);
    
    $graph->SetBox();
    $graph->SetShadow();
    $graph->SetDateRange($datStartGantt, $datEndGantt);
    
    // Add title and subtitle
    $graph->title->Set($strType .' '. $strTitle);
    //<SOURCEFORGE>
    //$graph->title->SetFont(FF_ARIAL, FS_BOLD, 12);
    //</SOURCEFORGE>
    $graph->subtitle->Set(STR_SITE_NAME_SILLAJ);
    
    // Show day, week and month scale
    $graph->ShowHeaders(GANTT_HDAY | GANTT_HWEEK | GANTT_HMONTH);
    
    // Instead of week number show the date for the first day in the week
    // on the week scale
    $graph->scale->week->SetStyle(WEEKSTYLE_FIRSTDAY);
    
    // Make the week scale font smaller than the default
    $graph->scale->week->SetFont(FF_FONT0);
    
    $graph->scale->day->SetStyle(DAYSTYLE_ONELETTER);
    
    // Use the short name of the month together with a 2 digit year
    // on the month scale
    $graph->scale->month->SetStyle(MONTHSTYLE_SHORTNAMEYEAR4);
    $graph->scale->month->SetFontColor('black');
    $graph->scale->month->SetBackgroundColor('#f0f8ff');
    
    // 0 % vertical label margin
    $graph->SetLabelVMarginFactor(0);
    
    for ($i=0;$i<count($arrSub);$i++) {
        // Format the bar for the first activity
        // ($row,$title,$startdate,$enddate)
        $activity = new GanttBar($i, $arrSub[$i]['strMain'], $arrSub[$i]['datMin'], $arrSub[$i]['datMax']);
        
        // Yellow diagonal line pattern on a red background
        $activity->SetPattern(BAND_RDIAG, 'lightblue');
        $activity->SetFillColor('#3B74B3');        
        
        // Set absolute height
        $activity->SetHeight(10);    
        $activity->title->SetCSIMTarget('gantt.php?'. $strSub .'='. $arrSub[$i]['intMainId'] .'&amp;datStartGantt='. $datStartGantt .'&amp;datEndGantt='. $datEndGantt);
        $activity->title->SetCSIMAlt($strAlt);
        $activity->title->SetColor('#21456D');
        
        // Finally add the bar to the graph
        $graph->Add($activity);
        
        // Create milestones
        for ($j=0;$j<count($arrSubDetails);$j++) {
            if ($arrSubDetails[$j]['intMainId'] == $arrSub[$i]['intMainId']) {            
                $milestone = new MileStone($i, '', $arrSubDetails[$j]['datEvent']);
                $milestone->mark->SetColor('black');
                $milestone->mark->SetFillColor('gray');
                $graph->Add($milestone);
            }
        }   
    }
    
    // ... and save it in the cache ; we'll point to this image from the template
    $graph->Stroke(FN_CACHE_SILLAJ . $fnImage);
    $strCsim = $graph->GetHTMLImageMap('gantt');
    file_put_contents(FN_CACHE_SILLAJ . $fnImage . '.txt', $strCsim);    
}
else {
    $strCsim = file_get_contents(FN_CACHE_SILLAJ . $fnImage . '.txt');
}

// Prepare the page where we'll embed the graph
$smarty->assign_by_ref(     'fnImage', $fnImage);
$smarty->assign_by_ref(     'strCsim', $strCsim);
$smarty->assign_by_ref('arrGanttSpan', $arrGanttSpan);
$smarty->assign_by_ref(     'intSpan', $intSpan);
$smarty->assign_by_ref(     'strMain', $strMain);  // project or task
$smarty->assign_by_ref(    'intObjId', $intObjId); // project/task id
$smarty->assign_by_ref(      'datEnd', $datEnd);
$smarty->assign(            'datPrev', date('Y-m-d', mktime(0, 0, 0, $arrEndGantt[1] - $intSpan, $arrEndGantt[2], $arrEndGantt[0])));
$smarty->assign(            'datNext', date('Y-m-d', mktime(0, 0, 0, $arrEndGantt[1] + $intSpan, $arrEndGantt[2], $arrEndGantt[0])));

// ... and display it
$smarty->display('gantt.tpl');
?>
