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
$date_1_er = $_POST['date1'];
$date_2_er = $_POST['date2'];

$query_suividem_count_er = $db_pg_test2->prepare("SELECT count(DISTINCT siren) FROM public.ta_suividem_ass WHERE dtsaisie>='$date_1_er' AND dtsaisie<='$date_2_er'");
$query_suividem_count_er->execute();
$fetch_count_er = $query_suividem_count_er->fetch(PDO::FETCH_NUM);
$count_er = $fetch_count_er[0];

$query_suividem_er = $db_pg_test2->prepare("SELECT DISTINCT siren, numdepot, noacte, dtacte, codegreffe FROM public.ta_suividem_ass WHERE dtsaisie>='$date_1_er' AND dtsaisie<='$date_2_er' ORDER BY siren");
$query_suividem_er->execute();
$liste_er = array();
while ($fetch_suividem_er = $query_suividem_er->fetch(PDO::FETCH_ASSOC)) {
    array_push($liste_er, $fetch_suividem_er);
}

// print_r($liste_er);

export_csv($liste_er,"liste_er");

echo "<div class='list_er button_with_icon'>";
echo "<a class='list' href='../../csv/liste_er.csv' target='_blank'>Export</a>";
echo "<label><i class='material-icons icon-search'>file_download</i></label>";
echo "</div>";

echo "<div class='text_er'>";
echo "Nombre de rejets reçus de <label class='text-rouge'>$date_1_er</label> à <label class='text-rouge'>$date_2_er</label>: <label class='text-blue'>$count_er</label>";
echo "</div>";
