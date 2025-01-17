<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin: 15px 0 5px;
            font-weight: bold;
            color: #555;
        }

        input[type="email"],
        input[type="password"],
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
    <h2>Login</h2>
</header>

<main class="container">
    <?php if (!empty($logs)) : ?>
        <div class="log-container">
            <h4>Log Messages:</h4>
            <ul>
                <?php foreach ($logs as $log) : ?>
                    <li><?= htmlspecialchars($log) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="index.php?view=login&action=processLogin">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required />

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required />

        <label for="role">Position:</label>
        <select id="role" name="role">
            <option value="doctor">Doctor</option>
            <option value="donor">Donor</option>
            <option value="patient">Patient</option>
        </select>

        <button type="submit">Login</button>
    </form>
</main>

<footer>
    <p>&copy; 2024 Medical Aid Charity. All rights reserved.</p>
</footer>

</body>
</html>
