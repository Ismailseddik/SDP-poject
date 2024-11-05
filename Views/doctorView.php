<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Information</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <h1>Medical Aid Charity</h1>
        <p>Your help makes a difference!</p>
    </header>

    <main class="container">
        <h2>Doctor Information</h2>

        <!-- Display a list of doctors -->
        <div class="doctor-list">
            <?php if (!empty($doctors)): ?>
                <?php foreach ($doctors as $doctor): ?>
                    <div class="doctor-card">
                        <p><strong>Name:</strong> <?= htmlspecialchars($doctor['name']) ?></p>
                        <p><strong>Specialty:</strong> <?= htmlspecialchars($doctor['specialty']) ?></p>
                        <p><strong>Available Times:</strong> <?= htmlspecialchars($doctor['available_times']) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No doctors available.</p>
            <?php endif; ?>
        </div>

        <!-- Form for adding a new doctor -->
        <h3>Add New Doctor</h3>
        <form class="doctor-form" action="index.php?view=doctor&action=addDoctor" method="POST">
            <label for="doctor_fname">First Name:</label>
            <input type="text" id="doctor_fname" name="doctor_fname" placeholder="Enter First Name" required>

            <label for="doctor_lname">Last Name:</label>
            <input type="text" id="doctor_lname" name="doctor_lname" placeholder="Enter Last Name" required>

            <label for="doctor_specialty">Specialty:</label>
            <input type="text" id="doctor_specialty" name="doctor_specialty" placeholder="Enter Specialty" required>

            <label for="doctor_available_times">Available Times:</label>
            <input type="text" id="doctor_available_times" name="doctor_available_times" placeholder="e.g., Mon-Fri, 9am-3pm" required>

            <label for="doctor_birthdate">Birth Date:</label>
            <input type="date" id="doctor_birthdate" name="doctor_birthdate" required>

            <button type="submit">Add Doctor</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Medical Aid Charity. All rights reserved.</p>
    </footer>
</body>

</html>