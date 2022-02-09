
<?php
$menu = null;
if(isset($_GET['menu'])){
    $menu = $_GET['menu'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="ULPI Asset Management - To create a management system for ULPI Broadleaf Irrigation.">
    <meta name="author" content="Kim Adorna : Junior Programmer : SSDG">
    
    <title>ULPI Irrigation Asset Management</title>
    <!-- Bootstrap Core CSS -->
    <link href="base/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="base/css/custom.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.10/css/dataTables.bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Initialize Bootstrap functionality -->
    <script>
        // Initialize tooltip component
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })

        // Initialize popover component
        $(function () {
            $('[data-toggle="popover"]').popover()
        })
    </script>

    <script type="text/javascript">
        function isNumberKey(txt, evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode == 46) {
            //Check if the text already contains the . character
            if (txt.value.indexOf('.') === -1) {
            return true;
            } else {
            return false;
            }
        } else {
            if (charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;
        }
        return true;
        }
    </script>
</head>

<body>
    <div id="wrapper">