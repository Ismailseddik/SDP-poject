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

          nav {
            background-color: #333;
            padding: 1em 0;
            text-align: center;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin: 0 1em;
        }

        nav ul li a {
            color: #ffffff;
            text-decoration: none;
            font-size: 1.1em;
            padding: 0.5em 1em;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        nav ul li a:hover {
            background-color: #4CAF50;
            color: #ffffff;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2, h3 {
            text-align: center;
            color: #333;
        }

        .patient-card {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }
    
    </style>
</head>
<body>
    <header>
        <h1>Medical Aid Charity - Donors</h1>
        <nav>
            <ul>
                <li><a href="index.php?view=patient&action=listPatients">Patients</a></li>
                <li><a href="index.php?view=doctor&action=listDoctors">Doctors</a></li>
                <li><a href="index.php?view=donor&action=listDonors">Donors</a></li>
                <li><a href="index.php?view=donation&action=listDonations">Donations</a></li>
                <li><a href="index.php?view=medicalApplication&action=listApplications">Medical Aid Applications</a></li>
            </ul>
        </nav>
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
