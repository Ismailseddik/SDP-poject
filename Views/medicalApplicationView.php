<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Application</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Medical Aid Charity</h1>
    </header>

    <main class="container">
        <h2>Medical Applications</h2>

        <div class="application-list">
            <?php foreach ($applications as $application): ?>
                <div class="application-card">
                    <p><strong>Patient:</strong> <?= htmlspecialchars($application['patient_name']) ?></p>
                    <p><strong>Requested Aid:</strong> <?= htmlspecialchars($application['aid_type']) ?></p>
                    <p><strong>Status:</strong> <?= htmlspecialchars($application['status']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <h3>Submit New Application</h3>
        <form class="application-form" action="submitApplication.php" method="POST">
            <label for="patient_name">Patient Name:</label>
            <input type="text" id="patient_name" name="patient_name" placeholder="Enter Patient Name" required>

            <label for="aid_type">Aid Type:</label>
            <select id="aid_type" name="aid_type" required>
                <option value="financial">Financial Aid</option>
                <option value="medical">Medical Aid</option>
                <option value="operational">Operational Aid</option>
            </select>

            <button type="submit">Submit Application</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Medical Aid Charity. All rights reserved.</p>
    </footer>
</body>
</html>
