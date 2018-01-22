<?php

function echo_input($class_block, $form_id_name, $class_input, $date1, $date2, $button, $function_ajax, $response_area, $loadinggif)
{
    echo "<div class='$class_block'>";
    echo "<form id='$form_id_name' name='$form_id_name' action='' method='post'>";
    echo "<div class='$class_input'>";
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
    echo "<input class='button_chercher' type='button' value='Chercher' id='$button' onClick='$function_ajax'>";
    echo "<label><i class='material-icons icon-search'>search</i></label>";
    echo "</div>";
    echo "</form>";
    echo "</div>";
    echo "<div class='no-padding' id='$loadinggif'><img class='loadinggif' alt='Chargement...' src='../../resources/assets/loading_gr.gif'/></div>";
    echo "<div class='$response_area' id='$response_area'></div>";
}

function echo_api($class_input, $form_id_name, $api_input_data, $api_button, $function_ajax, $loadinggif, $response_area, $bool_api)
{
    $api_siren = $api_input_data["api_siren"];
    $api_bilan = $api_input_data["api_bilan"];
    $api_ER_nom = $api_input_data["api_ER_nom"];
    $api_ER_prenom = $api_input_data["api_ER_prenom"];
    $api_ER_naissance = $api_input_data["api_ER_naissance"];

    switch ($bool_api) {
        case 0:
            echo "<div class='$class_input'>";
            echo "<form id='$form_id_name' name='$form_id_name' action='' method='post'>";
            echo "<div class='api_input_siren api_input_block'>";
            echo "<label class='api_input_title relat'>Siren: </label>";
            echo "<input class='api_input_text relat' type='text' maxlength='9' placeholder='Siren...' name='$api_siren' id='$api_siren'>";
            echo "</div>"; //api_input_siren
            echo "</div>"; //class_input
            break;
        case 1:
            echo "<div class='$class_input'>";
            echo "<form id='$form_id_name' name='$form_id_name' action='' method='post'>";
            echo "<div class='api_input_siren api_input_block'>";
            echo "<label class='api_input_title relat'>Siren: </label>";
            echo "<input class='api_input_text relat' type='text' maxlength='9' placeholder='Siren...' name='$api_siren' id='$api_siren'>";
            echo "</div>"; //api_input_siren

            echo "<div class='api_input_bilan api_input_block'>";
            echo "<label class='api_input_title relat'>Année du bilan: </label>";
            echo "<input class='api_input_text relat' type='text' maxlength='4' placeholder='aaaa' name='$api_bilan' id='$api_bilan'>";
            echo "</div>"; //api_input_bilan
            echo "</div>"; //class_input
            break;
        case 2:
            echo "<div class='$class_input'>";
            echo "<form id='$form_id_name' name='$form_id_name' action='' method='post'>";
            echo "<div class='api_input_ER_nom api_input_block'>";
            echo "<label class='api_input_title relat'>Nom: </label>";
            echo "<input class='api_input_text relat' type='text' maxlength='20' placeholder='Nom...' name='$api_ER_nom' id='$api_ER_nom'>";
            echo "</div>"; //api_input_ER_nom

            echo "<div class='api_input_ER_prenom api_input_block'>";
            echo "<label class='api_input_title relat'>Prénom: </label>";
            echo "<input class='api_input_text relat' type='text' maxlength='20' placeholder='Prénom...' name='$api_ER_prenom' id='$api_ER_prenom'>";
            echo "</div>"; //api_input_ER_prenom

            echo "<div class='api_input_ER_naissance api_input_block'>";
            echo "<label class='api_input_title relat'>Naissance: </label>";
            echo "<input class='api_input_text relat' type='text' maxlength='4' placeholder='Naissance(aaaa)' name='$api_ER_naissance' id='$api_ER_naissance'>";
            echo "</div>"; //api_input_ER_naissance
            echo "</div>"; //class_input
            break;
        default:
            echo "<div class='$class_input'>";
            echo "<form id='$form_id_name' name='$form_id_name' action='' method='post'>";
            echo "Error: 404";
            echo "</div>"; //class_input
    }

    echo "<div class='button_with_icon'>";
    echo "<input class='button_chercher' type='button' value='Chercher' id='$api_button' onClick='$function_ajax'>";
    echo "<label><i class='material-icons icon-search'>search</i></label>";
    echo "</div>"; //button_with_icon
    echo "</form>";

    echo "<div class='no-padding' id='$loadinggif'><img class='loadinggif' alt='Chargement...' src='../../resources/assets/loading_bl.gif'/></div>";
    echo "<div class='$response_area' id='$response_area'></div>";
}

function export_siren_traite($data, $file_name)
{

    $fp = fopen("../../csv/$file_name.csv", "w");
    $header_data = array("Siren", "Disponibilite");
    fputcsv($fp, $header_data);

    foreach ($data as $value) {
        fputcsv($fp, $value);
    }
    fclose($fp);
}

function api_statut($p_siren, $p_token)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.datainfogreffe.fr/api/v1/Entreprise/RepartitionCapitalStatus?siren=$p_siren&token=$p_token");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
}

function code_trans($code_statut)
{
    if ($code_statut == "404") {
        return "Non";
    } else if ($code_statut == "200") {
        return "Oui";
    }
}

/** check upload */
function empty_dir($directory)
{
    $handle = opendir($directory);
    while (($file = readdir($handle)) !== false) {
        if ($file != "." && $file != ".." && $file != ".DS_Store") {
            closedir($handle);
            return false;
        }
    }
    closedir($handle);
    return true;
}
