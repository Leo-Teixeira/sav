<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    require '../insertionSql.php';

    /*récupération des variables*/
    $nameFile = $_FILES['parcours_doc']['name'];
    $sizeFile = $_FILES['parcours_doc']['size'];
    $tmp_name = $_FILES['parcours_doc']['tmp_name'];
    $typeFile = $_FILES['parcours_doc']['type'];

    echo("OK");
    print_r($nameFile);

    depot_doc($nameFile, $tmp_name);
?>