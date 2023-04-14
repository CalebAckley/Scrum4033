<?php

function pdo_connect_mysql() {
    @include_once ('../app_config.php');    
    try {
    	return new PDO(DSN1.';charset=utf8', USER1, PASSWD1);
    } catch (PDOException $exception) {
    	// If there is an error with the connection, stop the script and display the error.
    	exit('Failed to connect to database!');
    }
}
function template_header($title) {
    @include_once ('../app_config.php'); 
    echo'
    <!DOCTYPE html>
    <html>
	   <head>
		<meta charset="utf-8">
		<title>Acme Medical</title>
		<link href="'.WEB_ROOT.APP_FOLDER_NAME.'/styles/style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <script src="https://kit.fontawesome.com/3150181b85.js" crossorigin="anonymous"></script>
	   </head>
	   <body>
            <nav class="navtop">
    	       <div>
    		      <h1>Acme Medical</h1>
                  	<a href="'.WEB_ROOT.APP_FOLDER_NAME.'/scripts/landingPage.php"><i class="fas fa-home"></i>Home</a>
    		    	<a href="'.WEB_ROOT.APP_FOLDER_NAME.'/scripts/fev1_table/fev_read.php"><i class="fas fa-address-book"></i>FEV1 Tests</a>
                  	<a href="'.WEB_ROOT.APP_FOLDER_NAME.'/scripts/patients_table/patients_read.php"><i class="fas fa-address-book"></i>Patients</a>
                  	<a href="'.WEB_ROOT.APP_FOLDER_NAME.'/scripts/visits_table/visits_read.php"><i class="fas fa-address-book"></i>Visits</a>
                  	<a href="'.WEB_ROOT.APP_FOLDER_NAME.'/scripts/medications_table/medication_read.php"><i class="fas fa-address-book"></i>Medications</a>
    	       </div>
            </nav>
';
}
function template_footer() {
echo <<<EOT
    </body>
</html>
EOT;
}
?>
