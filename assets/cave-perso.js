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
