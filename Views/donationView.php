<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donations</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Medical Aid Charity</h1>
    </header>

    <main class="container">
        <h2>Donations</h2>

        <div class="donation-list">
            <?php foreach ($donations as $donation): ?>
                <div class="donation-card">
                    <p><strong>Donor:</strong> <?= htmlspecialchars($donation['donor_name']) ?></p>
                    <p><strong>Amount:</strong> $<?= htmlspecialchars($donation['amount']) ?></p>
                    <p><strong>Date:</strong> <?= htmlspecialchars($donation['date']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <h3>Make a New Donation</h3>
        <form class="donation-form" action="addDonation.php" method="POST">
            <label for="donor_name">Donor Name:</label>
            <input type="text" id="donor_name" name="donor_name" placeholder="Enter Donor Name" required>

            <label for="donor_amount">Amount:</label>
            <input type="number" id="donor_amount" name="donor_amount" placeholder="Enter Donation Amount" required>

            <button type="submit">Donate</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Medical Aid Charity. All rights reserved.</p>
    </footer>
</body>
</html>
