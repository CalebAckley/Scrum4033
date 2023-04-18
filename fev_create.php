<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    $entryId = isset($_POST['entryId']) && !empty($_POST['entryId']) && $_POST['entryId'] != 'auto' ? $_POST['entryId'] : NULL;
    $patId = isset($_POST['patId']) && !empty($_POST['patId']) && $_POST['patId'] != 'auto' ? $_POST['patId'] : NULL;
    $visitId = isset($_POST['visitId']) && !empty($_POST['visitId']) && $_POST['visitId'] != 'auto' ? $_POST['visitId'] : NULL;
    $testDate = isset($_POST['testDate']) ? $_POST['testDate'] : '';
    $firstTest = isset($_POST['firstTest']) ? $_POST['firstTest'] : '';
    $secondTest = isset($_POST['secondTest']) ? $_POST['secondTest'] : '';
    $thirdTest = isset($_POST['thirdTest']) ? $_POST['thirdTest'] : '';
   
    // Insert new record into the fev1 table
    $stmt = $pdo->prepare('INSERT INTO fev1 VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$entryId, $patId, $visitId, $testDate, $firstTest, $secondTest, $thirdTest]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Input FEV1 Test Values</h2>
    <form action="fev_create.php" method="post">
        <label for="entryId">Entry ID</label>
        <label for="patId">Patient</label>
        <input type="text" name="entryId" placeholder="##" value="auto" id="entryId">

        <?php
        $stmt = $pdo->query("SELECT patId, patFirst, patLast FROM patients");
        $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
        ?>
            <select name="patId" id="patId">
            <?php foreach($patients as $patient) : ?>
            <option value="<?php echo $patient['patId']; ?>"><?php echo $patient['patId'] . ' - ' . $patient['patFirst'] . ' ' . $patient['patLast']; ?></option>
            <?php endforeach; ?>
            </select>
        <label></label>
        <label for="visitId">Visit ID</label>

        <?php
        $stmt = $pdo->query("SELECT visitId, patId, visitDate FROM visits");
        $visits = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        ?>
            <select name="visitId" id="visitId">
            <?php foreach($visits as $visit) : ?>
            <option value="<?php echo $visit['visitId']; ?>"><?php echo 'Patient ID ' . $visit['patId'] . ' - ' . $visit['visitDate']; ?></option>
            <?php endforeach; ?>
            </select>

        
        <label for="testDate">Date of Test</label>       
        <label for="firstTest">1st FEV1</label>
        <input type="date" name="testDate" id="testDate">
        <input type="text" name="firstTest" placeholder="##" id="firstTest">        

        <label for="secondTest">2nd FEV1</label>
        <label for="thirdTest">3rd FEV1</label>
        <input type="text" name="secondTest" placeholder="##" id="secondTest">   
        <input type="text" name="thirdTest" placeholder="##" id="thirdTest">

        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
