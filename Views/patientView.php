<h2>Patient Information</h2>
<?php foreach ($patients as $patient): ?>
    <div class="patient-card">
        <p><strong>Name:</strong> <?= htmlspecialchars($patient['name']) ?></p>
        <p><strong>Age:</strong> <?= htmlspecialchars($patient['age']) ?></p>
        <p><strong>Condition:</strong> <?= htmlspecialchars($patient['condition']) ?></p>
    </div>
<?php endforeach; ?>
