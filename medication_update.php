<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example //update.php?id=1 will get the contact with the id //of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, //but instead we update a record and not //insert
        $medID = isset($_POST['medID']) ? $_POST['medID'] : NULL;
        $patId = isset($_POST['patId']) ? $_POST['patId'] : NULL;
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
        // Update the record
        $stmt = $pdo->prepare('UPDATE medications SET medID = ?, patID= ?, medVEST = ?, medPlum = ?, medTobi = ?, medColi = ?, medHype = ?, medAzit = ?, medClar = ?, medGent = ?, medEnzy = ? WHERE medID = ?');
        $stmt->execute([$medID, $patId, $medVEST, $medAcap, $medPlum, $medTobi, $medColi, $medHype, $medAzit, $medClar, $medGent, $medEnzy, $_GET['medID']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM medications WHERE medID = ?');
    $stmt->execute([$_GET['medID']]);
    $medication = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$medication) {
        exit('Medication form doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Read')?>

<div class="content update">
	<h2>Update Medication Form #<?=$contact['id']?></h2>
    <form action="medication_update.php?id=<?=$contact['id']?>" method="post">
        <label for="id">ID</label>
        <label for="name">Name</label>
        <input type="text" name="id" placeholder="1" value="<?=$contact['id']?>" id="id">
        <input type="text" name="name" placeholder="John Doe" value="<?=$contact['name']?>" id="name">
        <label for="email">Email</label>
        <label for="phone">Phone</label>
        <input type="text" name="email" placeholder="johndoe@example.com" value="<?=$contact['email']?>" id="email">
        <input type="text" name="phone" placeholder="2025550143" value="<?=$contact['phone']?>" id="phone">
        <label for="title">Title</label>
        <label for="created">Created</label>
        <input type="text" name="title" placeholder="Employee" value="<?=$contact['title']?>" id="title">
        <input type="datetime-local" name="created" value="<?=date('Y-m-d\TH:i', strtotime($contact['created']))?>" id="created">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
