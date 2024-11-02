<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Aid Charity</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Medical Aid Charity Application</h1>
        <nav>
            <a href="index.php?view=patient">Patient</a> |
            <a href="index.php?view=doctor">Doctor</a> |
            <a href="index.php?view=donor">Donor</a> |
            <a href="index.php?view=donation">Donation</a> |
            <a href="index.php?view=aidType">Aid Type</a> |
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
