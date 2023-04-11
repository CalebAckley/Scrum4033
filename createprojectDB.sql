DROP DATABASE IF EXISTS acmemedical;
CREATE DATABASE IF NOT EXISTS acmemedical;
USE acmemedical;
-- create a new table
CREATE TABLE IF NOT EXISTS patients (
   patId INT NOT NULL AUTO_INCREMENT,
   patFirst VARCHAR(100) NOT NULL,
   patLast VARCHAR(150) NOT NULL,
   patGender ENUM('Male', 'Female', 'Prefer not to disclose'),
   patBirthdate DATE NOT NULL,
   patGenetics VARCHAR(250) NOT NULL,
   patDiabetes ENUM('Yes', 'No') NOT NULL,
   patOther VARCHAR(150),
   PRIMARY KEY (patID)
);

CREATE TABLE IF NOT EXISTS medications (
   medID INT NOT NULL AUTO_INCREMENT,
   patId INT NOT NULL,
   medVEST ENUM('Y', 'N') NOT NULL,
   medAcap ENUM('Y', 'N') NOT NULL,
   medPlum VARCHAR(75) NOT NULL,
   medTobi ENUM('Y', 'N') NOT NULL,
   medColi ENUM('Y', 'N') NOT NULL,
   medHype VARCHAR(75) NOT NULL,
   medAzit ENUM('Y', 'N') NOT NULL,
   medClar ENUM('Y', 'N') NOT NULL,
   medGent ENUM('Y', 'N') NOT NULL,
   medEnzy VARCHAR(75) NOT NULL,
   PRIMARY KEY (medID, patId),
   FOREIGN KEY (patId) REFERENCES patients(patId)
);

CREATE TABLE IF NOT EXISTS visits (
  patId INT,
  visitDate DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
  visitDoc VARCHAR(75) NOT NULL,
  PRIMARY KEY (patId, visitDate),
  FOREIGN KEY (patId) REFERENCES patients(patId) 
);

CREATE TABLE IF NOT EXISTS fev1 (
   entryId INT NOT NULL AUTO_INCREMENT,
   patId INT,
   testDate DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
   firstTest INT(3) NOT NULL,
   secondTest INT(3),
   thirdTest INT(3),
   PRIMARY KEY (entryId),
   FOREIGN KEY (patId) REFERENCES patients(patId)
);

-- CREATE USER 
CREATE USER 'kermit'@'localhost' IDENTIFIED BY 'sesame';

USE acmemedical;
GRANT SELECT, INSERT, UPDATE ON patients TO 'kermit'@'localhost';
FLUSH PRIVILEGES;
