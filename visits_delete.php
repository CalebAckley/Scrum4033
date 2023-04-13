<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the order ID exists
if (isset($_GET['patId']) && isset($_GET['visitDate'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM visits WHERE patId = ? AND visitDate = ?');
    $stmt->execute([$_GET['patId'], $_GET['visitDate']]);
    $entry = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$entry) {
        exit('Visit record does not exist with that patient ID and/or date!');
    }
    // Code to execute if the visit record exists
}
    // Make sure the user confirms before deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM visits WHERE patId = ?, visitDate = ?');
            $stmt->execute([$_GET['patId'], $_GET['visitDate']]);
            $msg = 'You have deleted the visit entry!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: visits_read.php');
            exit;
        }
    } else {
    exit('No ID specified!');
}
?>
<?=template_header('Delete')?>

<div class="content delete">
<h2>Delete Entry #<?=$entry['patId']?> - <?=$entry['visitDate']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete test entry for Patient #<?=$entry['patId']?> - <?=$entry['visitDate']?>?</p>
    <div class="yesno">
        <a href="visits_delete.php?patId=<?=$entry['patId']?>&confirm=yes">Yes</a>
        <a href="orders_delete.php?patId=<?=$entry['patId']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>
