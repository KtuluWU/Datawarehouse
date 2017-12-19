function navigateTo() {
    this.location.href = 'index.php';
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

    if (date2_year > date1_year) {
        swal("Oops...", "La durée ne peut pas être dépassée un an!", "warning");
        return false;
    }
    else if (isNaN(date1_year) || isNaN(date2_year) || date1_year==null || date2_year==null) {
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

function ajax_send_date(msg, date1, date2, req_file, loadinggif) {

    var url = "../requests/" + req_file + ".php";
    var postdate = "date1=" + date1 + "&date2=" + date2;

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
            msg.innerHTML = ajax.responseText;
            document.getElementById(loadinggif).style.display = "none";
            // alert("返回信息： " + ajax.responseText);
        }
    }

}

function send_date_ns() {
    document.getElementById("loadinggif_ns").style.display = "block";
    var msg = document.getElementById("response_NS");
    var date1 = document.form_pm_saisies.date_ns1.value;
    var date2 = document.form_pm_saisies.date_ns2.value;
    var check_date = this.check_date("date_ns1", "date_ns2");
    if (check_date) {
        this.ajax_send_date(msg, date1, date2, "req_NS", "loadinggif_ns");
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
    var check_date = this.check_date("date_er1", "date_er2");
    if (check_date) {
        this.ajax_send_date(msg, date1, date2, "req_ER", "loadinggif_er");
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
    var check_date = this.check_date("date_ed1", "date_ed2");
    if (check_date) {
        this.ajax_send_date(msg, date1, date2, "req_ED", "loadinggif_ed");
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
    var check_date = this.check_date("date_rj1", "date_rj2");
    if (check_date) {
        this.ajax_send_date(msg, date1, date2, "req_RJ", "loadinggif_rj");
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
    var check_date = this.check_date("date_ednr1", "date_ednr2");
    if (check_date) {
        this.ajax_send_date(msg, date1, date2, "req_EDNR", "loadinggif_ednr");
    }
    else {
        return;
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