<?php 
error_reporting(E_ALL || ~E_NOTICE);
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
echo "<title> Datawarehouse - API Tests </title>";
echo "</head>";
echo "<div class='page'>";
echo "<div class='title_logo dark'>";
echo "<div class='logo' onclick='navigateTo_index()'></div>";
echo "<div class='title_intranet'>Intranet Datawarehouse Datainfogreffe</div>";
echo "</div>"; // title_logo
echo "<div class='title_apitest light'>API Test</div>";
echo "<div class='back light'>";
echo "<a class='button_back' href='../../welcome.php'><i class='material-icons icon-back'>arrow_back</i>Back</a></div>";

/****************************************** Page ******************************************/



/******************* Fiche Identité *******************/
echo "<div class='api_FicheIdentite block light'>";
echo "<div class='title_block'>Fiche Identité</div>";
$api_input_data_FI = array("api_siren"=>"api_siren_FI");
echo_api('api_FI', 'api_form_FI', $api_input_data_FI, 'api_button_FI', 'send_data_apitest_FI()', 'loadinggif_api_FI', 'response_area_api_FI', 0);
echo "</div>"; //api_FicheIdentite

/******************* Représentants *******************/

echo "<div class='api_Representants block dark'>";
echo "<div class='title_block'>Représentants</div>";
$api_input_data_Rep = array("api_siren"=>"api_siren_Rep");
echo_api('api_Rep', 'api_form_Rep', $api_input_data_Rep, 'api_button_Rep', 'send_data_apitest_Rep()', 'loadinggif_api_Rep', 'response_area_api_Rep', 0);
echo "</div>"; //api_Representants

/******************* Comptes Annuels *******************/
echo "<div class='api_ComptesAnnuels block light'>";
echo "<div class='title_block'>Comptes Annuels</div>";
$api_input_data_CA = array("api_siren"=>"api_siren_CA", "api_bilan"=>"api_bilan_CA");
echo_api('api_CA', 'api_form_CA', $api_input_data_CA, 'api_button_CA', 'send_data_apitest_CA()', 'loadinggif_api_CA', 'response_area_api_CA', 1);
echo "</div>"; //api_ComptesAnnuels

/******************* Entreprise Représentants *******************/
echo "<div class='api_EntrepriseRepresentants block dark'>";
echo "<div class='title_block'>Entreprise Représentants</div>";
$api_input_data_ER = array("api_ER_nom"=>"api_ER_nom", "api_ER_prenom"=>"api_ER_prenom", "api_ER_naissance"=>"api_ER_naissance");
echo_api('api_ER', 'api_form_ER', $api_input_data_ER, 'api_button_ER', 'send_data_apitest_ER()', 'loadinggif_api_ER', 'response_area_api_ER', 2);
echo "</div>"; //api_EntrepriseRepresentants

/******************* Procédures Collectives *******************/
echo "<div class='api_ProceduresCollectives block light'>";
echo "<div class='title_block'>Procédures Collectives</div>";
$api_input_data_PC = array("api_siren"=>"api_siren_PC");
echo_api('api_PC', 'api_form_PC', $api_input_data_PC, 'api_button_PC', 'send_data_apitest_PC()', 'loadinggif_api_PC', 'response_area_api_PC', 0);
echo "</div>"; //api_ProceduresCollectives

/********************************************************************* DEV *******************************************************************************/

/******************* Nota-PME Performance *******************/
echo "<div class='api_NotaPMEPerformance block dark'>";
echo "<div class='title_block'>Nota-PME Performance</div>";
$api_input_data_NPP = array("api_siren"=>"api_siren_NPP");
echo_api('api_NPP', 'api_form_NPP', $api_input_data_NPP, 'api_button_NPP', 'send_data_apitest_NPP()', 'loadinggif_api_NPP', 'response_area_api_NPP', 0);
echo "</div>"; //api_NotaPMEPerformance

/******************* Nota-PME Essentiels *******************/
echo "<div class='api_NotaPMEEssentiels block light'>";
echo "<div class='title_block'>Nota-PME Essentiels</div>";
$api_input_data_NPE = array("api_siren"=>"api_siren_NPE");
echo_api('api_NPE', 'api_form_NPE', $api_input_data_NPE, 'api_button_NPE', 'send_data_apitest_NPE()', 'loadinggif_api_NPE', 'response_area_api_NPE', 0);
echo "</div>"; //api_NotaPMEEssentiels

/******************* Nota-PME Intégral *******************/
echo "<div class='api_NotaPMEIntegral block dark'>";
echo "<div class='title_block'>Nota-PME Intégral</div>";
$api_input_data_NPI = array("api_siren"=>"api_siren_NPI");
echo_api('api_NPI', 'api_form_NPI', $api_input_data_NPI, 'api_button_NPI', 'send_data_apitest_NPI()', 'loadinggif_api_NPI', 'response_area_api_NPI', 0);
echo "</div>"; //api_NotaPMEIntegral

/******************* AFDCC *******************/
echo "<div class='api_AFDCC block light'>";
echo "<div class='title_block'>AFDCC</div>";
$api_input_data_AFDCC = array("api_siren"=>"api_siren_AFDCC");
echo_api('api_AFDCC', 'api_form_AFDCC', $api_input_data_AFDCC, 'api_button_AFDCC', 'send_data_apitest_AFDCC()', 'loadinggif_api_AFDCC', 'response_area_api_AFDCC', 0);
echo "</div>"; //api_AFDCC

/******************* Evaluation Entreprises *******************/
echo "<div class='api_EvaluationEntreprises block dark'>";
echo "<div class='title_block'>Evaluation Entreprises</div>";
$api_input_data_EE = array("api_siren"=>"api_siren_EE");
echo_api('api_EE', 'api_form_EE', $api_input_data_EE, 'api_button_EE', 'send_data_apitest_EE()', 'loadinggif_api_EE', 'response_area_api_EE', 0);
echo "</div>"; //api_EvaluationEntreprises




echo "</div>"; // page
echo "<script src='../../resources/javascript/jquery-3.2.1.min.js'></script>";
echo "<script src='../../resources/javascript/javascript.js'></script>";
echo "<script src='../../resources/javascript/sweet-alert.js'></script>";