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
        }
        // Get the patient from the patients table
        $stmt = $pdo->prepare('SELECT * FROM patients WHERE patId = ?');
        $stmt->execute([$_GET['patId']]);
        $patient = $stmt->fetch(PDO::FETCH_ASSOC);

    }

    if (isset($_GET['patId'])) {
        if (!empty($_POST)) {
            // This part is similar to the create.php, //but instead we update a record and not //insert
            $entryId = isset($_POST['entryId']) ? $_POST['entryId'] : '';
            $patId = isset($_POST['patId']) ? $_POST['patId'] : '';
            $testDate = isset($_POST['testDate']) ? $_POST['testDate'] : '';
            $firstTest = isset($_POST['firstTest']) ? $_POST['firstTest'] : '';
            $secondTest = isset($_POST['secondTest']) ? $_POST['secondTest'] : '';
            $thirdTest = isset($_POST['thirdTest']) ? $_POST['thirdTest'] : '';

            $fevstmt = $pdo->prepare('SELECT * FROM fev1 WHERE patId = ?');
            $fevstmt->execute([$_GET['patId']]);
            $entries = $fevstmt->fetch(PDO::FETCH_ASSOC);

        }
    }

?>
<?=template_header('Read')?>

    <div class="content read">
        <h2>Patient #<?=$patient['patId']?></h2>
        <table>
            <thead>
                <tr>
                    <td>Patient #</td>
                    <td>First Name</td>
                    <td>Last Name</td>
                    <td>Gender</td>
                    <td>Date of Birth</td>
                    <td>Genetics</td>
                    <td>Diabetes?</td>
                    <td>Other Conditions?</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=$patient['patId']?></td>
                    <td><?=$patient['patFirst']?></td>
                    <td><?=$patient['patLast']?></td>
                    <td><?=$patient['patGender']?></td>
                    <td><?=$patient['patBirthdate']?></td>
                    <td><?=$patient['patGenetics']?></td>
                    <td><?=$patient['patDiabetes']?></td>
                    <td><?=$patient['patOther']?></td>
                    <td class="actions">
                        <a href="patients_update.php?patId=<?=$patient['patId']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                        <a href="patients_delete.php?patId=<?=$patient['patId']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                    </td>
                </tr>
            </tbody>
        </table><br>

        <h2>FEV1 Tests</h2>
	    <a href="fev_create.php" class="create-contact">Input New Tests</a>
	    <table>
            <thead>
                <tr>
                    <td>Entry ID</td>
                    <td>Patient ID</td>
                    <td>Test Date</td>
                    <td>FEV 1</td>
                    <td>FEV 1</td>
                    <td>FEV 1</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=$entries['entryId']?></td>
                    <td><?=$entries['patId']?></td>
                    <td><?=$entries['testDate']?></td>
                    <td><?=$entries['firstTest']?></td>
                    <td><?=$entries['secondTest']?></td>
                    <td><?=$entries['thirdTest']?></td>
                    <td class="actions">
                        <a href="fev_update.php?entryId=<?=$entries['entryId']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                        <a href="fev_delete.php?entryId=<?=$entries['entryId']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>

<?=template_footer()?>
