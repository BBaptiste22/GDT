let numeroEquipe = 1;
let compteurCartes = 0;
let entreesJoueurs = '';

function genererCarteEquipe() {
    const conteneurCartes = document.getElementById('conteneurCartes');
    const compteurEquipes = document.getElementById('compteurEquipes');
    const nombreJoueurParEquipe = parseInt(compteurEquipes.dataset.nombreJoueurs);
  
    for (let j = 1; j <= nombreJoueurParEquipe; j++) {
        entreesJoueurs += `Joueur ${j}: <input type="text" name="joueurs[]" class="form-control mb-2" required>`;
    }

    const carteHtml = `
        <div class="col mb-4">
            <div class="card h-100">
                <div class="card-header bg-success text-white">Équipe ${numeroEquipe}</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <input type="text" name="nom_equipe" class="form-control mb-2" placeholder="Nom de l'équipe" required>
                    </li>
                    <li class="list-group-item">
                        ${entreesJoueurs}
                    </li>
                    <li class="list-group-item d-flex">
                        <button type="button" class="btn btn-success me-2 soumettreEquipeBtn">Soumettre l'équipe</button>
                        <button type="button" class="btn btn-secondary ms-auto terminerEquipeBtn">Terminer</button>
                    </li>
                </ul>
            </div>
        </div>
    `;

    conteneurCartes.insertAdjacentHTML('beforeend', carteHtml);
    compteurEquipes.textContent = `Nombre d'équipes créées : ${compteurCartes}`;
}

window.addEventListener('load', genererCarteEquipe);

document.getElementById('conteneurCartes').addEventListener('click', function(event) {
    if (event.target.classList.contains('soumettreEquipeBtn')) {
        const carte = event.target.closest('.col');
        const formData = new FormData();
        const inputs = carte.querySelectorAll('input');

        inputs.forEach(input => {
            formData.append(input.name, input.value);
        });

        fetch('../../equipeBundle/equipeBundle/Controller/EquipeController.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert('Équipe soumise avec succès !');
            console.log(data);

            // Effacer les valeurs des champs de saisie
            inputs.forEach(input => {
                input.value = '';
            });

            // Mettre à jour le numéro de l'équipe
            numeroEquipe++;
            compteurCartes++;
            document.getElementById('compteurEquipes').textContent = `Nombre d'équipes créées : ${compteurCartes}`;

            // Mettre à jour le titre de la prochaine carte
            const nouvelleCarte = document.createElement('div');
            nouvelleCarte.innerHTML = `
                <div class="col mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-success text-white">Équipe ${numeroEquipe}</div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <input type="text" name="nom_equipe" class="form-control mb-2" placeholder="Nom de l'équipe" required>
                            </li>
                            <li class="list-group-item">
                                ${entreesJoueurs}
                            </li>
                            <li class="list-group-item d-flex">
                                <button type="button" class="btn btn-success me-2 soumettreEquipeBtn">Soumettre l'équipe</button>
                                <button type="button" class="btn btn-secondary ms-auto terminerEquipeBtn">Terminer</button>
                            </li>
                        </ul>
                    </div>
                </div>
            `;
            conteneurCartes.appendChild(nouvelleCarte.firstChild);

        })
        .catch(error => {
            console.error(error);
        });
    } else if (event.target.classList.contains('terminerEquipeBtn')) {
        window.location.href = '../views/equipes.php';
    }
});