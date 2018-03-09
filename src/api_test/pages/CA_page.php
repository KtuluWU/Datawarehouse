<?php
error_reporting(E_ALL || ~E_NOTICE);
require("../../../config/config.php");

$siren = $_GET['siren_CA'];
$bilan = $_GET['bilan_CA'];

function ComptesAnnuels($p_siren, $p_bilan, $p_token) {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.datainfogreffe.fr/api/v1/Entreprise/ComptesAnnuels/$p_siren?millesime=$p_bilan&token=$p_token");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $res = curl_exec($ch);
    curl_close($ch);
    echo $res;
}

ComptesAnnuels($siren, $bilan, $token_prod_demo);
