// code exécuté au démarrage
$(document).ready(function () {
    // si lors de l'inscription, l'email est déjà pris ou autre erreur, ré-afficher le modal d'inscription
    if ($('#RegisterMailExists').length > 0 || $('#ErrorMDPRegister').length > 0) $('#registerModal').modal('show')

    // si le login n'a pas fonctionné, ré-afficher le modal d'authentification
    if ($('#WrongLogin').length > 0) $('#loginModal').modal('show')

    $(".alert").show().delay(3000).fadeOut(500);

    // new post effects
    if ($("#newPostDone").length != 0)
        $("#newPostDone").fadeIn().delay(3000).fadeOut(500);
    if ($("#newPostMissingInfo").length != 0)
        $("#newPostMissingInfo").fadeIn().delay(3000).fadeOut(500);
    if ($("#newPostWrongFile").length != 0)
        $("#newPostWrongFile").fadeIn().delay(3000).fadeOut(500);

});

// jquery Modal Register
//#region ModalRegister
$('#RegisterMDPVerif').on('focusout', function () {
    if ($('#RegisterMDP').val() != "" && $('#InscriptionMDPVerif').val() != "") {
        if ($('#RegisterMDP').val() != $('#RegisterMDPVerif').val())
            $('#mdpUnmatch').fadeIn()

        else
            $('#mdpUnmatch').fadeOut()
    }
});

$('#RegisterMDP').on('focusout', function () {
    var regexNumber = new RegExp("[0-9]")

    if ($('#RegisterMDP').val() == $('#InscriptionMDPVerif').val())
        $('#mdpUnmatch').fadeOut()

    if (!regexNumber.test($('#RegisterMDP').val()))
        $('#mdpNoNum').fadeIn()
    else
        $('#mdpNoNum').fadeOut()
});

$('#RegisterMDP').on('keyup', function () {
    let mdpLen = $('#RegisterMDP').val().length
    if (mdpLen == 0) $('#strongMDP').val()
    else if (mdpLen >= 0 && mdpLen < 6) $('#strongMDP').text("- Faible").css("color", "red")
    else if (mdpLen >= 6 && mdpLen < 12) $('#strongMDP').text("- Moyen").css("color", "grey")
    else $('#strongMDP').text("- Fort").css("color", "green")
});
//#endregion ModalRegister

// affichage du path du fichier à upload
$('#file-upload').bind('change', function () {
    var fileName = $(this).val();
    $('#file-selected').html(fileName);
})

// si upvote / downvote clické
$('.upvote').click(function () {
    $.ajax({
        type: "POST",
        data: "action=upvote&id=" + $(this).attr("id"),
        url: "vote.php"
    });
})

$('.downvote').click(function () {
    $.ajax({
        type: "POST",
        data: "action=downvote&id=" + $(this).attr("id"),
        url: "vote.php"
    });
})