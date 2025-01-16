<?php
// Include the factory
require_once __DIR__ . '/../Factories/UIElementFactory.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Information</title>
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
        <h2>Patient List</h2>

        <div class="patient-list">
            <?php if (!empty($patients)): ?>
                <?php foreach ($patients as $patient): ?>
                    <?php
                    // Pass patient data to the factory
                    $patientData = [
                        'name' => $patient->getName(),
                        'age' => $patient->getAge(),
                    ];
                    echo UIElementFactory::createPatientCard($patientData);
                    ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No patients available.</p>
            <?php endif; ?>
        </div>

        <h3>Add New Patient</h3>
        <form class="patient-form" action="index.php?view=patient&action=addPatient" method="POST">
            <?= UIElementFactory::createFormField([
                'label' => 'Name:',
                'name' => 'patient_name',
                'type' => 'text',
                'placeholder' => 'Enter Patient Name'
            ]) ?>

            <?= UIElementFactory::createFormField([
                'label' => 'Age:',
                'name' => 'patient_age',
                'type' => 'number',
                'placeholder' => 'Enter Age'
            ]) ?>

            <?= UIElementFactory::createSubmitButton('Add Patient') ?>
        </form>

        </form>
    </main>
    <footer>
        <p>&copy; 2024 Medical Aid Charity. All rights reserved.</p>
    </footer>
</body>
</html>
