<?php
// error_reporting(E_ALL || ~E_NOTICE);
ini_set("max_execution_time", 0);
require "../../config/config.php";
require "file_request.php";

/********* Connexion de la Base de données associées *********/
try {
    $db_pg_test2 = new PDO($pg_pdo_conn_string);
} catch (PDOException $e) {
    die("Connection failed! (数据库连接错误): " . $e->getMessage() . "<br/>");
}

/****************************************** Page ******************************************/
$date_1_rj = $_POST['date1'];
$date_2_rj = $_POST['date2'];

$query_rejet_rj = $db_pg_test2->prepare("SELECT count(idpm) FROM public.ta_associes_rejets WHERE dtsaisie>='$date_1_rj' AND dtsaisie<='$date_2_rj' AND bdeleted<>1 ");
$query_rejet_rj->execute();
$fetch_count_rj = $query_rejet_rj->fetch(PDO::FETCH_NUM);
$count_rj = $fetch_count_rj[0];

$query_jointure_rj_pm_suividem = $db_pg_test2->prepare("SELECT tpa.siren, tar.numdepot, tar.noacte, tar.dtacte, tsa.codegreffe FROM ta_associes_rejets tar, ta_pm_ass tpa, ta_suividem_ass tsa WHERE tar.idpm = tpa.idpm AND tar.iddem = tsa.iddemext AND tar.dtsaisie>='$date_1_rj' AND tar.dtsaisie<='$date_2_rj' AND tar.bdeleted<>1 ORDER BY tpa.siren");
$query_jointure_rj_pm_suividem->execute();
$liste_rj = array();
while ($fetch_jointure_rj_pm_suividem = $query_jointure_rj_pm_suividem->fetch(PDO::FETCH_ASSOC)) {
    array_push($liste_rj, $fetch_jointure_rj_pm_suividem);
}

export_csv($liste_rj, "liste_rj");

echo "<div class='list_rj button_with_icon'>";
echo "<a class='list' href='../../csv/liste_rj.csv' target='_blank'>Export</a>";
echo "<label><i class='material-icons icon-search'>file_download</i></label>";
echo "</div>";

echo "<div class='text_rj'>";
echo "Nombre de rejets reçus de <label class='text-rouge'>$date_1_rj</label> à <label class='text-rouge'>$date_2_rj</label>: <label class='text-blue'>$count_rj</label>";
echo "</div>";
