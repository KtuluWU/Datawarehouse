<?php 
// error_reporting(E_ALL || ~E_NOTICE);
ini_set("max_execution_time", 0);

require "../../config/config.php";
require "../function_request.php";

/********* Connexion de la Base de données associées *********/
$dbtest2 = pg_connect($pg_conn_string);
$db_conn_mysql = mysqli_connect($mysqli_host, $mysqli_dbusername, $mysqli_dbpassword, $mysqli_dbname);

/****************************************** Page ******************************************/
echo "<head>";
echo "<link rel='stylesheet' type='text/css' href='../../resources/css/style.css' />";
echo "<link rel='stylesheet' href='../../resources/css/sweet-alert.css'>";
echo "<link rel='stylesheet' href='../../resources/css/bootstrap.min.css'>";
echo "<link rel='stylesheet' href='../../resources/css/zzsc.css'>";
echo "<link rel='stylesheet' href='../../resources/css/dcalendar.picker.css'>";
echo "</head>";
echo "<div class='page'>";
echo "<div class='title_logo dark'>";
echo "<div class='logo' onclick='navigateTo_index()'></div>";
echo "<div class='title_intranet'>Intranet Datawarehouse Datainfogreffe</div>";
echo "</div>";
echo "<div class='title_requestes light'>Requêtes</div>";
echo "<div class='back light'>";
echo "<a class='button_back' href='../../index.php'><i class='material-icons icon-back'>arrow_back</i>Back</a></div>";

/****************************************** Nombre de Sociétés saisies non rejetées ******************************************/
$query_saisie_ass = pg_query($dbtest2, "select count(distinct idpm) from public.ta_associes");
$count_ass = pg_fetch_all($query_saisie_ass)[0]["count"];
// $data_today = date("Y-m-d");
echo "<div class='pm-saisies block light' id='pm-saisies'>";
echo "<div class='title_block'>Nombre de Sociétés saisies non rejetées</div>";
echo "<div class='content_requeste'>$count_ass</div>";
// echo "Jusqu'à <a class='text-rouge'>".$data_today."</a>";
echo "<div class='text-rouge tip_ns'>( À partir du 2017-11-11 )</div>";
echo_input('find_by_day', 'form_pm_saisies', 'input_ns cald', 'date_ns1', 'date_ns2', 'button_NS', 'send_date_ns()', 'response_NS', 'loadinggif_ns');

echo "</div>"; //pm-saisies

/****************************************** Entreprises reçues ******************************************/
echo "<div class='entreprise-recues block dark'>";
echo "<div class='title_block'>Entreprises reçues</div>";
echo_input('select_er', 'form_entreprise_recue', 'input_er cald', 'date_er1', 'date_er2', 'button_ER', 'send_date_er()', 'response_ER', 'loadinggif_er');
echo "</div>";

/****************************************** Entreprises demandées en saisie ******************************************/
echo "<div class='entreprise-demandees block light'>";
echo "<div class='title_block'>Entreprises demandées en saisie</div>";
echo_input('select_ed', 'form_entreprise_demandees', 'input_ed cald', 'date_ed1', 'date_ed2', 'button_ED', 'send_date_ed()', 'response_ED', 'loadinggif_ed');
echo "</div>";

/****************************************** Rejets reçus ******************************************/
echo "<div class='rejets-recus block dark'>";
echo "<div class='title_block'>Rejets reçus</div>";
echo_input('select_rj', 'form_entreprise_rejets', 'input_rj cald', 'date_rj1', 'date_rj2', 'button_RJ', 'send_date_rj()', 'response_RJ', 'loadinggif_rj');
echo "</div>";

/****************************************** Entreprise demandées en saisie non répondues ******************************************/
echo "<div class='entreprise-demandee-nonrepondues block light'>";
echo "<div class='title_block'>Entreprise demandées en saisie non répondues</div>";
echo "<div class='title_block text-rouge'>En attendant de refaire</div>";
echo_input('select_ednr', 'form_entreprise_dnr', 'input_ednr cald', 'date_ednr1', 'date_ednr2', 'button_EDNR', 'send_date_ednr()', 'response_EDNR', 'loadinggif_ednr');
echo "</div>";

/****************************************** SIREN traitement ******************************************/

echo "<div class='siern-traitement block dark'>";
echo "<div class='title_block'>SIREN traitement</div>";
echo "<form action='' method='POST' enctype='multipart/form-data'>";
echo "<div class='upload'>";
echo "Téléchargez un fichier <label class='text-rouge'>.csv</label>: ";
echo "<input type='file' name='file' id='file' accept='text/csv'></input>";
echo "</div>";
echo "<div class='button_with_icon'>";
echo "<input class='button_chercher' type='submit' value='Télécharger' id='$telecharger'>";
echo "<label><i class='material-icons icon-search'>file_upload</i></label>";
echo "</div>";
echo "</form>";

function siren_check($siren_r) {    //Pour vérifier si tous les siren sont composés par 9 chiffres, sinon, ajouter '0' au premier chiffre
    $siren_new_r = array();
    for ($i=0;$i<sizeof($siren_r);$i++) {
      $lenth_siren = strlen(floor($siren_r[$i]));
      while( $lenth_siren < "9" ) {
        $siren_r[$i] = "0".$siren_r[$i];
        $lenth_siren += "1";
      }
      array_push($siren_new_r, $siren_r[$i]);
    }
    return $siren_new_r;
}


if ($_FILES["file"]["error"] > 0)
{
  echo "<div class='error_file'>Error: " . $_FILES["file"]["error"] . "</div>";
}
else {
  $filename=$_FILES['file']["name"];
  $type=$_FILES['file']["type"];
  $tmp_name=$_FILES['file']["tmp_name"];
  $size=$_FILES['file']["size"];
  $error=$_FILES['file']["error"];
  $url_file = "../../";

  move_uploaded_file($tmp_name, $url_file."upload/".$filename);
  
  echo "Nom du fichier: <label class='text-rouge'>$filename</label><br>";
  $file_csv = fopen($url_file."upload/".$filename,"r");
  $siren_doc_r = array();
  while(!feof($file_csv))
  {
    array_push($siren_doc_r, fgetcsv($file_csv)[0]);
  }
  $siren_traite = siren_check($siren_doc_r);
  $statut_r = [];

  for ($i=0;$i<sizeof($siren_traite);$i++) {
    $statut = json_decode(api_statut($siren_traite[$i], $token_test), true)["Code"];
    $statut_trans = code_trans($statut);
    array_push($statut_r, array("Siren"=>$siren_traite[$i],"Statut"=>$statut_trans));
  }
  fclose($file_csv);
  export_siren_traite($statut_r, "statut");
  
  
  unlink($url_file."upload/$filename");
  echo "<div class='statut button_with_icon'>";
  echo "<a class='list' href='../../csv/statut.csv' target='_blank'>Export</a>";
  echo "<label><i class='material-icons icon-search'>get_app</i></label>";
  echo "</div>";
}



echo "</div>";


echo "</div>";//page
echo "<script src='../../resources/javascript/jquery-3.2.1.min.js'></script>";
echo "<script src='../../resources/javascript/javascript.js'></script>";
echo "<script src='../../resources/javascript/sweet-alert.js'></script>";
echo "<script src='../../resources/javascript/dcalendar.picker.js'></script>";