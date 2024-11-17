<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Panel</title>
    <link rel="stylesheet" href="styles.css">
    <style>
                nav {
            background-color: #333;
            padding: 1em 0;
            text-align: center;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin: 0 1em;
        }

        nav ul li a {
            color: #ffffff;
            text-decoration: none;
            font-size: 1.1em;
            padding: 0.5em 1em;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        nav ul li a:hover {
            background-color: #4CAF50;
            color: #ffffff;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2, h3 {
            text-align: center;
            color: #333;
        }

        .patient-card {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <header>
        <h1>Medical Aid Charity</h1>
        <p>Your help makes a difference!</p>
    </header>
    <header>
        <nav>
            <ul>
                <li><a href="index.php?view=patient&action=listPatients">Patients</a></li>
                <li><a href="index.php?view=doctor&action=listDoctors">Doctors</a></li>
                <li><a href="index.php?view=donor&action=listDonors">Donors</a></li>
                <li><a href="index.php?view=donation&action=listDonations">Donations</a></li>
                <li><a href="index.php?view=medicalApplication&action=listApplications">Medical Aid Applications</a></li>
            </ul>
        </nav>
    </header>
    <main class="container">
        <h2>Doctor Panel</h2>

        <!-- Doctor List Section -->
        <section class="doctor-list">
            <h3>Doctor Information</h3>
            <?php if (!empty($doctors)): ?>
                <?php foreach ($doctors as $doctor): ?>
                    <div class="doctor-card">
                        <p><strong>Name:</strong> <?= htmlspecialchars($doctor->getFirstName() ?? "N/A") . ' ' . htmlspecialchars($doctor->getLastName() ?? "N/A") ?></p>
                        <p><strong>Specialty:</strong> <?= htmlspecialchars($doctor->getSpeciality() ?? "N/A") ?></p>
                        <p><strong>Rank:</strong> <?= htmlspecialchars($doctor->getRank() ?? "N/A") ?></p>
                        <p><strong>Available:</strong> <?= htmlspecialchars($doctor->isAvailable()) ?></p>
                        <!-- Application Section -->
                    <div class="applications">
                        <h4>Applications:</h4>
                        <?php 
                        $applications = Doctor::getApplicationsForDoctor($doctor->getId()); // Fetch applications dynamically
                        if (!empty($applications)): ?>
                            <?php foreach ($applications as $application): ?>
                                <p>
                                    Application ID: <?= htmlspecialchars($application['application_id']) ?>, 
                                    Patient: <?= htmlspecialchars($application['patient_first_name'] . ' ' . $application['patient_last_name']) ?>,
                                    Status: <?= htmlspecialchars($application['status_id']) ?>
                                </p>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No applications available.</p>
                        <?php endif; ?>
                    </div>
                        <a href="index.php?view=doctor&action=viewDoctorDetails&doctor_id=<?= htmlspecialchars($doctor->getId() ?? 0) ?>">View Details</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No doctors available.</p>
            <?php endif; ?>
        </section>

        <!-- Link to Add New Doctor Form -->
        <section class="doctor-form-link">
            <h3><a href="index.php?view=doctor&action=showAddDoctorForm">Add New Doctor</a></h3>
        </section>
    </main>

    <!-- Footer section -->
    <footer>
        <p>&copy; 2024 Medical Aid Charity. All rights reserved.</p>
    </footer>

</body>
</html>
