<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    $visitId = isset($_POST['visitId']) && !empty($_POST['visitId']) && $_POST['visitId'] != 'auto' ? $_POST['visitId'] : NULL;
    $patId = isset($_POST['patId']) && !empty($_POST['patId']) && $_POST['patId'] != 'auto' ? $_POST['patId'] : NULL;
    $visitDate = isset($_POST['visitDate']) ? $_POST['visitDate'] : '';
    $visitDoc = isset($_POST['visitDoc']) ? $_POST['visitDoc'] : '';
   
    // Insert new record into the visits table
    $stmt = $pdo->prepare('INSERT INTO visits VALUES (?, ?, ?, ?)');
    $stmt->execute([$visitId, $patId, $visitDate, $visitDoc]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Input Patient Visit Data</h2>
    <form action="visits_create.php" method="post">
    <label for="visitId">Visit ID</label>
        <input type="text" name="visitId" placeholder="##" value="auto" id="visitId"> 
        <label for="visitDate">Date of Visit</label>
        <input type="date" name="visitDate" placeholder="Input visit date" id="visitDate">
        <label for="visitDoc">Doctor</label>
        <input type="text" name="visitDoc" placeholder="Doctor Name" id="visitDoc">
       
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
