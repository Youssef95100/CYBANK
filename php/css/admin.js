document.addEventListener('DOMContentLoaded', () => {
    const boutonsBlocage = document.querySelectorAll('.btn-action-blocage');

    boutonsBlocage.forEach(btn => {
        btn.addEventListener('click', () => {
            const userId = btn.getAttribute('data-id');
            const actionActuelle = btn.textContent.trim() === 'Bloquer' ? 'bloquer' : 'debloquer';

            fetch('includes/toggle_blocage.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: userId, action: actionActuelle })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (actionActuelle === 'bloquer') {
                        btn.textContent = 'Débloquer';
                        btn.classList.remove('btn-bloquer');
                        btn.classList.add('btn-debloquer');
                    } else {
                        btn.textContent = 'Bloquer';
                        btn.classList.remove('btn-debloquer');
                        btn.classList.add('btn-bloquer');
                    }
                } else {
                    alert('Erreur : ' + data.message);
                }
            })
            .catch(error => console.error('Erreur:', error));
        });
    });
});
