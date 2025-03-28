/*$(document).ready(function() {
    $('#identifiant').on('blur', function() {
        var identifiant = $(this).val();
        if (identifiant.length > 0) {
            $.ajax({
                type: 'POST',
                url: 'Animateur.php',
                data: { identifiant: identifiant },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.exists) {
                        $('#identifiant').css('border-color', 'red');
                        if ($('#identifiant-error').length === 0) {
                            $('#identifiant').after('<span id="identifiant-error" style="color: red;">Cet identifiant est déjà pris.</span>');
                        }
                    } else {
                        $('#identifiant').css('border-color', '');
                        $('#identifiant-error').remove();
                    }
                }
            });
        }
    });
});*/

// pour afficher une erreur lors de la connexion si mdp ou ident incorrecte 
document.addEventListener('DOMContentLoaded', function() {
    const message = new URLSearchParams(window.location.search);
    const erreur = message.get('erreur');

    if (erreur === '1') {
        // Affiche un message d'erreur
        alert('Mot de passe incorrect. Veuillez réessayer.');
    }
    if (erreur === '2'){
        alert('Identifiant inexistant. Veuillez réessayer.');

    }
});

// fonction poules si oui affiche les champs nb poules et nb de joueurs par poules
function togglePouleFields() {
    const poulesOui = document.getElementById('poulesOui');
    const pouleFields = document.getElementById('pouleFields');
    pouleFields.style.display = poulesOui.checked ? 'block' : 'none';
}

document.addEventListener('DOMContentLoaded', (event) => {
    document.getElementById('poulesOui').addEventListener('click', togglePouleFields);
    document.getElementById('poulesNon').addEventListener('click', togglePouleFields);
});
