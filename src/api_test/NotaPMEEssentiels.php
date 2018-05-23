<?php 
// error_reporting(E_ALL || ~E_NOTICE);
ini_set("max_execution_time", 0);
require "../../config/config.php";


/****************************************** Page ******************************************/
$siren = $_POST['siren_apitest'];

echo "<div class='text_NPE api_link'>";
echo "<a href='../api_test/pages/NPE_page.php?siren_NPE=$siren' target='_blank'>https://api.datainfogreffe.fr/api/v1/Entreprise/notapme/essentiel/<label class='text-rouge'>$siren</label></a>";
echo "</div>";

echo "<div class='text_NPE api_link'>";
echo "(couche basse) <a href='../api_test/pages/NPE_basse_page.php?siren_NPE=$siren' target='_blank'>http://79.137.30.196:8079/notapme/ratio17?siren=<label class='text-rouge'>$siren</label></a>";
echo "</div>";
