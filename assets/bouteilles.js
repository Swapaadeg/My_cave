// MODALE REPONSE COMMENTAIRE
function ouvrirModal(caveId, commentaireId) {
    const modal = document.getElementById('modal-reponse');
    const form = document.getElementById('form-reponse');
    form.action = '/cave/' + caveId + '/repondre/' + commentaireId;
    modal.style.display = 'block';
}

function fermerModal() {
    const modal = document.getElementById('modal-reponse');
    modal.style.display = 'none';
}
window.ouvrirModal = ouvrirModal;
window.fermerModal = fermerModal;



// Ajout de bouteille à la cave
document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.ajouter-cave');

    buttons.forEach(button => {
        console.log('Bouton trouvé :', button);
        button.addEventListener('click', function () {
            const bouteilleId = this.dataset.id;
            const csrfToken = this.dataset.token;

            console.log('Click sur bouton avec id:', bouteilleId, 'et token:', csrfToken);

            if (!bouteilleId || !csrfToken) {
                console.error('ID ou token manquant :', { bouteilleId, csrfToken });
                alert('Erreur : ID ou token manquant.');
                return;
            }

            fetch(`/cave/ajouter/${bouteilleId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: `_token=${encodeURIComponent(csrfToken)}`
            })
            .then(response => {
                console.log('Réponse reçue :', response.status);
                if (!response.ok) {
                    throw new Error(`Erreur HTTP: ${response.status}`);
                }
                return response.text();
            })
            .then(() => {
                console.log('Ajout réussi pour id:', bouteilleId);
                this.textContent = "Ajoutée ✔️";
                this.disabled = true;
                this.classList.add("ajoutee");
            })
            .catch(error => {
                console.error('Erreur lors de l\'ajout :', error);
                alert("Une erreur est survenue : " + error.message);
            });
        });
    });
});