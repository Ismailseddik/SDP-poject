<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Aid Type</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 24px;
        }

        .aid-type-options {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 15px;
        }

        .current-aid-types {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .current-aid-types ul {
            padding-left: 20px;
            margin: 0;
        }

        label {
            font-size: 16px;
            color: #555;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            font-size: 18px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .undo-button {
            margin-top: 15px;
            background-color: #f44336;
        }

        .undo-button:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>
    <header>
        <h1>Add Aid Type</h1>
    </header>

    <main class="container">
        <!-- Display current aid types -->
        <div class="current-aid-types">
            <h2>Currently Assigned Aid Types</h2>
            <?php if (!empty($existingAidTypes)): ?>
                <ul>
                    <?php foreach ($existingAidTypes as $aidType): ?>
                        <li>
                            <?php 
                            // Display aid type names based on their ID
                            switch ($aidType->get_aid_type_id()) {
                                case 1:
                                    echo "Financial Aid";
                                    break;
                                case 2:
                                    echo "Medical Aid";
                                    break;
                                case 3:
                                    echo "Operational Aid";
                                    break;
                                default:
                                    echo "Unknown Aid Type";
                                    break;
                            }
                            ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No aid types currently assigned.</p>
            <?php endif; ?>
        </div>

        <!-- Form to add new aid types -->
        <form action="index.php?view=medicalApplication&action=addAidtype" method="POST">
            <input type="hidden" id="Medical_application_id" name="Medical_application_id" value="<?= htmlspecialchars($applicationId) ?>">

            <p>Select the required aid type(s):</p>
            <div class="aid-type-options">
                <label><input type="checkbox" name="aid_type[]" value="1"> Financial Aid</label>
                <label><input type="checkbox" name="aid_type[]" value="2"> Medical Aid</label>
                <label><input type="checkbox" name="aid_type[]" value="3"> Operational Aid</label>
            </div>

            <button type="submit">Add Aid Type</button>
        </form>

        <form action="index.php?view=medicalApplication&action=undoLastAction" method="POST">
            <button type="submit" class="undo-button">Undo Last Action</button>
        </form>
    </main>

    <footer>
        <p style="text-align: center;">&copy; 2024 Medical Aid Charity. All rights reserved.</p>
    </footer>
</body>
</html>
