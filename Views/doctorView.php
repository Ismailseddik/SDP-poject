<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Information</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to external CSS -->
</head>
<body>
    <div class="container">
        <h2>Doctor Information</h2>

        <div class="doctor-list">
            <?php foreach ($doctors as $doctor): ?>
                <div class="doctor-card">
                    <p><strong>Name:</strong> <?= htmlspecialchars($doctor['name']) ?></p>
                    <p><strong>Specialty:</strong> <?= htmlspecialchars($doctor['specialty']) ?></p>
                    <p><strong>Available Times:</strong> <?= htmlspecialchars($doctor['available_times']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Form for adding a new doctor -->
        <h3>Add New Doctor</h3>
        <form class="doctor-form" action="addDoctor.php" method="POST">
            <label for="doctor_name">Name:</label>
            <input type="text" id="doctor_name" name="doctor_name" placeholder="Enter Doctor Name" required>

            <label for="doctor_specialty">Specialty:</label>
            <input type="text" id="doctor_specialty" name="doctor_specialty" placeholder="Enter Specialty" required>

            <label for="doctor_available_times">Available Times:</label>
            <input type="text" id="doctor_available_times" name="doctor_available_times" placeholder="e.g., Mon-Fri, 9am-3pm" required>

            <button type="submit">Add Doctor</button>
        </form>
    </div>
</body>
</html>
