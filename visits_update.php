<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example //update.php?id=1 will get the contact with the id //of 1
if (isset($_GET['patId', 'visitDate'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, //but instead we update a record and not //insert
        $patId = isset($_POST['patId']) ? $_POST['patId'] : NULL;
        $visitDate = isset($_POST['visitDate']) ? $_POST['visitDate'] : '';
        $visitDoc = isset($_POST['visitDoc']) ? $_POST['visitDoc'] : '';

        // Update the record
        $stmt = $pdo->prepare('UPDATE visits SET patId = ?, visitDate = ?, visitDoc = ? WHERE patId, visitDate = ?, ?');
        $stmt->execute([$patId, $visitDate, $visitDoc $_GET['patId']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM visits WHERE patId = ?, visitDate = ?');
    $stmt->execute([$_GET['patId', 'visitDate']]);
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
	<h2>Update Visit Data<?=$patient['patId']?></h2>
    <form action="visits_update.php?patId=<?=$patient['patId']?>" method="post">
        <label for="patId">Patient ID</label>
        <label for="visitDate">Visit Date</label>
        <input type="text" name="patId" placeholder="##" value="<?=$patient['patId']?>" id="patId">
        <input type="date" name="visitDate" placeholder="Input date of visit" 
               value="<?=$patient['visitDate']?>" id="visitDate">
       
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
   
        <label for="visitDoc">Doctor </label>
        <input type="text" name="visitDoc" placeholder="##" value="<?=$patient['visitDoc']?>" id="visitDoc">

        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
