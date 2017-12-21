<?php 
// error_reporting(E_ALL || ~E_NOTICE);
ini_set("max_execution_time", 0);
require "../../config/config.php";
require "file_request.php";

/********* Connexion de la Base de données associées *********/
$dbtest2 = pg_connect($pg_conn_string);

/****************************************** Page ******************************************/
$date_1_rj = $_POST['date1'];
$date_2_rj = $_POST['date2'];

$query_rejet_rj = pg_query($dbtest2, "select count(idpm) from public.ta_associes_rejets where dtsaisie>='$date_1_rj' and dtsaisie<='$date_2_rj' and bdeleted<>1 ");
$count_rj = pg_fetch_all($query_rejet_rj)[0]["count"];

$query_jointure_rj_pm_suividem = pg_query($dbtest2, "select tpa.siren, tar.numdepot, tar.noacte, tar.dtacte, tsa.codegreffe from ta_associes_rejets tar, ta_pm_ass tpa, ta_suividem_ass tsa where tar.idpm = tpa.idpm and tar.iddem = tsa.iddemext and tar.dtsaisie>='$date_1_rj' and tar.dtsaisie<'=$date_2_rj' and tar.bdeleted<>1 order by tpa.siren");
$liste_rj = pg_fetch_all($query_jointure_rj_pm_suividem);

export_csv($liste_rj,"liste_rj");

echo "<div class='list_rj button_with_icon'>";
echo "<a class='list' href='../../csv/liste_rj.csv' target='_blank'>Export</a>";
echo "<label><i class='material-icons icon-search'>file_download</i></label>";
echo "</div>";

echo "<div class='text_rj'>";
echo "Nombre de rejets reçus de <label class='text-rouge'>$date_1_rj</label> à <label class='text-rouge'>$date_2_rj</label>: <label class='text-blue'>$count_rj</label>";
echo "</div>";
