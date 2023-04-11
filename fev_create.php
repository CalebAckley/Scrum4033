<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {

    $patId = isset($_POST['patId']) && !empty($_POST['patId']) && $_POST['patId'] != 'auto' ? $_POST['orderID'] : NULL;
    $testDate = isset($_POST['testDate']) ? $_POST['testDate'] : '';
    $firstTest = isset($_POST['firstTest']) ? $_POST['firstTest'] : '';
    $secondTest = isset($_POST['secondTest']) ? $_POST['secondTest'] : '';
    $thirdTest = isset($_POST['thirdTest']) ? $_POST['thirdTest'] : '';
   
    // Insert new record into the fev1 table
    $stmt = $pdo->prepare('INSERT INTO fev1 VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$patId, $testDate, $firstTest, $secondTest, $thirdTest]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Input FEV1 Test Values</h2>
    <form action="fev_create.php" method="post">
        <label for="patId">Patient ID</label>
        <label for="testDate">Date of Test</label>
        <input type="text" name="patId" placeholder="##" value="auto" id="patId">
        <input type="date" name="testDate" placeholder="Input date" id="testDate">
       
        <?php
        $stmt = $pdo->query("SELECT patId, patFirst, patLast FROM patients");
        $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
        ?>

        <label for="patId">Patient</label>
        <label></label>

            <select name="patId" id="patId">
            <?php foreach($patients as $patient) : ?>
            <option value="<?php echo $patient['patId']; ?>"><?php echo $patient['patId'] . ' - ' . $patient['patFirst'] . ' ' . $patient['patLast']; ?></option>
            <?php endforeach; ?>
            </select>
      
        <label></label>
        <label></label>
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>