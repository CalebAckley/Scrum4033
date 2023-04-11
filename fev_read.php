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
$stmt = $pdo->prepare('SELECT * FROM fev1 ORDER BY entryId LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$entires = $stmt->fetchAll(PDO::FETCH_ASSOC);

$num_entries = $pdo->query('SELECT COUNT(*) FROM fev1')->fetchColumn();
?>
<?=template_header('Read')?>

<div class="content read">
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
            <?php foreach ($entires as $entry): ?>
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
		<a href="fev_read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_entries): ?>
		<a href="fev_read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>
