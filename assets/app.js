/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.scss';
import Choices from 'choices.js';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

//Menu
document.addEventListener('DOMContentLoaded', () => {
  const burger = document.querySelector('.burger');
  const navbar = document.querySelector('.navbar');

  if (burger) {
    burger.addEventListener('click', () => {
      navbar.classList.toggle('open');
    });
  }
});


// MODALE FLASH

function fermerModale() {
      const modale = document.getElementById('modale-flash');
      if (modale) {
          modale.style.display = 'none';
      }
  }

  // Fermer automatiquement après 2 secondes
  setTimeout(() => {
      fermerModale();
  }, 2000);

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
    document.querySelectorAll('.ajouter-cave').forEach(button => {
        button.addEventListener('click', function () {
            const bouteilleId = this.dataset.id;
            const csrfToken = this.dataset.token;

            fetch(`/cave/ajouter/${bouteilleId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: `_token=${encodeURIComponent(csrfToken)}`
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur lors de l\'ajout');
                }
                return response.text();
            })
            .then(() => {
                this.textContent = "Ajoutée ✔️";
                this.disabled = true;
                this.classList.add("ajoutee");
            })
            .catch(error => {
                console.error(error);
                alert("Une erreur est survenue.");
            });
        });
    });
});