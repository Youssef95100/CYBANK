document.addEventListener('DOMContentLoaded', () => {
    const boutonsModifier = document.querySelectorAll('.btn-modifier');
    const btnSauvegarder = document.getElementById('btn-sauvegarder');
    const messageRetour = document.getElementById('message-retour');
    let donneesModifiees = {};

    boutonsModifier.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const li = e.target.closest('li');
            const spanValeur = li.querySelector('.info-valeur');
            
            if (spanValeur.querySelector('input')) return;

            const valeurActuelle = spanValeur.textContent.trim();
            const champ = spanValeur.getAttribute('data-champ');

            spanValeur.innerHTML = '';
            const input = document.createElement('input');
            input.type = 'text';
            input.value = valeurActuelle;
            input.className = 'input-edition-profil';
            
            input.addEventListener('input', () => {
                donneesModifiees[champ] = input.value;
                btnSauvegarder.classList.remove('erreur-invisible');
            });

            spanValeur.appendChild(input);
            input.focus();
        });
    });

    if (btnSauvegarder) {
        btnSauvegarder.addEventListener('click', () => {
            fetch('includes/update_profil.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(donneesModifiees)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    messageRetour.textContent = "Vos informations ont bien été mises à jour !";
                    messageRetour.className = "message-succes";
                    messageRetour.classList.remove('erreur-invisible');
                    btnSauvegarder.classList.add('erreur-invisible');
                    
                    document.querySelectorAll('.info-valeur input').forEach(input => {
                        input.parentElement.textContent = input.value;
                    });
                    donneesModifiees = {};
                } else {
                    messageRetour.textContent = "Erreur : " + data.message;
                    messageRetour.className = "message-erreur";
                    messageRetour.classList.remove('erreur-invisible');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
        });
    }
});