<?php
require_once __DIR__ . '/../Factories/UIElementFactory.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Doctor</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <h1>Add New Doctor</h1>
</header>

<main class="container">
    <form action="index.php?view=doctor&action=addDoctor" method="POST">
        <?= UIElementFactory::createFormField([
            'label' => 'First Name:',
            'name' => 'doctor_first_name',
            'type' => 'text',
            'placeholder' => 'Enter First Name',
            'required' => true,
        ]) ?>

        <?= UIElementFactory::createFormField([
            'label' => 'Last Name:',
            'name' => 'doctor_last_name',
            'type' => 'text',
            'placeholder' => 'Enter Last Name',
            'required' => true,
        ]) ?>

        <?= UIElementFactory::createFormField([
            'label' => 'Birth Date:',
            'name' => 'doctor_birth_date',
            'type' => 'date',
            'placeholder' => '',
            'required' => true,
        ]) ?>

        <?= UIElementFactory::createFormField([
            'label' => 'Address ID:',
            'name' => 'doctor_address_id',
            'type' => 'number',
            'placeholder' => 'Enter Address ID',
            'required' => true,
        ]) ?>

        <?= UIElementFactory::createDropdownField([
            'label' => 'Rank:',
            'name' => 'doctor_rank_id', 
            'options' => $ranks, // Pass rank array (ID => Name)
            'placeholder' => 'Select Rank',
        ]) ?>

        <?= UIElementFactory::createDropdownField([
            'label' => 'Specialty:',
            'name' => 'doctor_speciality_id', 
            'options' => $specialties, // Pass specialty array (ID => Name)
            'placeholder' => 'Select Specialty',
        ]) ?>

        <?= UIElementFactory::createFormField([
            'label' => 'Available:',
            'name' => 'doctor_available',
            'type' => 'checkbox',
        ]) ?>

        <?= UIElementFactory::createSubmitButton('Add Doctor') ?>
    </form>
</main>

<footer>
    <p>&copy; 2024 Medical Aid Charity. All rights reserved.</p>
</footer>
</body>
</html>
