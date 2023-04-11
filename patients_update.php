<?php
    @include_once ('../../app_config.php');
    @include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
    $pdo = pdo_connect_mysql();
    $msg = '';
    // Check if the patient patId exists, for example //update.php?patId=1 will get the patient with the patId //of 1
    if (isset($_GET['patId'])) {
        if (!empty($_POST)) {
            // This part is similar to the create.php, //but instead we update a record and not //insert
            $patId = isset($_POST['patId']) ? $_POST['patId'] : NULL;
            $patFirst = isset($_POST['patFirst']) ? $_POST['patFirst'] : '';
            $patLast = isset($_POST['patLast']) ? $_POST['patLast'] : '';
            $patGender = isset($_POST['patGender']) ? $_POST['patGender'] : '';
            $patBirthdate = isset($_POST['patBirthdate']) ? $_POST['patBirthdate'] : date('Y-m-d');
            $patGenetics = isset($_POST['patGenetics']) ? $_POST['patGenetics'] : '';
            $patDiabetes = isset($_POST['patDiabetes']) ? $_POST['patDiabetes'] : '';
            $patOther = isset($_POST['patOther']) ? $_POST['patOther'] : '';
            // Update the record
            $stmt = $pdo->prepare('UPDATE patients SET patId = ?, patFirst = ?, patLast = ?, patGender = ?, patBirthdate = ?, patGenetics = ?, patDiabetes = ?, patOther = ? WHERE patId = ?');
            $stmt->execute([$patId, $patFirst, $patLast, $patGender, $patBirthdate, $patGenetics, $patDiabetes, $patOther, $_GET['patId']]);
            $msg = 'Updated Successfully!';
        }
        // Get the patient from the patients table
        $stmt = $pdo->prepare('SELECT * FROM patients WHERE patId = ?');
        $stmt->execute([$_GET['patId']]);
        $patient = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$patient) {
            exit('patient doesn\'t exist with that ID!');
        }
    } else {
        exit('No ID specified!');
    }
?>
<?=template_header('Read')?>

    <div class="content update">
        <h2>Update patient #<?=$patient['patId']?></h2>
        <form action="patients_update.php?patId=<?=$patient['patId']?>" method="post">
            <label for="patId">ID</label>
            <label for="patFirst">First Name</label>
            <input type="text" name="patId" placeholder="1" value="<?=$patient['patId']?>" id="patId">
            <input type="text" name="patFirst" placeholder="John" value="<?=$patient['patFirst']?>" id="patFirst">
            <label for="patLast">Last Name</label>
            <label for="patGender">Gender</label>
            <input type="text" name="patLast" placeholder="Doe" value="<?=$patient['patLast']?>" id="patLast">
            <input type="text" name="patGender" placeholder="Gender" value="<?=$patient['patGender']?>" id="patGender">
            <label for="patBirthdate">Date of Birth</label>
            <label for="patGenetics">Genetics</label>
            <input type="date" name="patBirthdate" placeholder="DD/MM/YYYY" value="<?=date('Y-m-d')?>" id="patBirthdate">
            <input type="text" name="patGenetics" value="<?=$patient['patGenetics']?>" id="patGenetics">
            <label for="patDiabetes">Diabetes?</label>
            <label for="patOther">Other Conditions?</label>
            <input type="text" name="patDiabetes" placeholder="Yes or No?" value="<?=$patient['patDiabetes']?>" id="patDiabetes">
            <input type="text" name="patOther" placeholder="List Other Conditions Here" value="<?=$patient['patOther']?>" id="patOther">
            <input type="submit" value="Update">
        </form>
        <?php if ($msg): ?>
        <p><?=$msg?></p>
        <?php endif; ?>
    </div>

<?=template_footer()?>
