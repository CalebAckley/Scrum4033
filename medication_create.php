<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, //we must check if the POST variables exist if not we //can default them to blank
    $medID = isset($_POST['medID']) && !empty($_POST['medID']) && $_POST['medID'] != 'auto' ? $_POST['medID'] : NULL;
    $patId = isset($_POST['patId']) && !empty($_POST['patId']) && $_POST['patId'] != 'auto' ? $_POST['patId'] : NULL;
    // Check if POST variable "name" exists, if not default //the value to blank, basically the same for all //variables
    $medVEST = isset($_POST['medVEST']) ? $_POST['medVEST'] : '';
    $medAcap = isset($_POST['medAcap']) ? $_POST['medAcap'] : '';
    $medPlum = isset($_POST['medPlum']) ? $_POST['medPlum'] : '';
    $plumQuant= isset($_POST['plumQuant']) ? $_POST['plumQuant'] : '';
    $plumDate = isset($_POST['plumDate']) ? $_POST['plumDate'] : '';
    $medTobi = isset($_POST['medTobi']) ? $_POST['medTobi'] : '';
    $medColi = isset($_POST['medColi']) ? $_POST['medColi'] : '';
    $medHype = isset($_POST['medHype']) ? $_POST['medHype'] : '';
    $medAzit = isset($_POST['medAzit']) ? $_POST['medAzit'] : '';
    $medClar = isset($_POST['medClar']) ? $_POST['medClar'] : '';
    $medGent = isset($_POST['medGent']) ? $_POST['medGent'] : '';
    $medEnzy = isset($_POST['medEnzy']) ? $_POST['medEnzy'] : '';
    $enzyDate = isset($_POST['enzyDate']) ? $_POST['enzyDate'] : '';
    
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO medications VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$medID, $patId, $medVEST, $medAcap, $medPlum, $plumQuant, $plumDate, $medTobi, $medColi, $medHype, $medAzit, $medClar, $medGent, $medEnzy, $enzyDate]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create Medication Form</h2>
    <form action="medication_create.php" method="post">
        <label for="medID">MedID</label>
        <label for="patId">Patient ID</label>
        <input type="text" name="medID" placeholder="26" value="auto" id="id">
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
        <label for="medVEST">Vest</label>
        <select name="medVEST" id="medVEST"> <option value="N">No</option> <option value="Y">Yes</option> </select>
        <label></label>
        <label for="medAcap">Acapella</label>
        <select name="medAcap" id="medAcap"> <option value="N">No</option> <option value="Y">Yes</option> </select>
        <label></label>
        <label for="medPlum">Plumozyme</label>
        <select name="medPlum" id="medPlum"> <option value="N">No</option> <option value="Y">Yes</option> </select>
        <label></label>
        <label for="plumQuant">Plumozyme Quantity</label>
        <input type="text" name="plumeQuant" placeholder="Quantity" id="plumQuant">
        <label></label><label></label>
        <label for="plumDate">Plumozyme Date</label>
        <input type="date" name="plumDate" placeholder="DD/MM/YYYY" value="<?=date('d-m-Y')?>" id="plumDate">
        <label></label>
        <label></label>
        <label for="medTobi">Inhaled Tobi</label> 
        <select name="medTobi" id="medTobi"> <option value="N">No</option> <option value="Y">Yes</option> </select>
        <label></label>
        <label for="medColi">Inhaled Colistin</label>
        <select name="medColi" id="medColi"> <option value="N">No</option> <option value="Y3%">Yes 3%</option> <option value="Y7%">Yes 7%</option> </select>
        <label></label>
        <label for="medHype">Hypertonic Saline</label>
        <select name="medHype" id="medHype"> <option value="N">No</option> <option value="Y">Yes</option> </select>
        <label></label>
        <label for="medAzit">Azithromycin</label>
        <select name="medAzit" id="medAzit"> <option value="N">No</option> <option value="Y">Yes</option> </select>
        <label></label>
        <label for="medClar">Clarithromycin</label>
        <select name="medClar" id="medClar"> <option value="N">No</option> <option value="Y">Yes</option> </select>
        <label></label>
        <label for="medGent">Inhaled Gentamicin</label>
        <select name="medGent" id="medGent"> <option value="N">No</option> <option value="Y">Yes</option> </select>
        <label></label>
        <label for="medEnzy">Enzymes</label>
        <select name="medEnzy" id="medEnzy"> <option value="N">No</option> <option value="Y">Yes</option> </select>
        <label></label>
        <label for="enzyDate">Enzyme Type/Dosage</label>
        <input type="text" name="enzyType" placeholder="Type/Dosage" id="enzyType">

        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
