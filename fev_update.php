<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example //update.php?id=1 will get the contact with the id //of 1
if (isset($_GET['entryId'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, //but instead we update a record and not //insert
        $entryId = isset($_POST['entryId']) ? $_POST['entryId'] : NULL;
        $patId = isset($_POST['patId']) ? $_POST['patId'] : NULL;
        $visitId = isset($_POST['visitId']) ? $_POST['visitId'] : NULL;
        $testDate = isset($_POST['testDate']) ? $_POST['testDate'] : '';
        $firstTest = isset($_POST['firstTest']) ? $_POST['firstTest'] : '';
        $secondTest = isset($_POST['secondTest']) ? $_POST['secondTest'] : '';
        $thirdTest = isset($_POST['thirdTest']) ? $_POST['thirdTest'] : '';

        // Update the record
        $stmt = $pdo->prepare('UPDATE fev1 SET entryId = ?, patId = ?, visitId = ?, testDate = ?, firstTest = ?, secondTest = ?, thirdTest = ? WHERE entryId = ?');
        $stmt->execute([$entryId, $patId, $visitId, $testDate, $firstTest, $secondTest, $thirdTest, $_GET['entryId']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM fev1 WHERE entryId = ?');
    $stmt->execute([$_GET['entryId']]);
    $entry = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$entry) {
        exit('Test doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Read')?>

<div class="content update">
	<h2>Update FEV1 for Patient <?=$entry['patId']?></h2>
    <form action="fev_update.php?entryId=<?=$entry['entryId']?>" method="post">
        <label for="entryId">Entry ID</label>
        <label for="patId">Patient ID</label>
        <input type="text" name="entryId" value="<?=$entry['entryId']?>" id="entryId">
        <input type="text" name="patId" value="<?=$entry['patId']?>" id="patId">

        <label for="visitId">Visit ID</label>
        <input type="text" name="visitId" value="<?=$entry['visitId']?>" id="visitId">  
        
        <label for="testDate">Test Date</label>
        <label for="firstTest">1st FEV1</label>
        <input type="date" name="testDate" value="<?=$entry['testDate']?>" id="testDate">          
        <input type="text" name="firstTest" value="<?=$entry['firstTest']?>" id="firstTest">
          
        <label for="secondTest">2nd FEV1</label> 
        <label for="thirdTest">3rd FEV1</label>
        <input type="text" name="secondTest" value="<?=$entry['secondTest']?>" id="secondTest">
        <input type="text" name="thirdTest" value="<?=$entry['thirdTest']?>" id="thirdTest">

        <input type="submit" value="Update">
    </form>

    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
