<?php
    @include_once ('../../app_config.php');
    @include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
    $pdo = pdo_connect_mysql();
    $msg = '';
    // Check if the patient patId exists, for example //update.php?patId=1 will get the patient with the patId //of 1
    if (isset($_GET['medID'])) {
        if (!empty($_POST)) {
            // This part is similar to the create.php, //but instead we update a record and not //insert
            $medID = isset($_POST['medID']) ? $_POST['medID'] : NULL;
        $patId = isset($_POST['patId']) ? $_POST['patId'] : NULL;
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
        $enzyType = isset($_POST['enzyType']) ? $_POST['enzyType'] : '';
            // Update the record
            $stmt = $pdo->prepare('UPDATE medications SET medID = ?, patId= ?, medVEST = ?, medAcap = ?, medPlum = ?, plumQuant = ?, plumDate = ?, medTobi = ?, medColi = ?, medHype = ?, medAzit = ?, medClar = ?, medGent = ?, medEnzy = ?, enzyType = ? WHERE medID = ?');
        $stmt->execute([$medID, $patId, $medVEST, $medAcap, $medPlum, $plumQuant, $plumDate, $medTobi, $medColi, $medHype, $medAzit, $medClar, $medGent, $medEnzy, $enzyType, $_GET['medID']]);
        $msg = 'Updated Successfully!';
        }
        // Get the patient from the patients table
        $stmt = $pdo->prepare('SELECT * FROM medications WHERE medID = ?');
        $stmt->execute([$_GET['medID']]);
        $medication = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$medication) {
            exit('medication form doesn\'t exist with that ID!');
        }
    } else {
        exit('No ID specified!');
    }
?>
<?=template_header('Read')?>

<div class="content update">
	<h2>Update Medication Form #<?=$medication['medID']?></h2>
    <form action="medication_update.php?medID=<?=$medication['medID']?>" method="post">
        <label for="medID">MedID</label>
        <label for="patId">patID</label>
        <input type="text" name="medID" placeholder="##" value="<?=$medication['medID']?>" id="medID">
        <input type="text" name="patId" placeholder="##" value="<?=$medication['patId']?>" id="patId">
        <lable></label>
        <label for="medVEST">Vest</label>
        <label></label>
        <select name="medVEST" id="medVEST"> <option value="N">No</option> <option value="Y">Yes</option> </select>
        <label for="medAcap">Acapella</label>
        <label></label>
        <select name="medAcap" id="medAcap"> <option value="N">No</option> <option value="Y">Yes</option> </select>
        <label for="medPlum">Plumozyme</label>
        <label></label>
        <select name="medPlum" id="medPlum"> <option value="N">No</option> <option value="Y">Yes</option> </select>
        <label for="plumQuant">Plumozyme Quantity</label>
        <label></label>
        <input type="text" name="plumQuant" placeholder="Quantity" id="plumQuant">
        <label></label>
        <label for="plumDate">Plumozyme Date</label>
        <label></label>
        <input type="date" name="plumDate" placeholder="DD/MM/YYYY" value="<?=date('Y-m-d')?>" id="plumDate">
        <label></label>
        <label for="medTobi">Inhaled Tobi</label> 
        <label></label>
        <select name="medTobi" id="medTobi"> <option value="N">No</option> <option value="Y">Yes</option> </select>
        <label for="medColi">Inhaled Colistin</label>
        <label></label>
        <select name="medColi" id="medColi"> <option value="N">No</option> <option value="Y3%">Yes 3%</option> <option value="Y7%">Yes 7%</option> </select>
        <label for="medHype">Hypertonic Saline</label>
        <label></label>
        <select name="medHype" id="medHype"> <option value="N">No</option> <option value="Y">Yes</option> </select>
        <label for="medAzit">Azithromycin</label>
        <label></label>
        <select name="medAzit" id="medAzit"> <option value="N">No</option> <option value="Y">Yes</option> </select>
        <label for="medClar">Clarithromycin</label>
        <label></label>
        <select name="medClar" id="medClar"> <option value="N">No</option> <option value="Y">Yes</option> </select>
        <label for="medGent">Inhaled Gentamicin</label>
        <label></label>
        <select name="medGent" id="medGent"> <option value="N">No</option> <option value="Y">Yes</option> </select>
        <label for="medEnzy">Enzymes</label>
        <label></label>
        <select name="medEnzy" id="medEnzy"> <option value="N">No</option> <option value="Y">Yes</option> </select>
        <label for="enzyDate">Enzyme Type/Dosage</label>
        <label></label>
        <input type="text" name="enzyType" placeholder="Type/Dosage" id="enzyType">
        <label></label>
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
