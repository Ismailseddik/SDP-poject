<h2>Aid Types</h2>
<?php foreach ($aidTypes as $aidType): ?>
    <div class="aid-type-card">
        <p><strong>Aid Type:</strong> <?= htmlspecialchars($aidType['name']) ?></p>
        <p><strong>Description:</strong> <?= htmlspecialchars($aidType['description']) ?></p>
    </div>
<?php endforeach; ?>

<h3>Add New Aid Type</h3>
<form action="addAidType.php" method="POST">
    <label for="aid_type_name">Aid Type Name:</label>
    <input type="text" id="aid_type_name" name="aid_type_name" placeholder="Enter Aid Type Name">

    <label for="aid_type_description">Description:</label>
    <input type="text" id="aid_type_description" name="aid_type_description" placeholder="Enter Description">

    <button type="submit">Add Aid Type</button>
</form>
