<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Information</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Optional styling for the "Add New Donor" button */
        .add-donor-button {
            display: inline-block;
            margin: 20px 0;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 4px;
            text-align: center;
            text-decoration: none;
        }

        .add-donor-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <header>
        <h1>Medical Aid Charity - Donors</h1>
    </header>

    <main class="container">
        <h2>Donor List</h2>

        <!-- "Add New Donor" Button or Link -->
        <a href="index.php?view=donor&action=donorAddView" class="add-donor-button">Add New Donor</a>

        <div class="donor-list">
            <?php if (!empty($donors)): ?>
                <?php foreach ($donors as $donor): ?>
                    <div class="donor-card">
                        <p><strong>Name:</strong> <?= htmlspecialchars($donor->getFirstName()) . ' ' . htmlspecialchars($donor->getLastName()) ?></p>
                        <p><strong>Email:</strong> <?= htmlspecialchars($donor->getEmail()) ?></p>
                        <p><strong>Donation Amount:</strong> $<?= htmlspecialchars(number_format($donor->getAmount(), 2)) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No donors available.</p>
            <?php endif; ?>
        </div>
        <a href="index.php?view=donor&action=showAddDonationForm">Add New Donation</a>
    </main>

    <footer>
        <p>&copy; 2024 Medical Aid Charity. All rights reserved.</p>
    </footer>
</body>
</html>
