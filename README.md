# Medical Aid Charity System

## Overview

The **Medical Aid Charity System** is a PHP-based web application designed to facilitate the management of a charity organization focused on providing medical assistance. The system allows the charity to manage doctors, patients, donors, donations, and types of aid. The application leverages the MVC architecture and includes several design patterns such as Singleton (for database connections) and Strategy (for donor tiers). This project is intended to support efficient charity operations while keeping the codebase clean and maintainable.

## Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Project Structure](#project-structure)
- [Installation](#installation)
- [Usage](#usage)
- [Design Patterns](#design-patterns)
- [Contributing](#contributing)
- [License](#license)

## Features

- **Doctor Management**: Add, view, and manage doctors, including their specialties and availability.
- **Patient Management**: Add, view, and manage patients needing medical assistance.
- **Donor Management**: Add, view, and manage donors, including tiered donor strategies (e.g., Gold, Silver, Platinum).
- **Donation Tracking**: Track donations from donors and manage the allocation of resources.
- **Aid Type Management**: Manage different types of aid provided by the charity (e.g., medical supplies, financial aid).
- **MVC Architecture**: Follows MVC architecture for organized and maintainable code.
- **Database Singleton Pattern**: Ensures a single instance of the database connection.
- **Strategy Design Pattern**: Implements tiered donor management strategies.

## Tech Stack

- **Frontend**: HTML, CSS, Basic JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **Design Patterns**: Singleton, Strategy

## Project Structure

```plaintext
├── config/                   # Database Configuration files
├── controllers/              # Controllers for handling application logic
│   ├── DoctorController.php
│   ├── PatientController.php
│   └── ...
├── models/                   # Models representing application data
│   ├── Doctor.php
│   ├── Patient.php
│   └── ...
├── views/                    # Views for rendering HTML templates
│   ├── doctorView.php
│   ├── patientView.php
│   └── ...
├── strategies/               # Strategy pattern implementations for Donor Tiers
│   ├── GoldTier.php
│   ├── SilverTier.php
│   └── ...
├── Database.php              # Singleton Database connection
├── index.php                 # Main entry point and router
├── README.md                 # Project documentation
└── styles.css                # CSS for styling the application

```

### Dependencies
PHP (version 7.4 or above)
MySQL (version 5.7 or above

### Installation
1. Clone the repo:
   ```bash
   git clone https://github.com/Ismailseddik/SDP-poject.git
2. Navigate to the project directory:
   ```bash
   cd SDP-poject
3. Run XAMPP to start the server and the Database
4. Navigate to config.php and Change the port according to your SQL port number

### Usage
1. Navigate to the Main Page: Access the main page to view available options.
2. Doctor Management:
  i. List all doctors.
  ii. Add new doctors by filling out the form in the doctor management section.
3. Patient Management:
  i. List all patients.
  ii. Add new patients to the system.
4. Donor Management:
  i. View and manage donors according to tier levels (Gold, Silver, Platinum).
  ii. Track donations and categorize them by donor tiers.
5. Donation and Aid Type Management:
   Add, view, and manage donations and aid types as needed by the charity.

### Design Patterns
# Singleton (Database Connection)
The Singleton pattern is used to ensure a single instance of the database connection is used across the application. This approach reduces resource consumption and improves code efficiency.
Purpose: Provides a single database connection object for all queries.

# Strategy (Donor Tiers)
The Strategy pattern is used to implement different donor tiers (Gold, Silver, Platinum) with unique donation strategies for each tier.
Purpose: Allows the system to dynamically select the appropriate strategy based on the donor's tier.


### Contributing
Contributions are welcome! Here are some guidelines:

1. Fork the repository and create your feature branch.
  ```bash
  git checkout -b feature/new-feature
```
2. Commit your changes with descriptive messages.
  ```bash
  git commit -m "Add new feature"
  ```
3. Push to the branch.
  ```bash
  git push origin feature/new-feature
  ```
4. Open a Pull Request. Describe the changes you made and submit it for review.
Please make sure your code follows best practices and is well-documented.

### License
This project is licensed under the ASU License - see the LICENSE file for details. (to be added if acquired)

### Acknowledgments
This project was developed as part of a ASU Software Design Patterns Project to support charitable medical aid initiatives. We thank all contributors and collaborators for their assistance and support in building this project.

Feel free to reach out if you encounter any issues or have suggestions for improvement. Happy coding!

### Main Collaborators

This project wasn't going to be possible if it weren't for:
<br>
[Tarek Khaled](https://github.com/tito360x)
<br>
[Ismail Seddik](https://github.com/Ismailseddik)
<br>
[Mohamed Ayman](https://github.com/M0hAyman)
<br>
[Mohamed Hesham](https://github.com/MHZDN)
