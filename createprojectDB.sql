DROP DATABASE IF EXISTS acmemedical;
CREATE DATABASE IF NOT EXISTS acmemedical;
USE acmemedical;
-- create a new table
CREATE TABLE patients (
   patId INT AUTO_INCREMENT NOT NULL,
   patFirst VARCHAR(100) NOT NULL,
   patLast VARCHAR(150) NOT NULL,
   patGender ENUM('Male', 'Female', 'Prefer not to disclose') NOT NULL,
   patBithdate DATE NOT NULL,
   patGenetics VARCHAR(250) NOT NULL,
   patDiabetes ENUM('Yes', 'No') NOT NULL
   patOther VARCHAR(150),
   PRIMARY KEY (patID)
);

CREATE TABLE medications (
   medID INTO AUTO_INCREMENT NOT NULL,
   medVEST VARCHAR(1),
   medAcapella VARCHAR(1),
   medPlumozyme VARCHAR(75),
   medInhaledTobi VARCHAR(1),
   medInhaledColistin VARCHAR(1),
   medInhaledTobi VARCHAR(1),
   medHypertonicSaline VARCHAR(75),
   medAzithromycin VARCHAR(1),
   medClarithromycin VARCHAR(1),
   medInhaledGentamicin VARCHAR(1)
   Enzymes VARCHAR(75),
);

-- CREATE USER 
CREATE USER 'kermit'@'localhost' IDENTIFIED BY 'sesame';

USE acmemedical;
GRANT SELECT, INSERT, UPDATE ON patients TO 'kermit'@'localhost';
FLUSH PRIVILEGES;
