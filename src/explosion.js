document.querySelectorAll('.delete-button').forEach(button => {
    button.addEventListener('click', function() {
        const taskItem = this.closest('li'); // Trouver l'élément de la tâche
        const form = this.closest('.delete-form');

        // Positionner le parent de manière relative (nécessaire pour absolute)
        taskItem.style.position = 'relative';

        // Créer un élément pour l'explosion
        const explosion = document.createElement('img');
        explosion.src = 'https://media.tenor.com/NJqk_2_eQ40AAAAi/explosion-gif-transparent.gif';
        explosion.classList.add('explosion-gif');
        taskItem.appendChild(explosion);

         // Jouer le son d'explosion
         const explosionSound = new Audio('explosion.mp3'); // Assurez-vous que ce fichier existe dans votre répertoire
        explosionSound.play();

        // Soumettre le formulaire après l'explosion
        setTimeout(() => {
            form.setAttribute('action', 'delete.php'); // Définit l'action du formulaire
            form.submit(); // Soumet le formulaire
        }, 600); // Durée de l'animation (0.6s)
    });
});