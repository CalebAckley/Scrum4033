<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example //update.php?id=1 will get the contact with the id //of 1
if (isset($_GET['visitId']) ) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, //but instead we update a record and not //insert
        $visitId = isset($_POST['visitId']) ? $_POST['visitId'] : NULL;
        $patId = isset($_POST['patId']) ? $_POST['patId'] : NULL;
        $visitDate = isset($_POST['visitDate']) ? $_POST['visitDate'] : '';
        $visitDoc = isset($_POST['visitDoc']) ? $_POST['visitDoc'] : '';

        // Update the record
        $stmt = $pdo->prepare('UPDATE visits SET  patId = ?, visitDate = ?, visitDoc = ? WHERE visitId = ?');
        $stmt->execute([ $patId, $visitDate, $visitDoc, $_GET['visitId']]);
        $msg = 'Updated Successfully!';
    }

    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM visits WHERE visitId = ? ');
    $stmt->execute([$_GET['visitId']]);
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$patient) {
        exit('Visit doesn\'t exist with that visit ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Read')?>

<div class="content update">
	<h2>Update Visit Data: Patient  <?=$patient['patId']?></h2>
    <form action="visits_update.php?visitId=<?=$patient['visitId']?>" method="post">
        <label for="patId">Patient ID</label>
        <input type="text" name="patId" placeholder="##" value="<?=$patient['patId']?>" id="patId">
        <label for="visitDate">Visit Date</label>
        <input type="date" name="visitDate" placeholder="Input date of visit" 
               value="<?=$patient['visitDate']?>" id="visitDate">
        <label for="visitDoc">Doctor</label>
        <input type="text" name="visitDoc" placeholder="Doctor of patient" 
               value="<?=$patient['visitDoc']?>" id="visitDoc">
       
       <?php
        $stmt = $pdo->query("SELECT visitId, patId, visitDate, visitDoc FROM visits");
        $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>       
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
