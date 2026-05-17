document.addEventListener('DOMContentLoaded', () => {
    const conteneur = document.getElementById('conteneur-modification');
    if (!conteneur) return;

    const commandeInitiale = JSON.parse(conteneur.getAttribute('data-articles')) || [];
    let articlesModifiables = [];

    commandeInitiale.forEach(art => {
        articlesModifiables.push({
            id: art.id,
            nom: art.nom,
            prix: parseFloat(art.prix ?? 0),
            quantite: parseInt(art.quantite)
        });
    });

    const ancienTotal = articlesModifiables.reduce((sum, art) => sum + (art.prix * art.quantite), 0);
    document.getElementById('ancien-total').textContent = ancienTotal.toFixed(2);

    const tbody = document.getElementById('liste-articles-modif');
    const selectAjout = document.getElementById('ajout-nouveau-plat');

    function recalculerEtAfficher() {
        tbody.innerHTML = '';
        let nouveauTotal = 0;

        if (articlesModifiables.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="cellule-vide">Votre commande est vide.</td></tr>';
        }

        articlesModifiables.forEach((art, index) => {
            const sousTotal = art.prix * art.quantite;
            nouveauTotal += sousTotal;

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td><strong>${art.nom}</strong></td>
                <td>${art.prix.toFixed(2)} €</td>
                <td>
                    <button class="btn-qte" data-index="${index}" data-action="moins">-</button>
                    <span style="margin: 0 10px; font-weight: bold;">${art.quantite}</span>
                    <button class="btn-qte" data-index="${index}" data-action="plus">+</button>
                </td>
                <td><strong>${sousTotal.toFixed(2)} €</strong></td>
                <td><button class="btn-suppr" data-index="${index}">Enlever</button></td>
            `;
            tbody.appendChild(tr);
        });

        document.getElementById('nouveau-total').textContent = nouveauTotal.toFixed(2);
        const difference = nouveauTotal - ancienTotal;
        document.getElementById('difference-montant').textContent = (difference > 0 ? '+' : '') + difference.toFixed(2);

        const zoneFinance = document.getElementById('zone-finance');
        const explication = document.getElementById('explication-finance');

        zoneFinance.className = "indicateur-finance";
        if (Math.abs(difference) < 0.01) {
            zoneFinance.classList.add('finance-neutre');
            explication.textContent = "Aucun ajustement requis.";
        } else if (difference > 0) {
            zoneFinance.classList.add('finance-supplement');
            explication.textContent = "Vous allez être redirigé vers CYBank pour payer le complément.";
        } else {
            zoneFinance.classList.add('finance-remboursement');
            explication.textContent = "Un ticket de réduction du montant de la différence va vous être attribué.";
        }
    }

    tbody.addEventListener('click', (e) => {
        const index = e.target.getAttribute('data-index');
        if (index === null) return;

        if (e.target.classList.contains('btn-qte')) {
            const action = e.target.getAttribute('data-action');
            if (action === 'plus') {
                articlesModifiables[index].quantite++;
            } else if (action === 'moins' && articlesModifiables[index].quantite > 1) {
                articlesModifiables[index].quantite--;
            }
        } else if (e.target.classList.contains('btn-suppr')) {
            articlesModifiables.splice(index, 1);
        }
        recalculerEtAfficher();
    });

    selectAjout.addEventListener('change', () => {
        const option = selectAjout.options[selectAjout.selectedIndex];
        if (!option.value) return;

        const id = option.value;
        const nom = option.getAttribute('data-nom');
        const prix = parseFloat(option.getAttribute('data-prix'));

        const existant = articlesModifiables.find(art => art.id === id);
        if (existant) {
            existant.quantite++;
        } else {
            articlesModifiables.push({ id, nom, prix, quantite: 1 });
        }

        selectAjout.value = '';
        recalculerEtAfficher();
    });

    document.getElementById('btn-valider-modif').addEventListener('click', () => {
        const idCmd = document.getElementById('cmd-id').textContent.trim();
        
        fetch('includes/action_modifier_commande.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id_commande: idCmd, articles: articlesModifiables })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.redirect_url) {
                    window.location.href = data.redirect_url;
                } else {
                    alert(data.message);
                    window.location.href = 'profil.php';
                }
            } else {
                alert("Erreur : " + data.message);
            }
        })
        .catch(error => console.error('Erreur:', error));
    });

    recalculerEtAfficher();
});