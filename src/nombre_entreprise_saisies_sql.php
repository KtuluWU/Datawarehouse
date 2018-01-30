<?php 
require "../config/config.php";
require "function_request.php";

/********* Connexion de la Base de données associées *********/
try {
    $db_pg_test2 = new PDO($pg_pdo_conn_string);
} catch (PDOException $e) {
    die("Error!: " . $e->getMessage() . "<br/>");
}

try {
    $dbmysql = new PDO($pg_pdo_conn_string_histo);
} catch (PDOException $e) {
    die("Error!: " . $e->getMessage() . "<br/>");
}

$query_saisie_ass = $db_pg_test2->prepare("SELECT COUNT(distinct idpm) FROM public.ta_associes");
$query_saisie_ass->execute();
$count_ass = $query_saisie_ass->fetch(PDO::FETCH_ASSOC);
$data_today = date("Y-m-d");

function stocker_data_1($db_conn, $date, $nombre) {
    $sql = "INSERT INTO ta_entreprise_recu_histo (\"Date\", \"Nombre_saisies\") VALUES ('$date', '$nombre');";
    $query = $db_conn->prepare($sql);
    $query->execute();
}

echo "<div class='pm-saisies block'>";
echo "<div class='title_block text-rouge'>Tu trouves la page secretète!</div>";
echo "<div class='title_block'>Nombre de Sociétés saisies non rejetées</div>";
echo "<div class='content_requeste'>".$count_ass['count']."</div>";
stocker_data_1($dbmysql, $data_today, $count_ass["count"]);
echo "Jusqu'à <a class='text-rouge'>".$data_today."</a>";
echo "</div>";


















echo "<link rel='stylesheet' type='text/css' href='../resources/css/style.css' />";