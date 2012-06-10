<?php
// French translation 2006-01-17 18:18 
define('STR_PHP_LOCALE_WIN_SILLAJ', 'fr');
define('STR_PHP_LOCALE_NIX_SILLAJ', 'fr_FR');

// global
define(             'STR_ERROR_TITLE_SILLAJ', 'Erreur');
define('STR_EDIT_ACCOUNT_NOT_ALLOWED_SILLAJ', 'Modification de compte interdite');
define(           'STR_MESSAGE_TITLE_SILLAJ', 'Information');
define(                 'STR_PROJECT_SILLAJ', 'Projet');
define(                    'STR_TASK_SILLAJ', 'Activit�');
define(          'STR_GRAPH_DISABLED_SILLAJ', 'Graphiques inactifs (voir config.php)');

// Menu
$arrMenu = array(
               'index.php' => array('strMenu' => 'Mon temps',    'strTip' => 'Saisie des temps', 'booDisplay' => true),    
             'project.php' => array('strMenu' => 'Projets',      'strTip' => '�dition des projets', 'booDisplay' => true),
                'task.php' => array('strMenu' => 'Activit�s',    'strTip' => '�dition des activit�s', 'booDisplay' => true),
              'report.php' => array('strMenu' => 'Rapports',     'strTip' => 'Rapports hebdomadaires, mensuels...', 'booDisplay' => true),    
                'user.php' => array('strMenu' => 'Utilisateur',  'strTip' => 'Gestion du compte', 'booDisplay' => true),                
              'logout.php' => array('strMenu' => 'Quitter',      'strTip' => 'Se d�connecter', 'booDisplay' => true),
               'event.php' => array('strMenu' => '�v�nements',   'strTip' => '', 'booDisplay' => false), // menu virtuel mais utilis� pour mettre automatiquement le titre de la page
              'search.php' => array('strMenu' => 'Chercher',     'strTip' => '', 'booDisplay' => false),  // menu virtuel "
               'gantt.php' => array('strMenu' => 'Gantt',        'strTip' => '', 'booDisplay' => false),  // menu virtuel "
                'tool.php' => array('strMenu' => 'Outils',       'strTip' => 'Outils', 'booDisplay' => false)// menu virtuel (temp)
                    
           );                                                   

// index
define(    'STR_CALENDAR_SILLAJ', 'Calendrier');
define(    'STR_NEXT_DAY_SILLAJ', 'Jour suivant');
define(    'STR_PREV_DAY_SILLAJ', 'Jour pr�c�dent');
define(  'STR_NEXT_MONTH_SILLAJ', 'Mois suivant');
define(  'STR_PREV_MONTH_SILLAJ', 'Mois pr�c�dent');
define(    'STR_BAD_DATE_SILLAJ', 'Date invalide');
define(       'STR_EVENT_SILLAJ', '�v�nement');
define(      'STR_EVENTS_SILLAJ', '�v�nements');
           
// login
define(  'STR_LOGIN_PAGE_TITLE_SILLAJ', 'Login');
define(          'STR_NO_LOGIN_SILLAJ', 'Login absent');
define(       'STR_NO_PASSWORD_SILLAJ', 'Mot de passe absent');

// class Project
define(         'STR_PROJECT_CREATED_SILLAJ', 'Projet cr��');
define(        'STR_PROJECT_MODIFIED_SILLAJ', 'Projet modifi�');
define(         'STR_PROJECT_DELETED_SILLAJ', 'Projet supprim�');
define('STR_PROJECT_EDIT_NOT_ALLOWED_SILLAJ', "Interdiction d'�diter/visualiser ce projet");
define(       'STR_PROJECT_NOT_FOUND_SILLAJ', 'Aucun projet');
define(         'STR_NO_PROJECT_NAME_SILLAJ', 'Pas de nom pour le projet');

// class Task
define(         'STR_TASK_CREATED_SILLAJ', 'Activit� cr��e');
define(        'STR_TASK_MODIFIED_SILLAJ', 'Activit� modifi�e');
define(         'STR_TASK_DELETED_SILLAJ', 'Activit� supprim�e');
define('STR_TASK_EDIT_NOT_ALLOWED_SILLAJ', "Interdiction d'�diter/visualiser cette activit�");
define(       'STR_TASK_NOT_FOUND_SILLAJ', 'Aucune activit�');
define(         'STR_NO_TASK_NAME_SILLAJ', "Pas de nom pour l'activit�");

// class Authent
define(        'STR_NO_AUTHENT_SILLAJ', 'Authentification impossible. V�rifiez le login et le mot de passe');
define('STR_UNEXPECTED_AUTHENT_SILLAJ', "Probl�me d'authentification");

// class User
define(   'STR_ACCOUNT_CREATED_SILLAJ', 'Compte cr��');
define(  'STR_ACCOUNT_MODIFIED_SILLAJ', 'Compte modifi�');
define(         'STR_NO_IDPASS_SILLAJ', 'Vous devez fournir un login et un mot de passe pour �tre enregistr�');
define(     'STR_MISSING_EMAIL_SILLAJ', 'Vous devez fournir une adresse de courriel valide');

// class Event
define(         'STR_EVENT_CREATED_SILLAJ', '�v�nement cr��');
define(   'STR_EVENT_CREATED_2DAYS_SILLAJ', '(sur deux jours)');
define(      'STR_NO_TASK_SELECTED_SILLAJ', "Pas d'activit� s�lectionn�e");
define(   'STR_NO_PROJECT_SELECTED_SILLAJ', 'Pas de projet s�lectionn�');
define(         'STR_NO_TIME_INPUT_SILLAJ', "Pas d'information de dur�e entr�e");
define(         'STR_EVENT_DELETED_SILLAJ', '�v�nement supprim�');
define(        'STR_EVENT_MODIFIED_SILLAJ', '�v�nement modifi�');
define('STR_EVENT_EDIT_NOT_ALLOWED_SILLAJ', "Impossible d'�diter cet �v�nement");
define(       'STR_EVENT_NOT_FOUND_SILLAJ', '�v�nement non trouv� ou non modifiable');
define(     'STR_NO_EVENT_SELECTED_SILLAJ', "Pas d'�v�nement s�lectionn�");
define(      'STR_NO_DATE_SELECTED_SILLAJ', 'Pas de date s�lectionn�e');
define(        'STR_BAD_TIME_INPUT_SILLAJ', 'Fin avant d�but');
define(        'STR_BAD_TIME_VALUE_SILLAJ', 'Les valeurs de temps doivent �tre num�riques');
define('STR_PROJECTTASK_EVENT_NOT_FOUND_SILLAJ', "Pas de projet ou d'activit�");
define(     'STR_KEYWORD_NOT_FOUND_SILLAJ', 'Saisir un mot cl� pour la recherche');

//class Report
define(     'STR_ERROR_MISSING_DATE_SILLAJ', STR_NO_DATE_SELECTED_SILLAJ);
define(     'STR_ERROR_MISSING_USER_SILLAJ', 'Utilisateur non sp�cifi�');
define( 'STR_ERROR_USER_NOT_ALLOWED_SILLAJ', 'Utilisateur non autoris�');
define(        'STR_BAD_DATE_FORMAT_SILLAJ', 'Format de date incorrect dans config.php');

// Mail
define(  'STR_MAIL_INVALID_ADDRESS_SILLAJ', 'Adresse de courriel invalide');
define('STR_MAIL_ADDRESS_NOT_FOUND_SILLAJ', 'Adresse de courriel absente de la liste des utilisateurs');
define(          'STR_MAIL_SUBJECT_SILLAJ', 'Votre mot de passe');
define(             'STR_MAIL_BODY_SILLAJ', "Votre mot de passe a �t� r�initialis�.\nLogin : %s\nMot de passe : %s");
define(            'STR_MAIL_ERROR_SILLAJ', "Erreur d'envoi du message :");
define(          'STR_MAIL_SUCCESS_SILLAJ', 'Message envoy� �');
define(       'STR_MAIL_PAGE_TITLE_SILLAJ', 'Envoi du mot de passe');

// Gantt
define(   'STR_GANTT_CSIM_ALT_TASK_SILLAJ', 'Voir le diagramme de Gantt pour cette activit�');
define('STR_GANTT_CSIM_ALT_PROJECT_SILLAJ', 'Voir le diagramme de Gantt pour ce projet');
?>
