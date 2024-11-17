<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Donation</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Styling for container and form */
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin: 15px 0 5px;
            font-weight: bold;
            color: #555;
        }

        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            margin: 5px 0 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            font-size: 18px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<header>
    <h1>Add New Donation</h1>
</header>

<main class="container">
    <h2>Add New Donation</h2>
    <form method="POST" action="index.php?view=donor&action=addDonation">
        <label for="donor">Select Donor:</label>
        <?php if (empty($donors)): ?>
            <p>No donors available. Please add donors before making a donation.</p>
        <?php else: ?>
            <select name="donor_id" id="donor" class="form-control">
                <option value="">Select Donor</option>
                <?php foreach ($donors as $donor): ?>
                    <option value="<?= htmlspecialchars($donor->getId()); ?>">
                        <?= htmlspecialchars($donor->getFirstName() . ' ' . $donor->getLastName()); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        <?php endif; ?>

        <label for="donor">Select Donation:</label>
        <?php if (empty($donations)): ?>
            <p>No donations available. Please add donations before making a donation.</p>
        <?php else: ?>
            <select name="donation_id" id="donation" class="form-control">
                <option value="">Select Donation</option>
                <?php foreach ($donations as $donation): ?>
                    <option value="<?= htmlspecialchars($donation->getDonationId()); ?>">
                        <?= htmlspecialchars($donation->getDonationId()); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        <?php endif; ?>
        <label for="amount">Amount Donated:</label>
        <input type="number" name="amount" id="amount" class="form-control" placeholder="Enter Amount" required />

        <label for="donationType">Donation Type:</label>
        <select name="donation_type" id="donationType" class="form-control">
            <option value="Monetary">Monetary</option>
            <option value="Organ">Organ</option>
        </select>

        <button type="submit" class="btn btn-success mt-3">Add Donation</button>
    </form>

</main>

<footer>
    <p>&copy; 2024 Medical Aid Charity. All rights reserved.</p>
</footer>
</body>
</html>
