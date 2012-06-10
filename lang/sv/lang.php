<?php
// Swedish translation 2006-01-17 18:18 
// Thanks to janson.peter @ gmail.com

define('STR_PHP_LOCALE_WIN_SILLAJ', 'sve');
define('STR_PHP_LOCALE_NIX_SILLAJ', 'sv_SE');

// global
define(             'STR_ERROR_TITLE_SILLAJ', 'Fel');
define('STR_EDIT_ACCOUNT_NOT_ALLOWED_SILLAJ', '�ndring av konto f�rbjuden');
define(           'STR_MESSAGE_TITLE_SILLAJ', 'Information');
define(                 'STR_PROJECT_SILLAJ', 'Projekt');
define(                    'STR_TASK_SILLAJ', 'Uppgift');
define(          'STR_GRAPH_DISABLED_SILLAJ', 'Grafer inte p�slagna (se config.php)');
// Menu
$arrMenu = array(
               'index.php' => array('strMenu' => 'Min tid',   'strTip' => 'Editera h�ndelser', 'booDisplay' => true),    
             'project.php' => array('strMenu' => 'Projekt',   'strTip' => 'Editera projekt', 'booDisplay' => true),
                'task.php' => array('strMenu' => 'Uppgifter', 'strTip' => 'Editera uppgifter', 'booDisplay' => true),
              'report.php' => array('strMenu' => 'Rapporter', 'strTip' => 'Rapporter', 'booDisplay' => true),    
                'user.php' => array('strMenu' => 'Anv�ndare', 'strTip' => 'Anv�ndarinformation', 'booDisplay' => true),
              'logout.php' => array('strMenu' => 'Logga ut',  'strTip' => 'Avsluta', 'booDisplay' => true),
               'event.php' => array('strMenu' => 'H�ndelser', 'strTip' => '', 'booDisplay' => false), // virtual menu
              'search.php' => array('strMenu' => 'S�k',       'strTip' => '', 'booDisplay' => false),  // virtual menu
               'gantt.php' => array('strMenu' => 'Gantt',     'strTip' => '', 'booDisplay' => false),  // menu virtuel "              
                'tool.php' => array('strMenu' => 'Verktyg',   'strTip' => '', 'booDisplay' => false)// virtual menu
           );                                                   

// index
define(    'STR_CALENDAR_SILLAJ', 'Kalender');
define(    'STR_NEXT_DAY_SILLAJ', 'N�sta dag');
define(    'STR_PREV_DAY_SILLAJ', 'F�reg�ende dag');
define(  'STR_NEXT_MONTH_SILLAJ', 'N�sta m�nad');
define(  'STR_PREV_MONTH_SILLAJ', 'F�reg�ende m�nad');
define(    'STR_BAD_DATE_SILLAJ', 'Ogiltigt datum');
define(       'STR_EVENT_SILLAJ', 'h�ndelse');
define(      'STR_EVENTS_SILLAJ', 'h�ndelser');
           
// login
define(  'STR_LOGIN_PAGE_TITLE_SILLAJ', 'Login');
define(          'STR_NO_LOGIN_SILLAJ', 'Login-id saknas');
define(       'STR_NO_PASSWORD_SILLAJ', 'L�senord saknas');
define( 'STR_NO_RESPONSE_LOGIN_SILLAJ', 'No encrypted password found in your request ; you probably must enable javascript');

// class Project
define(         'STR_PROJECT_CREATED_SILLAJ', 'Projekt skapat');
define(        'STR_PROJECT_MODIFIED_SILLAJ', 'Projekt modifierat');
define(         'STR_PROJECT_DELETED_SILLAJ', 'Projekt raderat');
define('STR_PROJECT_EDIT_NOT_ALLOWED_SILLAJ', 'Du har inte tillst�nd att modifiera/accessa detta projekt');
define(       'STR_PROJECT_NOT_FOUND_SILLAJ', 'Inget projekt hittat');
define(         'STR_NO_PROJECT_NAME_SILLAJ', 'Inget projektnamn');

// class Task
define(         'STR_TASK_CREATED_SILLAJ', 'Uppgift skapad');
define(        'STR_TASK_MODIFIED_SILLAJ', 'Uppgift modifierad');
define(         'STR_TASK_DELETED_SILLAJ', 'Uppgift raderad');
define('STR_TASK_EDIT_NOT_ALLOWED_SILLAJ', 'Du har inte tillst�nd att modifiera/accessa denna uppgift');
define(       'STR_TASK_NOT_FOUND_SILLAJ', 'Ingen uppgift hittad');
define(         'STR_NO_TASK_NAME_SILLAJ', 'Ingen uppgiftsnamn');

// class Authent
define(        'STR_NO_AUTHENT_SILLAJ', 'Kunda inte validera anv�ndare. Kolla login-id och l�senord');
define('STR_UNEXPECTED_AUTHENT_SILLAJ', "Valideringsproblem");

// class User
define(   'STR_ACCOUNT_CREATED_SILLAJ', 'Konto skapat');
define(  'STR_ACCOUNT_MODIFIED_SILLAJ', 'Konto modifierat');
define(         'STR_NO_IDPASS_SILLAJ', 'Du m�ste ange ett login-id och ett l�senord f�r att registrera dig');
define(     'STR_MISSING_EMAIL_SILLAJ', 'Du m�ste ange en giltig email-adress');

// class Event
define(         'STR_EVENT_CREATED_SILLAJ', 'H�ndelse skapd');
define(   'STR_EVENT_CREATED_2DAYS_SILLAJ', '(on two days)');
define(      'STR_NO_TASK_SELECTED_SILLAJ', 'Ingen uppgift vald');
define(   'STR_NO_PROJECT_SELECTED_SILLAJ', 'Inget projekt valt');
define(         'STR_NO_TIME_INPUT_SILLAJ', 'Ingen l�ngd angiven');
define(         'STR_EVENT_DELETED_SILLAJ', 'H�ndelse raderad');
define(        'STR_EVENT_MODIFIED_SILLAJ', 'H�ndelse modifierad');
define('STR_EVENT_EDIT_NOT_ALLOWED_SILLAJ', 'Kunde inte modifiera denna h�ndelse');
define(       'STR_EVENT_NOT_FOUND_SILLAJ', 'H�ndelse kunde inte hittas eller modifieras');
define(     'STR_NO_EVENT_SELECTED_SILLAJ', 'Ingen h�ndelse vald');
define(      'STR_NO_DATE_SELECTED_SILLAJ', 'Inget datum valt');
define(        'STR_BAD_TIME_INPUT_SILLAJ', 'Slut f�re start');
define(        'STR_BAD_TIME_VALUE_SILLAJ', 'Tid skall vara numerisk');
define('STR_PROJECTTASK_EVENT_NOT_FOUND_SILLAJ', 'Inget projekt eller uppgift');
define(     'STR_KEYWORD_NOT_FOUND_SILLAJ', 'Nyckelord saknas');

//class Report
define(     'STR_ERROR_MISSING_DATE_SILLAJ', STR_NO_DATE_SELECTED_SILLAJ);
define(     'STR_ERROR_MISSING_USER_SILLAJ', 'Anv�ndare saknas');
define( 'STR_ERROR_USER_NOT_ALLOWED_SILLAJ', 'Anv�ndare har inte till�telse');
define(        'STR_BAD_DATE_FORMAT_SILLAJ', 'Felaktigt datumformat i config.php');

// Mail
define(   'STR_MAIL_INVALID_ADDRESS_SILLAJ', 'Ogiltigt email-adress');
define( 'STR_MAIL_ADDRESS_NOT_FOUND_SILLAJ', 'Email-adress kunde inte hittas i anv�ndarlistan');
define(           'STR_MAIL_SUBJECT_SILLAJ', 'Ditt l�senord');
define(              'STR_MAIL_BODY_SILLAJ', 'Ditt l�senord har nollst�llts\nLogin : %s\nL�senord : %s');
define(             'STR_MAIL_ERROR_SILLAJ', 'Mailer error :');
define(           'STR_MAIL_SUCCESS_SILLAJ', 'Meddelande har skickats till');
define(        'STR_MAIL_PAGE_TITLE_SILLAJ', 'Skickar l�senord');

// Gantt
define(   'STR_GANTT_CSIM_ALT_TASK_SILLAJ', 'Visa Gantt-graf f�r denna uppgift');
define('STR_GANTT_CSIM_ALT_PROJECT_SILLAJ', 'Visa Gantt-graf f�r detta projekt');
?>
