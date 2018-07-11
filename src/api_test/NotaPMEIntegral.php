<?php 
// error_reporting(E_ALL || ~E_NOTICE);
ini_set("max_execution_time", 0);
require "../../config/config.php";


/****************************************** Page ******************************************/
$siren = $_POST['siren_apitest'];

echo "<div class='text_NPI api_link'>";
echo "<a href='../api_test/pages/NPI_page.php?siren_NPI=$siren' target='_blank'>https://api.datainfogreffe.fr/api/v1/Entreprise/notapme/integral/<label class='text-rouge'>$siren</label></a>";
echo "</div>";

echo "<div class='text_NPI api_link'>";
echo "(couche basse) <a href='../api_test/pages/NPI_basse_page.php?siren_NPI=$siren' target='_blank'>https://apidata.datainfogreffe.fr:8069/notapme/ratio-all?siren=<label class='text-rouge'>$siren</label></a>";
echo "</div>";