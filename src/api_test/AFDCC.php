<?php 
// error_reporting(E_ALL || ~E_NOTICE);
ini_set("max_execution_time", 0);
require "../../config/config.php";


/****************************************** Page ******************************************/
$siren = $_POST['siren_apitest'];

echo "<div class='text_AFDCC api_link'>";
echo "<a href='../api_test/pages/AFDCC_page.php?siren_AFDCC=$siren' target='_blank'>https://api.datainfogreffe.fr/api/v1/Entreprise/afdcc/<label class='text-rouge'>$siren</label></a>";
echo "</div>";

echo "<div class='text_AFDCC api_link'>";
echo "(couche basse) <a href='../api_test/pages/AFDCC_basse_page.php?siren_AFDCC=$siren' target='_blank'>https://apidata.datainfogreffe.fr:8069/afdcc/score?siren=<label class='text-rouge'>$siren</label></a>";
echo "</div>";

