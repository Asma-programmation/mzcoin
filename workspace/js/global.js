$(document).ready(function () {
    $('nav#navbar').load('_content_navbar.html')
    $('div#footer').load('_content_footer.html')
    lister_comptes()
})

function modifier_etat_compte(ref, eta) {
    $.post("prg/compte/modifier_etat.php", {ref:ref, eta:eta}, function(data) { if(data == true) { alert('Opération terminée avec succès.'); window.location. reload(); } else { alert('Echèc de l\'opération !'); } }, 'text')
}

function ajouter_compte() {
    $('div#show').load('form_compte.html')
}

function deconnecter() {
    window.location.href = "prg/utilisateur/deconnecter.php"
}

function lister_comptes() {
    $("div#show").load("prg/compte/lister.php")
}