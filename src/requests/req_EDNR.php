<?php 
// error_reporting(E_ALL || ~E_NOTICE);
ini_set("max_execution_time", 0);
require "../../config/config.php";
require "file_request.php";

/********* Connexion de la Base de données associées *********/
$dbtest2 = pg_connect($pg_conn_string);

/****************************************** Page ******************************************/
$date_1_ednr = $_POST['date1'];
$date_2_ednr = $_POST['date2'];

$query_suividem_ednr = pg_query($dbtest2, "select count(distinct siren) from public.ta_suividem_ass where dtdemande is not null and dtsaisie is null and (dtdemande between '$date_1_ednr' and '$date_2_ednr')");
$count_ednr = pg_fetch_all($query_suividem_ednr)[0]["count"];

echo "<div class='text_rj'>";
echo "Nombre d'entreprise demandées en saisie non répondues de <label class='text-rouge'>$date_1_ednr</label> à <label class='text-rouge'>$date_2_ednr</label>: <label class='text-blue'>$count_ednr</label>";
echo "</div>";