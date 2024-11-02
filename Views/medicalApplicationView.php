<h2>Medical Aid Applications</h2>
<?php foreach ($applications as $application): ?>
    <div class="application-card">
        <p><strong>Patient Name:</strong> <?= htmlspecialchars($application['patient_name']) ?></p>
        <p><strong>Condition:</strong> <?= htmlspecialchars($application['condition']) ?></p>
        <p><strong>Requested Aid Type:</strong> <?= htmlspecialchars($application['aid_type']) ?></p>
    </div>
<?php endforeach; ?>

<h3>Submit New Medical Aid Application</h3>
<form action="submitApplication.php" method="POST">
    <label for="patient_name">Patient Name:</label>
    <input type="text" id="patient_name" name="patient_name" placeholder="Enter Patient Name">

    <label for="condition">Medical Condition:</label>
    <input type="text" id="condition" name="condition" placeholder="Enter Medical Condition">

    <label for="aid_type">Requested Aid Type:</label>
    <select id="aid_type" name="aid_type">
        <option value="financial">Financial Aid</option>
        <option value="medical">Medical Aid</option>
        <option value="operational">Operational Aid</option>
    </select>

    <button type="submit">Submit Application</button>
</form>
