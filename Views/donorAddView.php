<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Donor</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Styling for the form container */
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
        input[type="date"],
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

        .hidden {
            display: none;
        }
    </style>
</head>
<body>
<header>
    <h1>Add New Donor</h1>
</header>

<main class="container">
    <!-- <form action="index.php?view=donor&action=paymentType" method="POST">
    <select name="payment_type" id="paymentType" class="form-control" onchange="toggleDonationFields()">
            <option value="Paypal">Paypal</option>
            <option value="Credit">Credit</option>
        </select>
    <button type="submit">Choose Payment</button> -->
    </form>
    <form action="index.php?view=donor&action=addDonor" method="POST">
        <label for="donor_first_name">First Name:</label>
        <input type="text" id="donor_first_name" name="donor_first_name" placeholder="Enter First Name" required>

        <label for="donor_last_name">Last Name:</label>
        <input type="text" id="donor_last_name" name="donor_last_name" placeholder="Enter Last Name" required>

        <label for="donor_birth_date">Birth Date:</label>
        <input type="date" id="donor_birth_date" name="donor_birth_date" required>

        <label for="donationType">Donation Type:</label>
        <select name="donation_type" id="donationType" class="form-control" onchange="toggleDonationFields()">
            <option value="Monetary">Monetary</option>
            <option value="Organ">Organ</option>
        </select>

        <div id="amountField">
            <label for="donor_amount">Donation Amount:</label>
            <input type="number" id="donor_amount" name="donor_amount" placeholder="Enter Donation Amount" />
        </div>

        <div id="organField" class="hidden">
            <label for="organ">Donation Organ:</label>
            <input type="text" id="organ" name="organ" placeholder="Enter Organ Name" required/>
        </div>
        <label for="payment">Payment Method:</label>
        <select name="paymentType" id="paymentType" class="form-control" onchange="toggleDonationFields()">
            <option value="Paypal">Paypal</option>
            <option value="Credit">Credit</option>
        </select>
        <button type="submit">Add Donor</button>
    </form>
</main>

<footer>
    <p>&copy; 2024 Medical Aid Charity. All rights reserved.</p>
</footer>

<script>
    // Function to toggle the visibility of donation fields
    function toggleDonationFields() {
        const donationType = document.getElementById('donationType').value;
        const amountField = document.getElementById('amountField');
        const organField = document.getElementById('organField');

        if (donationType === 'Monetary') {
            amountField.style.display = 'block';
            organField.style.display = 'none';
            document.getElementById('donor_amount').required = true;
            document.getElementById('organ').required = false;
        } else if (donationType === 'Organ') {
            amountField.style.display = 'none';
            organField.style.display = 'block';
            document.getElementById('donor_amount').required = false;
            document.getElementById('organ').required = true;
        }
    }

    // Initialize the form fields on page load
    document.addEventListener('DOMContentLoaded', toggleDonationFields);
</script>
</body>
</html>
