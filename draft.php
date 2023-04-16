<?php
    @include_once ('../../app_config.php');
    @include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
    // Connect to MySQL database
    $pdo = pdo_connect_mysql();
    // Get the page via GET request (URL param: page), if non exists default the page to 1
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    // Number of records to show on each page
    $records_per_page = 10;
    // Prepare the SQL statement and get records from our patients table, LIMIT will determine the page
    $stmt = $pdo->prepare('SELECT * FROM patients ORDER BY patId LIMIT :current_page, :record_per_page');
    $stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
    $stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
    $stmt->execute();
    // Fetch the records so we can display them in our template.
    $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Get the total number of patients, this is so we can determine whether there should be a next and previous button
    $num_patients = $pdo->query('SELECT COUNT(*) FROM patients')->fetchColumn();
    //$selected_patient = $pdo->prepare('SELECT COUNT(*) FROM patients WHERE patId =');

    if (isset($_GET['patId'])) {
        if (!empty($_POST)) {
            $entryId = isset($_POST['entryId']) ? $_POST['entryId'] : NULL;
            $patId = isset($_POST['patId']) ? $_POST['patId'] : NULL;
            $testDate = isset($_POST['testDate']) ? $_POST['testDate'] : '';
            $firstTest = isset($_POST['firstTest']) ? $_POST['firstTest'] : '';
            $secondTest = isset($_POST['secondTest']) ? $_POST['secondTest'] : '';
            $thirdTest = isset($_POST['thirdTest']) ? $_POST['thirdTest'] : '';  
        }        
    
        $fev_stmt = $pdo->prepare('SELECT * from fev1 WHERE patId = ?');
        $fev_stmt->execute([$_GET['patId']]);
        $entries = $fev_stmt->fetch(PDO::FETCH_ASSOC);

        if (!$entries) {
            exit('Test doesn\'t exist with that Patient ID!');
        }
        else {
            exit('No ID specified!');
        }
    }

?>

<?=template_header('Read')?>
    <div class="content read">
        <h2>Patient File</h2>
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
                <?php foreach ($patients as $patient): ?>
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
                        <a href="draft.php?patId=<?=$patient['patId']?>" class="select"><i class="fas fa-hand-pointer" style="color: #ffffff;"></i></a>
                        <a href="patients_update.php?patId=<?=$patient['patId']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                        <a href="patients_delete.php?patId=<?=$patient['patId']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table><br>

    <h2>FEV1 Test</h2>        
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
            <?php foreach ($entries as $entry): ?>            
            <tr>
                <td><?=$entry['entryId']?></td>
                <td><?=$entry['patId']?></td>
                <td><?=$entry['testDate']?></td>
                <td><?=$entry['firstTest']?></td>
                <td><?=$entry['secondTest']?></td>
                <td><?=$entry['thirdTest']?></td>
                <td class="actions">
                    <a href="fev_update.php?entryId=<?=$entry['entryId']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="fev_delete.php?entryId=<?=$entry['entryId']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

        <div class="pagination">
            <?php if ($page > 1): ?>
            <a href="patients_read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
            <?php endif; ?>
            <?php if ($page*$records_per_page < $num_patients): ?>
            <a href="patients_read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
            <?php endif; ?>
        </div>
    </div>

<?=template_footer()?>