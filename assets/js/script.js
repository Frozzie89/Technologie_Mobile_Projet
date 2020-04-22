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


    $(".alert").show().delay(3000).fadeOut(500);
    // Load every Posts
    fetchData(0);
    // On change select -> remove all cards and add those whose tags corresponds
    $("#tagSelector").change(function () {
        $("#searchbarPost").val('');
        bindH2ToSelect($(this).children("option:selected").text());
        $('.col-lg-3').remove();
        let tagID = $(this).children("option:selected").val();
        fetchData(tagID);

    })

    // supprimer un post
    $(document).on('click', '.card-btn-right', function (event) {
        event.preventDefault();
        let idPost = this.id;
        if (confirm("Êtes-vous sûr de supprimer ce post ?")) {
            $.ajax({
                url: "deletePost.php",
                method: "POST",
                data: { postID: idPost },
                dataType: "text",
                success: function (data) {
                    $('.col-lg-3').remove();
                    fetchData(data);
                    //flash ou autre
                }
            });
        }
    })

    // supprimer un utilisateur
    $(document).on('click', '.deleteUser', function (event) {
        event.preventDefault();
        let idUser = this.id;
        if (confirm("Êtes-vous sûr de supprimer cet utilisateur?")) {
            $(this).closest("tr").fadeOut(500, function () { $(this).remove(); }).delay(500);
            $.ajax({
                url: "deleteUser.php",
                method: "POST",
                data: { userID: idUser },
                dataType: "text",
                // success: function () {
                // fetchData(data);
                //flash ou autre
                // }
            });
        }
    })

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


/* gestion post */

$("#searchbarPost").on("input", function () {
    var search = this.value;
    $('.col-lg-3').hide().each(function () {
        var text = $(this).find(".card-title:contains('" + search + "')");
        if (text.length) $(this).show();
    });
});

function limitTextPost(texte_posts) {
    texte_posts = texte_posts.substring(0, 70);
    texte_posts += "...";
    return texte_posts;
}

function bindH2ToSelect(nom_tag) {
    $('#titleBindToSelect').text(nom_tag);
}

function fetchData(tagValue) {
    $.getJSON('getPostsByTag.php', { tagID: tagValue }, function (posts) {
        //console.log(posts);
        let j = 0;
        $.each(posts, function (i, post) {

            $.getJSON('getPhotoOfPost.php', { postID: post.id_posts }, function (photo) {
                let postText = limitTextPost(post.texte_posts);
                console.log(postText);
                $("<div class='col-lg-3 card-news-max-height" + post.id_tags + "'><div class='card card-height card-style'>" +
                    "<img class='card-img-top' src='" + photo.nom_photos + "' alt='ok'>" +
                    "<div class='card-body card-body-style card-post'>" +
                    "<h5 class='card-title'>" + post.titre_posts + "</h5>" +
                    "<p class='card-text'>" + postText + "</p>" +
                    "<p class='tagPost'>" + post.id_tags + "</p>" +
                    "<a href='update-post.php?id=" + post.id_posts + "' class='btn btn-primary btn-lg card-btn-left'> Update </a>" +
                    "<a href='https://api.jquery.com/on/' id='" + post.id_posts + "' class='btn btn-primary btn-lg float-right card-btn-right'> Delete </a>").appendTo($(".maindiv"));
                // changer pour focntionne : delete
                // "<a href='delete-post.php?id="+post.id_posts+"' class='btn btn-primary btn-lg float-right card-btn-right'> Delete </a>"
            })
        })
    })

}

/* gestion utilisateurs */
$("#searchUser").on("input", function () {
    var search = this.value;
    $("tr:not(#tableHeader)").hide().each(function () {
        var pseudo = $(this).find("#pseudoUser:contains('" + search + "')");
        var email = $(this).find("#emailUser:contains('" + search + "')");
        if (pseudo.length || email.length) $(this).show();
    });
});

// pour case insensitive
$.expr[":"].contains = $.expr.createPseudo(function (arg) {
    return function (elem) {
        return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
    };
});

