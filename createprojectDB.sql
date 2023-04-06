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
   medVEST ENUM ('Yes' 'No'),
   medVEST ENUM ('Yes' 'No'),
   medVEST ENUM ('Yes' 'No'),
   medVEST ENUM ('Yes' 'No'),
   medVEST ENUM ('Yes' 'No'),
   medVEST ENUM ('Yes' 'No'),
   medVEST ENUM ('Yes' 'No'),
   medVEST ENUM ('Yes' 'No'),
   medVEST ENUM ('Yes' 'No'),
   medVEST ENUM ('Yes' 'No'),
   
);

-- CREATE USER 
CREATE USER 'kermit'@'localhost' IDENTIFIED BY 'sesame';

USE acmemedical;
GRANT SELECT, INSERT, UPDATE ON patients TO 'kermit'@'localhost';
FLUSH PRIVILEGES;
