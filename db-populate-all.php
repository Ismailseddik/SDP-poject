<?php
require_once "db-conn-setup.php";
require_once "config.php";

$configs = require "config.php";

run_queries([

"DROP DATABASE IF EXISTS $configs->DB_NAME",
    
"CREATE DATABASE $configs->DB_NAME",
    
"USE $configs->DB_NAME",
    

"CREATE TABLE `address` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `parent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

"INSERT INTO `address` (`name`, `parent_id`) VALUES
('Egypt', 0),
('Iraq', 0),
('Cairo', 1),
('Basra', 2),
('Heliopolis', 3);",

"CREATE TABLE `doctor` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `speciality_id` int(11) NOT NULL,
  `rank_id` int(11) NOT NULL,
  `isAvailable` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

"INSERT INTO `doctor` (`person_id`, `speciality_id`, `rank_id`, `isAvailable`) VALUES ('1', '1', '1', '1');",
"INSERT INTO `doctor` (`person_id`, `speciality_id`, `rank_id`, `isAvailable`) VALUES ('2', '1', '1', '1');",

"CREATE TABLE `doctor_rank` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `rank` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",


"INSERT INTO `doctor_rank` (`rank`) VALUES
('Resident'),
('Intern'), 
('Attending Physician'), 
('Consultant');",

"CREATE TABLE `donor_tier` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `tier` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

"INSERT INTO `donor_tier` (`tier`) VALUES
('Silver'),
('Gold'),
('Platinum');",

"CREATE TABLE `document` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",


"CREATE TABLE `donation` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `amount` float,
  `donation_type_id` int(11) NOT NULL,
  `donation_date` datetime NOT NULL,
  `organ`  varchar(150)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

"INSERT INTO `donation` (`amount`, `donation_type_id`, `donation_date`, `organ`) VALUES 
('200', '1', '2024-11-13 12:52:39.000000', 'Kidney'),
('150', '2', '2024-11-14 09:30:00.000000', 'Pancreas'),
('300', '2', '2024-11-15 15:45:20.000000', 'Heart'),
('500', '1', '2024-11-16 10:20:10.000000', 'Liver');",

"CREATE TABLE `donation_type` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `donation_type`  varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

"INSERT INTO `donation_type` (`donation_type`) VALUES
('Organ Donation'),
('Monetary Donation');",


"CREATE TABLE `donor` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `tier_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",


"INSERT INTO `donor` (`person_id`, `tier_id`) VALUES
(1, 1),
(2,1),
(3,1),
(4,1);",



"CREATE TABLE `donor_donation` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `donation_id` int(11) NOT NULL,
  `donor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

"INSERT INTO `donor_donation` (`donation_id`, `donor_id`) VALUES ('1', '2');",
"INSERT INTO `donor_donation` (`donation_id`, `donor_id`) VALUES ('2', '3');",
"INSERT INTO `donor_donation` (`donation_id`, `donor_id`) VALUES ('3', '4');",
"INSERT INTO `donor_donation` (`donation_id`, `donor_id`) VALUES ('3', '1');",

"CREATE TABLE `medical_aid_application` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `doctor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

"INSERT INTO `medical_aid_application` (`doctor_id`) VALUES ('1');",
"INSERT INTO `medical_aid_application` (`doctor_id`) VALUES ('2');",


"CREATE TABLE `medical_aid_documents` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `application_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",


"CREATE TABLE `patient` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

"INSERT INTO `patient` (`id`,`person_id`) VALUES 
(1,2),
(2,2);",


"CREATE TABLE `patient_medical_aid_application` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

"INSERT INTO `patient_medical_aid_application` (`patient_id`, `application_id`, `status_id`) VALUES ('1', '1', '1');",
"INSERT INTO `patient_medical_aid_application` (`patient_id`, `application_id`, `status_id`) VALUES ('1', '2', '1');",


"CREATE TABLE `patient_medical_aid_application_aid_type` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `patient_application_id` INT NOT NULL,
  `aid_type_id` INT NOT NULL
);", 

// "INSERT INTO `patient_medical_aid_application_aid_type` (`patient_application_id`, `aid_type_id`) VALUES ('1', '1');",
// "INSERT INTO `patient_medical_aid_application_aid_type` (`patient_application_id`, `aid_type_id`) VALUES ('1', '2');",
// "INSERT INTO `patient_medical_aid_application_aid_type` (`patient_application_id`, `aid_type_id`) VALUES ('1', '3');",


"CREATE TABLE `person` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `birth_date` date NOT NULL,
  `address_id` int(11) NOT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",


"INSERT INTO `person` (`first_name`, `last_name`, `birth_date`, `address_id`) VALUES
('ismail', 'seddik', '2001-11-05', 1),
('tarek', 'khaled', '2001-12-06',1),
('mohamed', 'ayman', '2000-12-06',1),
('hesham', 'mohamed', '2001-09-06',1);",

"INSERT INTO `person` (`first_name`, `last_name`, `birth_date`, `address_id`, `isDeleted`) VALUES ('Ahmed', 'Khaled', '2002-02-12', '2', '0');",

"CREATE TABLE `phonenumber` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `number` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

"INSERT INTO `phonenumber` (`number`) VALUES
(122233333);",


"CREATE TABLE `phone_phonenumber` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `phone_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",


"CREATE TABLE `speciality` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `speciality_name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

"INSERT INTO `speciality` (`speciality_name`) VALUES
('Cardiology'),
('Internal Medicine'),
('Pediatrics'),
('Neurology');",

"CREATE TABLE `aid_type` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",


// Insert sample data for aid types
"INSERT INTO `aid_type` (`type`) VALUES 
  ('Financial Aid'),
  ('Medical Aid'),
  ('Operational Aid');",

"CREATE TABLE `application_status` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

"INSERT INTO `application_status` (`status`) VALUES 
  ('Pending'),
  ('Approved'),
  ('Rejected');",

"ALTER TABLE `doctor`
  ADD FOREIGN KEY (`person_id`) REFERENCES `person` (`id`),
  ADD FOREIGN KEY (`rank_id`) REFERENCES `doctor_rank` (`id`),
  ADD FOREIGN KEY (`speciality_id`) REFERENCES `speciality` (`id`);",


"ALTER TABLE `donor`
  ADD FOREIGN KEY (`person_id`) REFERENCES `person` (`id`),
  ADD FOREIGN KEY (`tier_id`) REFERENCES `donor_tier` (`id`);",

"ALTER TABLE `donation`
  ADD FOREIGN KEY (`donation_type_id`) REFERENCES `donation_type` (`id`);",
  
"ALTER TABLE `donor_donation`
  ADD FOREIGN KEY (`donation_id`) REFERENCES `donation` (`id`),
  ADD FOREIGN KEY (`donor_id`) REFERENCES `donor` (`id`);",


"ALTER TABLE `medical_aid_application`
  ADD FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`id`);",

"ALTER TABLE `patient_medical_aid_application_aid_type`
  ADD FOREIGN KEY (`patient_application_id`) REFERENCES `patient_medical_aid_application`(`id`),
  ADD FOREIGN KEY (`aid_type_id`) REFERENCES `aid_type`(`id`)",

"ALTER TABLE `medical_aid_documents`
  ADD FOREIGN KEY (`application_id`) REFERENCES `medical_aid_application` (`id`),
  ADD FOREIGN KEY (`document_id`) REFERENCES `document` (`id`);",


"ALTER TABLE `patient`
  ADD FOREIGN KEY (`person_id`) REFERENCES `person` (`id`);",


"ALTER TABLE `patient_medical_aid_application`
  ADD FOREIGN KEY (`application_id`) REFERENCES `medical_aid_application` (`id`),
  ADD FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`),
  ADD FOREIGN KEY (`status_id`) REFERENCES `application_status`(`id`);",

"ALTER TABLE `patient_medical_aid_application_aid_type`
  ADD FOREIGN KEY (`patient_application_id`) REFERENCES `patient_medical_aid_application`(`id`),
  ADD FOREIGN KEY (`aid_type_id`) REFERENCES `aid_type`(`id`)",

"ALTER TABLE `person`
  ADD FOREIGN KEY (`address_id`) REFERENCES `address` (`id`);",


"ALTER TABLE `phone_phonenumber`
  ADD FOREIGN KEY (`person_id`) REFERENCES `person` (`id`),
  ADD FOREIGN KEY (`phone_id`) REFERENCES `phonenumber` (`id`);",



"COMMIT;",

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
],true);