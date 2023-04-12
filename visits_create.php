<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {

    $patId = isset($_POST['patId']) && !empty($_POST['patId']) && $_POST['patId'] != 'auto' ? $_POST['patID'] : NULL;
    $visitDate = isset($_POST['visitDate']) ? $_POST['visitDate'] : '';
    $visitDoc = isset($_POST['visitDoc']) ? $_POST['visitDoc'] : '';
   
    // Insert new record into the fev1 table
    $stmt = $pdo->prepare('INSERT INTO visits VALUES (?, ?, ?)');
    $stmt->execute([$patId, $visitDate, $visitDoc]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Input Patient Visit Data</h2>
    <form action="visits_create.php" method="post">
        <label for="patId">Patient ID</label>
        <label for="visitDate">Date of Visit</label>
        <input type="text" name="patId" placeholder="##" value="auto" id="patId">
        <input type="date" name="visitDate" placeholder="Input visit date" id="visitDate">
       
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