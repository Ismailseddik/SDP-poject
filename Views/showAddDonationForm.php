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

        input[type="text"],
        input[type="email"],
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
        <form action="index.php?view=donor&action=addDonation" method="POST">
            <label for="donor_first_name">First Name:</label>
            <input type="text" id="donor_first_name" name="donor_first_name" placeholder="Enter First Name" required>

            <label for="donor_last_name">Last Name:</label>
            <input type="text" id="donor_last_name" name="donor_last_name" placeholder="Enter Last Name" required>

            <label for="donor_email">Email:</label>
            <input type="email" id="donor_email" name="donor_email" placeholder="Enter Email" required>

            <label for="donor_amount">Amount Donated:</label>
            <input type="number" id="donor_amount" name="donor_amount" placeholder="Enter Amount" required>

            <label for="donation_type">Donation Type:</label>
            <select id="donation_type" name="donation_type" required>
                <option value="monetary">Monetary</option>
                <option value="organ">Organ</option>
            </select>

            <button type="submit">Add Donation</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Medical Aid Charity. All rights reserved.</p>
    </footer>
</body>
</html>
