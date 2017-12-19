<?php 
// error_reporting(E_ALL || ~E_NOTICE);
require "../../config/config.php";

/****************************************** Page ******************************************/
echo "<head>";
echo "<link rel='stylesheet' type='text/css' href='../../resources/css/style.css' />";
echo "<link rel='stylesheet' href='../../resources/css/sweet-alert.css'>";
echo "<link rel='stylesheet' href='../../resources/css/bootstrap.min.css'>";
echo "</head>";
echo "<div class='page'>";
echo "<div class='title_logo dark'>";
echo "<div class='logo' onclick='navigateTo_index()'></div>";
echo "<div class='title_intranet'>Intranet Datawarehouse Datainfogreffe</div>";
echo "</div>";
echo "<div class='back light'>";
echo "<a class='button_back' href='../../index.php'><i class='material-icons icon-back'>arrow_back</i>Back</a></div>";
/* echo "<div class='pages no-padding'>";
echo "<div class='link_page'>";
echo "<a class='button_request' href='src/pages/request.php' target='_blank'>Requête<i class='material-icons icon-back'>arrow_forward</i></a></div>";
echo "<div class='link_page'>";
echo "<a class='button_dibe' href='src/pages/dibe.php' target='_blank'>DIBE<i class='material-icons icon-back'>arrow_forward</i></a></div>";
echo "<div class='link_page'>";
echo "<a class='button_apitest' href='src/pages/apitest.php' target='_blank'>API TEST<i class='material-icons icon-back'>arrow_forward</i></a></div>";
echo "</div>"; */

/****************************************** Siren input ******************************************/
echo "<div class='top light'>";
echo "<div class='input_usr'>";
echo "<form id='input_siren' name='input_siren' action='' method='post' onSubmit='return check_siren()'>";
echo "<div class='style_input'>";
echo "<label class='saisir_un_siren relat'>Saisir un siren: </label>";
echo "<input class='input_text_siren relat' type='text' maxlength='9' placeholder='Siren...' name='input_text_siren' id='input_text_siren' autocomplete='off'>";
echo "</div>";
echo "<div class='button_with_icon'>";
echo "<input class='button_chercher' type='submit' value='Chercher' id='button_siren' onClick=''>";
echo "<label><i class='material-icons icon-search'>search</i></label>";
echo "</div>";
echo "</form>";
echo "</div>";//input_usr

$siren = $_POST['input_text_siren']; 
if ($siren!=null) {
    echo "<div class='siren_display'>";
    echo "Siren: <label class='text-rouge'>".$siren."</label>";
    echo "</div>";
}
echo "</div>";
/***********************************   Les APIs   ***********************************/
echo "<div class='content light'>";
echo "<div class='api'>";
echo "<div class='api_base'>";
echo "<div class='title_api'>API de base</div>";
echo "<div class='block_api button_with_icon'>";
echo "<a class='api_lien list' href='../api/api_base_statut.php?siren=$siren' target='_blank'>l’état</a>";
echo "<label><i class='material-icons icon-search'>done</i></label>";
echo "</div>";
echo "<div class='block_api button_with_icon'>";
echo "<a class='api_lien list' href='../api/api_base_bdirects.php?siren=$siren' target='_blank'>associés</a><br>";
echo "<label><i class='material-icons icon-search'>done</i></label>";
echo "</div>";
echo "</div>";
echo "<div class='api_commercant'>";
echo "<div class='title_api'>API commerçante</div>";
echo "<div class='block_api button_with_icon'>";
echo "<a class='api_lien list' href='../api/api_statut.php?siren=$siren' target='_blank'>l'état</a><br>";
echo "<label><i class='material-icons icon-search'>done</i></label>";
echo "</div>";
echo "<div class='block_api button_with_icon'>";
echo "<a class='api_lien list' href='../api/api_associe.php?siren=$siren' target='_blank'>associés</a><br>";
echo "<label><i class='material-icons icon-search'>done</i></label>";
echo "</div>";//block_api

echo "</div>";//api_commercant
echo "</div>";//api

/*********************   Connecter la base de données associées TEST2   *********************/

$dbtest2 = pg_connect($pg_conn_string);

$res = pg_query($dbtest2, "select * from public.ta_suividem_ass where siren='$siren' order by dtdepot DESC");
$fetch_res = pg_fetch_all($res);
$sizetable = sizeof($fetch_res);
// print_r($fetch_res);

/********* Coderetour *********/
function cr($cr, $denomination, $siren) {
    if ($denomination != null && $cr != null && $siren != null) {
        switch($cr) {
            case 0:
                return "Saisie non rejetée";
                break;
            case 05:
                return "Forme juridique incompatible";
                break;
            case 11:
                return "Anomalie Siren";
                break;
            case 12:
                return "Document autre que statut,";
                break;
            case 13:
                return "Statut incomplet";
                break;
            case 14:
                return "Liste des associés non précisée";
                break;
            case 15:
                return "Nombre de part des associés non précisé";
                break;
            case 31:
                return "Statut illisible";
                break;
            case 32:
                return "Statut indisponible";
                break;
            case 101:
                return "Date de dépôt/saisie invalide";
                break;
            case 102:
                return "Date de dépôt et date de saisie incohérentes";
                break;
            case 21:
                return "Nombres de parts incohérents";
                break;
            case 121:
                return "Nombres de parts incohérents";
                break;
            case 141:
                return "Multiples occurences d'un même associé";
                break;
            default:
                return "Null";
        }
    }
    elseif ($denomination != null && $cr == null && $siren != null) {
        return "En cours";
    }
    elseif ($siren == null) {
        return " ";
    }
    else {
        return "Non trouvé dans la base";
    }
} 

/********* Résultat *********/

function echo_res1($ress) {
    $size = sizeof(pg_fetch_all($ress));
    for($i=0; $i<$size; $i++) {
        for ($j=0;$j<count(pg_fetch_all($ress)[$i]);$j++){
            $key = array_keys(pg_fetch_all($ress)[$i]);
            $value = array_values(pg_fetch_all($ress)[$i]);
            echo $key[$j].": ".$value[$j]."<br>";
        }
        echo "<br>";
    }
}

/********* Page *********/
echo "<div class='divider'></div>";

for ($i=0; $i<$sizetable; $i++) {
    $dtdepot = pg_fetch_all($res)[$i]["dtdepot"];
    $dtdemande = pg_fetch_all($res)[$i]["dtdemande"];
    $denomination = pg_fetch_all($res)[$i]["denomination"];
    $coderetour = pg_fetch_all($res)[$i]["coderetour"];
    $cr_des = cr($coderetour, $denomination, $siren);
    $iddemext = pg_fetch_all($res)[$i]["iddemext"];
    $numdepot = pg_fetch_all($res)[$i]["numdepot"];
    $numacte = pg_fetch_all($res)[$i]["noacte"];
    $dtacte = pg_fetch_all($res)[$i]["dtacte"];
    $dtsaisie_dev = pg_fetch_all($res)[$i]["dtsaisie"];

    echo "<div class='data'>";
    echo "<div class='title'>";
    echo "Siren: $siren<br>";
    echo "Date de dépôt: $dtdepot<br>";
    echo "Dénomination: $denomination<br>";
    if ($dtdemande != null) {
        echo "Demandé en saisie le $dtdemande<br>";
    }
    echo "Numéro de dépôt: $numdepot<br>";
    echo "Numéro d'acte: $numacte<br>";
    echo "Date d'acte: $dtacte<br>";
    echo "Date de saisie: $dtsaisie_dev<br>";
    echo "État: <b class='text-rouge'>$cr_des</b><br>";
    if ($coderetour != null) {
        echo "CodeRetour: $coderetour<br>";
    }

    echo "</div>";
    echo "<div class='divider_col'></div>";
    echo "<div class='contenu'>";
    if ($coderetour == null && $siren != null) {
        echo "<div class='text-rouge'>";
        echo "NULL";
        echo "</div>";
    }
    elseif ($coderetour == 0 && $siren != null) {
        $res1 = pg_query($dbtest2, "select * from public.ta_associes where iddem='$iddemext'");
        $size = sizeof(pg_fetch_all($res1));
        $dtsaisie_ass = pg_fetch_all($res)[$i]["dtsaisie"];
        echo "<div class='title_2'>";
        echo "Nombre associé: $size <br>";
        echo "Date de saisie: $dtsaisie_ass <br>";
        echo "</div>";
        echo_res1($res1);
    }
    elseif ($siren == null) {
        echo " ";
    }
    else {
        $res1 = pg_query($dbtest2, "select * from public.ta_associes_rejets where iddem='$iddemext'");
        $dtsaisie_ass_rejet = pg_fetch_all($res)[$i]["dtsaisie"];
        echo "<div class='title_2'>";
        echo "Date de saisie: $dtsaisie_ass_rejet <br>";
        echo "</div>";
        echo_res1($res1);
    }

    echo "</div></div>";
}

echo "<script src='../../resources/javascript/jquery-3.2.1.min.js'></script>";
echo "<script src='../../resources/javascript/javascript.js'></script>";
echo "<script src='../../resources/javascript/sweet-alert.js'></script>";