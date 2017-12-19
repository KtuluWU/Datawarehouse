<?php

function echo_input($class_block, $form_id_name, $class_inout, $date1, $date2, $button, $fonction_ajax, $response_area, $loadinggif) {
    echo "<div class='$class_block'>";
    echo "<form id='$form_id_name' name='$form_id_name' action='' method='post'>";
    echo "<div class='$class_inout'>";
    echo "<div class='text-left relat'>De</div>";
    echo "<div class='no-padding'>";
    echo "<input class='input-left relat' placeholder='Année-Mois-Jour' name='$date1' id='$date1' autocomplete='off'>";
    echo "<label><i class='material-icons icon-calendar'>today</i></label>";
    echo "</div>";
    echo "<div class='text-right relat'>à</div>";
    echo "<div class='no-padding'>";
    echo "<input class='input-right relat' placeholder='Année-Mois-Jour' name='$date2' id='$date2' autocomplete='off'>";
    echo "<label><i class='material-icons icon-calendar'>today</i></label>";
    echo "</div>";
    echo "</div>";
    echo "<div class='button_with_icon'>";
    echo "<input class='button_chercher' type='button' value='Chercher' id='$button' onClick='$fonction_ajax'>";
    echo "<label><i class='material-icons icon-search'>search</i></label>";
    echo "</div>";
    echo "</form>";
    echo "</div>";
    echo "<div class='no-padding' id='$loadinggif'><img class='loadinggif' alt='Chargement...' src='../../resources/assets/loading_gr.gif'/></div>";
    echo "<div class='$response_area' id='$response_area'></div>";
}

function export_siren_traite($data,$file_name) {
    
    $fp = fopen ("../../csv/$file_name.csv","w");
    $header_data = array("Siren", "Disponibilite");
    fputcsv($fp, $header_data);

    foreach ($data as $value) {
        fputcsv($fp, $value);
    }
    fclose($fp);
}

function api_statut($p_siren, $p_token) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.datainfogreffe.fr/api/v1/Entreprise/RepartitionCapitalStatus?siren=$p_siren&token=$p_token");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
  }
  
function code_trans($code_statut) {
    if ($code_statut=="404") {
        return "Non";
    }
    else if ($code_statut=="200") {
        return "Oui";
    }
}