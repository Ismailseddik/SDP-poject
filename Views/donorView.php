<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Information</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Medical Aid Charity</h1>
    </header>

    <main class="container">
        <h2>Donor Information</h2>

        <div class="donor-list">
            <?php foreach ($donors as $donor): ?>
                <div class="donor-card">
                    <p><strong>Name:</strong> <?= htmlspecialchars($donor['name']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($donor['email']) ?></p>
                    <p><strong>Amount Donated:</strong> $<?= htmlspecialchars($donor['amount']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <h3>Add New Donor</h3>
        <form class="donor-form" action="addDonor.php" method="POST">
            <label for="donor_name">Name:</label>
            <input type="text" id="donor_name" name="donor_name" placeholder="Enter Donor Name" required>

            <label for="donor_email">Email:</label>
            <input type="email" id="donor_email" name="donor_email" placeholder="Enter Email" required>

            <label for="donor_amount">Amount Donated:</label>
            <input type="number" id="donor_amount" name="donor_amount" placeholder="Enter Amount" required>

            <button type="submit">Add Donor</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Medical Aid Charity. All rights reserved.</p>
    </footer>
</body>
</html>
