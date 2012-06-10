<?php
// Deutsche Uebersetzung 2007-01-23 18:18 
// Thanks to lmoehri @ gwdg.de

define('STR_PHP_LOCALE_WIN_SILLAJ', 'deu');
define('STR_PHP_LOCALE_NIX_SILLAJ', 'de_DE');

// global
define(             'STR_ERROR_TITLE_SILLAJ', 'Fehler');
define('STR_EDIT_ACCOUNT_NOT_ALLOWED_SILLAJ', 'Account Veränderung nicht erlaubt');
define(           'STR_MESSAGE_TITLE_SILLAJ', 'Information');
define(                  'STR_PROJECT_SILLAJ', 'Projekt');
define(                 'STR_CUSTOMER_SILLAJ', 'Kunde');
define(                     'STR_TASK_SILLAJ', 'Tätigkeit');
define(           'STR_GRAPH_DISABLED_SILLAJ', 'Graph nicht nutzbar (siehe config.php)');
// Menu
$arrMenu = array(
               'index.php' => array('strMenu' => 'Meine Zeit',      'strTip' => 'Ereignisse bearbeiten', 'booDisplay' => true),    
             'project.php' => array('strMenu' => 'Projekte',        'strTip' => 'Projekte bearbeiten', 'booDisplay' => true),
                'task.php' => array('strMenu' => 'Tätigkeiten',     'strTip' => 'Tätigkeiten bearbiten', 'booDisplay' => true),
              'report.php' => array('strMenu' => 'Berichte',        'strTip' => 'Berichte', 'booDisplay' => true),    
                'user.php' => array('strMenu' => 'Nutzer',          'strTip' => 'Nutzer Informationen', 'booDisplay' => true),
              'logout.php' => array('strMenu' => 'Abmelden',        'strTip' => 'Beenden', 'booDisplay' => true),              
               'event.php' => array('strMenu' => 'Ereignisse',      'strTip' => '', 'booDisplay' => false), // virtual menu
              'search.php' => array('strMenu' => 'Suche',           'strTip' => '', 'booDisplay' => false),  // virtual menu
               'gantt.php' => array('strMenu' => 'Gantt Graph',     'strTip' => '', 'booDisplay' => false),  // virtual menu
                'tool.php' => array('strMenu' => 'Werkzeuge',       'strTip' => '', 'booDisplay' => false)// virtual menu
           );                                                   

// index
define(    'STR_CALENDAR_SILLAJ', 'Kalender');
define(    'STR_NEXT_DAY_SILLAJ', 'Nächster Tag');
define(    'STR_PREV_DAY_SILLAJ', 'Vorheriger Tag');
define(  'STR_NEXT_MONTH_SILLAJ', 'Nächster Monat');
define(  'STR_PREV_MONTH_SILLAJ', 'Vorheriger Monat');
define(    'STR_BAD_DATE_SILLAJ', 'Ungütiges Datum');
define(       'STR_EVENT_SILLAJ', 'Ereignis');
define(      'STR_EVENTS_SILLAJ', 'Ereignisse');
           
// login
define(  'STR_LOGIN_PAGE_TITLE_SILLAJ', 'Anmeldung');
define(          'STR_NO_LOGIN_SILLAJ', 'Anmeldung fehlt');
define(       'STR_NO_PASSWORD_SILLAJ', 'Passwort fehlt');
define( 'STR_NO_RESPONSE_LOGIN_SILLAJ', 'No encrypted password found in your request ; you probably must enable javascript');

// class Project
define(         'STR_PROJECT_CREATED_SILLAJ', 'Projekt erzeugt');
define(        'STR_PROJECT_MODIFIED_SILLAJ', 'Projekt bearbeitet');
define(         'STR_PROJECT_DELETED_SILLAJ', 'Project gelöscht');
define('STR_PROJECT_EDIT_NOT_ALLOWED_SILLAJ', 'Keine Erlaubnis dieses Projekt zu bearbeiten');
define(       'STR_PROJECT_NOT_FOUND_SILLAJ', 'Kein Projekt gefunden');
define(         'STR_NO_PROJECT_NAME_SILLAJ', 'Kein Projektname');

// class Task
define(         'STR_TASK_CREATED_SILLAJ', 'Tätigkeit erzeugt');
define(        'STR_TASK_MODIFIED_SILLAJ', 'Tätigkeit bearbeitet');
define(         'STR_TASK_DELETED_SILLAJ', 'Tätigkeit gelöscht');
define('STR_TASK_EDIT_NOT_ALLOWED_SILLAJ', 'Keine Erlaubnis diese Tätigkeit zu bearbeiten');
define(       'STR_TASK_NOT_FOUND_SILLAJ', 'Keine Tätigkeit gefunden');
define(         'STR_NO_TASK_NAME_SILLAJ', 'Kein Name der Tätigkeit');

// class Authent
define(        'STR_NO_AUTHENT_SILLAJ', 'Anmeldung nicht erfolgreich. Bitte prüfen sie Username und Passwort');
define('STR_UNEXPECTED_AUTHENT_SILLAJ', "Authentifizierungsproblem");

// class User
define(   'STR_ACCOUNT_CREATED_SILLAJ', 'Account erzeugt');
define(  'STR_ACCOUNT_MODIFIED_SILLAJ', 'Account bearbeitet');
define(         'STR_NO_IDPASS_SILLAJ', 'Zur Registrierung wird ein Name und ein Passwort benötigt');
define(     'STR_MISSING_EMAIL_SILLAJ', 'Es muss eine gütige eMail Adresse angegeben werden.');

// class Event
define(         'STR_EVENT_CREATED_SILLAJ', 'Ereignis erzeugt');
define(   'STR_EVENT_CREATED_2DAYS_SILLAJ', '(mit zwei Tagen)');
define(      'STR_NO_TASK_SELECTED_SILLAJ', 'Keine Tätigkeit gewählt');
define(   'STR_NO_PROJECT_SELECTED_SILLAJ', 'Kein Projekt gewählt');
define(  'STR_NO_CUSTOMER_SELECTED_SILLAJ', 'Kein Kunde gewählt');
define(         'STR_NO_TIME_INPUT_SILLAJ', 'Kein Dauer angegeben');
define(         'STR_EVENT_DELETED_SILLAJ', 'Ereignis gelöscht');
define(        'STR_EVENT_MODIFIED_SILLAJ', 'Ereignis bearbeitet');
define('STR_EVENT_EDIT_NOT_ALLOWED_SILLAJ', 'Keine Erlaubnis dieses Ereignis zu bearbeiten');
define(       'STR_EVENT_NOT_FOUND_SILLAJ', 'Kein Ereignis gefunden');
define(     'STR_NO_EVENT_SELECTED_SILLAJ', 'Kein Ereignis gewählt');
define(      'STR_NO_DATE_SELECTED_SILLAJ', 'Kein Datum gewählt');
define(        'STR_BAD_TIME_INPUT_SILLAJ', 'Ende vor Anfang');
define(        'STR_BAD_TIME_VALUE_SILLAJ', 'Zeiteingabe bitte numerisch');
define('STR_PROJECTTASK_EVENT_NOT_FOUND_SILLAJ', 'Kein Projekt oder Tätigkeit');
define(     'STR_KEYWORD_NOT_FOUND_SILLAJ', 'Schluesselbegriff nicht gefunden');

//class Report
define(     'STR_ERROR_MISSING_DATE_SILLAJ', STR_NO_DATE_SELECTED_SILLAJ);
define(     'STR_ERROR_MISSING_USER_SILLAJ', 'User fehlt');
define( 'STR_ERROR_USER_NOT_ALLOWED_SILLAJ', 'User hat keine Erlaubnis');
define(        'STR_BAD_DATE_FORMAT_SILLAJ', 'Fehlerhaftes Datumsformat in config.php');

// Mail
define(   'STR_MAIL_INVALID_ADDRESS_SILLAJ', 'Ungütige eMail Addresse');
define( 'STR_MAIL_ADDRESS_NOT_FOUND_SILLAJ', 'eMail addresse wurde nicht in der User Liste gefunden');
define(           'STR_MAIL_SUBJECT_SILLAJ', 'Ihr Passwort');
define(              'STR_MAIL_BODY_SILLAJ', 'Ihr Passwort wurde zurueckgesetzt\nLogin : %s\nPasswort : %s');
define(             'STR_MAIL_ERROR_SILLAJ', 'Mailer Fehler:');
define(           'STR_MAIL_SUCCESS_SILLAJ', 'Nachricht wurde gesendet an');
define(        'STR_MAIL_PAGE_TITLE_SILLAJ', 'Sende Passwort');

// Gantt
define(   'STR_GANTT_CSIM_ALT_TASK_SILLAJ', 'Zeige den Gantt Graph für diese Tätigkeit');
define('STR_GANTT_CSIM_ALT_PROJECT_SILLAJ', 'Zeige den Gantt Graph für dieses Projekt');
define('STR_GANTT_CSIM_ALT_CUSTOMER_SILLAJ', 'Zeige den Gantt Graph für diesen Kunden');
?>
