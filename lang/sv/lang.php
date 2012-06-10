<?php
// Swedish translation 2006-01-17 18:18 
// Thanks to janson.peter @ gmail.com

define('STR_PHP_LOCALE_WIN_SILLAJ', 'sve');
define('STR_PHP_LOCALE_NIX_SILLAJ', 'sv_SE');

// global
define(             'STR_ERROR_TITLE_SILLAJ', 'Fel');
define('STR_EDIT_ACCOUNT_NOT_ALLOWED_SILLAJ', 'Ändring av konto förbjuden');
define(           'STR_MESSAGE_TITLE_SILLAJ', 'Information');
define(                 'STR_PROJECT_SILLAJ', 'Projekt');
define(                    'STR_TASK_SILLAJ', 'Uppgift');
define(          'STR_GRAPH_DISABLED_SILLAJ', 'Grafer inte påslagna (se config.php)');
// Menu
$arrMenu = array(
               'index.php' => array('strMenu' => 'Min tid',   'strTip' => 'Editera händelser', 'booDisplay' => true),    
             'project.php' => array('strMenu' => 'Projekt',   'strTip' => 'Editera projekt', 'booDisplay' => true),
                'task.php' => array('strMenu' => 'Uppgifter', 'strTip' => 'Editera uppgifter', 'booDisplay' => true),
              'report.php' => array('strMenu' => 'Rapporter', 'strTip' => 'Rapporter', 'booDisplay' => true),    
                'user.php' => array('strMenu' => 'Användare', 'strTip' => 'Användarinformation', 'booDisplay' => true),
              'logout.php' => array('strMenu' => 'Logga ut',  'strTip' => 'Avsluta', 'booDisplay' => true),
               'event.php' => array('strMenu' => 'Händelser', 'strTip' => '', 'booDisplay' => false), // virtual menu
              'search.php' => array('strMenu' => 'Sök',       'strTip' => '', 'booDisplay' => false),  // virtual menu
               'gantt.php' => array('strMenu' => 'Gantt',     'strTip' => '', 'booDisplay' => false),  // menu virtuel "              
                'tool.php' => array('strMenu' => 'Verktyg',   'strTip' => '', 'booDisplay' => false)// virtual menu
           );                                                   

// index
define(    'STR_CALENDAR_SILLAJ', 'Kalender');
define(    'STR_NEXT_DAY_SILLAJ', 'Nästa dag');
define(    'STR_PREV_DAY_SILLAJ', 'Föregående dag');
define(  'STR_NEXT_MONTH_SILLAJ', 'Nästa månad');
define(  'STR_PREV_MONTH_SILLAJ', 'Föregående månad');
define(    'STR_BAD_DATE_SILLAJ', 'Ogiltigt datum');
define(       'STR_EVENT_SILLAJ', 'händelse');
define(      'STR_EVENTS_SILLAJ', 'händelser');
           
// login
define(  'STR_LOGIN_PAGE_TITLE_SILLAJ', 'Login');
define(          'STR_NO_LOGIN_SILLAJ', 'Login-id saknas');
define(       'STR_NO_PASSWORD_SILLAJ', 'Lösenord saknas');
define( 'STR_NO_RESPONSE_LOGIN_SILLAJ', 'No encrypted password found in your request ; you probably must enable javascript');

// class Project
define(         'STR_PROJECT_CREATED_SILLAJ', 'Projekt skapat');
define(        'STR_PROJECT_MODIFIED_SILLAJ', 'Projekt modifierat');
define(         'STR_PROJECT_DELETED_SILLAJ', 'Projekt raderat');
define('STR_PROJECT_EDIT_NOT_ALLOWED_SILLAJ', 'Du har inte tillstånd att modifiera/accessa detta projekt');
define(       'STR_PROJECT_NOT_FOUND_SILLAJ', 'Inget projekt hittat');
define(         'STR_NO_PROJECT_NAME_SILLAJ', 'Inget projektnamn');

// class Task
define(         'STR_TASK_CREATED_SILLAJ', 'Uppgift skapad');
define(        'STR_TASK_MODIFIED_SILLAJ', 'Uppgift modifierad');
define(         'STR_TASK_DELETED_SILLAJ', 'Uppgift raderad');
define('STR_TASK_EDIT_NOT_ALLOWED_SILLAJ', 'Du har inte tillstånd att modifiera/accessa denna uppgift');
define(       'STR_TASK_NOT_FOUND_SILLAJ', 'Ingen uppgift hittad');
define(         'STR_NO_TASK_NAME_SILLAJ', 'Ingen uppgiftsnamn');

// class Authent
define(        'STR_NO_AUTHENT_SILLAJ', 'Kunda inte validera användare. Kolla login-id och lösenord');
define('STR_UNEXPECTED_AUTHENT_SILLAJ', "Valideringsproblem");

// class User
define(   'STR_ACCOUNT_CREATED_SILLAJ', 'Konto skapat');
define(  'STR_ACCOUNT_MODIFIED_SILLAJ', 'Konto modifierat');
define(         'STR_NO_IDPASS_SILLAJ', 'Du måste ange ett login-id och ett lösenord för att registrera dig');
define(     'STR_MISSING_EMAIL_SILLAJ', 'Du måste ange en giltig email-adress');

// class Event
define(         'STR_EVENT_CREATED_SILLAJ', 'Händelse skapd');
define(   'STR_EVENT_CREATED_2DAYS_SILLAJ', '(on two days)');
define(      'STR_NO_TASK_SELECTED_SILLAJ', 'Ingen uppgift vald');
define(   'STR_NO_PROJECT_SELECTED_SILLAJ', 'Inget projekt valt');
define(         'STR_NO_TIME_INPUT_SILLAJ', 'Ingen längd angiven');
define(         'STR_EVENT_DELETED_SILLAJ', 'Händelse raderad');
define(        'STR_EVENT_MODIFIED_SILLAJ', 'Händelse modifierad');
define('STR_EVENT_EDIT_NOT_ALLOWED_SILLAJ', 'Kunde inte modifiera denna händelse');
define(       'STR_EVENT_NOT_FOUND_SILLAJ', 'Händelse kunde inte hittas eller modifieras');
define(     'STR_NO_EVENT_SELECTED_SILLAJ', 'Ingen händelse vald');
define(      'STR_NO_DATE_SELECTED_SILLAJ', 'Inget datum valt');
define(        'STR_BAD_TIME_INPUT_SILLAJ', 'Slut före start');
define(        'STR_BAD_TIME_VALUE_SILLAJ', 'Tid skall vara numerisk');
define('STR_PROJECTTASK_EVENT_NOT_FOUND_SILLAJ', 'Inget projekt eller uppgift');
define(     'STR_KEYWORD_NOT_FOUND_SILLAJ', 'Nyckelord saknas');

//class Report
define(     'STR_ERROR_MISSING_DATE_SILLAJ', STR_NO_DATE_SELECTED_SILLAJ);
define(     'STR_ERROR_MISSING_USER_SILLAJ', 'Användare saknas');
define( 'STR_ERROR_USER_NOT_ALLOWED_SILLAJ', 'Användare har inte tillåtelse');
define(        'STR_BAD_DATE_FORMAT_SILLAJ', 'Felaktigt datumformat i config.php');

// Mail
define(   'STR_MAIL_INVALID_ADDRESS_SILLAJ', 'Ogiltigt email-adress');
define( 'STR_MAIL_ADDRESS_NOT_FOUND_SILLAJ', 'Email-adress kunde inte hittas i användarlistan');
define(           'STR_MAIL_SUBJECT_SILLAJ', 'Ditt lösenord');
define(              'STR_MAIL_BODY_SILLAJ', 'Ditt lösenord har nollställts\nLogin : %s\nLösenord : %s');
define(             'STR_MAIL_ERROR_SILLAJ', 'Mailer error :');
define(           'STR_MAIL_SUCCESS_SILLAJ', 'Meddelande har skickats till');
define(        'STR_MAIL_PAGE_TITLE_SILLAJ', 'Skickar lösenord');

// Gantt
define(   'STR_GANTT_CSIM_ALT_TASK_SILLAJ', 'Visa Gantt-graf för denna uppgift');
define('STR_GANTT_CSIM_ALT_PROJECT_SILLAJ', 'Visa Gantt-graf för detta projekt');
?>
