<?php
require_once("../../../Initialization/initialize.php");

$id = $_POST['id'];

$data = Dynaset::execute("DELETE IrrigItemNames WHERE PK = $id");
if($data){
    echo "Delete Item Success!";
}
?>