<?php
error_reporting(E_ALL || ~E_NOTICE);
require("../../config/config.php");

$siren = $_GET['siren'];

/* echo "Siren: ".$siren;
echo '<br>'; */

function associe($p_siren, $p_token) {
    /* $url = "https://api.datainfogreffe.fr/api/v1/Entreprise/RepartitionCapital?siren=$p_siren&restitution=[json]|[pdf]&token=$p_token";
    $file_content = file_get_contents($url);
    echo $file_content; */

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.datainfogreffe.fr/api/v1/Entreprise/RepartitionCapital?siren=$p_siren&restitution=[json]|[pdf]&token=$p_token");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $res = curl_exec($ch);

    curl_close($ch);

    echo $res;

}


associe($siren,$token_prod_demo);
