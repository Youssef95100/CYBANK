document.addEventListener('DOMContentLoaded', () => {
    const boutonsStatut = document.querySelectorAll('.btn-statut-livraison');
    const grille = document.getElementById('conteneur-grille-livraison');
    const messageGlobal = document.getElementById('message-retour-livraison');

    boutonsStatut.forEach(btn => {
        btn.addEventListener('click', () => {
            const idCommande = btn.getAttribute('data-id');
            const statutCible = btn.getAttribute('data-statut');

            fetch('includes/update_commande_statut.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id_commande: idCommande,
                    statut: statutCible
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const carte = document.getElementById(`carte-${idCommande}`);
                    if (carte) {
                        carte.remove();
                    }

                    const cartesRestantes = document.querySelectorAll('#conteneur-grille-livraison .carte-profil');
                    if (cartesRestantes.length === 0 && grille) {
                        grille.insertAdjacentHTML('beforebegin', `
                            <section class="carte-profil pleine-largeur" id="bloc-livraison-vide">
                                <p class="message-vide-livraison">Aucune livraison en cours pour le moment.</p>
                            </section>
                        `);
                        grille.remove();
                    }
                } else {
                    if (messageGlobal) {
                        messageGlobal.textContent = "Erreur : " + data.message;
                        messageGlobal.className = "message-erreur";
                        messageGlobal.classList.remove('erreur-invisible');
                    } else {
                        alert("Erreur : " + data.message);
                    }
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert("Erreur de communication avec le serveur de livraison.");
            });
        });
    });
});