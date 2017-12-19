<?php 
require "../config/config.php";
require "function_request.php";

/********* Connexion de la Base de données associées *********/
$dbtest2 = pg_connect($pg_conn_string);
$db_conn_mysql = mysqli_connect($mysqli_host, $mysqli_dbusername, $mysqli_dbpassword, $mysqli_dbname);

$query_saisie_ass = pg_query($dbtest2, "select count(distinct idpm) from public.ta_associes");
$count_ass = pg_fetch_all($query_saisie_ass)[0]["count"];
$data_today = date("Y-m-d");

function stocker_data_1($db_conn, $date, $nombre) {
    $sql = "INSERT INTO ta_entreprise_recu_histo (Date, Nombre_saisies) VALUES ('$date', '$nombre');";
    mysqli_query($db_conn, $sql);
    mysqli_close($db_conn);
}

echo "<div class='pm-saisies block'>";
echo "<div class='title_requeste text-rouge'>Tu trouves la page secretète!</div>";
echo "<div class='title_requeste'>Nombre de Sociétés saisies non rejetées</div>";
echo "<div class='content_requeste'>$count_ass</div>";
stocker_data_1($db_conn_mysql, $data_today, $count_ass);
echo "Jusqu'à <a class='text-rouge'>".$data_today."</a>";
echo "</div>";


















echo "<link rel='stylesheet' type='text/css' href='../resources/css/style.css' />";