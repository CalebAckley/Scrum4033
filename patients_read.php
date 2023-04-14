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
?>
<?=template_header('Read')?>

    <div class="content read">
        <h2>Patients</h2>
        <a href="patients_create.php" class="create-contact">Create Patient</a>
        <table>
            <thead>
                <tr>
                    <td>#</td>
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
                        <a href="patients_update.php?patId=<?=$patient['patId']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                        <a href="patients_delete.php?patId=<?=$patient['patId']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
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
