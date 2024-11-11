<?php
require_once "db-conn-setup.php";

run_queries([

"DROP DATABASE IF EXISTS $configs->DB_NAME",
    
"CREATE DATABASE $configs->DB_NAME",
    
"USE $configs->DB_NAME",
    

"CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `parent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",



"INSERT INTO `address` (`id`, `name`, `parent_id`) VALUES
(1, 'Egypt', 0),
(2, 'Iraq', 0),
(3, 'Cairo', 1),
(4, 'Basra', 2),
(5, 'Heliopolis', 3);",



"CREATE TABLE `doctor` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `speciality_id` int(11) NOT NULL,
  `rank_id` int(11) NOT NULL,
  `isAvailable` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

"INSERT INTO `doctor` (`id`, `person_id`, `speciality_id`, `rank_id`, `isAvailable`) VALUES ('1', '1', '1', '1', '1');",

"CREATE TABLE `doctor_rank` (
  `id` int(11) NOT NULL,
  `rank` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",


"INSERT INTO `doctor_rank` (`id`, `rank`) VALUES
(1, 'Resident ');",


"CREATE TABLE `document` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",



"CREATE TABLE `donation` (
  `id` int(11) NOT NULL,
  `amount` float NOT NULL,
  `donation_type_id` int(11) NOT NULL,
  `donation_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",



"CREATE TABLE `donor` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `tier_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",


"INSERT INTO `donor` (`id`, `person_id`, `tier_id`) VALUES
(1, 1, 1);",


"CREATE TABLE `donor_donation` (
  `id` int(11) NOT NULL,
  `donation_id` int(11) NOT NULL,
  `donor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",


"CREATE TABLE `medical_aid_application` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",



"CREATE TABLE `medical_aid_documents` (
  `id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",


"CREATE TABLE `patient` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",


"CREATE TABLE `patient_medical_aid_application` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",


"CREATE TABLE `person` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `birth_date` date NOT NULL,
  `address_id` int(11) NOT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",


"INSERT INTO `person` (`id`, `first_name`, `last_name`, `birth_date`, `address_id`) VALUES
(1, 'ismail', 'seddik', '2001-11-05', 1);",


"CREATE TABLE `phonenumber` (
  `id` int(11) NOT NULL,
  `number` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

"INSERT INTO `phonenumber` (`id`, `number`) VALUES
(1, 122233333);",


"CREATE TABLE `phone_phonenumber` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `phone_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",


"CREATE TABLE `speciality` (
  `id` int(11) NOT NULL,
  `speciality_name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

"CREATE TABLE `aid_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

"CREATE TABLE `application_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

"INSERT INTO `speciality` (`id`, `speciality_name`) VALUES
(1, 'Cardiology.');",

//-- Insert initial data into the aid_type table
"INSERT INTO `aid_type` (type) VALUES 
  ('Financial Aid'),
  ('Medical Aid'),
  ('Operational Aid');",

"INSERT INTO `application_status` (status) VALUES 
  ('Pending'),
  ('Approved'),
  ('Rejected');",

"ALTER TABLE `address`
  ADD PRIMARY KEY (`id`);",


"ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `foreignkey_to_speciality` (`speciality_id`),
  ADD KEY `fk_pers` (`person_id`),
  ADD KEY `fk_rank` (`rank_id`);",

"ALTER TABLE `doctor_rank`
  ADD PRIMARY KEY (`id`);",


"ALTER TABLE `document`
  ADD PRIMARY KEY (`id`);",


"ALTER TABLE `donation`
  ADD PRIMARY KEY (`id`);",


"ALTER TABLE `donor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_person` (`person_id`);",


"ALTER TABLE `donor_donation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_donation` (`donation_id`),
  ADD KEY `fk_donor` (`donor_id`);",

"ALTER TABLE `medical_aid_application`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_doctor` (`doctor_id`);",


"ALTER TABLE `medical_aid_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_application` (`application_id`),
  ADD KEY `fk_document` (`document_id`);",


"ALTER TABLE `patient`
  ADD PRIMARY KEY (`id`),
  ADD KEY `foreign key` (`person_id`);",


"ALTER TABLE `patient_medical_aid_application`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_patient` (`patient_id`),
  ADD KEY `fk_app` (`application_id`),
  ADD COLUMN `status_id` int(11) DEFAULT 1,
  ADD FOREIGN KEY (`status_id`) REFERENCES `application_status`(`id`);",



"ALTER TABLE `person`
  ADD PRIMARY KEY (`id`),
  ADD KEY `foreign_key_to_address` (`address_id`);",


"ALTER TABLE `phonenumber`
  ADD PRIMARY KEY (`id`);",


"ALTER TABLE `phone_phonenumber`
  ADD PRIMARY KEY (`id`),
  ADD KEY `foreignkey_to_phonenumber` (`phone_id`),
  ADD KEY `foreignkey_to_person` (`person_id`);",


"ALTER TABLE `speciality`
  ADD PRIMARY KEY (`id`);",




"ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;",


"ALTER TABLE `doctor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",


"ALTER TABLE `doctor_rank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;",


"ALTER TABLE `document`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",


"ALTER TABLE `donation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",


"ALTER TABLE `donor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;",


"ALTER TABLE `donor_donation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",


"ALTER TABLE `medical_aid_application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",


"ALTER TABLE `medical_aid_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",


"ALTER TABLE `patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",


"ALTER TABLE `patient_medical_aid_application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",


"ALTER TABLE `person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;",

"ALTER TABLE `phonenumber`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;",


"ALTER TABLE `phone_phonenumber`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",


"ALTER TABLE `speciality`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;",




"ALTER TABLE `doctor`
  ADD CONSTRAINT `fk_pers` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`),
  ADD CONSTRAINT `fk_rank` FOREIGN KEY (`rank_id`) REFERENCES `doctor_rank` (`id`),
  ADD CONSTRAINT `foreignkey_to_speciality` FOREIGN KEY (`speciality_id`) REFERENCES `speciality` (`id`);",


"ALTER TABLE `donor`
  ADD CONSTRAINT `FK_person` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`);",


"ALTER TABLE `donor_donation`
  ADD CONSTRAINT `fk_donation` FOREIGN KEY (`donation_id`) REFERENCES `donation` (`id`),
  ADD CONSTRAINT `fk_donor` FOREIGN KEY (`donor_id`) REFERENCES `donor` (`id`);",


"ALTER TABLE `medical_aid_application`
  ADD CONSTRAINT `fk_doctor` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`id`);",


"ALTER TABLE `medical_aid_documents`
  ADD CONSTRAINT `fk_application` FOREIGN KEY (`application_id`) REFERENCES `medical_aid_application` (`id`),
  ADD CONSTRAINT `fk_document` FOREIGN KEY (`document_id`) REFERENCES `document` (`id`);",


"ALTER TABLE `patient`
  ADD CONSTRAINT `foreign key` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`);",


"ALTER TABLE `patient_medical_aid_application`
  ADD CONSTRAINT `fk_app` FOREIGN KEY (`application_id`) REFERENCES `medical_aid_application` (`id`),
  ADD CONSTRAINT `fk_patient` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`);",


"ALTER TABLE `person`
  ADD CONSTRAINT `foreign_key_to_address` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`);",


"ALTER TABLE `phone_phonenumber`
  ADD CONSTRAINT `foreignkey_to_person` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`),
  ADD CONSTRAINT `foreignkey_to_phonenumber` FOREIGN KEY (`phone_id`) REFERENCES `phonenumber` (`id`);",

"COMMIT;",

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */


],true);