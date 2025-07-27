// assets/js/app.js
console.log('Script app.js chargé');

document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM chargé, recherche des éléments');
    const paysSelect = document.querySelector('.filter-pays');
    const regionSelect = document.querySelector('.filter-region');

    if (paysSelect && regionSelect) {
        console.log('Éléments trouvés :', { paysSelect, regionSelect });
        paysSelect.addEventListener('change', function () {
            const paysId = this.value;
            console.log('Pays sélectionné :', paysId);

            fetch(`/get-regions?paysId=${paysId}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Erreur HTTP: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Réponse du serveur :', data);
                const selectedRegionId = regionSelect.getAttribute('data-selected-id');
                // Vider les options existantes et ajouter le placeholder
                regionSelect.innerHTML = '<option value="">Toutes les régions</option>';

                // Remplir avec les nouvelles régions
                if (data.regions && data.regions.length > 0) {
                    data.regions.forEach(region => {
                        const option = document.createElement('option');
                        option.value = region.id; // Utilise l'ID comme valeur
                        option.textContent = region.nom;
                        if (selectedRegionId && selectedRegionId == region.id) {
                            option.selected = true;
                        }
                        regionSelect.appendChild(option);
                    });
                } else {
                    console.warn('Aucune région trouvée pour ce pays.');
                }
            })
            .catch(error => console.error('Erreur lors du chargement des régions :', error));
        });

        // Déclencher au chargement si un pays est déjà sélectionné
        if (paysSelect.value) {
            paysSelect.dispatchEvent(new Event('change'));
        }
    } else {
        console.error('Éléments .filter-pays ou .filter-region non trouvés.');
    }
});