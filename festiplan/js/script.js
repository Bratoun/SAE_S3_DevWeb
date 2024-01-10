document.addEventListener('DOMContentLoaded', function() {
    var boutonSuppression = document.querySelectorAll('suppression');

    boutonSuppression.addEventListener('click', function() {

        // Récupérer l'ID du spectacle à partir de l'attribut data
        var idSpectacle = boutonSuppression.getAttribute('data-id-spectacle');

        // Afficher la boîte de dialogue de confirmation
        var confirmation = confirm("Si des festivals ont programmer votre spectacle, il sera supprimer de la liste des spectacles du festival. Voulez-vous vraiment supprimer ce spectacle ?");

        // Vérifier la réponse de l'utilisateur
        if (confirmation) {
            // L'utilisateur a cliqué sur "OK"
            alert("Spectacle supprimé !");
            // Rediriger vers la page de suppression avec l'ID du spectacle
            window.location.href = '/festiplan?controller=Spectacle&action=supprimerSpectacle&idSpectacle=' + idSpectacle;
        } 
    });
});

document.addEventListener('DOMContentLoaded', function() {
    var boutonSuppressionFestival = document.getElementById('suppressionFestival');

    boutonSuppressionFestival.addEventListener('click', function() {

        // Récupérer l'ID du spectacle à partir de l'attribut data
        var idFestival = boutonSuppressionFestival.getAttribute('data-id-festival');

        // Afficher la boîte de dialogue de confirmation
        var confirmation = confirm("Souhaitez vous vraiment supprimer votre festival ?");

        // Vérifier la réponse de l'utilisateur
        if (confirmation) {
            // L'utilisateur a cliqué sur "OK"
            alert("Festival supprimé !");
            // Rediriger vers la page de suppression avec l'ID du spectacle
            window.location.href = '/festiplan?controller=Festival&action=supprimerFestival&idFestival=' + idFestival;
        } 
    });
});