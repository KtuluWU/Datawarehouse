<?php 
// error_reporting(E_ALL || ~E_NOTICE);
ini_set("max_execution_time", 0);
require "../config/config.php";
require "file_request.php";

/********* Connexion de la Base de données associées *********/
$dbtest2 = pg_connect($pg_conn_string);

/****************************************** Page ******************************************/
$date_1_er = $_POST['date1'];
$date_2_er = $_POST['date2'];

$query_suividem_count_er = pg_query($dbtest2, "select count(distinct siren) from public.ta_suividem_ass where dtsaisie>='$date_1_er' and dtsaisie<='$date_2_er'");
$count_er = pg_fetch_all($query_suividem_count_er)[0]["count"];

$query_suividem_er = pg_query($dbtest2, "select distinct siren, numdepot, noacte, dtacte, codegreffe from public.ta_suividem_ass where dtsaisie>='$date_1_er' and dtsaisie<='$date_2_er' order by siren");
$liste_er = pg_fetch_all($query_suividem_er);

export_csv($liste_er,"liste_er");

echo "<div class='list_er button_with_icon'>";
echo "<a class='list' href='../associe/csv/liste_er.csv' target='_blank'>Export</a>";
echo "<label><i class='material-icons icon-search'>file_download</i></label>";
echo "</div>";

echo "<div class='text_er'>";
echo "Nombre de rejets reçus de <label class='text-rouge'>$date_1_er</label> à <label class='text-rouge'>$date_2_er</label>: <label class='text-blue'>$count_er</label>";
echo "</div>";
