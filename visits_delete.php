<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the order ID exists
if (isset($_GET['visitId'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM visits WHERE visitId = ?');
    $stmt->execute([$_GET['visitId']]);
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$patient) {
        $msg = 'Visit record does not exist with that visit ID!';
    }
} else {
    exit('No ID specified!');
}
// Make sure the user confirms before deletion
if (isset($_GET['confirm'])) {
    if ($_GET['confirm'] == 'yes') {
        // User clicked the "Yes" button, delete record
        $stmt = $pdo->prepare('DELETE FROM visits WHERE visitId = ? ');
        $stmt->execute([$_GET['visitId']]);
        $msg = 'You have deleted the visit entry!';
    } else {
        // User clicked the "No" button, redirect them back to the read page
        header('Location: visits_read.php');
        exit;
    }
}
?>
<?=template_header('Delete')?>

<div class="content delete">
    <h2>Delete Entry #<?=$patient['visitId']?></h2>
    <?php if ($msg): ?>
        <p><?=$msg?></p>
    <?php else: ?>
        <p>Are you sure you want to delete the visit record #<?=$patient['visitId']?>?</p>
        <div class="yesno">
            <a href="visits_delete.php?visitId=<?=$patient['visitId']?>&confirm=yes">Yes</a>
            <a href="visits_read.php">No</a>
        </div>
    <?php endif; ?>
</div>

<?=template_footer()?>
