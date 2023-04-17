<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;
// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM medications ORDER BY medID LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$medications = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_medications = $pdo->query('SELECT COUNT(*) FROM medications')->fetchColumn();
?>
<?=template_header('Read')?>

<div class="content read">
	<h2>Read Contacts</h2>
	<a href="medication_create.php" class="create-contact">Create Medication Form</a>
	<table>
        <thead>
            <tr>
                <td>Patient ID</td>
                <td>Med ID</td>
                <td>Vest</td>
                <td>Acapella</td>
                <td>Plumozyme</td>
                <td>Plum. Qty</td>
                <td>Plum. Date</td>
                <td>Inhaled Tobi</td>
                <td>Inhaled Colistin</td>
                <td>Hypertonic Saline</td>
                <td>Azithromycin</td>
                <td>Clarithromycin</td>
                <td>Inhaled Gentamicin</td>
                <td>Enzymes</td>
                <td>Enzymes Type/Dosage</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($medications as $medication): ?>
            <tr>
                <td><?=$medication['medID']?></td>
                <td><?=$medication['patId']?></td>
                <td><?=$medication['medVEST']?></td>
                <td><?=$medication['medAcap']?></td>
                <td><?=$medication['medPlum']?></td>
                <td><?=$medication['plumQuant']?></td>
                <td><?=$medication['plumDate']?></td>
                <td><?=$medication['medTobi']?></td>
                <td><?=$medication['medColi']?></td>
                <td><?=$medication['medHype']?></td>
                <td><?=$medication['medAzit']?></td>
                <td><?=$medication['medClar']?></td>
                <td><?=$medication['medGent']?></td>
                <td><?=$medication['medEnzy']?></td>
                <td><?=$medication['enzyType']?></td>
                <td class="actions">
                    <a href="medication_update.php?medID=<?=$medication['medID']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="medication_delete.php?medID=<?=$medication['medID']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="medication_read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_medications): ?>
		<a href="medication_read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>
