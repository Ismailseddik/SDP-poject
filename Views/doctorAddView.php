<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Doctor</title>
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
        input[type="date"],
        input[type="number"],
        input[type="checkbox"] {
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
        <h1>Add New Doctor</h1>
    </header>

    <main class="container">
        <form action="index.php?view=doctor&action=addDoctor" method="POST">
            <label for="doctor_first_name">First Name:</label>
            <input type="text" id="doctor_first_name" name="doctor_first_name" placeholder="Enter First Name" required>

            <label for="doctor_last_name">Last Name:</label>
            <input type="text" id="doctor_last_name" name="doctor_last_name" placeholder="Enter Last Name" required>

            <label for="doctor_birth_date">Birth Date:</label>
            <input type="date" id="doctor_birth_date" name="doctor_birth_date" required>

            <label for="doctor_address_id">Address ID:</label>
            <input type="number" id="doctor_address_id" name="doctor_address_id" placeholder="Enter Address ID" required>

            <label for="doctor_rank_name">Rank:</label>
            <input type="text" id="doctor_rank_name" name="doctor_rank_name" placeholder="Enter Rank" required>

            <label for="doctor_speciality_name">Specialty:</label>
            <input type="text" id="doctor_speciality_name" name="doctor_speciality_name" placeholder="Enter Specialty" required>

            <label for="is_available">Available:</label>
            <input type="checkbox" id="is_available" name="is_available" value="1">

            <button type="submit">Add Doctor</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Medical Aid Charity. All rights reserved.</p>
    </footer>
</body>
</html>
