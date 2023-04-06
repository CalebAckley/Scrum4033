DROP DATABASE IF EXISTS acmemedical;
CREATE DATABASE IF NOT EXISTS acmemedical;
USE acmemedical;
-- create a new table
CREATE TABLE patients (
   patId INT AUTO_INCREMENT NOT NULL,
   patFirst VARCHAR(100) NOT NULL,
   patLast VARCHAR(150) NOT NULL,
   patGender VARCHAR(1) NOT NULL,
   patBithdate DATETIME NOT NULL,
   patGenetics VARCHAR(250) NOT NULL,
   patDiabetes VARCHAR(3) NOT NULL
   patOther VARCHAR(150),
   PRIMARY KEY (patID)
);



-- CREATE USER 
CREATE USER 'kermit'@'localhost' IDENTIFIED BY 'sesame';

USE acmemedical;
GRANT SELECT, INSERT, UPDATE ON patients TO 'kermit'@'localhost';
FLUSH PRIVILEGES;
