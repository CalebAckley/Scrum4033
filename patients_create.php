<?php
    @include_once ('../../app_config.php');
    @include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
    $pdo = pdo_connect_mysql();
    $msg = '';
    // Check if POST data is not empty
    if (!empty($_POST)) {
        // Post data not empty insert a new record
        // Set-up the variables that are going to be inserted, //we must check if the POST variables exist if not we //can default them to blank
        $patId = isset($_POST['patId']) && !empty($_POST['patId']) && $_POST['patId'] != 'auto' ? $_POST['patId'] : NULL;
        // Check if POST variable "patFirst" exists, if not default //the value to blank, basically the same for all //variables
        $patFirst = isset($_POST['patFirst']) ? $_POST['patFirst'] : '';
        $patLast = isset($_POST['patLast']) ? $_POST['patLast'] : '';
        $patGender = isset($_POST['patGender']) ? $_POST['patGender'] : '';
        $patBirthdate = isset($_POST['patBirthdate']) ? $_POST['patBirthdate'] : date('Y-m-d');
        $patGenetics = isset($_POST['patGenetics']) ? $_POST['patGenetics'] : '';
        $patDiabetes = isset($_POST['patDiabetes']) ? $_POST['patDiabetes'] : '';
        $patOther = isset($_POST['patOther']) ? $_POST['patOther'] : '';
        // Insert new record into the patients table
        $stmt = $pdo->prepare('INSERT INTO patients VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$patId, $patFirst, $patLast, $patGender, $patBirthdate, $patGenetics, $patDiabetes, $patOther]);
        // Output message
        $msg = 'Created Successfully!';
    }
?>
<?=template_header('Create')?>

    <div class="content update">
        <h2>Create patient</h2>
        <form action="patients_create.php" method="post">
            <label for="patId">ID</label>
            <label for="patFirst">First Name</label>
            <input type="text" name="patId" placeholder="26" value="auto" id="patId">
            <input type="text" name="patFirst" placeholder="John" id="patFirst">
            <label for="patLast">Last Name</label>
            <label for="patGender">Gender</label>
            <input type="text" name="patLast" placeholder="Doe" id="patLast">
            <input type="text" name="patGender" placeholder="Gender" id="patGender">
            <label for="patBirthdate">Birthdate</label>
            <label for="patGenetics">Genetics</label>
            <input type="date" name="patBirthdate" placeholder="DD/MM/YYYY" value="<?=date('Y-m-d')?>" id="patBirthdate">
            <input type="text" name="patGenetics" placeholder="Genetics" id="patGenetics">
            <label for="patDiabetes">Diabetes?</label>
            <label for="patOther">Other Conditions?</label>
            <input type="text" name="patDiabetes" placeholder="Yes or No" id="patDiabetes">
            <input type="text" name="patOther" placeholder="List Other Conditions Here" id="patOther">
            <input type="submit" value="Create">
        </form>
        <?php if ($msg): ?>
        <p><?=$msg?></p>
        <?php endif; ?>
    </div>

<?=template_footer()?>