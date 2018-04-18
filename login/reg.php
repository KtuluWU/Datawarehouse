<?php
require "../config/config.php";

/****************************************** Title ******************************************/
echo "<head>";
echo "<link rel='stylesheet' type='text/css' href='../resources/css/style.css?v=201801251000' />";
echo "<link rel='stylesheet' href='../resources/css/sweet-alert.css'>";
echo "<link rel='stylesheet' href='../resources/css/bootstrap.min.css'>";
echo "<link rel='shortcut icon' href='../resources/assets/data_favicon.png' />";
echo "<title> Datawarehouse - Inscription </title>";
echo "</head>";
echo "<div class='page'>";
echo "<div class='title_logo dark'>";
echo "<div class='logo' onclick='navigateTo_index_for_register()'></div>";
echo "<div class='title_intranet'>Intranet Datawarehouse Datainfogreffe</div>";
echo "</div>";

/****************************************** Page ******************************************/

echo "<div class='content light'>";

echo "<div class='reg_title'>Enregistrez-vous</div>";

echo "<div class='back light'>";
echo "<a class='button_back' href='../index.php'><i class='material-icons icon-back'>arrow_back</i>Back</a></div>";

echo "<form id='form_register' name='form_register' action='action_register.php' method='post' onSubmit='return check_register()'>";

echo "<div class='reg_civilite'>";
echo "<div class='civi_male'>";
echo "<input class='reg_civilite_input' type='radio' name='reg_civilite' value='0' />";
echo "<label class='reg_civilite_text'>Homme</label>";
echo "</div>"; // civi_male
echo "<div class='civi_female'>";
echo "<input class='reg_civilite_input' type='radio' name='reg_civilite' value='1' />";
echo "<label class='reg_civilite_text'>Femme</label>";
echo "</div>"; // civi_female
echo "</div>"; // reg_civilite

echo "<div class='reg_username'>";
echo "<div class='reg_username_div'>";
echo "<input class='reg_username_input reg_input' type='text' name='reg_firstname' id='reg_firstname' maxlength='20' placeholder='Prénom *' autocomplete='off' />";
echo "</div>"; // reg_username_div
echo "<div class='reg_username_div'>";
echo "<input class='reg_username_input reg_input' type='text' name='reg_lastname' id='reg_lastname' maxlength='20' placeholder='Nom *' autocomplete='off' />";
echo "</div>"; // reg_username_div
echo "</div>"; // reg_username

echo "<div class='reg_input_div'>";
echo "<input class='reg_email_input reg_input' type='text' name='reg_email' id='reg_email' maxlength='30' placeholder='E-mail *' autocomplete='off' />";
echo "</div>"; // reg_input_div

echo "<div class='reg_input_div'>";
echo "<input class='reg_pswd_input reg_input' type='password' name='reg_pswd' id='reg_pswd' maxlength='30' placeholder='Mot de passe (8-20 caractères) *' autocomplete='off' />";
echo "</div>"; // reg_input_div

echo "<div class='reg_input_div'>";
echo "<input class='reg_cf_pswd_input reg_input' type='password' name='reg_cf_pswd' id='reg_cf_pswd' maxlength='30' placeholder='Confirmer le mot de passe *' autocomplete='off' />";
echo "</div>"; // reg_input_div

echo "<div class='reg_input_div'>";
echo "<input class='reg_mobile_input reg_input' type='text' name='reg_mobile' id='reg_mobile' maxlength='20' placeholder='Numéro de téléhone' autocomplete='off' />";
echo "</div>"; // reg_input_div

echo "<div class='button_with_icon'>";
echo "<input class='button_chercher' type='submit' value='Enregistrer'>";
echo "<label><i class='material-icons icon-search'>input</i></label>";
echo "</div>"; //button_with_icon

echo "</form>";
echo "</div>"; // content



echo "</div>"; // page
echo "<script src='../resources/javascript/jquery-3.2.1.min.js'></script>";
echo "<script src='../resources/javascript/javascript.js'></script>";
echo "<script src='../resources/javascript/sweet-alert.js'></script>";
