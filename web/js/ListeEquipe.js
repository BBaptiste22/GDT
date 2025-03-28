// Édition d'une équipe
$('.icon-edit-equipe').on('click', function() {
    var equipeId = $(this).data('id');
    var teamNameElement = $('#teamName_' + equipeId);
    var currentTeamName = teamNameElement.text();

    // Création d'un champ de saisie pour éditer le nom de l'équipe
    var inputField = $('<input type="text" class="edit-input form-control" value="' + currentTeamName + '">');
    var saveButton = $('<button class="btn btn-primary save-button">Sauvegarder</button>');
    var cancelButton = $('<button class="btn btn-secondary cancel-button">Annuler</button>');

    teamNameElement.empty().append(inputField).append(saveButton).append(cancelButton);

    // Clic sur le bouton "Annuler"
    cancelButton.on('click', function() {
        teamNameElement.empty().text(currentTeamName);
    });

    // Clic sur le bouton "Sauvegarder"
    saveButton.on('click', function() {
        var nouveauNomEquipe = inputField.val();

        $.ajax({
            url: '../../GDT/equipeBundle/Entity/modifier.php',
            type: 'POST',
            data: { action: 'updateEquipe', equipeId: equipeId, nouveauNom: nouveauNomEquipe },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    teamNameElement.empty().text(nouveauNomEquipe);
                } else {
                    alert(response.error);
                    teamNameElement.empty().text(currentTeamName);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Erreur lors de la modification de l\'équipe.');
                teamNameElement.empty().text(currentTeamName);
            }
        });
    });
});

// Édition d'un joueur
$('.icon-edit-joueur').on('click', function() {
    var joueurId = $(this).data('id');
    var listItem = $(this).closest('li');
    listItem.find('.joueur-nom').hide();
    listItem.find('.icon-edit-joueur').hide();
    listItem.find('.edit-input').show();
    listItem.find('.save-button').show();
    listItem.find('.cancel-button').show();
});

// Annulation de l'édition d'un joueur
$('.cancel-button').on('click', function() {
    var joueurId = $(this).data('id');
    var listItem = $(this).closest('li');
    listItem.find('.joueur-nom').show();
    listItem.find('.icon-edit-joueur').show();
    listItem.find('.edit-input').hide();
    listItem.find('.save-button').hide();
    listItem.find('.cancel-button').hide();
});

// Sauvegarde des modifications du joueur
$('.save-button').on('click', function() {
    var joueurId = $(this).data('id');
    var nouveauNomJoueur = $(this).siblings('.edit-input').val();

    $.ajax({
        url: '../../GDT/equipeBundle/Entity/modifier.php',
        type: 'POST',
        data: { action: 'updateJoueur', joueurId: joueurId, nouveauNom: nouveauNomJoueur },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                var listItem = $('.save-button[data-id="'+ joueurId +'"]').closest('li');
                listItem.find('.joueur-nom').text(nouveauNomJoueur).show();
                listItem.find('.icon-edit-joueur').show();
                listItem.find('.edit-input').hide();
                listItem.find('.save-button').hide();
                listItem.find('.cancel-button').hide();
            } else {
                alert(response.error);
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert('Erreur lors de la modification du nom du joueur.');
        }
    });
});

// Suppression d'une équipe
$('.icon-delete').on('click', function() {
    var equipeId = $(this).data('id');

    if (confirm("Êtes-vous sûr de vouloir supprimer cette équipe ?")) {
        $.ajax({
            url: '../../GDT/equipeBundle/Entity/supprimer.php',
            type: 'POST',
            data: { id: equipeId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert('Erreur lors de la suppression de l\'équipe : ' + response.error);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Erreur lors de la suppression de l\'équipe.');
            }
        });
    }
});
