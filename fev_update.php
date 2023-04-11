<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example //update.php?id=1 will get the contact with the id //of 1
if (isset($_GET['patId', 'testDate'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, //but instead we update a record and not //insert
        $patId = isset($_POST['patId']) ? $_POST['patId'] : NULL;
        $testDate = isset($_POST['testDate']) ? $_POST['testDate'] : '';
        $firstTest = isset($_POST['firstTest']) ? $_POST['firstTest'] : '';
        $secondTest = isset($_POST['secondTest']) ? $_POST['secondTest'] : '';
        $thirdTest = isset($_POST['thirdTest']) ? $_POST['thirdTest'] : '';

        // Update the record
        $stmt = $pdo->prepare('UPDATE fev1 SET patId = ?, testDate = ?, firstTest = ?, secondTest = ?, thirdTest = ? WHERE patId, testDate = ?, ?');
        $stmt->execute([$patId, $testDate, $firstTest, $secondTest, $thirdTest $_GET['patId']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM fev1 WHERE patId = ?, testDate = ?');
    $stmt->execute([$_GET['patId', 'testDate']]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$order) {
        exit('Test doesn\'t exist with that ID and/or date!');
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Read')?>

<div class="content update">
	<h2>Update FEV1 Test<?=$patient['patId']?></h2>
    <form action="fev_update.php?patId=<?=$patient['patId']?>" method="post">
        <label for="patId">Patient ID</label>
        <label for="testDate">Test Date</label>
        <input type="text" name="patId" placeholder="##" value="<?=$patient['patId']?>" id="patId">
        <input type="date" name="testDate" placeholder="Input date of test" 
               value="<?=$patient['testDate']?>" id="testDate">
       
         <?php
        $stmt = $pdo->query("SELECT patId, patFirst, patLast FROM patients");
        $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        
        <label for="patId">Patient</label>
        <label></label>
        <select name="patId" id="patId">
            <option value="<?=$patient['patId']?>" selected><?=$patient['patId']?></option>
            <?php foreach($patients as $patient) : ?>
            <option value="<?php echo $patient['patId']; ?>"><?php echo $patient['patId'] . ' - ' . $patient['patFirst'] . ' ' . $patient['patLast']; ?></option>
            <?php endforeach; ?>
        </select>
   
        <label for="firstTest">1st FEV1</label>
        <label for="secondTest">2nd FEV1</label>
        <input type="text" name="firstTest" placeholder="##" value="<?=$patient['firstTest']?>" id="firstTest">
        <input type="text" name="secondTest" placeholder="##" value="<?=$patient['secondTest']?>" id="secondTest">
        
        <label for="thirdTest">3rd FEV1</label>
        <label></label>
        <input type="text" name="thirdTest" placeholder="##" value="<?=$patient['thirdTest']?>" id="thirdTest">

        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
