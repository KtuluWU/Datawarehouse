<?php 
// error_reporting(E_ALL || ~E_NOTICE);
ini_set("max_execution_time", 0);

require "../../config/config.php";
require "../function_request.php";
session_start();
if (!isset($_SESSION['firstname'])) {
    echo "<meta http-equiv='refresh' content='0; url=../../index.php'>";
}
/****************************************** Title ******************************************/
echo "<head>";
echo "<link rel='stylesheet' type='text/css' href='../../resources/css/style.css' />";
echo "<link rel='stylesheet' href='../../resources/css/bootstrap.min.css'>";
echo "<link rel='stylesheet' href='../../resources/css/sweet-alert.css'>";
echo "<link rel='stylesheet' href='../../resources/css/zzsc.css'>";
echo "<link rel='shortcut icon' href='../../resources/assets/data_favicon.png' />";
echo "<title> Datawarehouse - DIBE </title>";
echo "</head>";
echo "<div class='page'>";
echo "<div class='title_logo dark'>";
echo "<div class='logo' onclick='navigateTo_index()'></div>";
echo "<div class='title_intranet'>Intranet Datawarehouse Datainfogreffe</div>";
echo "</div>"; // title_logo
echo "<div class='title_dibe light'>DIBE Historique</div>";
echo "<div class='back light'>";
echo "<a class='button_back' href='dibe.php'><i class='material-icons icon-back'>arrow_back</i>Back</a></div>";
/****************************************** Page ******************************************/
echo "<div class='commande_dibe light'>";

echo "<div class='titles_input relat'>";
echo "<div class='title_input'>Numéro Client : </div>";
echo "<div class='title_input'>Numéro utilisateur : </div>";
echo "<div class='title_input'>Référence : </div>";
echo "<div class='title_input'>Fichier : </div>";
echo "<div class='title_input'>Statut : </div>";
echo "</div>";// titles_input

/************************* Informations Saisies *************************/
$nclient = $_GET['nclient'];
$nutilis = $_GET['nutilisateur'];
$ref = $_GET['ref'];
$file = $_GET['file'];
$statut = $_GET['statut'];

function check_info($info) {
    if ($info != "" && $info != null) {
        return $info;
    }
    else {
        return "Null";
    }
}

function check_statut($statut) {
    if ($statut != null && $statut != "") {
        switch($statut) {
            case 0:
                return "Commande bien exécutée";
                break;
            case 1:
                return "<label class='text-rouge'>Impossible d’ouvrir le fichier csv</label>";
                break;
            case 2:
                return "<label class='text-rouge'>Problème dans la ligne de commande</label>";
                break;
            case 3:
                return "<label class='text-rouge'>Problème d’identification abonné</label>";
                break;
            default:
                return "En cours";
        }
    }
    else {
        return "En cours";
    }
}
/************************************************************************/

echo "<div class='inputs_dibe relat'>";
echo "<div class='info_input'>".check_info($nclient)."</div>";
echo "<div class='info_input'>".check_info($nutilis)."</div>";
echo "<div class='info_input'>".check_info($ref)."</div>";
echo "<div class='info_input'>".check_info($file)."</div>";
echo "<div class='info_input'>".check_statut($statut)."</div>";
echo "</div>";// inputs_dibe
echo "</div>"; // commande_dibe









echo "</div>"; // page
echo "<script src='../../resources/javascript/jquery-3.2.1.min.js'></script>";
echo "<script src='../../resources/javascript/javascript.js'></script>";
echo "<script src='../../resources/javascript/sweet-alert.js'></script>";