<?php 
// error_reporting(E_ALL || ~E_NOTICE);
ini_set("max_execution_time", 0);
require "../../config/config.php";


/****************************************** Page ******************************************/
$nom = $_POST['nom_apitest'];
$prenom = $_POST['prenom_apitest'];
$naissance = $_POST['naissance_apitest'];

echo "<div class='text_ER api_link'>";
echo "<a href='../api_test/pages/ER_page.php?nom_api_ER=$nom&prenom_api_ER=$prenom&naissance_api_ER=$naissance' target='_blank'>https://api.datainfogreffe.fr/api/v1/Entreprise/EntrepriseRepresentant?nom=<label class='text-rouge'>$nom</label>&prenom=<label class='text-rouge'>$prenom</label>&naissance=<label class='text-rouge'>$naissance</label></a>";
echo "</div>";
