<?php
// Include the factory
require_once __DIR__ . '/../Factories/UIElementFactory.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Information</title>
    <link rel="stylesheet" href="styles.css">
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

        <!-- "Add New Donor" Button -->
        <?= UIElementFactory::createButton([
            'label' => 'Add New Donor',
            'link' => 'index.php?view=donor&action=donorAddView',
            'class' => 'add-donor-button'
        ]) ?>

        <div class="donor-list">
            <?php if (!empty($donors)): ?>
                <?php foreach ($donors as $donor): ?>
                    <?php
                    echo UIElementFactory::createDonorCard([
                        'name' => $donor->getFirstName() . ' ' . $donor->getLastName(),
                        'amount' => $donor->getAmount()
                    ]);
                    ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No donors available.</p>
            <?php endif; ?>
        </div>

        <!-- Add New Donation Link -->
        <?= UIElementFactory::createButton([
            'label' => 'Add New Donation',
            'link' => 'index.php?view=donor&action=showAddDonationForm',
            'class' => 'add-donor-button'
        ]) ?>
    </main>

    <!-- Logs Section -->
    <?= !empty($logs) ? UIElementFactory::createLogList($logs) : '' ?>

    <footer>
        <p>&copy; 2024 Medical Aid Charity. All rights reserved.</p>
    </footer>
</body>
</html>
