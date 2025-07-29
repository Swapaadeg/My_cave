// Sélecteur de pays et de région
// Chargement des régions en fonction du pays sélectionné
document.addEventListener('DOMContentLoaded', function () {
    const paysSelect = document.querySelector('.filter-pays');
    const regionSelect = document.querySelector('.filter-region');

    const loadRegions = (paysId, selectedRegionId = null) => {
        regionSelect.innerHTML = '<option value="">Toutes les régions</option>';

        if (paysId) {
            fetch(`/get-regions?paysId=${paysId}`, {
                method: 'GET',
                headers: { 'Accept': 'application/json' },
            })
                .then(response => response.json())
                .then(data => {
                    data.regions.forEach(region => {
                        const option = document.createElement('option');
                        option.value = region.id;
                        option.textContent = region.nom;
                        if (selectedRegionId && region.id == selectedRegionId) {
                            option.selected = true;
                        }
                        regionSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Erreur lors du chargement des régions:', error));
        }
    };

    if (paysSelect && regionSelect) {
        // Gestion du changement de pays
        paysSelect.addEventListener('change', function () {
            loadRegions(this.value);
        });

        // Pré-remplir les régions si un pays est sélectionné au chargement
        const selectedPaysId = paysSelect.value;
        const selectedRegionId = regionSelect.dataset.selected;

        if (selectedPaysId) {
            loadRegions(selectedPaysId, selectedRegionId);
        }
    }
});
