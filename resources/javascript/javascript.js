function navigateTo_index_for_index() {
    this.location.href = 'index.php';
}

function navigateTo_index_for_register() {
    this.location.href = '../welcome.php';
}

function navigateTo_index() {
    this.location.href = '../../welcome.php';
}

function navigateTo_logout() {
    this.location.href = './login/exit.php';
}

function navigateTo_register() {
    this.location.href = './login/reg.php';
}

function navigateTo_associes() {
    this.location.href = 'src/pages/associes.php';
}

function navigateTo_request() {
    this.location.href = 'src/pages/request.php';
}

function navigateTo_dibe() {
    this.location.href = 'src/pages/dibe.php';
}

function navigateTo_apitest() {
    this.location.href = 'src/pages/apitest.php';
}

function check_siren() {
    var siren = document.getElementById("input_text_siren").value;
    var len_siren = siren.length;
    if (isNaN(siren)) {
        swal("Oops...", "Siren non disponible!", "error");
        return false;
    }
    else if (len_siren != 9) {
        swal("Oops...", "Le siren doit avoir 9 chiffres!", "warning");
        return false;
    }
    else {
        return true;
    }
}

function check_dibe() {
    var nclient = document.getElementById("input_dibe_nc").value;
    var nutilis = document.getElementById("input_dibe_nut").value;
    var mdp = document.getElementById("input_dibe_mdp").value;
    var ref = document.getElementById("input_dibe_ref").value;
    var file = document.getElementById("input_dibe_csv").value;

    if (nclient != "" && (isNaN(nclient) || nclient.length < 4)) {
        swal("Oops...", "Le numéro de client non disponible!", "error");
        return false;
    }
    else if (nclient == "") {
        swal("Oops...", "Le numéro de client ne peut pas être vide!", "error");
        return false;
    }
    else if (nutilis != "" && (isNaN(nutilis) || nutilis.length < 4)) {
        swal("Oops...", "Le numéro d'utilisateur non disponible!", "error");
        return false;
    }
    else if (nutilis == "") {
        swal("Oops...", "Le numéro d'utilisateur ne peut pas être vide!", "error");
        return false;
    }
    else if (mdp == "") {
        swal("Oops...", "Le mot de passe ne peut pas être vide!", "error");
        return false;
    }
    /* else if (ref != "" && ref.length < 8) {
        swal("Oops...", "La référence non disponible!", "error");
        return false;
    } */
    else if (file == "") {
        swal("Oops...", "Le fichier est obligatoire!", "error");
        return false;
    }
    else {
        return true;
    }
}

function check_date(str_date_1, str_date_2) {
    var date_1 = document.getElementById(str_date_1).value;
    var date_2 = document.getElementById(str_date_2).value;
    var date1_year = date_1.slice(0, 4);
    var date2_year = date_2.slice(0, 4);
    var date1_month = date_1.slice(5, 7);
    var date2_month = date_2.slice(5, 7);

    if ((date2_year - date1_year > 1) || ((date1_year < date2_year) && (date1_month < date2_month))) {
        swal("Oops...", "La durée ne peut pas être dépassée un an!", "warning");
        return false;
    }
    else if (isNaN(date1_year) || isNaN(date2_year) || date1_year == null || date2_year == null) {
        swal("Oops...", "Date non disponible!", "error");
        return false;
    }
    else if (date_1 > date_2) {
        swal("Oops...", "La date de gauche ne peut pas être supérieure à celle de droîte!", "error");
        return false;
    }
    else {
        return true;
    }
}

function ajax_send_date(bool_data, bool_api, msg, data, req_file, loadinggif) {

    if (bool_data == 0) {
        var url = "../requests/" + req_file + ".php";
        var postdate = "date1=" + data["date1"] + "&date2=" + data["date2"];
    }
    else if (bool_data == 1 && bool_api == 1) {
        var url = "../api_test/" + req_file + ".php";
        var postdate = "siren_apitest=" + data["siren"];
    }
    else if (bool_data == 1 && bool_api == 2) {
        var url = "../api_test/" + req_file + ".php";
        var postdate = "siren_apitest=" + data["siren"] + "&bilan_apitest=" + data["bilan"];
    }
    else if (bool_data == 1 && bool_api == 3) {
        var url = "../api_test/" + req_file + ".php";
        var postdate = "nom_apitest=" + data["nom"] + "&prenom_apitest=" + data["prenom"] + "&naissance_apitest=" + data["naissance"];
    }
    else if (bool_data == 2) {
        var url = "./login/" + req_file + ".php";
        var postdate = "email=" + data["email"] + "&pwd=" + data["pwd"];
    }


    var ajax = false;
    //初始化XMLHttpRequest对象
    if (window.XMLHttpRequest) { //Mozilla 浏览器
        ajax = new XMLHttpRequest();
        if (ajax.overrideMimeType) {//设置MiME类别
            ajax.overrideMimeType("text/xml");
        }
    }
    else if (window.ActiveXObject) { // IE浏览器
        try {
            ajax = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                ajax = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) { }
        }
    }
    if (!ajax) { // 异常，创建对象实例失败
        window.alert("不能创建XMLHttpRequest对象实例.");
        return false;
    }

    //ajax post
    ajax.open("POST", url, true);

    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");//HTTP head

    //ajax post发送
    ajax.send(postdate);
    // document.getElementById(loadinggif).style.display = "none";
    ajax.onreadystatechange = function () {
        //如果执行状态成功，那么就把返回信息写到指定的层里
        if (ajax.readyState == 4 && ajax.status == 200) {
            if (bool_data == 2) {
                if (ajax.responseText == "200") {
                    location.href = './login/login_sessions.php?useremail='+data["email"];
                } else if (ajax.responseText == "403") {
                    msg.innerHTML = "<div class='reg_tips text-rouge'>Le mot de passe n'est pas correct!</div>";
                } else if (ajax.responseText == "404") {
                    msg.innerHTML = "<div class='reg_tips text-rouge'>L'adresse e-mail n'est pas correcte!</div>"
                }
            } else {
                msg.innerHTML = ajax.responseText;
            }
            document.getElementById(loadinggif).style.display = "none";
            // alert("返回信息： " + ajax.responseText);
        }
    }
}
/*************************** API Test ***************************/
function send_data_apitest_FI() {
    document.getElementById("loadinggif_api_FI").style.display = "block";
    var msg = document.getElementById("response_area_api_FI");
    var siren = document.api_form_FI.api_siren_FI.value;
    var data = { "siren": siren };
    ajax_send_date(1, 1, msg, data, "FicheIdentite", "loadinggif_api_FI")
}

function send_data_apitest_Rep() {
    document.getElementById("loadinggif_api_Rep").style.display = "block";
    var msg = document.getElementById("response_area_api_Rep");
    var siren = document.api_form_Rep.api_siren_Rep.value;
    var data = { "siren": siren };
    ajax_send_date(1, 1, msg, data, "Representants", "loadinggif_api_Rep")
}

function send_data_apitest_CA() {
    document.getElementById("loadinggif_api_CA").style.display = "block";
    var msg = document.getElementById("response_area_api_CA");
    var siren = document.api_form_CA.api_siren_CA.value;
    var bilan = document.api_form_CA.api_bilan_CA.value;
    var data = { "siren": siren, "bilan": bilan };
    ajax_send_date(1, 2, msg, data, "ComptesAnnuels", "loadinggif_api_CA")
}

function send_data_apitest_ER() {
    document.getElementById("loadinggif_api_ER").style.display = "block";
    var msg = document.getElementById("response_area_api_ER");
    var nom = document.api_form_ER.api_ER_nom.value;
    var prenom = document.api_form_ER.api_ER_prenom.value;
    var naissance = document.api_form_ER.api_ER_naissance.value;
    var data = { "nom": nom, "prenom": prenom, "naissance": naissance };
    ajax_send_date(1, 3, msg, data, "EntrepriseRepresentants", "loadinggif_api_ER")
}

function send_data_apitest_PC() {
    document.getElementById("loadinggif_api_PC").style.display = "block";
    var msg = document.getElementById("response_area_api_PC");
    var siren = document.api_form_PC.api_siren_PC.value;
    var data = { "siren": siren };
    ajax_send_date(1, 1, msg, data, "ProceduresCollectives", "loadinggif_api_PC")
}

/*************************** API Test DEV ***************************/

function send_data_apitest_NPP() {
    document.getElementById("loadinggif_api_NPP").style.display = "block";
    var msg = document.getElementById("response_area_api_NPP");
    var siren = document.api_form_NPP.api_siren_NPP.value;
    var data = { "siren": siren };
    ajax_send_date(1, 1, msg, data, "NotaPMEPerformance", "loadinggif_api_NPP")
}

function send_data_apitest_NPE() {
    document.getElementById("loadinggif_api_NPE").style.display = "block";
    var msg = document.getElementById("response_area_api_NPE");
    var siren = document.api_form_NPE.api_siren_NPE.value;
    var data = { "siren": siren };
    ajax_send_date(1, 1, msg, data, "NotaPMEEssentiels", "loadinggif_api_NPE")
}

function send_data_apitest_NPI() {
    document.getElementById("loadinggif_api_NPI").style.display = "block";
    var msg = document.getElementById("response_area_api_NPI");
    var siren = document.api_form_NPI.api_siren_NPI.value;
    var data = { "siren": siren };
    ajax_send_date(1, 1, msg, data, "NotaPMEIntegral", "loadinggif_api_NPI")
}

function send_data_apitest_AFDCC() {
    document.getElementById("loadinggif_api_AFDCC").style.display = "block";
    var msg = document.getElementById("response_area_api_AFDCC");
    var siren = document.api_form_AFDCC.api_siren_AFDCC.value;
    var data = { "siren": siren };
    ajax_send_date(1, 1, msg, data, "AFDCC", "loadinggif_api_AFDCC")
}

function send_data_apitest_EE() {
    document.getElementById("loadinggif_api_EE").style.display = "block";
    var msg = document.getElementById("response_area_api_EE");
    var siren = document.api_form_EE.api_siren_EE.value;
    var data = { "siren": siren };
    ajax_send_date(1, 1, msg, data, "EvaluationEntreprises", "loadinggif_api_EE")
}

/*************************** Request ***************************/
function send_date_ns() {
    document.getElementById("loadinggif_ns").style.display = "block";
    var msg = document.getElementById("response_NS");
    var date1 = document.form_pm_saisies.date_ns1.value;
    var date2 = document.form_pm_saisies.date_ns2.value;
    var data = { "date1": date1, "date2": date2 };
    var check_date = this.check_date("date_ns1", "date_ns2");
    if (check_date) {
        ajax_send_date(0, 0, msg, data, "req_NS", "loadinggif_ns");
    }
    else {
        return;
    }
}

function send_date_er() {
    document.getElementById("loadinggif_er").style.display = "block";
    var msg = document.getElementById("response_ER");
    var date1 = document.form_entreprise_recue.date_er1.value;
    var date2 = document.form_entreprise_recue.date_er2.value;
    var data = { "date1": date1, "date2": date2 };
    var check_date = this.check_date("date_er1", "date_er2");
    if (check_date) {
        ajax_send_date(0, 0, msg, data, "req_ER", "loadinggif_er");
    }
    else {
        return;
    }
}

function send_date_ed() {
    document.getElementById("loadinggif_ed").style.display = "block";
    var msg = document.getElementById("response_ED");
    var date1 = document.form_entreprise_demandees.date_ed1.value;
    var date2 = document.form_entreprise_demandees.date_ed2.value;
    var data = { "date1": date1, "date2": date2 };
    var check_date = this.check_date("date_ed1", "date_ed2");
    if (check_date) {
        ajax_send_date(0, 0, msg, data, "req_ED", "loadinggif_ed");
    }
    else {
        return;
    }
}

function send_date_rj() {
    document.getElementById("loadinggif_rj").style.display = "block";
    var msg = document.getElementById("response_RJ");
    var date1 = document.form_entreprise_rejets.date_rj1.value;
    var date2 = document.form_entreprise_rejets.date_rj2.value;
    var data = { "date1": date1, "date2": date2 };
    var check_date = this.check_date("date_rj1", "date_rj2");
    if (check_date) {
        ajax_send_date(0, 0, msg, data, "req_RJ", "loadinggif_rj");
    }
    else {
        return;
    }
}

function send_date_ednr() {
    document.getElementById("loadinggif_ednr").style.display = "block";
    var msg = document.getElementById("response_EDNR");
    var date1 = document.form_entreprise_dnr.date_ednr1.value;
    var date2 = document.form_entreprise_dnr.date_ednr2.value;
    var data = { "date1": date1, "date2": date2 };
    var check_date = this.check_date("date_ednr1", "date_ednr2");
    if (check_date) {
        ajax_send_date(0, 0, msg, data, "req_EDNR", "loadinggif_ednr");
    }
    else {
        return;
    }
}

/*************************** Login ***************************/

function send_data_login() {
    document.getElementById("loadding_login").style.display = "block";
    var msg = document.getElementById("response_login");
    var email = document.form_login.login_email.value;
    var pwd = document.form_login.login_pswd.value;
    var data = { "email": email, "pwd": pwd };
    ajax_send_date(2, 0, msg, data, "login", "loadding_login")
}

/*************************** Register ***************************/

function regular_verification(email, pwd, mobile) {
    var expr_email = /^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[.\-a-z0-9]*[a-z0-9]+\.){1,63}[a-z0-9]+$/;
    var expr_pwd = /^.{8,20}$/;
    var expr_mobile = /^[0-9]{9,15}$/;
    var res = new Array();

    res["email"] = expr_email.test(email);
    res["pwd"] = expr_pwd.test(pwd);
    res["mobile"] = expr_mobile.test(mobile);

    return res;
}

function check_register() {
    var civilite = document.form_register.reg_civilite.value;
    var firstname = document.getElementById("reg_firstname").value;
    var lastname = document.getElementById("reg_lastname").value;
    var email = document.getElementById("reg_email").value;
    var pwd = document.getElementById("reg_pswd").value;
    var cf_pwd = document.getElementById("reg_cf_pswd").value;
    var mobile = document.getElementById("reg_mobile").value;

    var res = regular_verification(email, pwd, mobile);
    
    if (civilite == "") {
        swal("Oops...", "Veuillez choisir votre civilité!", "error");
        return false;
    } else if (firstname == "") {
        swal("Oops...", "Veuillez saisir votre prénom!", "error");
        return false;
    } else if (lastname == "") {
        swal("Oops...", "Veuillez saisir votre nom!", "error");
        return false;
    } else if (email == "") {
        swal("Oops...", "Veuillez saisir votre e-mail!", "error");
        return false;
    } else if (!res["email"]) {
        swal("Oops...", "E-mail non disponible!", "error");
        return false;
    } else if (!res["pwd"]) {
        swal("Oops...", "Mot de passe est obligé entre 8 et 20 caractères!", "error");
        return false;
    } else if (pwd == "") {
        swal("Oops...", "Veuillez saisir un mot de passe!", "error");
        return false;
    } else if (pwd !== cf_pwd) {
        swal("Oops...", "Deux mots de passe ne sont pas pareils!", "error");
        document.getElementById("reg_cf_pswd").value = "";
        return false;
    } else if (mobile != "" && !res["mobile"]) {
        swal("Oops...", "Numéro de téléphone non disponible!", "error");
        return false;
    } else {
        return true;
    }
}

$(document).ready(function () {
    $('#date_ns1, #date_ns2, #date_er1, #date_er2, #date_ed1, #date_ed2, #date_rj1, #date_rj2, #date_ednr1, #date_ednr2').dcalendarpicker({
        format: 'yyyy-mm-dd'
    });
    // $('#loadinggif_ns, #loadinggif_er, #loadinggif_ed, #loadinggif_rj, #loadinggif_ednr').hide();
    $('#button_NS').click(function () {
        var scroll_offset1 = $("#pm-saisies").offset();
        $("html,body").animate({ scrollTop: scroll_offset1.top }, 500);
    });
});

/* $(function(){
    $('#api_FI_siren').on('input propertychange', function () {
        var result = $(this).val();
        console.log(result);
        $('#FI_link').html(result);
    });
}); */