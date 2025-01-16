<?php
// Include the factory
require_once __DIR__ . '/../Factories/UIElementFactory.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Aid Applications</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Medical Aid Charity</h1>
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

        <!-- Application List -->
        <div class="application-list">
            <?php if (!empty($applications)): ?>
                <?php foreach ($applications as $application): ?>
                    <?php
                    // Pass data to the factory
                    echo UIElementFactory::createApplicationCard([
                        'patient_name' => $application['patient_first_name'] . ' ' . $application['patient_last_name'],
                        'doctor_name' => $application['doctor_first_name'] . ' ' . $application['doctor_last_name'],
                        'status' => $application['status'],
                        'button_link' => "index.php?view=medicalApplication&action=showAddAidTypeForm&application_id=" . htmlspecialchars($application['application_id']),
                        'button_text' => 'Add Aid Types'
                    ]);
                    ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No applications available.</p>
            <?php endif; ?>
        </div>

        <!-- Add New Application Button -->
        <?= UIElementFactory::createAddButton("index.php?view=medicalApplication&action=showAddApplicationForm", "Add New Application") ?>
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
        <p>&copy; 2024 Medical Aid Charity. All rights reserved.</p>
    </footer>
</body>
</html>
