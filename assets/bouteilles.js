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




// Gestion AJAX du stock cave (boutons + et -)
document.addEventListener('DOMContentLoaded', function () {
    // Ajout de bouteille à la cave (boutons sur page bouteilles)
    const addButtons = document.querySelectorAll('.ajouter-cave');
    addButtons.forEach(button => {
        button.addEventListener('click', function () {
            const bouteilleId = this.dataset.id;
            const csrfToken = this.dataset.token;
            if (!bouteilleId || !csrfToken) return;
            fetch(`/cave/ajouter/${bouteilleId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: `_token=${encodeURIComponent(csrfToken)}`
            })
            .then(response => {
                if (!response.ok) throw new Error(`Erreur HTTP: ${response.status}`);
                return response.text();
            })
            .then(() => {
                this.textContent = "Ajoutée ✔️";
                this.disabled = true;
                this.classList.add("ajoutee");
            })
            .catch(error => {
                alert("Une erreur est survenue : " + error.message);
            });
        });
    });

    // Gestion AJAX + et - sur la page cave perso
    function updateStockTotal() {
        let total = 0;
        document.querySelectorAll('.stock-quantite').forEach(span => {
            total += parseInt(span.textContent, 10) || 0;
        });
        const totalSpan = document.querySelector('.stock-total .stock-total-value');
        if (totalSpan) {
            totalSpan.textContent = total;
        }
    }

    document.querySelectorAll('.stock-actions').forEach(actions => {
        const btnPlus = actions.querySelector('.btn-increment');
        const btnMoins = actions.querySelector('.btn-decrement');
        const stockSpan = actions.querySelector('.stock-quantite');
        if (btnPlus) {
            btnPlus.addEventListener('click', function (e) {
                e.preventDefault();
                const url = this.dataset.url;
                const token = this.dataset.token;
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: `_token=${encodeURIComponent(token)}`
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success && stockSpan) {
                        stockSpan.textContent = data.quantite;
                        updateStockTotal();
                    }
                });
            });
        }
        if (btnMoins) {
            btnMoins.addEventListener('click', function (e) {
                e.preventDefault();
                const url = this.dataset.url;
                const token = this.dataset.token;
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: `_token=${encodeURIComponent(token)}`
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success && stockSpan) {
                        stockSpan.textContent = data.quantite;
                        updateStockTotal();
                    }
                });
            });
        }
    });
});