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
    $medTobi = isset($_POST['medTobi']) ? $_POST['medTobi'] : '';
    $medColi = isset($_POST['medColi']) ? $_POST['medColi'] : '';
    $medHype = isset($_POST['medHype']) ? $_POST['medHype'] : '';
    $medAzit = isset($_POST['medAzit']) ? $_POST['medAzit'] : '';
    $medClar = isset($_POST['medClar']) ? $_POST['medClar'] : '';
    $medGent = isset($_POST['medGent']) ? $_POST['medGent'] : '';
    $medEnzy = isset($_POST['medEnzy']) ? $_POST['medEnzy'] : '';
    
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO medications VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$medID, $patId, $medVEST, $medAcap, $medPlum, $medTobi, $medColi, $medHype, $medAzit, $medClar, $medGent, $medEnzy]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create Medication Form</h2>
    <form action="medication_create.php" method="post">
        <label for="medID">MedID</label>
        <label for="patId">patID</label>
        <input type="text" name="medID" placeholder="26" value="auto" id="id">
        <input type="text" name="patiD" placeholder="26" value="auto" id="id">
        <label for="medVEST">Vest</label>
        <label for="medAcap">Acapella</label>
        <select name="medVEST" id="medVEST"> <option value="N">No</option> <option value="Y">Yes</option> </select>
        <select name="medAcap" id="medAcap"> <option value="N">No</option> <option value="Y">Yes</option> </select>
        <label for="medPlum">Plumozyme</label>
        <label for="medTobi">Inhaled Tobi</label> 
        <select name="medPlum" id="medPlum"> <option value="N">No</option> <option value="Y">Yes</option> </select>
        <select name="medTobi" id="medTobi"> <option value="N">No</option> <option value="Y">Yes</option> </select>
        <label for="medColi">Inhaled Colistin</label>
        <label for="medHype">Hypertonic Saline</label>
        <select name="medColi" id="medColi"> <option value="N">No</option> <option value="Y3%">Yes 3%</option> <option value="Y7%">Yes 7%</option> </select>
        <select name="medHype" id="medHype"> <option value="N">No</option> <option value="Y">Yes</option> </select>
        <label for="medAzit">Azithromycin</label>
        <label for="medClar">Clarithromycin</label>
        <select name="medAzit" id="medAzit"> <option value="N">No</option> <option value="Y">Yes</option> </select>
        <select name="medClar" id="medClar"> <option value="N">No</option> <option value="Y">Yes</option> </select>
        <label for="medGent">Inhaled Gentamicin</label>
        <label for="medEnzy">Enzymes</label>
        <select name="medGent" id="medGent"> <option value="N">No</option> <option value="Y">Yes</option> </select>
        <input type="text" name="medEnzy" placeholder="Yes or No, Type/Dosage" id="medEnzy">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>