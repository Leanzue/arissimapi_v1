<?php
include 'C:\xampp\htdocs\restapi\db.php';
include 'C:\xampp\htdocs\restapi\imsistatus\execrequests_functions.php';

//dd("START EXEC ESIM REQUEST...");

$exec_count = 10;

for ($i = 1; $i <= $exec_count; $i++) {
    $req_rslt = execRequests($pdo);
}

//dd("END EXEC.");

?>