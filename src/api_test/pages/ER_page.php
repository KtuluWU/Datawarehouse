<?php
error_reporting(E_ALL || ~E_NOTICE);
require("../../../config/config.php");

$nom = $_GET['nom_api_ER'];
$prenom = $_GET['prenom_api_ER'];
$naissance = $_GET['naissance_api_ER'];

function EntrepriseRepresentant($p_nom, $p_prenom, $p_naissance, $p_token) {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.datainfogreffe.fr/api/v1/Entreprise/EntrepriseRepresentant?nom=$p_nom&prenom=$p_prenom&naissance=$p_naissance&token=$p_token");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $res = curl_exec($ch);
    curl_close($ch);
    echo $res;
}

EntrepriseRepresentant($nom, $prenom, $naissance, $token_prod_demo);
