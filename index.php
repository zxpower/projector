<?php
/**
* Display calendar. list, add, edit, delete events
*/

require('./inc/config.php');

// Check if we are authenticated (else go to login page)
$user->checkAuthent();

// class instanciation
$project = new Project;
$task = new Task;
$event = new Event;

// Do we need to get the full task list in the <select> ? 
// yes, except if we're editing an event (only the tasks associated to the selected event's project are displayed) 
// see below
$booNeedFullTaskList = true; 

// manage an event if we are validating a form (we have post values)
// or we come from index.php?intEventId=xxx (from the RSS feed for example)
if (count($_POST) || !empty($_GET['intEventId'])) {
	
	// submitted via an edit button (from index.php or project.php or task.php)
    if (!empty($_POST['inpEdit']) || !empty($_GET['intEventId'])) {
    
        if (empty($_REQUEST['intEventId'])) {
            raiseError(STR_NO_EVENT_SELECTED_SILLAJ);
        }
        
        $arrCurrentEvent = $event->get($_REQUEST['intEventId']);
        $booNeedFullTaskList = false; // we don't need to get the full task list in the <select> when editing, only the project's associated tasks ; see $project->getTask below
        
        $smarty->assign(               'booEdit', true);
        $smarty->assign_by_ref(     'intEventId', $_REQUEST['intEventId']);
        $smarty->assign_by_ref('arrCurrentEvent', $arrCurrentEvent);  
        $smarty->assign_by_ref(        'arrTask', $project->getTask($arrCurrentEvent['intProjectId'], true));      
        $_SESSION['datEvent'] = $arrCurrentEvent['datEvent']; // Remember the current date
    }
    // submitted via a delete button
    elseif(!empty($_POST['inpDelete'])) {
        $smarty->assign_by_ref('strMessage', $event->del());
    }
    // submitted via validate change button (with booEdit hidden input)
    elseif (!empty($_POST['booEdit'])) {
        $smarty->assign_by_ref('strMessage', $event->set());
    }    
    // submitted via validate button
    else {
        $smarty->assign_by_ref('strMessage', $event->add());
        // remember current project and task for the next input
        $smarty->assign('intLastTaskId', $_POST['intTaskId']);
        $smarty->assign('intLastProjectId', $_POST['intProjectId']);
		$smarty->assign_by_ref('arrTask', $project->getTask($_POST['intProjectId'], true));
		$booNeedFullTaskList = false;
    }
}

// If no date is given, default to the session-stored day or, if not available, to today
if (!empty($_REQUEST['datEvent'])) {
    $_SESSION['datEvent'] = $_REQUEST['datEvent'];
} 
if (empty($_SESSION['datEvent'])) {
    $_SESSION['datEvent'] = date('Y-m-d');                         
}

// check date format
// and to get month and year when assigning
$arrDatEvent = validIsoDate($_SESSION['datEvent']);

// get a list of all projects to fill the projects dropdown list
$smarty->assign_by_ref('arrProject', $project->get());

// to fill the tasks dropdown list
// we only need this full task list on a blank form
// if we need a subset of the task list (ie a project is already selected), the
// assign was already made above in "submitted via an edit button"
if (((count($_POST) == 0) || (count($_GET) == 0)) && $booNeedFullTaskList) {
    $smarty->assign_by_ref('arrTask', $task->get());
}

$smarty->assign_by_ref(     'datEvent', $_SESSION['datEvent']); // which date are we displaying ?
$smarty->assign_by_ref( 'intYearEvent', $arrDatEvent[1]);		// which year is the day we are displaying ?
$smarty->assign_by_ref('intMonthEvent', $arrDatEvent[2]);		// which month is the day we are displaying ?
$smarty->assign_by_ref(  'intDayEvent', $arrDatEvent[3]);		// which day is the day we are displaying ?
$smarty->assign_by_ref(     'arrEvent', $event->getForDay($_SESSION['datEvent']));   // events for the date
$smarty->assign_by_ref('arrEventMonth', $event->getForMonth($_SESSION['datEvent'])); // events for the month of the date dispalyed (for the calendar)
$smarty->assign_by_ref(       'strSum', $event->sumByDay($_SESSION['datEvent']));	 // sum hour worked for the day we are displaying
$smarty->assign_by_ref(  'datTomorrow', date('Y-m-d', mktime(0, 0, 0, $arrDatEvent[2], $arrDatEvent[3]+1, $arrDatEvent[1]))); // date's tomorrow : next meta
$smarty->assign_by_ref( 'datYesterday', date('Y-m-d', mktime(0, 0, 0, $arrDatEvent[2], $arrDatEvent[3]-1, $arrDatEvent[1]))); // date's yesterday : prev meta

$smarty->register_function('calendar', 'smarty_function_calendar'); // registering a smarty plugin to build the calendar
$smarty->display('index.tpl');


/**
* Build a month calendar in templates (Smarty plugin registred above)
* using PEAR::Calendar
* Days already filled are highlighted
* as well as "today" and the selected current date
* called by {calendar year=$intYear month=$intMonth day=$intDay events=$arrEvent} in template index.tpl
*/
function smarty_function_calendar($params, &$smarty) {
	// For which day are we building the monthly calendar ?
    if (empty($params['year'])) {
        $year = date('Y');
    } 
    else {
        $year = $params['year'];
    }
    
    if (empty($params['month'])) {
        $month = date('n');
    }
    else {
        $month = $params['month'];
    }
    
    if (empty($params['day'])) {
        $day = date('j');
    }
    else {
        $day = $params['day'];
    }
    
    if (empty($params['events'])) { // Days to highlight in the month
        $arrEvents = array();
    }
    else {
        $arrEvents = $params['events'];
    }
    
    require('Calendar/Month/Weekdays.php'); // call PEAR::Calendar
        
    $Month = new Calendar_Month_Weekdays($year, $month, INT_START_WEEK_DAY_SILLAJ);    
    $Month->build();
   
    // Construct strings for next/previous links
    $pMonth = $Month->prevMonth('object'); // Get previous month as object
    $strPrevMonth = '<a href="?datEvent='. $pMonth->thisYear() .'-'. sprintf('%02d', $pMonth->thisMonth()) .'-'. sprintf('%02d', $pMonth->thisDay()) .'" title="'. STR_PREV_MONTH_SILLAJ .'">&lt;</a>';
    $nMonth = $Month->nextMonth('object');
    $strNextMonth = '<a href="?datEvent='. $nMonth->thisYear() .'-'. sprintf('%02d', $nMonth->thisMonth()).'-'. sprintf('%02d', $nMonth->thisDay()) .'" title="'. STR_NEXT_MONTH_SILLAJ .'">&gt;</a>';
    
    // Calendar header
    $strCalendar = '<h3><a href="?datEvent='. date('Y-m-d', mktime(0, 0, 0, $month, $day - 1, $year))
      .'" title="'. STR_PREV_DAY_SILLAJ .' : '. strftime(STR_LONG_DATE_FORMAT_SILLAJ, mktime(0, 0, 0, $month, $day - 1, $year)) .'">&lt;</a>&nbsp;'. strftime(STR_LONG_DATE_FORMAT_SILLAJ, mktime(0, 0, 0, $month, $day, $year)) 
      .'&nbsp;<a href="?datEvent='. date('Y-m-d', mktime(0, 0, 0, $month, $day + 1, $year))
      .'" title="'. STR_NEXT_DAY_SILLAJ .' : '. strftime(STR_LONG_DATE_FORMAT_SILLAJ, mktime(0, 0, 0, $month, $day + 1, $year)) .'">&gt;</a></h3><table id="calendarTable" summary="'. STR_CALENDAR_SILLAJ
      ."\">\n  <caption>$strPrevMonth&nbsp;" . strftime('%b', mktime(0, 0, 0, $month, 1, $year)) 
      ." $year&nbsp;$strNextMonth</caption>\n";
    
    // days header row
    $i = 0;    
    $strCalendar .= "  <tr>\n";
    for($i=INT_START_WEEK_DAY_SILLAJ; $i < 7 + INT_START_WEEK_DAY_SILLAJ; $i++) {
        $strCalendar .= '    <th>' . strtoupper(substr(strftime('%a', mktime(0, 0, 0, 6, 4 + $i, 2000)), 0, 1)) . "</th>\n";        
    }
    $strCalendar .= "  </tr>\n";
    
    // days
    $strDays = '';
    $arrCountValueEvents = array_count_values($arrEvents); //print_r($arrCountValueEvents);
    while ($Day = $Month->fetch()) {  
        $strCurrentDayIso = sprintf('%04d-%02d-%02d', $Day->thisYear(), $Day->thisMonth(), $Day->thisDay());
           
        if ($Day->isFirst()) {
            $strDays .= "  <tr>\n";
        }

        if ($Day->isEmpty()) {
            $strDays .= "    <td>&nbsp;</td>\n";
        }        
        else {
            $strNbEventsInDay = '';
            if (in_array($strCurrentDayIso, $arrEvents)) {
                $strClass = 'dayEvent';
                $strNbEventsInDay = ' ('. $arrCountValueEvents[$strCurrentDayIso].' '. ($arrCountValueEvents[$strCurrentDayIso] > 1 ? STR_EVENTS_SILLAJ : STR_EVENT_SILLAJ) .')';
            }
            elseif ($strCurrentDayIso == date('Y-m-d')) {
                $strClass = 'today';
            }
            else {
                $strClass = 'day';
            }

            if ($strCurrentDayIso == "$year-$month-$day") {
                $strClass .= ' daySelected';
            }
                        
            $strDays .= '    <td><a href="?datEvent='. $strCurrentDayIso .'" title="'. strftime(STR_LONG_DATE_FORMAT_SILLAJ, mktime(0, 0, 0, $Day->thisMonth(), $Day->thisDay(), $Day->thisYear())) . $strNbEventsInDay .'"><span class="'. $strClass .'">'. $Day->thisDay() ."</span></a></td>\n";
        } 
    
        if ($Day->isLast()) {
            $strDays .= "  </tr>\n";
        }
    }    
    return $strCalendar . $strDays ."</table>\n";
}
?>
