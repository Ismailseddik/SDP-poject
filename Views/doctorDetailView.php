<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Details</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Styling for the main container and card layout */
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .doctor-details {
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .doctor-details p {
            font-size: 18px;
            color: #555;
            margin: 10px 0;
        }

        .doctor-details p strong {
            color: #333;
        }

        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold;
        }

        .back-link:hover {
            color: #388E3C;
        }
    </style>
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

        <a class="back-link" href="index.php?view=doctor&action=listDoctors">Back to List</a>
    </main>

    <footer>
        <p>&copy; 2024 Medical Aid Charity. All rights reserved.</p>
    </footer>
</body>
</html>
