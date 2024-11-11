<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Panel</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Medical Aid Charity</h1>
        <p>Your help makes a difference!</p>
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
