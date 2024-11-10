<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Doctor Details</h1>
    </header>

    <main class="container">
        <?php if ($doctor): ?>
            <div class="doctor-details">
                <p><strong>Name:</strong> <?= htmlspecialchars($doctor->getFirstName() . ' ' . $doctor->getLastName()) ?></p>
                <p><strong>Specialty:</strong> <?= htmlspecialchars($doctor->getSpeciality()) ?></p>
                <p><strong>Rank:</strong> <?= htmlspecialchars($doctor->getRank()) ?></p>
                <p><strong>Available:</strong> <?= htmlspecialchars($doctor->isAvailable()) ?></p>
            </div>
        <?php else: ?>
            <p>Doctor information not available.</p>
        <?php endif; ?>

        <a href="index.php?view=doctor&action=listDoctors">Back to List</a>
    </main>

    <footer>
        <p>&copy; 2024 Medical Aid Charity. All rights reserved.</p>
    </footer>
</body>
</html>
