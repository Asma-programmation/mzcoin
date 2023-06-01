$(document).ready(function () {
    $('nav#navbar').load('_content_navbar.html')
    $('div#footer').load('_content_footer.html')
})

function deconnecter() {
    window.location.href = "prg/utilisateur/deconnecter.php";
}
