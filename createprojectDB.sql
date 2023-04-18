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
   plumQuant VARCHAR(75) NOT NULL,
   plumDate DATE NOT NULL,
   medTobi ENUM('Y', 'N') NOT NULL,
   medColi VARCHAR(75) NOT NULL,
   medHype VARCHAR(75) NOT NULL,
   medAzit ENUM('Y', 'N') NOT NULL,
   medClar ENUM('Y', 'N') NOT NULL,
   medGent ENUM('Y', 'N') NOT NULL,
   medEnzy ENUM('Y', 'N') NOT NULL,
   enzyType VARCHAR(75) NOT NULL,
   PRIMARY KEY (medID),
   FOREIGN KEY (patId) REFERENCES patients(patId)
   );


CREATE TABLE IF NOT EXISTS visits (
  visitId INT NOT NULL AUTO_INCREMENT,
  patId INT NOT NULL,
  visitDate DATE,
  visitDoc VARCHAR(75) NOT NULL,
  PRIMARY KEY (visitId),
  FOREIGN KEY (patId) REFERENCES patients(patId) 
);

CREATE TABLE IF NOT EXISTS fev1 (
   entryId INT NOT NULL AUTO_INCREMENT,
   patId INT,
   visitId INT,
   testDate DATE,
   firstTest INT(3) NOT NULL,
   secondTest INT(3),
   thirdTest INT(3),
   PRIMARY KEY (entryId),
   FOREIGN KEY (patId) REFERENCES patients(patId),
   FOREIGN KEY (visitId) REFERENCES visits(visitId)
);

-- CREATE USER 
CREATE USER 'kermit'@'localhost' IDENTIFIED BY 'sesame';

USE acmemedical;
GRANT SELECT, INSERT, UPDATE ON patients TO 'kermit'@'localhost';
FLUSH PRIVILEGES;
