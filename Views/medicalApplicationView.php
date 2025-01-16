<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['message'])): ?>
    <div class="success-message">
        <?= htmlspecialchars($_SESSION['message']) ?>
    </div>
<?php
    unset($_SESSION['message']); // Clear message after displaying
endif;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Aid Applications</title>
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
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .application-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .application-card {
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .application-card p {
            margin: 0 0 10px;
            font-size: 14px;
            color: #333;
        }

        .application-card .button {
            display: inline-block;
            text-align: center;
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: bold;
        }

        .application-card .button:hover {
            background-color: #45a049;
        }

        h2 {
            text-align: center;
            color: #4CAF50;
            font-size: 24px;
        }

        .add-button {
            text-align: center;
            margin-top: 20px;
        }

        .add-button .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
        }

        .add-button .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <header>
        <h1>Medical Aid Charity</h1>
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
        <h2>Medical Aid Applications</h2>

        <div class="application-list">
            <?php 
            // Debugging step to print application data in the view:
            error_log(print_r($applications, true));

            foreach ($applications as $application): ?>
                <div class="application-card">
                    <p><strong>Patient:</strong> <?= htmlspecialchars($application['patient_first_name'] . ' ' . $application['patient_last_name']) ?></p>
                    <p><strong>Doctor:</strong> <?= htmlspecialchars($application['doctor_first_name'] . ' ' . $application['doctor_last_name']) ?></p>
                    <p><strong>Status:</strong> <?= htmlspecialchars($application['status']) ?></p>
                    <a href="index.php?view=medicalApplication&action=showAddAidTypeForm&application_id=<?= htmlspecialchars($application['application_id']) ?>" class="button">Add Aid Types</a>
                </div>
            <?php endforeach; ?>
        </div>


        <div class="add-button">
            <a href="index.php?view=medicalApplication&action=showAddApplicationForm" class="button">Add New Application</a>
        </div>
    </main>
    <?php if (!empty($logs)): ?>
        <div class="logs">
            <h3>Logs</h3>
            <ul>
                <?php foreach ($logs as $log): ?>
                    <li><?= htmlspecialchars($log) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <footer>
        <p style="text-align: center;">&copy; 2024 Medical Aid Charity. All rights reserved.</p>
    </footer>
</body>
</html>
