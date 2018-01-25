<?php
// error_reporting(E_ALL || ~E_NOTICE);
require "config/config.php";
session_start();

if (!isset($_SESSION['firstname'])) {
    echo "<meta http-equiv='refresh' content='0; url=./index.php'>";
}
/****************************************** Title ******************************************/
echo "<head>";
echo "<link rel='stylesheet' type='text/css' href='resources/css/style.css' />";
echo "<link rel='stylesheet' href='resources/css/sweet-alert.css'>";
echo "<link rel='stylesheet' href='resources/css/bootstrap.min.css'>";
echo "</head>";
echo "<div class='page'>";
echo "<div class='title_logo dark'>";
echo "<div class='logo' onclick='navigateTo_index_for_index()'></div>";
echo "<div class='title_intranet'>Intranet Datawarehouse Datainfogreffe</div>";
echo "</div>";

/****************************************** Page ******************************************/
echo "<div class='button_with_icon light'>";
echo "<input class='button_chercher' type='button' id='button_logout' value='Se Déconnecter' onClick='navigateTo_logout()'>";
echo "<label><i class='material-icons icon-search'>search</i></label>";
echo "</div>"; //button_with_icon

echo "<div class='content_index light'>";

echo "<div class='links_left'>";
echo "<div class='link_left link_index' onclick='navigateTo_associes()'>Associés actionnaires</div>";
echo "<div class='link_left link_index' onclick='navigateTo_request()'>Requêtes associées</div>";
echo "</div>"; //links_left

echo "<div class='links_right'>";
echo "<div class='link_right link_index' onclick='navigateTo_dibe()'>DIBE</div>";
echo "<div class='link_right link_index' onclick='navigateTo_apitest()'>API Tests</div>";
echo "</div>"; //links_right

echo "</div>"; // content_index

echo "</div>"; // page
echo "<script src='resources/javascript/jquery-3.2.1.min.js'></script>";
echo "<script src='resources/javascript/javascript.js'></script>";
echo "<script src='resources/javascript/sweet-alert.js'></script>";
