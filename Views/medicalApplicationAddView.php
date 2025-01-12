<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Medical Aid Application</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Medical Aid Charity</h1>
    </header>

    <main class="container">
        <h2>Add New Medical Aid Application</h2>

        <form action="index.php?view=medicalApplication&action=addApplication" method="POST" class="application-form">
            <label for="patient_id">Patient ID:</label>
            <input type="number" id="patient_id" name="patient_id" placeholder="Enter Patient ID" required>

            <label for="doctor_id">Doctor ID:</label>
            <input type="number" id="doctor_id" name="doctor_id" placeholder="Enter Doctor ID" required>

            <label for="status_id">Status:</label>
            <select id="status_id" name="status_id">
                <option value="1">Pending</option>
                <option value="2">Approved</option>
                <option value="3">Rejected</option>
            </select>


            <button type="submit" class="button">Submit Application</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Medical Aid Charity. All rights reserved.</p>
    </footer>
</body>
</html>
