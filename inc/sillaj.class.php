<?php
/******************************************************************************/
/**
 * Manage projects
 */
class Project {
    /**
     * Get project information
     * for all projects or for the intProjectId 
     * for one user
     */
    function get($intProjectId = '', $booAll = false) {
        global $db;

        $strRem = $booAll ? ', strRem, booShare, booUseInReport' : '';
        $strWhere = '';
        $strProject = 'strProject';
        
        if ($intProjectId !== '') {
            $strWhere = 'AND (intProjectId = '. $intProjectId .')';
        }
        
        // if we want to see shared projects
        $strShared = '';
        if ($_SESSION['booUseShare']) {
            if ($intProjectId == '') {
                $strProject = "CASE WHEN booShare = '1' THEN CONCAT('* ', strProject) ELSE strProject END AS strProject";
            }
            $strShared = "OR (booShare = '1')";
        }
            
        $arrProject = $db->getAssoc("
          SELECT
            intProjectId,
            $strProject
            $strRem
          FROM sillaj_project
            LEFT JOIN sillaj_user ON (strUserId = sillaj_user_strUserId)
          WHERE (booDisplay = '1')
            AND ((strUserId = '". $_SESSION['strUserId'] ."') $strShared)
            $strWhere
          ORDER BY sillaj_project.strProject
        ");

        if (DB::isError($arrProject)) {
            raiseError($arrProject->getMessage());
        }                         
        return $arrProject;
    }
            
    
    /**
     * Get task information
     * dependent from the intProjectId (to preselect task in edit_project)
     */         
    function getTask($intProjectId, $booAll = false) {
        global $db;        

        $strWhere = $intProjectId != 0 ? "AND (sillaj_project_intProjectId = $intProjectId)" : '';

        // if we want to see shared tasks
        $strShared = '';
        $strTask = 'strTask';   
        if ($_SESSION['booUseShare']) {
            $strShared = "OR (booShare = '1')";
            $strTask = "CASE WHEN booShare = '1' THEN CONCAT('* ', strTask) ELSE strTask END AS strTask";           
        }
        
        $strQuery = "
          SELECT
            intTaskId,
            $strTask
          FROM sillaj_task
            LEFT JOIN sillaj_task_project ON (sillaj_task_intTaskId = sillaj_task.intTaskId)
            LEFT JOIN sillaj_user ON (strUserId = sillaj_user_strUserId)
          WHERE (booDisplay = '1')
            AND ((strUserId = '". $_SESSION['strUserId'] ."') $strShared)
            $strWhere
          ORDER BY sillaj_task.strTask                    
        ";
        
        $arrTask = $booAll ? $db->getAssoc($strQuery) : $db->getCol($strQuery);
        
        if (DB::isError($arrTask)) {
            raiseError($arrTask->getMessage());
        }

        return $arrTask;
    }
    
    /**
     * get all events for a project
     */
    function getEvent($intProjectId, $booOrderByTask = false) {
        global $db;               
        
        // Allowed to see ?
        $this->canSee($intProjectId);
        
        $strOrder = $booOrderByTask ? 'intTaskId' : 'datEvent DESC, timStart DESC, timEnd DESC, strTask' ;
         
        if ($_SESSION['booUseShare']) {
            $strSub = "CASE WHEN sillaj_project.booShare = '1' THEN CONCAT('* ', strProject) ELSE strProject END AS strSub";
            $strMain = "CASE WHEN sillaj_task.booShare = '1' THEN CONCAT('* ', strTask) ELSE strTask END AS strMain";
            $strUserId = 'strUserId,';   
            $strUserWhere = '';                 
        }
        else {
            $strSub = 'strProject AS strSub';
            $strMain = 'strTask AS strMain';  
            $strUserId = '';  
            $strUserWhere = "AND (strUserId = '". $_SESSION['strUserId'] ."')"; 
        }
        
        $arrEvent = $db->getAll("
          SELECT
            intEventId,
            $strMain,
            intTaskId AS intMainId,
            $strSub,
            timStart,
            timEnd,
            timDuration,
            datEvent,
            $strUserId
            sillaj_event.strRem         
          FROM sillaj_event
            LEFT JOIN sillaj_user ON (strUserId = sillaj_event.sillaj_user_strUserId)
            LEFT JOIN sillaj_task ON (intTaskId = sillaj_event.sillaj_task_intTaskId)            
            LEFT JOIN sillaj_project ON (sillaj_event.sillaj_project_intProjectId = intProjectId)
          WHERE ((sillaj_event.sillaj_project_intProjectId = '$intProjectId') $strUserWhere)           
          ORDER BY $strOrder
        ");        

        if (DB::isError($arrEvent)) {
            raiseError($arrEvent->getMessage());
        }                    
        return $arrEvent;
    }

    /**
     * get all events for a project FORMATTED FOR GANTT CHART
     */
    function getGantt($intProjectId) {
        global $db;               
        
        // Allowed to see ?
        $this->canSee($intProjectId);
                
        if ($_SESSION['booUseShare']) {
            $strSub = "CASE WHEN sillaj_project.booShare = '1' THEN CONCAT('* ', strProject) ELSE strProject END AS strSub";
            $strMain = "CASE WHEN sillaj_task.booShare = '1' THEN CONCAT('* ', strTask) ELSE strTask END AS strMain";
            $strUserId = ', strUserId';   
            $strUserWhere = '';                 
        }
        else {
            $strSub = 'strProject AS strSub';
            $strMain = 'strTask AS strMain';  
            $strUserId = '';  
            $strUserWhere = "AND (strUserId = '". $_SESSION['strUserId'] ."')"; 
        }
        
        $arrEvent = $db->getAll("
          SELECT
            $strMain,
            intTaskId AS intMainId,
            $strSub,
            MIN(datEvent) AS datMin,
            MAX(datEvent) AS datMax
            $strUserId       
          FROM sillaj_event
            LEFT JOIN sillaj_user ON (strUserId = sillaj_event.sillaj_user_strUserId)
            LEFT JOIN sillaj_task ON (intTaskId = sillaj_event.sillaj_task_intTaskId)            
            LEFT JOIN sillaj_project ON (sillaj_event.sillaj_project_intProjectId = intProjectId)          
          WHERE ((sillaj_event.sillaj_project_intProjectId = '$intProjectId') $strUserWhere)     
          GROUP BY sillaj_event.sillaj_task_intTaskId      
          ORDER BY datMin, datMax, strMain
        ");        

        if (DB::isError($arrEvent)) {
            raiseError($arrEvent->getMessage());
        }                         
        return $arrEvent;
    }

    /**
     * Check input values
     */
    function checkInput() {
        $strProject = trim($_POST['strProject']);
        if (empty($strProject)) {
            raiseError(STR_NO_PROJECT_NAME_SILLAJ);
        }
        
        // Do we share this project ?
        $booShare = (!empty($_POST['cbxShare']) && ($_POST['cbxShare'] == 'on')) ? '1' : '0';
        
        // Should we use this project in reports ?
        $booUseInReport = (!empty($_POST['cbxUseInReport']) && ($_POST['cbxUseInReport'] == 'on')) ? '1' : '0';                
        
        // sanitize
        if (!get_magic_quotes_gpc()) { 
           return array(
             'strProject' => addslashes($strProject),
             'strRem' => addslashes($_POST['strRem']),
             'booShare' => $booShare,
             'booUseInReport' => $booUseInReport
           );  
        } else { 
           return array(
             'strProject' => $strProject,
             'strRem' => $_POST['strRem'],
             'booShare' => $booShare,
             'booUseInReport' => $booUseInReport
           ); 
        }     
    }
    
    /**
     * Add a new project
     */ 
    function add() {
        global $db;
        
        // Check input values
        $arrInput = $this->checkInput();
        
        // Add to the project table
        $db->query('BEGIN');
        $arrProject = $db->query("
          INSERT INTO sillaj_project
            (intProjectId, sillaj_user_strUserId, strProject, booDisplay, strRem, booShare, booUseInReport)
          VALUES (
            NULL,
            '". $_SESSION['strUserId'] ."',
            '". $arrInput['strProject'] ."',
            '1',
            '". $arrInput['strRem'] ."',
            '". $arrInput['booShare'] ."',
            '". $arrInput['booUseInReport'] ."'
          )"
        );
        
        if (DB::isError($arrProject)) {
            $db->query('ROLLBACK');
            raiseError($arrProject->getMessage());
        }
        
        // Get a new value for the primary key
        $intProjectId = DBSillaj::lastId();
        
        // Add to the link table
        if (! empty($_POST['arrTask'])) {
            for($i=0;$i<count($_POST['arrTask']);$i++) {
                $arrProject = $db->query("
                  INSERT INTO sillaj_task_project
                    (sillaj_task_intTaskId, sillaj_project_intProjectId)
                  VALUES (
                    '". $_POST['arrTask'][$i] ."',
                    $intProjectId
                  )");
                if (DB::isError($arrProject)) {
                    $db->query('ROLLBACK');
                    raiseError($arrProject->getMessage());
                }
            } 
        } 
        $db->query('COMMIT');
        return STR_PROJECT_CREATED_SILLAJ;
    }
    
    /**
     * update a project
     */ 
    function set() {
        global $db;
        
        // check if this project belongs to the user
        $this->canModify($_POST['intProjectId']);
        
        // Check input values
        $arrInput = $this->checkInput();
        
        // update the project table
        $db->query('BEGIN');
        $arrProject = $db->query("
          UPDATE sillaj_project
          SET
            strProject = '". $arrInput['strProject'] ."',
            strRem = '". $arrInput['strRem']."',
            booShare = '". $arrInput['booShare'] ."',
            booUseInReport = '". $arrInput['booUseInReport'] ."'
          WHERE
            (intProjectId = ". $_POST['intProjectId'] .")"
        );
                
        if (DB::isError($arrProject)) {
            $db->query('ROLLBACK');
            raiseError($arrProject->getMessage());
        }

        // delete the old associated tasks        
        $arrProject = $db->query("
          DELETE FROM sillaj_task_project          
          WHERE
            (sillaj_project_intProjectId = ". $_POST['intProjectId'] .")"
        );
        
        if (DB::isError($arrProject)) {
            $db->query('ROLLBACK');
            raiseError($arrProject->getMessage());
        }
        
        // Add the new associated tasks to the link table
        if (!empty($_POST['arrTask'])) {
            for($i=0;$i<count($_POST['arrTask']);$i++) {
                $arrProject = $db->query("
                  INSERT INTO sillaj_task_project
                    (sillaj_task_intTaskId, sillaj_project_intProjectId)
                  VALUES (
                    '".$_POST['arrTask'][$i]."',
                    ".$_POST['intProjectId']."
                  )");
                  
                if (DB::isError($arrProject)) {
                    $db->query('ROLLBACK');
                    raiseError($arrProject->getMessage());
                }
            }
        } 
        
        $db->query('COMMIT');
        return STR_PROJECT_MODIFIED_SILLAJ;        
    }
    
    /**
     * Delete a project. Actually only hiding, so old events are still consistent 
     */ 
    function del() {                
        global $db;
        
        // check if this project belongs to the user
        $this->canModify($_POST['intProjectId']); 
        
        $arrProject = $db->query("
          UPDATE sillaj_project
          SET booDisplay = '0'
          WHERE intProjectId = ". $_POST['intProjectId'] 
        );
          
        if (DB::isError($arrProject)) {
            raiseError($arrProject->getMessage());
        }
        
        return STR_PROJECT_DELETED_SILLAJ;
    }
    
    /**
     * check if a project belongs to the user
     */
    function canModify($intProjectId) {                
        global $db;
        
        $strUserId = $db->getOne("
          SELECT
            sillaj_user_strUserId
          FROM sillaj_project            
          WHERE (intProjectId = $intProjectId)
        ");
            
        if (DB::isError($strUserId)) {
            raiseError($strUserId->getMessage());
        }   
        
        if ($strUserId != $_SESSION['strUserId']) { 
             raiseError(STR_PROJECT_EDIT_NOT_ALLOWED_SILLAJ);
        }
    }
    
    /**
     * check if a project can be seen by the user 
     */
    function canSee($intProjectId) {                
        global $db;
        
        $arrRes = $db->getRow("
          SELECT
            sillaj_user_strUserId,
            booShare
          FROM sillaj_project            
          WHERE (intProjectId = $intProjectId)   
          LIMIT 1        
        ");
            
        if (DB::isError($arrRes)) {
            raiseError($arrRes->getMessage());
        }   
        if (($arrRes['sillaj_user_strUserId'] != $_SESSION['strUserId']) && !$arrRes['booShare']) { 
             raiseError(STR_PROJECT_EDIT_NOT_ALLOWED_SILLAJ);
        }
    }
    
    /**
     * calculate the sum of worked hours on one project 
     */
    function getSum($intProjectId) {
        global $db;
        
        if ($_SESSION['booUseShare']) {
           $strUserWhere = '';                 
        }
        else {
           $strUserWhere = "AND (sillaj_user_strUserId = '". $_SESSION['strUserId'] ."')"; 
        }
        
        $strSum = $db->getOne("
          SELECT
            TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(timDuration))), '%H:%i')
          FROM sillaj_event            
          WHERE ((sillaj_project_intProjectId = $intProjectId) $strUserWhere)
        ");
            
        if (DB::isError($strSum)) {
            raiseError($strSum->getMessage());
        }   
        
        return $strSum;
    }
    
} // end class Project

/******************************************************************************/
/*
 * Manage tasks
 */
class Task {
    /**
     * Get task information
     * for all task or for the intTaskId
     */  
    function get($intTaskId = '', $booAll = false) {
        global $db;
        
        $strRem = $booAll ? ', strRem, booShare, booUseInReport' : '';
        $strTask = 'strTask';
        $strWhere = $intTaskId !== '' ? 'AND (intTaskId = ' . $intTaskId .')' : '';
          
        // if we want to see shared projects   
        $strShared = '';     
        if ($_SESSION['booUseShare']) {
            if ($intTaskId == '') {
                $strTask = "CASE WHEN booShare = '1' THEN CONCAT('* ', strTask) ELSE strTask END AS strTask";
            }
            $strShared = "OR (booShare = '1')";
        }                   
        
        $arrTask = $db->getAssoc("
          SELECT
            intTaskId,
            $strTask
            $strRem
          FROM sillaj_task
            LEFT JOIN sillaj_user ON (strUserId = sillaj_user_strUserId)
          WHERE (booDisplay = '1')
            AND ((strUserId = '". $_SESSION['strUserId'] ."') $strShared)
            $strWhere
          ORDER BY sillaj_task.strTask
        ");
            
        if (DB::isError($arrTask)) {
            raiseError($arrTask->getMessage());
        }
       
        return $arrTask;
    }    
    
    /**
     * Get project information
     * dependent from the intTaskId (to preselect project in edit_project)
     */               
    function getProject($intTaskId) {
        global $db;        
        
        // if we want to see shared projects
        $strShared = '';
        $strProject = 'strProject';   
        if ($_SESSION['booUseShare']) {
            $strShared = "OR (booShare = '1')";
            $strProject = "CASE WHEN booShare = '1' THEN CONCAT('* ', strProject) ELSE strProject END AS strProject";           
        }
        
        $arrTask = $db->getCol("
           SELECT
            intProjectId,
            $strProject
          FROM sillaj_project
            LEFT JOIN sillaj_task_project ON (sillaj_project_intProjectId = sillaj_project.intProjectId)
            LEFT JOIN sillaj_user ON (strUserId = sillaj_user_strUserId)
          WHERE (booDisplay = '1')
            AND ((strUserId = '". $_SESSION['strUserId'] ."') $strShared)
            AND (sillaj_task_intTaskId = $intTaskId)
          ORDER BY strProject                    
        ");
            
        if (DB::isError($arrTask)) {
            raiseError($arrTask->getMessage());
        }
      
        return $arrTask;
    }
    
    /**
     * get all events for a task
     */    
    function getEvent($intTaskId, $booOrderByProject = false) {
        global $db;
                       
        // Allowed to see ?
        $this->canSee($intTaskId);
        
        $strOrder = $booOrderByProject ? 'intProjectId' : 'datEvent DESC, timStart DESC, timEnd DESC, strProject';
          
        if ($_SESSION['booUseShare']) {
            $strMain = "CASE WHEN sillaj_project.booShare = '1' THEN CONCAT('* ', strProject) ELSE strProject END AS strMain";
            $strSub = "CASE WHEN sillaj_task.booShare = '1' THEN CONCAT('* ', strTask) ELSE strTask END AS strSub";
            $strUserId = 'strUserId,';   
            $strUserWhere = '';               
        }
        else {
            $strMain = "strProject AS strMain";
            $strSub = "strTask AS strSub";  
            $strUserId = '';  
            $strUserWhere = "AND (strUserId = '". $_SESSION['strUserId'] ."')"; 
        }
        
        $arrEvent = $db->getAll("
          SELECT
            intEventId,
            $strSub,
            intProjectId AS intMainId,
            $strMain,
            timStart,
            timEnd,
            timDuration,
            datEvent,
            $strUserId
            sillaj_event.strRem
          FROM sillaj_event
            LEFT JOIN sillaj_user on (strUserId = sillaj_event.sillaj_user_strUserId)
            LEFT JOIN sillaj_task on (intTaskId = sillaj_event.sillaj_task_intTaskId)            
            LEFT JOIN sillaj_project on (sillaj_event.sillaj_project_intProjectId = intProjectId)
          WHERE ((sillaj_event.sillaj_task_intTaskId = '$intTaskId') $strUserWhere)           
          ORDER BY $strOrder
        ");
        
        if (DB::isError($arrEvent)) {
            raiseError($arrEvent->getMessage());
        }                        
        return $arrEvent;
    }
    
     /**
     * get all events for a task FORMATTED FOR GANTT CHART
     */
    function getGantt($intTaskId) {
        global $db;               
        
        // Allowed to see ?
        $this->canSee($intTaskId);
                
        if ($_SESSION['booUseShare']) {
            $strMain = "CASE WHEN sillaj_project.booShare = '1' THEN CONCAT('* ', strProject) ELSE strProject END AS strMain";
            $strSub = "CASE WHEN sillaj_task.booShare = '1' THEN CONCAT('* ', strTask) ELSE strTask END AS strSub";
            $strUserId = ', strUserId';   
            $strUserWhere = '';               
        }
        else {
            $strMain = "strProject AS strMain";
            $strSub = "strTask AS strSub";  
            $strUserId = '';  
            $strUserWhere = "AND (strUserId = '". $_SESSION['strUserId'] ."')"; 
        }
        
        $arrEvent = $db->getAll("
          SELECT
            $strMain,
            intProjectId AS intMainId,
            $strSub,
            MIN(datEvent) AS datMin,
            MAX(datEvent) AS datMax
            $strUserId 
          FROM sillaj_event
            LEFT JOIN sillaj_user ON (strUserId = sillaj_event.sillaj_user_strUserId)
            LEFT JOIN sillaj_task ON (intTaskId = sillaj_event.sillaj_task_intTaskId)            
            LEFT JOIN sillaj_project ON (sillaj_event.sillaj_project_intProjectId = intProjectId)
          WHERE ((sillaj_event.sillaj_task_intTaskId = '$intTaskId') $strUserWhere)  
          GROUP BY sillaj_event.sillaj_project_intProjectId               
          ORDER BY datMin, datMax, strMain
        ");

        if (DB::isError($arrEvent)) {
            raiseError($arrEvent->getMessage());
        }                         
        return $arrEvent;
    }

    
    /**
     * Check input values
     */
    function checkInput() {
        $strTask = trim($_POST['strTask']);
        if (empty($strTask)) {
            raiseError(STR_NO_TASK_NAME_SILLAJ);
        }
        
        // Do we share this task ?
        $booShare = (!empty($_POST['cbxShare']) && ($_POST['cbxShare'] == 'on')) ? '1' : '0';

        // Should we use this project in reports ?
        $booUseInReport = (!empty($_POST['cbxUseInReport']) && ($_POST['cbxUseInReport'] == 'on')) ? '1' : '0';
            
        // sanitize
        if (!get_magic_quotes_gpc()) { 
           return array(
             'strTask' => addslashes($strTask),
             'strRem' => addslashes($_POST['strRem']),
             'booShare' => $booShare,
             'booUseInReport' => $booUseInReport
           );  
        } 
        else { 
           return array(
             'strTask' => $strTask,
             'strRem' => $_POST['strRem'],
             'booShare' => $booShare,
             'booUseInReport' => $booUseInReport
           ); 
        }     
    }
    
    /**
     * Add a new task 
     */ 
    function add() {
        global $db;
        
        // Check input values
        $arrInput = $this->checkInput();        
        
        // Add to the task table
        $db->query('BEGIN');
        $arrTask = $db->query("
          INSERT INTO sillaj_task
            (intTaskId, sillaj_user_strUserId, strTask, booDisplay, strRem, booShare, booUseInReport)
          VALUES (
            NULL,
            '". $_SESSION['strUserId'] ."',
            '". $arrInput['strTask'] ."',
            '1',
            '". $arrInput['strRem'] ."',
            '". $arrInput['booShare'] ."',
            '". $arrInput['booUseInReport'] ."'
          )"
        );
        
        if (DB::isError($arrTask)) {
            $db->query('ROLLBACK');
            raiseError($arrTask->getMessage());
        }
        
        // Get a new value for the primary key
        $intTaskId = DBSillaj::lastId();
        
        // Add to the link table
        if (! empty($_POST['arrProject'])) {
            for($i=0;$i<count($_POST['arrProject']);$i++) {
                $arrTask = $db->query("
                  INSERT INTO sillaj_task_project
                    (sillaj_task_intTaskId, sillaj_project_intProjectId)
                  VALUES (
                    $intTaskId,
                    '". $_POST['arrProject'][$i] ."'
                  )");
                if (DB::isError($arrTask)) {
                    $db->query('ROLLBACK');
                    raiseError($arrTask->getMessage());
                }
            } 
        } 
        
        $db->query('COMMIT');
        return STR_TASK_CREATED_SILLAJ;
    }
    
    /**
     * update a task 
     */ 
    function set() {
        global $db;
        
        // check if this task belongs to the user
        $this->canModify($_POST['intTaskId']);
        
        // Check input values
        $arrInput = $this->checkInput();
        
        // update the task table
        $db->query('BEGIN');
        $arrTask = $db->query("
          UPDATE sillaj_task
          SET
            strTask = '". $arrInput['strTask'] ."',
            strRem = '". $arrInput['strRem'] ."',
            booShare = '". $arrInput['booShare'] ."',
            booUseInReport = '". $arrInput['booUseInReport'] ."'
          WHERE
            (intTaskId = '". $_POST['intTaskId'] ."')
        ");
                
        if (DB::isError($arrTask)) {
            $db->query('ROLLBACK');
            raiseError($arrTask->getMessage());
        }

        // delete the old tasks        
        $arrTask = $db->query("
          DELETE FROM sillaj_task_project
          WHERE
            (sillaj_task_intTaskId = ". $_POST['intTaskId'] .")
        ");
        
        if (DB::isError($arrTask)) {
            $db->query('ROLLBACK');
            raiseError($arrTask->getMessage());
        }
        
        // Add the new projects to the link table
        if (!empty($_POST['arrProject'])) {
            for($i=0;$i<count($_POST['arrProject']);$i++) {
                $arrTask = $db->query("
                  INSERT INTO sillaj_task_project
                    (sillaj_task_intTaskId, sillaj_project_intProjectId)
                  VALUES (
                    ". $_POST['intTaskId'] .",
                    '". $_POST['arrProject'][$i] ."'
                  )");
                  
                if (DB::isError($arrTask)) {
                    $db->query('ROLLBACK');
                    raiseError($arrTask->getMessage());
                }
            }
        }  
        
        $db->query('COMMIT');
        return STR_TASK_MODIFIED_SILLAJ;
    }
    
    /**
     * Delete a task. Actually only hiding, so old events are still consistent 
     */ 
    function del() {
        global $db;
        
        // check if this task belongs to the user
        $this->canModify($_POST['intTaskId']); 
        
        $arrTask = $db->query("
          UPDATE sillaj_task
          SET booDisplay = '0'
          WHERE intTaskId = ". $_POST['intTaskId'] 
        );
          
        if (DB::isError($arrTask)) {
            raiseError($arrTask->getMessage());
        }
        
        return STR_TASK_DELETED_SILLAJ;
    }
    
    /**
     * check if a project belongs to the user 
     */
    function canModify($intTaskId) {
        global $db;
        
        $strUserId = $db->getOne("
          SELECT
            sillaj_user_strUserId
          FROM sillaj_task
          WHERE (intTaskId = $intTaskId)
        ");
            
        if (DB::isError($strUserId)) {
            raiseError($strUserId->getMessage());
        }   
        if ($strUserId != $_SESSION['strUserId']) { 
             raiseError(STR_TASK_EDIT_NOT_ALLOWED_SILLAJ);
        }
    }
    
    /**
     * check if a project can be seen by the user
     */
    function canSee($intTaskId) {
        global $db;
        
        $arrRes = $db->getRow("
          SELECT
            sillaj_user_strUserId,
            booShare
          FROM sillaj_task
          WHERE (intTaskId = $intTaskId)
          LIMIT 1
        ");
            
        if (DB::isError($arrRes)) {
            raiseError($arrRes->getMessage());
        }   
        if (($arrRes['sillaj_user_strUserId'] != $_SESSION['strUserId']) && !$arrRes['booShare']) { 
             raiseError(STR_TASK_EDIT_NOT_ALLOWED_SILLAJ);
        }
    }
    
    /**
     * calculate the sum of worked hours on one task 
     */
    function getSum($intTaskId) {
        global $db;
        
        if ($_SESSION['booUseShare']) {
           $strUserWhere = '';
        }
        else {
           $strUserWhere = "AND (sillaj_user_strUserId = '". $_SESSION['strUserId'] ."')"; 
        }
        
        $strSum = $db->getOne("
          SELECT
            TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(timDuration))), '%H:%i')
          FROM sillaj_event            
          WHERE ((sillaj_task_intTaskId = $intTaskId) $strUserWhere)
        ");
            
        if (DB::isError($strSum)) {
            raiseError($strSum->getMessage());
        }   
        
        return $strSum;
    }
    
} // end class Task

/******************************************************************************/
/**
 * Manage events
 */
class Event {
    /**
     * Get event information for one user
     * for one event (id specified)
     */   
    function get($intEventId) {
        global $db;
        
        if (empty($intEventId)) {
            raiseError(STR_NO_EVENT_SELECTED_SILLAJ);
        }
       
        $arrEvent = $db->getAll("
          SELECT
            intEventId,
            sillaj_task_intTaskId AS intTaskId,
            strTask,
            sillaj_project_intProjectId AS intProjectId,
            strProject,
            timStart,
            timEnd,
            timDuration,
            datEvent,
            sillaj_event.strRem
          FROM sillaj_event
            LEFT JOIN sillaj_user on (strUserId = sillaj_event.sillaj_user_strUserId)
            LEFT JOIN sillaj_task on (intTaskId = sillaj_event.sillaj_task_intTaskId)            
            LEFT JOIN sillaj_project on (sillaj_event.sillaj_project_intProjectId = intProjectId)
          WHERE (intEventId = '$intEventId')
            AND (strUserId = '". $_SESSION['strUserId'] ."')
          LIMIT 1
        ");

        if (DB::isError($arrEvent)) {
            raiseError($arrEvent->getMessage()); 
        }
        if (count($arrEvent) == 1) {
            return $arrEvent[0];
        }
        else {
            raiseError(STR_EVENT_NOT_FOUND_SILLAJ); 
        }    
    }
    
    /**
     * Get event information for one user
     * for all event or for the date specified
     */   
    function getForDay($datEvent) {
        global $db;
        
        if (empty($datEvent)) {
            raiseError(STR_NO_DATE_SELECTED_SILLAJ);
        }
        
        if ($_SESSION['booUseShare']) {
            $strMain = "CASE WHEN sillaj_project.booShare = '1' THEN CONCAT('* ', strProject) ELSE strProject END AS strMain";
            $strSub = "CASE WHEN sillaj_task.booShare = '1' THEN CONCAT('* ', strTask) ELSE strTask END AS strSub";            
        }
        else {
            $strMain = "strProject AS strMain";
            $strSub = "strTask AS strSub";  
        }
        
        $arrEvent = $db->getAll("
          SELECT
            intEventId,
            $strSub,
            $strMain,
            TIME_FORMAT(timStart, '%H:%i') AS timStart,
            TIME_FORMAT(timEnd, '%H:%i') AS timEnd,
            TIME_FORMAT(timDuration, '%H:%i') AS timDuration,
            datEvent,
            
            sillaj_event.strRem
          FROM sillaj_event
            LEFT JOIN sillaj_user on (strUserId = sillaj_event.sillaj_user_strUserId)
            LEFT JOIN sillaj_task on (intTaskId = sillaj_event.sillaj_task_intTaskId)
            LEFT JOIN sillaj_project on (sillaj_event.sillaj_project_intProjectId = intProjectId)
          WHERE (datEvent = '$datEvent')
            AND (strUserId = '". $_SESSION['strUserId'] ."')
          ORDER BY timStart DESC, timDuration DESC, strProject, strTask 
        ");

        if (DB::isError($arrEvent)) {
            raiseError($arrEvent->getMessage()); 
        }
           
        return $arrEvent;
    }
    
    /**
     * Get event dates for one user
     * for one month
     */   
    function getForMonth($datEvent) {
        global $db;
        
        if (empty($datEvent)) {
            raiseError(STR_NO_DATE_SELECTED_SILLAJ);
        }
        
        $arrEvent = $db->getCol("
          SELECT -- DISTINCT
            datEvent
          FROM sillaj_event
          WHERE (MONTH(datEvent) = MONTH('$datEvent'))
            AND (sillaj_user_strUserId = '". $_SESSION['strUserId'] ."')
          ORDER BY timStart
        ");
            
        if (DB::isError($arrEvent)) {
            raiseError($arrEvent->getMessage());
        }
           
        return $arrEvent;
    }
    
    /**
     * Get the last n events for one user for RSS and Atom
     */   
    function getLastItems($strUserId, $intItems = INT_RSS_MAX_ITEM_SILLAJ) {
        global $db;
        
        if (empty($strUserId)) {
            raiseError('No user');
        }
        
        /*if ($_SESSION['booUseShare']) {
            $strProject = "CASE WHEN sillaj_project.booShare = '1' THEN CONCAT('* ', strProject) ELSE strProject END AS strProject";
            $strTask = "CASE WHEN sillaj_task.booShare = '1' THEN CONCAT('* ', strTask) ELSE strTask END AS strTask";            
        }
        else { */
            $strProject = "strProject AS strProject";
            $strTask = "strTask AS strTask";  
        //}
        
        $arrEvent = $db->getAll("
          SELECT
            intEventId,
            $strTask,
            $strProject,
            sillaj_project.intProjectId,
            TIME_FORMAT(timStart, '%H:%i') AS timStart,
            TIME_FORMAT(timEnd, '%H:%i') AS timEnd,
            TIME_FORMAT(timDuration, '%H:%i') AS timDuration,
            UNIX_TIMESTAMP(CONCAT(datEvent, ' ', IFNULL(timStart, '00:00:00'))) AS datEvent,
            UNIX_TIMESTAMP(sillaj_event.datUpdate) AS datUpdate,            
            sillaj_event.strRem
          FROM sillaj_event
            LEFT JOIN sillaj_task on (intTaskId = sillaj_event.sillaj_task_intTaskId)            
            LEFT JOIN sillaj_project on (sillaj_event.sillaj_project_intProjectId = intProjectId)
          WHERE (sillaj_event.sillaj_user_strUserId = '$strUserId')
          ORDER BY 
            datEvent DESC
          LIMIT $intItems");
            
        if (DB::isError($arrEvent)) {
            raiseError($arrEvent->getMessage());
        }
        
        return $arrEvent;
    }
    
    /**
     * add new event
     */    
    function add() {
        global $db;
        
        // if we have +d in timEnd we will add 2 events : before and after
        // midnight
        if (strstr($_POST['timEnd'], '+d') != false) {
            $timEnd2 = str_replace('+d', '', $_POST['timEnd']);
            $_POST['timEnd'] = '24:00';  
        }
        
        $arrInput = $this->checkInput();
                        
        $arrEvent = $db->query("
          INSERT INTO sillaj_event (
            sillaj_task_intTaskId,
            sillaj_project_intProjectId,
            sillaj_user_strUserId,
            timStart, 
            timEnd,
            timDuration,
            datEvent,
            strRem
          )
          VALUES (
            ". $_POST['intTaskId'] .",
            ". $_POST['intProjectId'] .",
            '". $_SESSION['strUserId'] ."',
            ". $arrInput['timStart'] .",
            ". $arrInput['timEnd'] .",
            ". $arrInput['timDuration'] .",
            '". $_POST['datEvent'] ."',
            '". $arrInput['strRem'] ."'
          )"
        );
        
        if (DB::isError($arrEvent)) {
            raiseError($arrEvent->getMessage());
        }
        
        // add task after midnight
        if (isset($timEnd2)) {
        
            // Add one day to the submitted date
            $arrDate = explode('-', $_POST['datEvent']); 
            $ts = mktime(0, 0, 0, $arrDate[1], $arrDate[2]+1, $arrDate[0]);
            $strDate = date('Y-m-d', $ts);

            $timDuration = "SEC_TO_TIME(TIME_TO_SEC('". $this->createMaketime($timEnd2) ."') - TIME_TO_SEC('". $this->createMaketime('00:00') ."'))";
            
            // query
            $arrEvent = $db->query("
              INSERT INTO sillaj_event (
                sillaj_task_intTaskId,
                sillaj_project_intProjectId,
                sillaj_user_strUserId,
                timStart, 
                timEnd,
                timDuration,
                datEvent,
                strRem
              )
              VALUES (
                ". $_POST['intTaskId'] .",
                ". $_POST['intProjectId'] .",
                '". $_SESSION['strUserId'] ."',
                '00:00',
                '". $this->createMaketime($timEnd2). "',
                $timDuration,
                '$strDate',
                '". $arrInput['strRem'] ."'
              )"
            );
            
            if (DB::isError($arrEvent)) {
                raiseError($arrEvent->getMessage());
            }
            return STR_EVENT_CREATED_SILLAJ .' '. STR_EVENT_CREATED_2DAYS_SILLAJ;
        }
              
        return STR_EVENT_CREATED_SILLAJ;
    }
    
    /**
     * update an event 
     */
    function set() {
        global $db;
        
        if (empty($_POST['intEventId'])) {
            raiseError(STR_NO_EVENT_SELECTED_SILLAJ);
        }
        
        // check if this task belongs to the user
        $this->canModify($_POST['intEventId']); 
        
        $arrInput = $this->checkInput();
        
        $arrEvent = $db->query("
          UPDATE sillaj_event
          SET
            sillaj_task_intTaskId = ". $_POST['intTaskId'] .",
            sillaj_project_intProjectId = ". $_POST['intProjectId'] .",
            timStart =  ".$arrInput['timStart'].",
            timEnd = ".$arrInput['timEnd'].",
            timDuration =  ".$arrInput['timDuration'].",  
            datEvent = '". $_POST['datEvent'] ."',
            strRem =  '". $arrInput['strRem'] ."'
          WHERE (intEventId = '". $_POST['intEventId'] ."')
        ");
            
        if (DB::isError($arrEvent)) {
            raiseError($arrEvent->getMessage());
        }
           
        return STR_EVENT_MODIFIED_SILLAJ;
    }
    
    /**
     * Prepare a time string for a SQL statement from a time input
     * input time can be :
     *   - "hh-mm-ss" "hh:mm:ss" "hh,mm,ss" "hh;mm;ss" or "hh mm ss" 
     *   - with "mm" and "ss" optionnal, and 0 padding optionnal too
     * output is hh:mm:ss
     */
    function createMaketime($input) {
        $arrMaketime = split("[-:,;[:space:]]", $input);
        $strMaketime = '';
        
        for ($i=0;$i<3;$i++) {
            if ($i > count($arrMaketime) - 1) {
                $strMaketime .= '00:';
            }
            else {
                if (!is_numeric($arrMaketime[$i])) {
                    raiseError(STR_BAD_TIME_VALUE_SILLAJ);
                }
                $strMaketime .= sprintf('%02d', $arrMaketime[$i]) . ':';
            }   
        }
        return substr($strMaketime, 0, -1);
    }
    
    /**
     * Get the last update of an event.
     * Used to know if we must refresh the cache when we build a gant graph
     * see gantt.php           
     */
    function getDateLastUpdate() {
        global $db;
        
        return $db->getOne("
          SELECT
            UNIX_TIMESTAMP(MAX(datUpdate))
           FROM
            sillaj_event          
        ");
    }
    
    /**
     * delete an event 
     */
    function del() {
        global $db;
        
        if (empty($_POST['intEventId'])) {
            raiseError(STR_NO_EVENT_SELECTED_SILLAJ);
        }
        
        // check if this task belongs to the user
        $this->canModify($_POST['intEventId']); 
        
        $arrEvent = $db->query("
          DELETE FROM
            sillaj_event
          WHERE (intEventId = '". $_POST['intEventId'] ."')
        ");
            
        if (DB::isError($arrEvent)) {
            raiseError($arrEvent->getMessage());
        }
           
        return STR_EVENT_DELETED_SILLAJ;
    }
    
    /**
     * check if an event belongs to the user 
     */
    function canModify($intEventId) {
        global $db;
        
        if (empty($intEventId)) {
            raiseError(STR_NO_EVENT_SELECTED_SILLAJ);
        }
        
        $strUserId = $db->getOne("
          SELECT
            sillaj_user_strUserId
          FROM sillaj_event           
          WHERE (intEventId = $intEventId)
        ");
            
        if (DB::isError($strUserId)) {
            raiseError($strUserId->getMessage());
        }   
        if ($strUserId != $_SESSION['strUserId']) { 
             raiseError(STR_EVENT_EDIT_NOT_ALLOWED_SILLAJ);
        }
    }

    /**
     * Check input value for add() and set()
     */
    function checkInput() {

        // check project and task
        if (empty($_POST['intTaskId'])) {
            raiseError(STR_NO_TASK_SELECTED_SILLAJ);
        }
        
        if (empty($_POST['intProjectId'])) {
            raiseError(STR_NO_PROJECT_SELECTED_SILLAJ);
        }
        
        // check time
        if (empty($_POST['timDuration'])) {
            $d = '';
        }
        else {
            $d = trim($_POST['timDuration']);
        }
        
        if (empty($_POST['timStart'])) {
            $s = '';
        }
        else {
            $s = trim($_POST['timStart']);
        }
        
        if (empty($_POST['timEnd'])) {
            $e = '';
        }
        else {
            $e = trim($_POST['timEnd']);
        }
        
        if ((empty($d) && empty($s) && empty($e))
          || (empty($s) && !empty($e)) 
          || (!empty($s) && empty($e))) {
            raiseError(STR_NO_TIME_INPUT_SILLAJ);
        }
        
        // Add leading 0 for the next comparison
        list($h, $m) = split('[-:,; ]', $s);
        $o = strlen($h) == 1 ? '0' : '';
        $s = $o . $s;
        
        list($h, $m) = split('[-:,; ]', $e);
        $o = strlen($h) == 1 ? '0' : '';
        $e = $o . $e;
        
        // Check if start is before end
        if (empty($d) && ($s > $e)) {
            raiseError(STR_BAD_TIME_INPUT_SILLAJ . htmlspecialchars(" $s > $e"));
        }
        
        // order and duration calculation (SQL statement)
        if (!empty($s) && !empty($e)) {
            if ($s < $e) {
                $timStart = $s;
                $timEnd = $e;
            }
            else {
                $timStart = $e;
                $timEnd = $s;
            }
            $timDuration = "SEC_TO_TIME(TIME_TO_SEC('". $this->createMaketime($timEnd) ."') - TIME_TO_SEC('". $this->createMaketime($timStart) ."'))";
        }
        else {
            if ($d == '') {
                $timDuration = 'NULL';
            }
            else {
                $timDuration = "'". $this->createMaketime($d) ."'";
            }
        }
        
        if ($_POST['timStart'] == '') {
            $timStart = 'NULL';
        }
        else {
            $timStart ="'". $this->createMaketime($s) ."'";
        }
        
        if ($_POST['timEnd'] == '') {
            $timEnd = 'NULL';
        }
        else {
            $timEnd ="'". $this->createMaketime($e) ."'";
        }
        
        if (!get_magic_quotes_gpc()) { 
           $strRem = addslashes($_POST['strRem']); 
        } else { 
           $strRem = $_POST['strRem']; 
        } 
        
        return array(
             'timStart' => $timStart,
               'timEnd' => $timEnd,
          'timDuration' => $timDuration,
               'strRem' => $strRem
        );
    }
    
    /**
     * Calculate the total time worked on one day
     */
    function sumByDay($datEvent) {
        global $db;
        
        if (empty($datEvent)) {
            raiseError(STR_NO_DATE_SELECTED_SILLAJ);
        }
        
        $strSum = $db->getOne("
          SELECT
            TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(timDuration))),'%H:%i') AS strSum
          FROM sillaj_event           
          WHERE (datEvent = '$datEvent')
            AND (sillaj_user_strUserId = '". $_SESSION['strUserId'] ."')
        ");
            
        if (DB::isError($strSum)) {
            raiseError($strSum->getMessage());
        }  
        
        return $strSum; 
    }
    
    
    /**
     * Search engine
     * Find events searching in project, task and rem     
     */
    function find($strKeyword) {
        global $db;
        
        if ($_SESSION['booUseShare']) {
            $strMain = "CASE WHEN sillaj_project.booShare = '1' THEN CONCAT('* ', strProject) ELSE strProject END AS strMain";
            $strSub = "CASE WHEN sillaj_task.booShare = '1' THEN CONCAT('* ', strTask) ELSE strTask END AS strSub";                
        }
        else {
            $strMain = 'strProject AS strMain';
            $strSub = 'strTask AS strSub';
        }
        
        $arrEvent = $db->getAll("
          SELECT
            intEventId,
            $strSub,
            $strMain,
            timStart,
            timEnd,
            timDuration,
            datEvent,
            sillaj_event.strRem
          FROM sillaj_event
            LEFT JOIN sillaj_user on (strUserId = sillaj_event.sillaj_user_strUserId)
            LEFT JOIN sillaj_task on (intTaskId = sillaj_event.sillaj_task_intTaskId)
            LEFT JOIN sillaj_project on (sillaj_event.sillaj_project_intProjectId = intProjectId)
          WHERE 
            (
              (sillaj_event.strRem LIKE '%$strKeyword%') 
              OR (strProject LIKE '%$strKeyword%') 
              OR (strTask LIKE '%$strKeyword%')
            )
            AND (strUserId = '". $_SESSION['strUserId'] ."')
          ORDER BY datEvent DESC, timStart DESC, timEnd DESC, strProject, strTask
        ");
        
        
        if (DB::isError($arrEvent)) {
            raiseError($arrEvent->getMessage());
        }                         
        return $arrEvent;
    }
} // end Class Event


/******************************************************************************/
/**
 * Report building
 */
class Report {

    /**
     * List of project detailed by their tasks with their respective times and %
     */
    function getProject($strUserId, $strSort, $datStart, $datEnd) {
        global $db;
        
        if ($strSort == 'time') {
            $strOrderBy = 'timDurationTotProject DESC, intMainId, timDurationTotTask DESC';
        }
        else {
            $strOrderBy = 'report_project.strProject, sillaj_task.strTask';
        }
        
        // we first build a temporary table to hold the main items (projects). This step is needed because
        // a simple join wouldn't allow us to sort both by time and by name
        $arrReport = $db->query("
          CREATE TEMPORARY TABLE report_project
            SELECT
              intProjectId,
              strProject,
              booshare,
              SUM(TIME_TO_SEC(timDuration)) AS timDurationTotProject,
              SUM(TIME_TO_SEC(timDuration)) / TIME_TO_SEC('". $this->getSumWorked($strUserId, $datStart, $datEnd) ."') * 100 AS numPcentDurationTotProject,
              booUseInReport,
              sillaj_project.strRem AS strRemM
            FROM sillaj_event
              LEFT JOIN sillaj_project ON (intProjectId = sillaj_project_intProjectId)
            WHERE (datEvent BETWEEN '$datStart' AND '$datEnd')
              AND (sillaj_event.sillaj_user_strUserId = '$strUserId')
              AND (sillaj_project.booUseInReport = '1')
            GROUP BY 
              intProjectId
        ");
             
        if (DB::isError($arrReport)) {
            raiseError($arrReport->getMessage());
        }  
        
        // Then we join our temporary table to the global table, sorted by time or name
        
        // first check if we use shared project/tasks
        if ($_SESSION['booUseShare']) {
          $strMain = "CASE WHEN report_project.booShare = '1' THEN CONCAT('* ', strProject) ELSE strProject END AS strMain";
          $strSub = "CASE WHEN sillaj_task.booShare = '1' THEN CONCAT('* ', strTask) ELSE strTask END AS strSub";            
        }
        else {
            $strMain = "strProject AS strMain";
            $strSub = "strTask AS strSub";  
        }
        
        $arrReport = $db->getAll("                  
          SELECT        
            intProjectId AS intMainId,
            CAST(TIME_FORMAT(SEC_TO_TIME(timDurationTotProject), '%H:%i') AS CHAR(8)) AS timDurationTotMain,
            numPcentDurationTotProject AS numPcentDurationTotMain,
            $strMain,
            intTaskId AS intSubId,
            $strSub,
            SUM(TIME_TO_SEC(timDuration)) AS timDurationTotTask,
            TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(timDuration))), '%H:%i') AS timDurationTotSub,
            SUM(TIME_TO_SEC(timDuration)) / TIME_TO_SEC('". $this->getSumWorked($strUserId, $datStart, $datEnd) ."') * 100 AS numPcentDurationTotSub,
            strRemM,
            sillaj_task.strRem AS strRemS
          FROM sillaj_event
            LEFT JOIN sillaj_task ON (intTaskId = sillaj_task_intTaskId) 
            LEFT JOIN report_project ON (intProjectId = sillaj_project_intProjectId)          
          WHERE (datEvent BETWEEN '$datStart' AND '$datEnd')
            AND (sillaj_event.sillaj_user_strUserId = '$strUserId') 
            AND (report_project.booUseInReport = '1')           
          GROUP BY 
            intProjectId, intTaskId
          ORDER BY
            $strOrderBy
        ");
           
        if (DB::isError($arrReport)) {
            raiseError($arrReport->getMessage());
        }         
        
        // clean the temporary table 
        $db->query('DROP TABLE report_project');
        
        return $arrReport; 
    }
    
    /**
     * List of tasks with their respective times and %
     */
    function getTask($strUserId, $strSort, $datStart, $datEnd) {
        global $db;
        
        if ($strSort == 'time') {
            $strOrderBy = 'timDurationTotTask DESC, intMainId, timDurationTotProject DESC';
        }
        else {
            $strOrderBy = 'report_task.strTask, sillaj_project.strProject';
        }
        
        // we first build a temporary table to hold the main items (tasks). This step is needed because
        // a simple join wouldn't allow us to sort both by time and by name                
        $arrReport = $db->query("
          CREATE TEMPORARY TABLE report_task
            SELECT
              intTaskId,
              strTask,
              booShare,
              SUM(TIME_TO_SEC(timDuration)) AS timDurationTotTask,
              SUM(TIME_TO_SEC(timDuration)) / TIME_TO_SEC('". $this->getSumWorked($strUserId, $datStart, $datEnd) ."') * 100 AS numPcentDurationTotTask,
              sillaj_task.booUseInReport,
              sillaj_task.strRem AS strRemM
            FROM sillaj_event
              LEFT JOIN sillaj_task ON (intTaskId = sillaj_task_intTaskId)
            WHERE (datEvent BETWEEN '$datStart' AND '$datEnd')
              AND (sillaj_event.sillaj_user_strUserId = '$strUserId')  
              AND (sillaj_task.booUseInReport = '1')           
            GROUP BY 
              intTaskId
        ");                      
              
        if (DB::isError($arrReport)) {
            raiseError($arrReport->getMessage());
        }  
        
        // Then we join our temporary table to the global table, sorted by time or name
        
        // first check if we use shared project/tasks
        if ($_SESSION['booUseShare']) {
          $strSub = "CASE WHEN sillaj_project.booShare = '1' THEN CONCAT('* ', strProject) ELSE strProject END AS strSub";
          $strMain = "CASE WHEN report_task.booShare = '1' THEN CONCAT('* ', strTask) ELSE strTask END AS strMain";            
        }
        else {
            $strSub = "strProject AS strSub";
            $strMain = "strTask AS strMain";  
        }
        
        $arrReport = $db->getAll("                  
          SELECT        
            intTaskId AS intMainId,
            CAST(TIME_FORMAT(SEC_TO_TIME(timDurationTotTask), '%H:%i') AS CHAR(8)) AS timDurationTotMain,
            numPcentDurationTotTask AS numPcentDurationTotMain,
            $strMain,
            intProjectId AS intSubId,
            $strSub,
            SUM(TIME_TO_SEC(timDuration)) AS timDurationTotProject,
            TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(timDuration))), '%H:%i') AS timDurationTotSub,
            SUM(TIME_TO_SEC(timDuration)) / TIME_TO_SEC('". $this->getSumWorked($strUserId, $datStart, $datEnd) ."') * 100 AS numPcentDurationTotSub,
            strRemM,
            sillaj_project.strRem AS strRemS
          FROM sillaj_event
            LEFT JOIN sillaj_project ON (intProjectId = sillaj_project_intProjectId) 
            LEFT JOIN report_task ON (intTaskId = sillaj_task_intTaskId)          
          WHERE (datEvent BETWEEN '$datStart' AND '$datEnd')
            AND (sillaj_event.sillaj_user_strUserId = '$strUserId')
            AND (report_task.booUseInReport = '1')
          GROUP BY 
            intTaskId, intProjectId 
          ORDER BY
            $strOrderBy
        ");
            
        if (DB::isError($arrReport)) {
            raiseError($arrReport->getMessage());
        }          
        
        // clean temporary table
        $db->query('DROP TABLE report_task');
        
        return $arrReport; 
    }
    
    function getSumWorked($strUserId, $datStart, $datEnd) {
        global $db;

        $strReport = $db->getOne("
          SELECT
            TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(timDuration))), '%H:%i') AS timDurationTot           
          FROM sillaj_event
            LEFT JOIN sillaj_project ON (sillaj_event.sillaj_project_intProjectId = sillaj_project.intProjectId)
            LEFT JOIN sillaj_task ON (sillaj_event.sillaj_task_intTaskId = sillaj_task.intTaskId)         
          WHERE (datEvent BETWEEN '$datStart' AND '$datEnd')
            AND (sillaj_event.sillaj_user_strUserId = '$strUserId')
            AND ((sillaj_project.booUseInReport = '1') 
			  OR(sillaj_task.booUseInReport = '1'))
        ");
            
        if (DB::isError($strReport)) {
            raiseError($strReport->getMessage());
        }  
        
        return $strReport; 
    }

}

/******************************************************************************/
/**
 * Template engine
 * It extents Smarty to find the correct path for templates and config files
 */
class SmartySillaj extends Smarty {
    var $strTemplateName = '';
   
    function setTemplate($template) {
        $this->strTemplateName = $template;
        if ($template && file_exists(FN_ROOT_DIR_SILLAJ .'templates/'. $template .'/')) {
         
            $this->template_dir = FN_ROOT_DIR_SILLAJ .'templates/'. $template .'/';
            $this->config_dir   = FN_ROOT_DIR_SILLAJ .'lang/';
            $this->compile_dir  = FN_ROOT_DIR_SILLAJ .'templates/'. $template .'/templates_c/';
            $this->cache_dir    = FN_CACHE_SILLAJ;                                   
           
            return 1;
        } 
        else {
            return 0;
       }
    }
   
    function smartySillaj($strTemplateName = '') {
        $this->Smarty();
        $this->caching       = false; // by default, no caching. Set to true on some specific templates (login.php, report.php...)
        $this->force_compile = BOO_DEBUG_SILLAJ;
        $this->compile_check = BOO_DEBUG_SILLAJ;
        $this->debugging     = BOO_DEBUG_SILLAJ;
        $this->cache_lifetime= 3600;
        
        // delete useless leading whitespace in HTML
        $this->load_filter('output', 'trimwhitespace');
        
        // if the template dir is not found, set some var to display an error message
        // later (after smarty assignations) and revert to the default theme 
        if(!$this->setTemplate($strTemplateName)) {
            $this->setTemplate(STR_TEMPLATE_SILLAJ);           
            define('BOO_TEMPLATE_NOT_FOUND_SILLAJ', true);
            define('STR_BAD_TEMPLATE_SILLAJ', $strTemplateName);
            $_SESSION['strThemeName'] = STR_TEMPLATE_SILLAJ;
        }
        else {
            define('BOO_TEMPLATE_NOT_FOUND_SILLAJ', false);
        }        
    }       
} // end class SmartySillaj

/******************************************************************************/
/**
* Manage users
*/
class User {

    /**
     * Constructor
     */
    function User() {   
        // session.cookie_httponly should be set to true in php.ini to limit XSS
        session_name('SILLAJSESSID');     
        session_start();
    }

    /**
     * Call this function at the beginning of each page to protect
     * if not authenticated -> will be redirected to the login page
     */
    function checkAuthent() {
        if (empty($_SESSION['booIsAuthent'])) {
            $urlDest = $_SERVER['REQUEST_URI'];
            header('Location: '. URL_ROOT_DIR_SILLAJ .'login.php?urlDest='. urlencode($urlDest));
            exit();
        }
        return true;
    }       
    
    /**
     * Check credentials in the database
     * We use a a nonce-based authentication and we store password encrypted in the database
     * 
     * 1- the server generates a random nonce, sent with the login form
     * 2- before submitting the form, javascript will MD5 the password and
     *    will MD5 it, concatened with the nonce and the user login, and reset the 
     *    password so it's not sent in clear text 
     * 3- here we check if the user exists and if the encrypted response is correct                              
     */
    function execAuthent($booRedirect = true) {
        global $db;
        global $smarty;
        global $sillaj;
        
        $smarty->assign('booDisplayMenu', false); // if we show an error message we don't want to display the menu
        
        // Check data from the form    
        $urlDest = empty($_POST['urlDest']) ? URL_ROOT_DIR_SILLAJ : $_POST['urlDest'];     
        
        if (empty($_POST['strUserId'])) {
            raiseError(STR_NO_LOGIN_SILLAJ);
        }
        
        if (empty($_POST['strPassword']) && (empty($_POST['strResponse']) && empty($_POST['booEdit']))) {
            raiseError(STR_NO_PASSWORD_SILLAJ);
        }
        
        // Check if 1 valid couple login/password 
        // If javascript is disabled we won't get the response but just the 
        // password in clear text. We can manage these two types of authentication              
        if (!empty($_POST['strResponse'])) {             
            $strWhere = "('". $_POST['strResponse'] ."' = MD5(CONCAT(strPassword,'". $_SESSION['strNonce'] ."','". $_POST['strUserId'] ."')))";
        }
        else {
            $strWhere = "strPassword = MD5('". $_POST['strPassword'] ."')";            
        }
        
        $arrAuthent = $db->getAll("
            SELECT
              strUserId,
              strName,
              strFirstname,
              strEmail,
              booAllowOther,
              booUseShare,
              strLanguage,
              strTemplate
            FROM sillaj_user
            WHERE 
              strUserId = '". $_POST['strUserId'] ."'
              AND $strWhere
            ");
        
        if (DB::isError($arrAuthent)) {
            raiseError($arrAuthent->getMessage());
        }
        if (count($arrAuthent) == 0) {
            raiseError(STR_NO_AUTHENT_SILLAJ);
        }
        if (count($arrAuthent) > 1) {
            raiseError(STR_UNEXPECTED_AUTHENT_SILLAJ);
        }
        
        // remember values
        $_SESSION[    'strUserId'] = $arrAuthent[0]['strUserId'];
        $_SESSION[      'strName'] = $arrAuthent[0]['strName'];        
        $_SESSION[ 'strFirstname'] = $arrAuthent[0]['strFirstname'];
        $_SESSION[     'strEmail'] = $arrAuthent[0]['strEmail'];
        $_SESSION['booAllowOther'] = $arrAuthent[0]['booAllowOther'];
        $_SESSION[  'booUseShare'] = $arrAuthent[0]['booUseShare'];
        $_SESSION[ 'booIsAuthent'] = true;                 
        
        // set the preferred language if it exists, else we keep the default one
        if (in_array($arrAuthent[0]['strLanguage'], $sillaj->getLanguage())) {
            $_SESSION['strLocale'] = $arrAuthent[0]['strLanguage'];
        }
        
        // set the preferred template if it exists, else we keep the default one
        if (in_array($arrAuthent[0]['strTemplate'], $sillaj->getTemplate())) {
            $_SESSION['strThemeName'] = $arrAuthent[0]['strTemplate'];
        }
       
        if ($booRedirect) {
            header('Location: '. $urlDest);
            exit();
        }
    }
    
    /**
     * Get users
     */
    function get($strUserId = '', $booActive = false) {
        global $db;
        
        $strWhere = '';
        if (($strUserId != '') || $booActive) {
            $strWhere = 'WHERE ';
        }
        else { // all names (for report.php)     
               
            $arrUser = $db->getAssoc("
              SELECT
                strUserId,
                CONCAT(strUserId,' (', strName, ' ', strFirstname, ')')                               
              FROM sillaj_user                           
              WHERE
                (booAllowOther = '1') || (strUserId = '". $_SESSION['strUserId'] ."')
              ORDER BY  
                strName,
                strFirstname,
                strUserId   
            ");
            
            if (DB::isError($arrUser)) {
                raiseError($arrUser->getMessage());
            }      
            return $arrUser;
        }
        
        if ($strUserId != '') {
            $strWhere .= "strUserId = '$strUserId' ";
        }
        
        if ($booActive) {
            if (strlen($strWhere) > 6) {
                $strWhere .= 'AND ';
            }
            $strWhere .= "booActive = '1' ";
        }     
            
        // query        
        $arrUser = $db->getAll('
          SELECT
            strUserId,
            strName,
            strFirstname,
            strEmail,
            strPassword,
            booActive,
            booUseShare,
            booAllowOther,
            strLanguage,
            strTemplate            
          FROM sillaj_user 
          '. $strWhere .'
          ORDER BY  
            strName,
            strFirstname,
            strUserId
        ');
        
        if (DB::isError($arrUser)) {
            raiseError($arrUser->getMessage());
        }
        if (count($arrUser) == 1) {
            return $arrUser[0];
        }        
        return $arrUser;    
    }
    
    /**
     * Check input values
     */
    function checkInput() { 
        if (!empty($_POST['cbxAllowOther']) && ($_POST['cbxAllowOther'] == 'on')) {
            $booAllowOther = '1';
        }
        else {
            $booAllowOther = '0';
        }  
        if (!empty($_POST['cbxUseShare']) && ($_POST['cbxUseShare'] == 'on')) {
            $booUseShare = '1';
        }
        else {
            $booUseShare = '0';
        }        
        
        if (empty($_POST['strEmail']) || ! $this->validEmail($_POST['strEmail'])) {
        	raiseError(STR_MISSING_EMAIL_SILLAJ);	
        }
        else {
            $strEmail = trim($_POST['strEmail']);
        } 	
        
        // sanitize
        if (!get_magic_quotes_gpc()) { 
           return array(
             'strName' => addslashes($_POST['strName']),
             'strFirstname' => addslashes($_POST['strFirstname']),
             'strEmail' => addslashes($strEmail),
             'booAllowOther' => $booAllowOther,
             'booUseShare' => $booUseShare
           );  
        } else { 
           return array(
             'strName' => $_POST['strName'],
             'strFirstname' => $_POST['strFirstname'],
             'strEmail' => $strEmail,
             'booAllowOther' => $booAllowOther,
             'booUseShare' => $booUseShare
           ); 
        }     
    }
    
    /**
     * New account
     */    
    function add() {
        global $db;
        
        $arrInput = $this->checkInput();
        
        $strUserId = trim($_POST['strUserId']);
        $strPassword = trim($_POST['strPassword']);
        
        if (($strUserId == '') || ($strPassword == '')) {
            raiseError(STR_NO_IDPASS_SILLAJ);
        }
        
        $arrUser = $db->query("
          INSERT INTO sillaj_user
            (strUserId, strName, strFirstname, strEmail, strPassword, booActive, 
            booAllowOther, booUseShare, strLanguage, strTemplate)
          VALUES (
            '". $_POST['strUserId'] ."',
            '". $arrInput['strName'] ."',
            '". $arrInput['strFirstname'] ."',
            '". $arrInput['strEmail'] ."',
            MD5('".$_POST['strPassword']."'),
            '1',
            '". $arrInput['booAllowOther'] ."',
            '". $arrInput['booUseShare'] ."',
            '". $_POST['strLanguage'] ."',
            '". $_POST['strTemplate'] ."'
          )"
        );
        
        if (DB::isError($arrUser)) {
            raiseError($arrUser->getMessage());
        }
        return STR_ACCOUNT_CREATED_SILLAJ;
    }
    
    /**
     *  Account modif
     */
    function set() {
        global $db;
        
        $arrInput = $this->checkInput();
        
        $strUpdatePassword = '';
        if ($_POST['strPassword'] != '') {
            $strUpdatePassword = ", strPassword = MD5('". $_POST['strPassword'] ."')";
        }

        $arrUser = $db->query("
          UPDATE sillaj_user
          SET
            strName = '". $arrInput['strName'] ."',
            strFirstname = '". $arrInput['strFirstname'] ."',
            strEmail = '". $arrInput['strEmail'] ."'
            $strUpdatePassword,
            booAllowOther = '". $arrInput['booAllowOther'] ."',
            booUseShare = '". $arrInput['booUseShare'] ."',
            strLanguage = '". $_POST['strLanguage'] ."',
            strTemplate = '". $_POST['strTemplate'] ."'
          WHERE
            (strUserId = '". $_SESSION['strUserId'] ."')"
        );
        
        if (DB::isError($arrUser)) {
            raiseError($arrUser->getMessage());
        }
        
        $_SESSION[      'strName'] = $arrInput['strName'];
        $_SESSION[ 'strFirstname'] = $arrInput['strFirstname'];
        $_SESSION[     'strEmail'] = $arrInput['strEmail'];
        $_SESSION['booAllowOther'] = $arrInput['booAllowOther'];
        $_SESSION[  'booUseShare'] = $arrInput['booUseShare'];
        
        $sillaj = new Sillaj;
        if (in_array($_POST['strLanguage'], $sillaj->getLanguage())) {
            $_SESSION['strLocale'] =  $_POST['strLanguage'];
        }
        
        if (in_array($_POST['strTemplate'], $sillaj->getTemplate())) {
            $_SESSION['strThemeName'] = $_POST['strTemplate'];
        }
        
        return STR_ACCOUNT_MODIFIED_SILLAJ;
    }
    
    /**
     * Valid email
     */
    function validEmail($strEmail) {
        // http://www.iki.fi/markus.sipila/pub/emailvalidator.php
        if (!eregi("^[a-z0-9,!#\$%&'\*\+/=\?\^_`\{\|}~-]+(\.[a-z0-9,!#\$%&'\*\+/=\?\^_`\{\|}~-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*\.([a-z]{2,})$", $strEmail)) {
            raiseError(STR_MAIL_INVALID_ADDRESS_SILLAJ .' : '. htmlspecialchars($strEmail));
        }	
        return true;
    }
    
    /** 
     * Check email
     */
    function checkEmail($strEmail) {
        global $db;
        
        $strEmail = trim($strEmail);
        
        $this->validEmail($strEmail);
        
        $intRes = $db->getOne("
          SELECT            
            COUNT(strEmail)       
          FROM sillaj_user 
          WHERE strEmail = '$strEmail'
          GROUP BY strEmail          
        ");

        if (DB::isError($intRes)) {
            raiseError($intRes->getMessage());
        }
        if ($intRes == 0) {
            raiseError(STR_MAIL_ADDRESS_NOT_FOUND_SILLAJ .' : '. htmlspecialchars($_POST['strEmail']));
        }
    }
    
    /** 
     * Reset password (before sending an email when "password forgotten")
     */
    function resetPassword($strEmail, $booCommitNow = true) {
        global $db;
        
        $strNewPassword = Sillaj::getRandom();

        $strEmail = trim($strEmail);
        
        // Update accounts (note : several accounts can have the same email address)
        $db->query('BEGIN');
        $intRes = $db->query("
          UPDATE sillaj_user 
          SET strPassword = MD5('$strNewPassword')
          WHERE strEmail = '$strEmail'
        ");
        
        if (DB::isError($intRes)) {
            $db->query('ROLLBACK');
            raiseError($intRes->getMessage());
        }
        
        // Select updated accounts (to mail new account information) 
        // this result will be returned at the end of the function,
        // to be inserted in the email (if $booCommitNow == false)
        $intRes = $db->getAll("
          SELECT
            strUserId,
            '$strNewPassword' AS strPassword
          FROM
            sillaj_user           
          WHERE strEmail = '$strEmail'
        ");
        
        if (DB::isError($intRes)) {
            $db->query('ROLLBACK');
            raiseError($intRes->getMessage());
        }
        
        if ($booCommitNow) {
            $db->query('COMMIT');
        }

        return $intRes;    
    }
    
    /** 
     * Destroy the session
     */
    function logout() {
        session_destroy();
        header('Location: ' . URL_ROOT_DIR_SILLAJ);
        exit();
    }
    
} // end class Authent

/******************************************************************************/
/**
 * Get the last id inserted in the database ; we don't use PEAR DB::lastId() (?)
 * because on MySQL it adds a table in the database to track the id. Not
 * very clean (and possible user rights pb ?). Our solution is maybe not very portable though...
 * (should work in MySQL, Sybase, SQL Server (?)...)
 */
class DBSillaj extends DB {
    
    function lastId() {
        global $db;
        
        $intMax = $db->GetOne("SELECT @@IDENTITY");
        if (DB::isError($intMax)) {
            raiseError($intMax->getMessage());
        }

        return $intMax;
    }
    
} // end class DBSillaj

/******************************************************************************/
/**
 * Utilities for the application
 */
class Sillaj {
    /**
     * list available languages
     */
    function getLanguage($booWithFullName = false) {  
        global $arrLanguageNameLookup;
          
        $arrLanguage = $this->listDir(FN_ROOT_DIR_SILLAJ . 'lang/');
        
        if ($booWithFullName) {
            $arrLanguageFullName = array();
            foreach($arrLanguage as $l) {
                $arrLanguageFullName[$l] = isset($arrLanguageNameLookup[$l]) ? $arrLanguageNameLookup[$l] : $l;
                
            }
            asort($arrLanguageFullName, SORT_STRING);            
            return $arrLanguageFullName;  
        }
        else {
            return $arrLanguage;
        }
    }
    
    /**
     * list available templates
     */
    function getTemplate() {
        return $this->listDir(FN_ROOT_DIR_SILLAJ . 'templates/');        
    }
    
    /**
     * list available themes (CSS) for the current template
     * ignoring the compulsory themes (default.css and print.css and calendar.css)
     */
    function getCss() {
        // search CSS files in current template dir
        $tmp = $this->listFile(FN_ROOT_DIR_SILLAJ . 'templates/' . $_SESSION['strThemeName'] . '/styles/', 'css');
        
        // prune system files
        $arrCss = array(); 
        foreach ($tmp as $strCss) {
            if (!in_array($strCss, array('default.css', 'print.css', 'calendar.css'))) {
                $arrCss[] = array('fnCss' => $strCss, 'strNameCss' => substr($strCss, 0, -4));
            }
        }   
        return $arrCss;     
    }
    
    /**
     * list subdirectories of a directory
     */
    function listDir($fnDir) {
        $arrDir = array();
        
        if (is_dir($fnDir)) {
            if ($hdl = opendir($fnDir)) {        
                while (($file = readdir($hdl)) !== false) {
                    // skip system dir and files and hidden dir (ex : .svn)                              
                    if ((substr($file, 0, 1) != '.') && is_dir($fnDir . $file)) {                   
                        $arrDir[] = $file;           
                    }      
                }
                closedir($hdl);
            }            
        }
        return $arrDir ;
    }
    
    /**
     * list files in a directory
     */
    function listFile($fnDir, $strExt = '') {
        $arrFile = array();
        
        if (is_dir($fnDir)) {
            if ($hdl = opendir($fnDir)) {        
                while (($file = readdir($hdl)) !== false) {           
                    if ($file != '.' && $file != '..' && !is_dir($fnDir . $file)) {   
                        if (($strExt == '') || preg_match("/\.". $strExt ."$/i", $file)) {            
                            $arrFile[] = $file;
                        }                           
                    }      
                }
                closedir($hdl);
            }            
        }
        return $arrFile ;
    }
    
    /**
     * Generate a random 7 character string used for new password and authent (nonce)
     */         
    function getRandom() {        
        $strBase = 'abchefghjkmnpqrstuvwxyz0123456789';
        srand((double) microtime() * 1000000); 
        $i = 0;
        $strRandom = '';
        while ($i <= 7) {
            $intPos = rand() % 33;
            $tmp = substr($strBase, $intPos, 1);
            $strRandom = $strRandom . $tmp;
            $i++;
        }        
        return $strRandom;    
    }
    
} // end class Sillaj
?>
