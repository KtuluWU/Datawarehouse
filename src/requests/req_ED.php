<?php 
// error_reporting(E_ALL || ~E_NOTICE);
ini_set("max_execution_time", 0);
require "../../config/config.php";
require "file_request.php";

/********* Connexion de la Base de données associées *********/
$dbtest2 = pg_connect($pg_conn_string);

/****************************************** Page ******************************************/
$date_1_ed = $_POST['date1'];
$date_2_ed = $_POST['date2'];

$query_suividem_count_ed = pg_query($dbtest2, "select count(distinct siren) from public.ta_suividem_ass where dtdemande>='$date_1_ed' and dtdemande<='$date_2_ed'");
$count_ed = pg_fetch_all($query_suividem_count_ed)[0]["count"];

$query_suividem_ed = pg_query($dbtest2, "select distinct siren, numdepot, noacte, dtacte, codegreffe from public.ta_suividem_ass where dtdemande>='$date_1_ed' and dtdemande<='$date_2_ed' order by siren");
$liste_ed = pg_fetch_all($query_suividem_ed);

export_csv($liste_ed,"liste_ed");

echo "<div class='list_ed button_with_icon'>";
echo "<a class='list' href='../../csv/liste_ed.csv' target='_blank'>Export</a>";
echo "<label><i class='material-icons icon-search'>file_download</i></label>";
echo "</div>";

echo "<div class='text_ed'>";
echo "Nombre de rejets reçus de <label class='text-rouge'>$date_1_ed</label> à <label class='text-rouge'>$date_2_ed</label>: <label class='text-blue'>$count_ed</label>";
echo "</div>";