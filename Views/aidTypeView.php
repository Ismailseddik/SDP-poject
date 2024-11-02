<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aid Types</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Medical Aid Charity</h1>
    </header>

    <main class="container">
        <h2>Available Aid Types</h2>

        <div class="aid-type-list">
            <?php foreach ($aidTypes as $type): ?>
                <div class="aid-type-card">
                    <p><strong>Type:</strong> <?= htmlspecialchars($type['name']) ?></p>
                    <p><strong>Description:</strong> <?= htmlspecialchars($type['description']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Medical Aid Charity. All rights reserved.</p>
    </footer>
</body>
</html>
