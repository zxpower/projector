CREATE TABLE sillaj_user (
  strUserId VARCHAR(20) NOT NULL,
  strName VARCHAR(45) NOT NULL,
  strFirstname VARCHAR(45) NULL,
  strEmail VARCHAR(255) NOT NULL,
  strPassword CHAR(32) NOT NULL,
  booActive SET('0','1') NULL DEFAULT '1',
  booUseShare SET('0', '1') NULL DEFAULT '0',
  booAllowOther SET('0','1') NULL DEFAULT '0',
  strLanguage CHAR(2) NULL,
  strTemplate VARCHAR(50) NULL,
  PRIMARY KEY(strUserId)
)
TYPE=MyISAM;

CREATE TABLE sillaj_task (
  intTaskId SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  sillaj_user_strUserId VARCHAR(20) NOT NULL,
  strTask VARCHAR(255) NOT NULL,
  booDisplay SET('0','1') NULL DEFAULT '1',
  strRem VARCHAR(255) NULL,
  booShare SET('0','1') NULL DEFAULT '0',
  booUseInReport SET('0','1') NULL DEFAULT '1',
  datUpdate TIMESTAMP NOT NULL,
  PRIMARY KEY(intTaskId),
  INDEX sillaj_task_FKIndex1(sillaj_user_strUserId),
  INDEX sillaj_task_strTask(strTask),
  FOREIGN KEY(sillaj_user_strUserId)
    REFERENCES sillaj_user(strUserId)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
)
TYPE=MyISAM;

CREATE TABLE sillaj_project (
  intProjectId SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  sillaj_user_strUserId VARCHAR(20) NOT NULL,
  strProject VARCHAR(255) NOT NULL,
  booDisplay SET('0','1') NULL DEFAULT '1',
  strRem VARCHAR(255) NULL,
  booShare SET('0','1') NULL DEFAULT '0',
  booUseInReport SET('0','1') NULL DEFAULT '1',
  datUpdate TIMESTAMP NOT NULL,
  PRIMARY KEY(intProjectId),
  INDEX sillaj_project_FKIndex1(sillaj_user_strUserId),
  INDEX sillaj_project_strProject(strProject),
  FOREIGN KEY(sillaj_user_strUserId)
    REFERENCES sillaj_user(strUserId)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
)
TYPE=MyISAM;

CREATE TABLE sillaj_task_project (
  sillaj_task_intTaskId SMALLINT UNSIGNED NOT NULL,
  sillaj_project_intProjectId SMALLINT UNSIGNED NOT NULL,
  PRIMARY KEY(sillaj_task_intTaskId, sillaj_project_intProjectId),
  INDEX sillaj_task_project_FKIndex1(sillaj_task_intTaskId),
  INDEX sillaj_task_project_FKIndex2(sillaj_project_intProjectId),
  FOREIGN KEY(sillaj_task_intTaskId)
    REFERENCES sillaj_task(intTaskId)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(sillaj_project_intProjectId)
    REFERENCES sillaj_project(intProjectId)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
)
TYPE=MyISAM;

CREATE TABLE sillaj_event (
  intEventId INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  sillaj_task_intTaskId SMALLINT UNSIGNED NOT NULL,
  sillaj_project_intProjectId SMALLINT UNSIGNED NOT NULL,
  sillaj_user_strUserId VARCHAR(20) NOT NULL,
  timStart TIME NULL,
  timEnd TIME NULL,
  timDuration TIME NULL,
  datEvent DATE NOT NULL,
  strRem VARCHAR(255) NULL,
  datUpdate TIMESTAMP NOT NULL,
  PRIMARY KEY(intEventId, sillaj_task_intTaskId, sillaj_project_intProjectId),
  INDEX sillaj_event_FKIndex1(sillaj_task_intTaskId),
  INDEX sillaj_event_FKIndex2(sillaj_user_strUserId),
  INDEX sillaj_event_FKIndex3(sillaj_project_intProjectId),
  INDEX sillaj_event_strRem(strRem),
  FOREIGN KEY(sillaj_task_intTaskId)
    REFERENCES sillaj_task(intTaskId)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(sillaj_user_strUserId)
    REFERENCES sillaj_user(strUserId)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(sillaj_project_intProjectId)
    REFERENCES sillaj_project(intProjectId)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
)
TYPE=MyISAM;


