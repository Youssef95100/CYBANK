document.addEventListener('DOMContentLoaded', () => {
    const filtreCategorie = document.getElementById('filtre-categorie');
    const triPlats = document.getElementById('tri-plats');
    const grille = document.getElementById('grille-produits');

    let platsActuels = [];

    function afficherPlats() {
        grille.innerHTML = '';

        if (platsActuels.length === 0) {
            grille.innerHTML = '<p class="cellule-vide">Aucun produit trouvé pour cette catégorie.</p>';
            return;
        }

        platsActuels.forEach(plat => {
            const article = document.createElement('article');
            article.className = 'carte-pizza';

            let imgSrc = 'https://img.cuisineaz.com/800x450/2013/12/20/i92032-pizza-savoyarde.jpeg';
            if (plat.categorie === 'Boisson') imgSrc = 'https://www.destinationcocktails.fr/wp-content/uploads/2019/11/Cocktail-virgin-mojito.jpg';
            if (plat.categorie === 'Dessert') imgSrc = 'https://assets.afcdn.com/recipe/20210519/120536_w1024h1024c1cx1060cy707.webp';

            let htmlContent = `
                <img src="${imgSrc}" alt="${plat.nom}" class="img-pizza">
                <h3>${plat.nom}</h3>
                <p class="ingredients">${plat.ingredients}</p>
                <div class="pied-carte">
                    <span class="prix">${parseFloat(plat.prix).toFixed(2)} €</span>
            `;

            if (typeof estClient !== 'undefined' && estClient) {
                htmlContent += `
                    <form action="presentation.php" method="POST" class="form-ajout-panier">
                        <input type="hidden" name="action" value="ajouter">
                        <input type="hidden" name="id_article" value="${plat.id}">
                        <input type="hidden" name="nom_article" value="${plat.nom}">
                        <input type="hidden" name="prix_article" value="${plat.prix}">
                        <input type="number" name="quantite" value="1" min="1" max="10" class="input-quantite">
                        <button type="submit" class="btn-ajouter">Ajouter</button>
                    </form>
                `;
            }

            htmlContent += `</div>`;
            article.innerHTML = htmlContent;
            grille.appendChild(article);
        });
    }

    function trierPlats() {
        const tri = triPlats.value;
        if (tri === 'prix_asc') {
            platsActuels.sort((a, b) => parseFloat(a.prix) - parseFloat(b.prix));
        } else if (tri === 'prix_desc') {
            platsActuels.sort((a, b) => parseFloat(b.prix) - parseFloat(a.prix));
        } else if (tri === 'nom_asc') {
            platsActuels.sort((a, b) => a.nom.localeCompare(b.nom));
        } else {
            platsActuels.sort((a, b) => a.id.localeCompare(b.id));
        }
        afficherPlats();
    }

    function chargerPlats() {
        const categorie = filtreCategorie.value;
        
        fetch(`includes/filtre_plats.php?categorie=${encodeURIComponent(categorie)}`)
            .then(response => response.json())
            .then(data => {
                platsActuels = data;
                trierPlats(); 
            })
            .catch(error => {
                console.error('Erreur:', error);
                grille.innerHTML = '<p class="message-erreur">Erreur lors du chargement de la carte.</p>';
            });
    }

    filtreCategorie.addEventListener('change', chargerPlats);
    triPlats.addEventListener('change', trierPlats);

    chargerPlats();
});