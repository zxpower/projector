USE sillaj;
ALTER TABLE sillaj_task
  ADD COLUMN booUseInReport SET('0', '1')  DEFAULT '1';
ALTER TABLE sillaj_project
  ADD COLUMN booUseInReport SET('0', '1')  DEFAULT '1';