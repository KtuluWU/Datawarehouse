<?php
// error_reporting(E_ALL || ~E_NOTICE);
ini_set("max_execution_time", 0);
require "../../config/config.php";

function export_csv($data,$file_name) {
    
    $fp = fopen ("../../csv/$file_name.csv","w");
    $header_data = array("Siren", "Numero de depot", "Numero d'acte", "Date d'acte", "CodeGreffe");
    fputcsv($fp, $header_data);

    foreach ($data as $value) {
        fputcsv($fp, $value);
    }
    fclose($fp);
}