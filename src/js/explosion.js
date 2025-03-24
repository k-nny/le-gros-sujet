animations = [
    {
        gif: 'https://media.tenor.com/NJqk_2_eQ40AAAAi/explosion-gif-transparent.gif',
        sound: 'explosion.mp3'
    },
    {
        gif: 'https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/55b3eef7-e3ab-4675-9f91-3d5353a8cecd/dis0rc5-4093eb20-136a-4e7c-993f-d6366a3f4159.gif?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcLzU1YjNlZWY3LWUzYWItNDY3NS05ZjkxLTNkNTM1M2E4Y2VjZFwvZGlzMHJjNS00MDkzZWIyMC0xMzZhLTRlN2MtOTkzZi1kNjM2NmEzZjQxNTkuZ2lmIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.gLpP0uvVP2ReAVJfZR8Kz4PFubP27V72skCgYZ1ECjY',
        sound: 'laser.mp3'
    },
    {
        gif: 'https://i.pinimg.com/originals/2a/39/6e/2a396e7bfb1c6189a00a71a7c3f9ec8e.gif',
        sound: '8bit-shot.wav'
    },

]


document.querySelectorAll('.delete-button').forEach(button => {
    button.addEventListener('click', function() {
        const taskItem = this.closest('li'); // Trouver l'élément de la tâche
        const form = this.closest('.delete-form');

        // Positionner le parent de manière relative (nécessaire pour absolute)
        taskItem.style.position = 'relative';

        
        explosion(taskItem, animations)



        // Soumettre le formulaire après l'explosion
        setTimeout(() => {
            form.setAttribute('action', './php/delete.php'); // Définit l'action du formulaire
            form.submit(); // Soumet le formulaire
        }, 600); // Durée de l'animation (0.6s)
    });
});

function explosion(parent, animations){
    // Créer un élément pour l'explosion
    var random = Math.floor(Math.random() * animations.length);
    anim = animations[random];
    const explosion = document.createElement('img');
    explosion.src = anim.gif;
    explosion.classList.add('explosion-gif');
    parent.appendChild(explosion);

        // Jouer le son d'explosion
        const explosionSound = new Audio("assets/" + anim.sound); // Assurez-vous que ce fichier existe dans votre répertoire
    explosionSound.play();
}