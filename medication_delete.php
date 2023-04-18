<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the contact ID exists
if (isset($_GET['medId'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM medications WHERE medID = ?');
    $stmt->execute([$_GET['medID']]);
    $medication = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$medication) {
        exit('Medication Form doesn\'t exist with that ID!');
    }
    // Make sure the user confirms before deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM medications WHERE medID = ?');
            $stmt->execute([$_GET['medID']]);
            $msg = 'You have deleted the medication form!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: medication_read.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Delete')?>

<div class="content delete">
	<h2>Delete Medication Form #<?=$medication['medID']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete this medication form #<?=$medication['medID']?>?</p>
    <div class="yesno">
        <a href="medication_delete.php?medID=<?=$medication['medID']?>&confirm=yes">Yes</a>
        <a href="medication_delete.php?medID=<?=$medication['medID']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>
