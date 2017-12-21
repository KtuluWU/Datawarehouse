<?php 
// error_reporting(E_ALL || ~E_NOTICE);
ini_set("max_execution_time", 0);
require "../../config/config.php";


/****************************************** Page ******************************************/
$siren = $_POST['siren_apitest'];
$bilan = $_POST['bilan_apitest'];

echo "<div class='text_CA api_link'>";
echo "<a href='../api_test/pages/CA_page.php?siren_CA=$siren&bilan_CA=$bilan' target='_blank'>https://api.datainfogreffe.fr/api/v1/Entreprise/ComptesAnnuels/<label class='text-rouge'>$siren</label>?millesime=<label class='text-rouge'>$bilan</label></a>";
echo "</div>";
