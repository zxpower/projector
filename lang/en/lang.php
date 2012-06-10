<?php
// English translation 2006-01-17 18:18 
define('STR_PHP_LOCALE_WIN_SILLAJ', 'en');
define('STR_PHP_LOCALE_NIX_SILLAJ', 'en_EN');

// global
define(             'STR_ERROR_TITLE_SILLAJ', 'Error');
define('STR_EDIT_ACCOUNT_NOT_ALLOWED_SILLAJ', 'Account modification forbidden');
define(           'STR_MESSAGE_TITLE_SILLAJ', 'Information');
define(                  'STR_PROJECT_SILLAJ', 'Project');
define(                     'STR_TASK_SILLAJ', 'Task');
define(           'STR_GRAPH_DISABLED_SILLAJ', 'Graph not enabled (see config.php)');
// Menu
$arrMenu = array(
               'index.php' => array('strMenu' => 'My time',  'strTip' => 'Events edition', 'booDisplay' => true),    
             'project.php' => array('strMenu' => 'Projects', 'strTip' => 'Projects edition', 'booDisplay' => true),
                'task.php' => array('strMenu' => 'Tasks',    'strTip' => 'Tasks edition', 'booDisplay' => true),
              'report.php' => array('strMenu' => 'Reports',  'strTip' => 'Reports', 'booDisplay' => true),    
                'user.php' => array('strMenu' => 'User',     'strTip' => 'User informations', 'booDisplay' => true),
              'logout.php' => array('strMenu' => 'Logout',   'strTip' => 'Quit', 'booDisplay' => true),
               'event.php' => array('strMenu' => 'Events',   'strTip' => '', 'booDisplay' => false), // virtual menu
              'search.php' => array('strMenu' => 'Search',   'strTip' => '', 'booDisplay' => false),  // virtual menu
               'gantt.php' => array('strMenu' => 'Gantt chart',        'strTip' => '', 'booDisplay' => false),  // menu virtuel "
                'tool.php' => array('strMenu' => 'Tools',    'strTip' => '', 'booDisplay' => false)// virtual menu
           );                                                   

// index
define(    'STR_CALENDAR_SILLAJ', 'Calendar');
define(    'STR_NEXT_DAY_SILLAJ', 'Next day');
define(    'STR_PREV_DAY_SILLAJ', 'Previous Day');
define(  'STR_NEXT_MONTH_SILLAJ', 'Next month');
define(  'STR_PREV_MONTH_SILLAJ', 'Previous month');
define(    'STR_BAD_DATE_SILLAJ', 'Invalid date');
define(       'STR_EVENT_SILLAJ', 'event');
define(      'STR_EVENTS_SILLAJ', 'events');
           
// login
define(  'STR_LOGIN_PAGE_TITLE_SILLAJ', 'Login');
define(          'STR_NO_LOGIN_SILLAJ', 'Login missing');
define(       'STR_NO_PASSWORD_SILLAJ', 'Password missing');
define( 'STR_NO_RESPONSE_LOGIN_SILLAJ', 'No encrypted password found in your request ; you probably must enable javascript');

// class Project
define(         'STR_PROJECT_CREATED_SILLAJ', 'Project created');
define(        'STR_PROJECT_MODIFIED_SILLAJ', 'Projet edited');
define(         'STR_PROJECT_DELETED_SILLAJ', 'Project deleted');
define('STR_PROJECT_EDIT_NOT_ALLOWED_SILLAJ', 'Not allowed to edit/access this project');
define(       'STR_PROJECT_NOT_FOUND_SILLAJ', 'No project found');
define(         'STR_NO_PROJECT_NAME_SILLAJ', 'No project name');

// class Task
define(         'STR_TASK_CREATED_SILLAJ', 'Task created');
define(        'STR_TASK_MODIFIED_SILLAJ', 'Task edited');
define(         'STR_TASK_DELETED_SILLAJ', 'Task deleted');
define('STR_TASK_EDIT_NOT_ALLOWED_SILLAJ', 'Not allowed to edit/access this task');
define(       'STR_TASK_NOT_FOUND_SILLAJ', 'No task found');
define(         'STR_NO_TASK_NAME_SILLAJ', 'No task name');

// class Authent
define(        'STR_NO_AUTHENT_SILLAJ', 'Unable to authenticate. Check login and password');
define('STR_UNEXPECTED_AUTHENT_SILLAJ', "Authentication problem");

// class User
define(   'STR_ACCOUNT_CREATED_SILLAJ', 'Account created');
define(  'STR_ACCOUNT_MODIFIED_SILLAJ', 'Account edited');
define(         'STR_NO_IDPASS_SILLAJ', 'You must provide a login and a password to register');
define(     'STR_MISSING_EMAIL_SILLAJ', 'You must provide a valid email address');

// class Event
define(         'STR_EVENT_CREATED_SILLAJ', 'Event created');
define(   'STR_EVENT_CREATED_2DAYS_SILLAJ', '(on two days)');
define(      'STR_NO_TASK_SELECTED_SILLAJ', 'No task selected');
define(   'STR_NO_PROJECT_SELECTED_SILLAJ', 'No project selected');
define(         'STR_NO_TIME_INPUT_SILLAJ', 'No duration input');
define(         'STR_EVENT_DELETED_SILLAJ', 'Event deleted');
define(        'STR_EVENT_MODIFIED_SILLAJ', 'Event edited');
define('STR_EVENT_EDIT_NOT_ALLOWED_SILLAJ', 'Unable to edit this event');
define(       'STR_EVENT_NOT_FOUND_SILLAJ', 'Event not found or not editable');
define(     'STR_NO_EVENT_SELECTED_SILLAJ', 'No event selected');
define(      'STR_NO_DATE_SELECTED_SILLAJ', 'No date selected');
define(        'STR_BAD_TIME_INPUT_SILLAJ', 'End before start');
define(        'STR_BAD_TIME_VALUE_SILLAJ', 'Time should be numeric');
define('STR_PROJECTTASK_EVENT_NOT_FOUND_SILLAJ', 'No project or task');
define(     'STR_KEYWORD_NOT_FOUND_SILLAJ', 'Missing keyword');

//class Report
define(     'STR_ERROR_MISSING_DATE_SILLAJ', STR_NO_DATE_SELECTED_SILLAJ);
define(     'STR_ERROR_MISSING_USER_SILLAJ', 'Missing user');
define( 'STR_ERROR_USER_NOT_ALLOWED_SILLAJ', 'User not allowed');
define(        'STR_BAD_DATE_FORMAT_SILLAJ', 'Bad date format in config.php');

// Mail
define(   'STR_MAIL_INVALID_ADDRESS_SILLAJ', 'Invalid email address');
define( 'STR_MAIL_ADDRESS_NOT_FOUND_SILLAJ', 'Email address not found in the user list');
define(           'STR_MAIL_SUBJECT_SILLAJ', 'Your password');
define(              'STR_MAIL_BODY_SILLAJ', 'Your password has been reset\nLogin : %s\nPassword : %s');
define(             'STR_MAIL_ERROR_SILLAJ', 'Mailer error :');
define(           'STR_MAIL_SUCCESS_SILLAJ', 'Message has been sent to');
define(        'STR_MAIL_PAGE_TITLE_SILLAJ', 'Sending password');

// Gantt
define(   'STR_GANTT_CSIM_ALT_TASK_SILLAJ', 'Show the Gantt graph for this task');
define('STR_GANTT_CSIM_ALT_PROJECT_SILLAJ', 'Show the Gantt graph for this project');
?>
