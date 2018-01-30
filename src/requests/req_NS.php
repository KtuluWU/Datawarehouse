<?php
// error_reporting(E_ALL || ~E_NOTICE);
ini_set("max_execution_time", 0);
require "../../config/config.php";
require "../function_request.php";

/********* Connexion de la Base de données associées *********/
try {
    $dbmysql = new PDO($pg_pdo_conn_string_histo);
} catch (PDOException $e) {
    die("Error!: " . $e->getMessage() . "<br/>");
}

/****************************************** Page ******************************************/
$date_ns1 = $_POST['date1'];
$date_ns2 = $_POST['date2'];

$query_day = $dbmysql->prepare("SELECT day2-day1 FROM (SELECT DISTINCT \"Nombre_saisies\" AS day1 FROM ta_entreprise_recu_histo WHERE \"Date\"='$date_ns1') a,
                               (SELECT DISTINCT \"Nombre_saisies\" AS day2 FROM ta_entreprise_recu_histo WHERE \"Date\"='$date_ns2') b");
$query_day->execute();
$nombre_day = $query_day->fetch(PDO::FETCH_NUM);
if (!$nombre_day) {
    $nombre = "Date non disponible";
} else {
    $nombre = $nombre_day[0];
}
echo "Nombre saisies du <label class='text-rouge'>$date_ns1</label> à <label class='text-rouge'>$date_ns2</label>: <label class='text-blue'>$nombre</label>";

/* $query_day1 = mysqli_query($db_conn_mysql, $sql_day1);
$query_day2 = mysqli_query($db_conn_mysql, $sql_day2);
$nombre_day1 = mysqli_fetch_all($query_day1)[0][0];
$nombre_day2 = mysqli_fetch_all($query_day2)[0][0];
$nombre = $nombre_day2 - $nombre_day1;
echo "Nombre saisies du <label class='text-rouge'>$date_ns1</label> à <label class='text-rouge'>$date_ns2</label>: <label class='text-blue'>$nombre</label>"; */
// }
