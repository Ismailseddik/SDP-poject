<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Medical Aid Charity</h1>
    </header>

    <main class="container">
        <h2>Application Details</h2>

        <div class="application-card">
            <p><strong>Patient Name:</strong> <?= htmlspecialchars($application['patient_name']) ?></p>
            <p><strong>Doctor Name:</strong> <?= htmlspecialchars($application['doctor_name']) ?></p>
            <p><strong>Status:</strong> <?= htmlspecialchars($application['application_status']) ?></p>
        </div>

        <h3>Update Application Status</h3>
        <form action="index.php?view=medicalApplication&action=updateStatus" method="POST" class="application-form">
            <input type="hidden" name="application_id" value="<?= $application['application_id'] ?>">
            
            <label for="status_id">New Status:</label>
            <select id="status_id" name="status_id">
                <option value="1" <?= $application['application_status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="2" <?= $application['application_status'] == 'Approved' ? 'selected' : '' ?>>Approved</option>
                <option value="3" <?= $application['application_status'] == 'Rejected' ? 'selected' : '' ?>>Rejected</option>
            </select>

            <button type="submit" class="button">Update Status</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Medical Aid Charity. All rights reserved.</p>
    </footer>
</body>
</html>
