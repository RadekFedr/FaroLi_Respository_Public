-- Creates main table of repository in PostgreSQL DB
CREATE TABLE repository (
  box_id SERIAL NOT NULL PRIMARY KEY,
  url_web text NOT NULL,
  icon_url text,
  title text,
  descript text,
  keywords text,
  insert_date timestamp,
  checkbox boolean
);