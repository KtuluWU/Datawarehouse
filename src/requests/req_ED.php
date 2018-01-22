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
$date_1_ed = $_POST['date1'];
$date_2_ed = $_POST['date2'];

$query_suividem_count_ed = $db_pg_test2->prepare("SELECT count(DISTINCT siren) FROM public.ta_suividem_ass WHERE dtdemande>='$date_1_ed' AND dtdemande<='$date_2_ed'");
$query_suividem_count_ed->execute();
$fetch_count_ed = $query_suividem_count_ed->fetch(PDO::FETCH_NUM);
$count_ed = $fetch_count_ed[0];

$query_suividem_ed = $db_pg_test2->prepare("SELECT DISTINCT siren, numdepot, noacte, dtacte, codegreffe FROM public.ta_suividem_ass WHERE dtdemande>='$date_1_ed' AND dtdemande<='$date_2_ed' ORDER BY siren");
$query_suividem_ed->execute();
$liste_ed = array();
while ($fetch_suividem_er = $query_suividem_ed->fetch(PDO::FETCH_ASSOC)) {
    array_push($liste_ed, $fetch_suividem_er);
}
export_csv($liste_ed, "liste_ed");

echo "<div class='list_ed button_with_icon'>";
echo "<a class='list' href='../../csv/liste_ed.csv' target='_blank'>Export</a>";
echo "<label><i class='material-icons icon-search'>file_download</i></label>";
echo "</div>";

echo "<div class='text_ed'>";
echo "Nombre de rejets reçus de <label class='text-rouge'>$date_1_ed</label> à <label class='text-rouge'>$date_2_ed</label>: <label class='text-blue'>$count_ed</label>";
echo "</div>";
