document.addEventListener('DOMContentLoaded', () => {
    const formStatut = document.getElementById('form-statut-commande');
    const messageRetour = document.getElementById('message-retour');
    const idCommande = document.getElementById('id-commande').textContent.trim();

    if (formStatut) {
        formStatut.addEventListener('submit', (e) => {
            e.preventDefault();
            
            const nouveauStatut = document.getElementById('nouveau_statut').value;
            const selectLivreur = document.getElementById('livreur');
            const idLivreur = selectLivreur ? selectLivreur.value : '';

            fetch('includes/update_commande_statut.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id_commande: idCommande,
                    statut: nouveauStatut,
                    livreur: idLivreur
                })
            })
            .then(response => response.json())
            .then(data => {
                messageRetour.classList.remove('erreur-invisible');
                if (data.success) {
                    messageRetour.textContent = "Statut de la commande mis à jour avec succès !";
                    messageRetour.className = "message-succes";
                } else {
                    messageRetour.textContent = "Erreur : " + data.message;
                    messageRetour.className = "message-erreur";
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                messageRetour.textContent = "Erreur de communication avec le serveur.";
                messageRetour.className = "message-erreur";
                messageRetour.classList.remove('erreur-invisible');
            });
        });
    }
});