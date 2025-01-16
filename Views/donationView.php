<?php
// Include the factory
require_once __DIR__ . '/../Factories/UIElementFactory.php';
?>
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
    <h2>Donations</h2>

    <section class="donation-list">
        <?php if (!empty($donations) && !empty($donors)): ?>
            <?php foreach ($donations as $index => $donation): ?>
                <?php
                $donorName = $index < count($donors) 
                    ? htmlspecialchars($donors[$index]->getFirstName() . ' ' . $donors[$index]->getLastName()) 
                    : 'Unknown Donor';

                echo UIElementFactory::createDonationCard([
                    'donationId' => $donation->getDonationId(),
                    'donorName' => $donorName,
                    'amount' => $donation->getAmount(),
                    'organ' => $donation->getOrgan(),
                    'date' => $donation->getDonationDate()?->format('Y-m-d')
                ]);
                ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No donations or donors available.</p>
        <?php endif; ?>
    </section>
</main>

<footer>
    <p>&copy; 2024 Medical Aid Charity. All rights reserved.</p>
</footer>
</body>
</html>
