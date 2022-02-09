<?php
require_once("../../../Initialization/initialize.php");

$id = $_POST['id'];
$ip = $_SERVER['REMOTE_ADDR'];
$encoder = $_POST['Encoder'];
$category = $_POST['Category'];

$save_log = "INSERT INTO IrrigAssetManagementLog (TransactionID, Category, Action, IPAddress, DateCreated, Encoder) VALUES ('Transaction ID: TRID110-{$id}', '{$category}', 'Deleted Document', '{$ip}', GETDATE(), '{$encoder}')";

if($category == "New Document"){

    $data = Dynaset::execute("DELETE IrrigDocument Where Category = 'New Document' AND PK = $id");
    $data2 = Dynaset::execute("DELETE IrrigItemNames Where Category = 'New Document' AND ID = $id");

} else if ($category == "Registered Document"){

    $data = Dynaset::execute("DELETE IrrigDocument Where PK = $id");
    $data2 = Dynaset::execute("DELETE IrrigItemNames Where ID = $id");

} else {
    $data = Dynaset::execute("DELETE IrrigDocument Where PK = $id");
    $data2 = Dynaset::execute("DELETE IrrigItemNames Where ID = $id");
}

if($data && $category == "New Document"){

    $log = Dynaset::execute($save_log);
    echo 'Current Doc. cancelled';

} else if ($data && $category == "Registered Document"){

    $log = Dynaset::execute($save_log);
    echo "Registered Document Deleted";
    
} else {

    $log = Dynaset::execute($save_log);
    echo "Document Deleted";
}
?>