<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Donation</title>
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
            color: #fff;
            margin: 0;
            padding: 15px;
        }

        .header-bar {
            background-color: #0a9396;
            border-radius: 8px 8px 0 0;
        }

        label {
            display: block;
            margin: 15px 0 5px;
            font-weight: bold;
            color: #555;
        }

        input[type="number"],
        input[type="text"],
        select {
            width: 100%;
            padding: 10px;
            margin: 5px 0 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .hidden {
            display: none;
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
    <div class="header-bar">
        <h1>Add New Donation</h1>
    </div>
</header>

<main class="container">
    <form method="POST" action="index.php?view=donor&action=addDonation">
        <label for="donor">Select Donor:</label>
        <?php if (empty($donors)): ?>
            <p>No donors available. Please add donors before making a donation.</p>
        <?php else: ?>
            <select name="donor_id" id="donor" class="form-control" required>
                <option value="">Select Donor</option>
                <?php foreach ($donors as $donor): ?>
                    <option value="<?= htmlspecialchars($donor->getId()); ?>">
                        <?= htmlspecialchars($donor->getFirstName() . ' ' . $donor->getLastName()); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        <?php endif; ?>

        <label for="donation">Select Donation:</label>
        <?php if (empty($donations)): ?>
            <p>No donations available. Please add donations before making a donation.</p>
        <?php else: ?>
            <select name="donation_id" id="donation" class="form-control" required>
                <option value="">Select Donation</option>
                <?php foreach ($donations as $donation): ?>
                    <option value="<?= htmlspecialchars($donation->getDonationId()); ?>">
                        <?= htmlspecialchars($donation->getDonationId()); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        <?php endif; ?>

        <label for="donationType">Donation Type:</label>
        <select name="donation_type" id="donationType" class="form-control" required>
            <option value="Monetary">Monetary</option>
            <option value="Organ">Organ</option>
        </select>

        <!-- Monetary Donation Section -->
        <div id="monetaryFields" class="hidden">
            <label for="amount">Amount Donated:</label>
            <input type="number" name="amount" id="amount" class="form-control" placeholder="Enter Amount" min="1" />
        </div>

        <!-- Organ Donation Section -->
        <div id="organFields" class="hidden">
            <label for="organ">Organ Donated:</label>
            <input type="text" name="organ" id="organ" class="form-control" placeholder="Enter Organ (e.g., Kidney)" />
            <label for="organCondition">Organ Condition:</label>
            <input type="text" name="organ_condition" id="organCondition" class="form-control" placeholder="Describe Organ Condition" />
        </div>

        <button type="submit" class="btn btn-success mt-3">Add Donation</button>
    </form>
</main>

<footer>
    <p>&copy; 2024 Medical Aid Charity. All rights reserved.</p>
</footer>

<script>
    // JavaScript to toggle fields
    document.addEventListener("DOMContentLoaded", function () {
        const donationType = document.getElementById("donationType");
        const monetaryFields = document.getElementById("monetaryFields");
        const organFields = document.getElementById("organFields");

        // Toggle fields based on donation type
        function toggleFields() {
            const type = donationType.value;
            if (type === "Monetary") {
                monetaryFields.classList.remove("hidden");
                organFields.classList.add("hidden");
            } else if (type === "Organ") {
                organFields.classList.remove("hidden");
                monetaryFields.classList.add("hidden");
            } else {
                monetaryFields.classList.add("hidden");
                organFields.classList.add("hidden");
            }
        }

        // Initialize fields on load
        toggleFields();

        // Add event listener for changes
        donationType.addEventListener("change", toggleFields);
    });
</script>
</body>
</html>
