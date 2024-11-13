<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Aid Charity</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
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
<body>
    <header>
        <h1>Medical Aid Charity Application</h1>
        <nav>
            <a href="index.php?view=patient">Patient</a> |
            <a href="index.php?view=doctor">Doctor</a> |
            <a href="index.php?view=donor">Donor</a> |
            <a href="index.php?view=donation">Donation</a> | |
            <a href="index.php?view=medicalApplication">Medical Application</a>
        </nav>
    </header>

    <main>
        <?php include($content); ?>
    </main>

    <footer>
        <p>&copy; <?= date('Y') ?> Medical Aid Charity</p>
    </footer>
</body>
</html>
