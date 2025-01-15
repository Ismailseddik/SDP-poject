<?php
// Include the factory
require_once __DIR__ . '/../Factories/UIElementFactory.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Panel</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Medical Aid Charity</h1>
        <p>Your help makes a difference!</p>
    </header>
    <header>
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
        <h2>Doctor Panel</h2>

    <!-- Doctor List Section -->
    <section class="doctor-list">
        <h3>Doctor Information</h3>
        <?php if (!empty($doctors)): ?>
            <?php foreach ($doctors as $doctor): ?>
                <?php
                $doctorCardContent = [
                    'title' => htmlspecialchars($doctor->getFirstName() . ' ' . $doctor->getLastName()),
                    'content' => 
                        "<p>Specialty: " . htmlspecialchars($doctor->getSpeciality() ?? 'N/A') . "</p>" .
                        "<p>Rank: " . htmlspecialchars($doctor->getRank() ?? 'N/A') . "</p>" .
                        "<p>Available: " . (htmlspecialchars($doctor->isAvailable()) ? 'Yes' : 'No') . "</p>",
                    'link' => "index.php?view=doctor&action=viewDoctorDetails&doctor_id=" . htmlspecialchars($doctor->getId()),
                ];

                // Append applications
                $applications = Doctor::getApplicationsForDoctor($doctor->getId());
                if (!empty($applications)) {
                    $applicationsHtml = "<div class='applications'><h4>Applications:</h4>";
                    foreach ($applications as $application) {
                        $applicationsHtml .= "<p>Application ID: " . htmlspecialchars($application['application_id']) .
                                            ", Patient: " . htmlspecialchars($application['patient_first_name'] . ' ' . $application['patient_last_name']) .
                                            ", Status: " . htmlspecialchars($application['status_id']) . "</p>";
                    }
                    $applicationsHtml .= "</div>";
                    $doctorCardContent['content'] .= $applicationsHtml;
                } else {
                    $doctorCardContent['content'] .= "<p>No applications available.</p>";
                }

                // Render card
                echo UIElementFactory::createCard('doctor', $doctorCardContent);
                ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No doctors available.</p>
        <?php endif; ?>
    </section>
        <!-- Link to Add New Doctor Form -->
        <section class="doctor-form-link">
            <h3><a href="index.php?view=doctor&action=showAddDoctorForm">Add New Doctor</a></h3>
        </section>

    </main>

    <!-- Footer section -->
    <footer>
        <p>&copy; 2024 Medical Aid Charity. All rights reserved.</p>
    </footer>

</body>
</html>
