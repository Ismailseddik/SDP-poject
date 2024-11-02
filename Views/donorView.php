<h2>Donor Information</h2>
<?php foreach ($donors as $donor): ?>
    <div class="donor-card">
        <p><strong>Name:</strong> <?= htmlspecialchars($donor['name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($donor['email']) ?></p>
        <p><strong>Donation Amount:</strong> $<?= htmlspecialchars($donor['amount']) ?></p>
    </div>
<?php endforeach; ?>

<h3>Add New Donor</h3>
<form action="addDonor.php" method="POST">
    <label for="donor_name">Name:</label>
    <input type="text" id="donor_name" name="donor_name" placeholder="Enter Donor Name">

    <label for="donor_email">Email:</label>
    <input type="email" id="donor_email" name="donor_email" placeholder="Enter Donor Email">

    <label for="donation_amount">Donation Amount:</label>
    <input type="number" id="donation_amount" name="donation_amount" placeholder="Enter Amount">

    <button type="submit">Add Donor</button>
</form>
