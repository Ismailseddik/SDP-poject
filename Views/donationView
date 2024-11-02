<h2>Donation Records</h2>
<?php foreach ($donations as $donation): ?>
    <div class="donation-card">
        <p><strong>Donation ID:</strong> <?= htmlspecialchars($donation['id']) ?></p>
        <p><strong>Amount:</strong> $<?= htmlspecialchars($donation['amount']) ?></p>
        <p><strong>Donor:</strong> <?= htmlspecialchars($donation['donor_name']) ?></p>
    </div>
<?php endforeach; ?>

<h3>New Donation</h3>
<form action="addDonation.php" method="POST">
    <label for="donor_id">Donor ID:</label>
    <input type="number" id="donor_id" name="donor_id" placeholder="Enter Donor ID">

    <label for="donation_amount">Amount:</label>
    <input type="number" id="donation_amount" name="donation_amount" placeholder="Enter Donation Amount">

    <button type="submit">Add Donation</button>
</form>
