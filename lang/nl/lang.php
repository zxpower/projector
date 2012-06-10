<?php
// Dutch translation 2007-09-08 21:00
// Thanks to bert.fransen @ sygma.nl

define('STR_PHP_LOCALE_WIN_SILLAJ', 'nl');
define('STR_PHP_LOCALE_NIX_SILLAJ', 'nl_NL');

// global
define(             'STR_ERROR_TITLE_SILLAJ', 'Error');
define('STR_EDIT_ACCOUNT_NOT_ALLOWED_SILLAJ', 'Wijziging account verboden');
define(           'STR_MESSAGE_TITLE_SILLAJ', 'Informatie');
define(                  'STR_PROJECT_SILLAJ', 'Project');
define(                     'STR_TASK_SILLAJ', 'Activiteit');
define(           'STR_GRAPH_DISABLED_SILLAJ', 'Planning niet geactiveerd (zie config.php)');
// Menu
$arrMenu = array(
               'index.php' => array('strMenu' => 'Mijn tijd',  'strTip' => 'Events edition', 'booDisplay' => true),    
             'project.php' => array('strMenu' => 'Projecten', 'strTip' => 'Projects edition', 'booDisplay' => true),
                'task.php' => array('strMenu' => 'Activiteiten',    'strTip' => 'Tasks edition', 'booDisplay' => true),
              'report.php' => array('strMenu' => 'Rapporten',  'strTip' => 'Reports', 'booDisplay' => true),    
                'user.php' => array('strMenu' => 'Gebruiker',     'strTip' => 'User informations', 'booDisplay' => true),
              'logout.php' => array('strMenu' => 'Log uit',   'strTip' => 'Quit', 'booDisplay' => true),
               'event.php' => array('strMenu' => 'Werkzaamheden',   'strTip' => '', 'booDisplay' => false), // virtual menu
              'search.php' => array('strMenu' => 'Zoeken',   'strTip' => '', 'booDisplay' => false),  // virtual menu
               'gantt.php' => array('strMenu' => 'Planning',        'strTip' => '', 'booDisplay' => false),  // menu virtuel "
                'tool.php' => array('strMenu' => 'Tools',    'strTip' => '', 'booDisplay' => false)// virtual menu
           );                                                   

// index
define(    'STR_CALENDAR_SILLAJ', 'Kalender');
define(    'STR_NEXT_DAY_SILLAJ', 'Morgen');
define(    'STR_PREV_DAY_SILLAJ', 'Gisteren');
define(  'STR_NEXT_MONTH_SILLAJ', 'Volgende maand');
define(  'STR_PREV_MONTH_SILLAJ', 'Vorige maand');
define(    'STR_BAD_DATE_SILLAJ', 'Ongeldige datum');
define(       'STR_EVENT_SILLAJ', 'activiteit');
define(      'STR_EVENTS_SILLAJ', 'activiteiten');
           
// login
define(  'STR_LOGIN_PAGE_TITLE_SILLAJ', 'Log in');
define(          'STR_NO_LOGIN_SILLAJ', 'Log in ontbreekt');
define(       'STR_NO_PASSWORD_SILLAJ', 'Wachtwoord ontbreekt');

// class Project
define(         'STR_PROJECT_CREATED_SILLAJ', 'Project vastgelegd');
define(        'STR_PROJECT_MODIFIED_SILLAJ', 'Projet gewijzigd');
define(         'STR_PROJECT_DELETED_SILLAJ', 'Project verwijderd');
define('STR_PROJECT_EDIT_NOT_ALLOWED_SILLAJ', 'Niet toegestaan dit project te wijzigen/openen');
define(       'STR_PROJECT_NOT_FOUND_SILLAJ', 'Geen project gevonden');
define(         'STR_NO_PROJECT_NAME_SILLAJ', 'Geen projectnaam');

// class Task
define(         'STR_TASK_CREATED_SILLAJ', 'Activiteit vastgelegd');
define(        'STR_TASK_MODIFIED_SILLAJ', 'Activiteit gewijzigd');
define(         'STR_TASK_DELETED_SILLAJ', 'Activiteit verwijderd');
define('STR_TASK_EDIT_NOT_ALLOWED_SILLAJ', 'Niet toegestaan deze activiteit te wijzigen/openen');
define(       'STR_TASK_NOT_FOUND_SILLAJ', 'Geen activiteit gevonden');
define(         'STR_NO_TASK_NAME_SILLAJ', 'Geen activiteitnaam');

// class Authent
define(        'STR_NO_AUTHENT_SILLAJ', 'Verificatie mislukt. Controleer login en wachtwoord');
define('STR_UNEXPECTED_AUTHENT_SILLAJ', "Verificatie probleem");

// class User
define(   'STR_ACCOUNT_CREATED_SILLAJ', 'Account vastgelegd');
define(  'STR_ACCOUNT_MODIFIED_SILLAJ', 'Account gewijzigd');
define(         'STR_NO_IDPASS_SILLAJ', 'U moet een login en wachtwoord verstrekken om te registreren');
define(     'STR_MISSING_EMAIL_SILLAJ', 'U moet een geldig emailadres verstrekken');

// class Event
define(         'STR_EVENT_CREATED_SILLAJ', 'Werkzaamheden vastgelegd');
define(      'STR_NO_TASK_SELECTED_SILLAJ', 'Geen activiteit geselecteerd');
define(   'STR_NO_PROJECT_SELECTED_SILLAJ', 'Geen project geselecteerd');
define(         'STR_NO_TIME_INPUT_SILLAJ', 'Geen tijdspanne ingevuld');
define(         'STR_EVENT_DELETED_SILLAJ', 'Werkzaamheden verwijderd');
define(        'STR_EVENT_MODIFIED_SILLAJ', 'Werkzaamheden gewijzigd');
define('STR_EVENT_EDIT_NOT_ALLOWED_SILLAJ', 'Niet in staat deze werkzaamheden te wijzigen');
define(       'STR_EVENT_NOT_FOUND_SILLAJ', 'Werkzaamheden niet gevonden of niet te wijzigen');
define(     'STR_NO_EVENT_SELECTED_SILLAJ', 'Geen activiteit geselecteerd');
define(      'STR_NO_DATE_SELECTED_SILLAJ', 'Geen datum geselecteerd');
define(        'STR_BAD_TIME_INPUT_SILLAJ', 'Einde voor start');
define(        'STR_BAD_TIME_VALUE_SILLAJ', 'Tijd moet numeriek zijn');
define('STR_PROJECTTASK_EVENT_NOT_FOUND_SILLAJ', 'Geen project of activiteit');
define(     'STR_KEYWORD_NOT_FOUND_SILLAJ', 'Keyword ontbreekt');

//class Report
define(     'STR_ERROR_MISSING_DATE_SILLAJ', STR_NO_DATE_SELECTED_SILLAJ);
define(     'STR_ERROR_MISSING_USER_SILLAJ', 'Gebruiker ontbreekt');
define( 'STR_ERROR_USER_NOT_ALLOWED_SILLAJ', 'Gebruiker niet toegestaan');
define(        'STR_BAD_DATE_FORMAT_SILLAJ', 'Verkeerd datum format in config.php');

// Mail
define(   'STR_MAIL_INVALID_ADDRESS_SILLAJ', 'Ongeldig email adres');
define( 'STR_MAIL_ADDRESS_NOT_FOUND_SILLAJ', 'Email adres niet gevonden in gebruikerslijst');
define(           'STR_MAIL_SUBJECT_SILLAJ', 'Uw wachtwoord');
define(              'STR_MAIL_BODY_SILLAJ', 'Uw wachtwoord is gereset\nLogin : %s\nPassword : %s');
define(             'STR_MAIL_ERROR_SILLAJ', 'Mail error :');
define(           'STR_MAIL_SUCCESS_SILLAJ', 'Bericht verzonden aan');
define(        'STR_MAIL_PAGE_TITLE_SILLAJ', 'Wachtwoord wordt verzonden');

// Gantt
define(   'STR_GANTT_CSIM_ALT_TASK_SILLAJ', 'Toon planning voor deze activiteit');
define('STR_GANTT_CSIM_ALT_PROJECT_SILLAJ', 'Toon planning voor dit project');
?>
