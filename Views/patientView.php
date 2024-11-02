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
    </header>

    <main class="container">
        <h2>Patient Information</h2>

        <div class="patient-list">
            <?php foreach ($patients as $patient): ?>
                <div class="patient-card">
                    <p><strong>Name:</strong> <?= htmlspecialchars($patient['name']) ?></p>
                    <p><strong>Age:</strong> <?= htmlspecialchars($patient['age']) ?></p>
                    <p><strong>Condition:</strong> <?= htmlspecialchars($patient['condition']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <h3>Add New Patient</h3>
        <form class="patient-form" action="addPatient.php" method="POST">
            <label for="patient_name">Name:</label>
            <input type="text" id="patient_name" name="patient_name" placeholder="Enter Patient Name" required>

            <label for="patient_age">Age:</label>
            <input type="number" id="patient_age" name="patient_age" placeholder="Enter Age" required>

            <label for="patient_condition">Condition:</label>
            <input type="text" id="patient_condition" name="patient_condition" placeholder="Enter Condition" required>

            <button type="submit">Add Patient</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Medical Aid Charity. All rights reserved.</p>
    </footer>
</body>
</html>
