document.addEventListener('DOMContentLoaded', () => {
    const toggleMdpBtns = document.querySelectorAll('.toggle-mdp');
    
    toggleMdpBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const mdpInput = e.target.previousElementSibling;
            if (mdpInput.type === 'password') {
                mdpInput.type = 'text';
                e.target.textContent = 'Masquer';
            } else {
                mdpInput.type = 'password';
                e.target.textContent = 'Afficher';
            }
        });
    });

    const champsLimites = document.querySelectorAll('[maxlength]');
    
    champsLimites.forEach(champ => {
        const idCompteur = 'compteur-' + champ.id;
        const compteurElement = document.getElementById(idCompteur);
        
        if (compteurElement) {
            compteurElement.textContent = champ.value.length;
            
            champ.addEventListener('input', () => {
                compteurElement.textContent = champ.value.length;
            });
        }
    });

    const formInscription = document.getElementById('form-inscription');
    const formConnexion = document.getElementById('form-connexion');
    const erreurJs = document.getElementById('erreur-js');

    function afficherErreur(message) {
        erreurJs.textContent = message;
        erreurJs.classList.remove('erreur-invisible');
    }

    if (formInscription) {
        formInscription.addEventListener('submit', (e) => {
            erreurJs.classList.add('erreur-invisible');
            const tel = document.getElementById('telephone').value;
            const email = document.getElementById('email').value;

            const regexTel = /^(0|\+33)[1-9]([-. ]?[0-9]{2}){4}$/;
            const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!regexEmail.test(email)) {
                e.preventDefault();
                afficherErreur("L'adresse e-mail n'est pas au bon format.");
                return;
            }

            if (!regexTel.test(tel)) {
                e.preventDefault();
                afficherErreur("Le numéro de téléphone n'est pas valide.");
                return;
            }
        });
    }

    if (formConnexion) {
        formConnexion.addEventListener('submit', (e) => {
            erreurJs.classList.add('erreur-invisible');
            const email = document.getElementById('email').value;
            const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!regexEmail.test(email)) {
                e.preventDefault();
                afficherErreur("L'adresse e-mail n'est pas au bon format.");
            }
        });
    }
});