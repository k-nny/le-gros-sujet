<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <?php
    require "../vendor/autoload.php";

    // Load environment variables
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();

    $status = [];
    $errors = [];

    // Display message from URL
    if (isset($_GET['message'])) {
        echo "<p class='message'>" . htmlspecialchars($_GET['message']) . "</p>";
    }

    try {
        $db = new PDO('pgsql:dbname=' . $_SERVER['DB_NAME'] . ';port=' . $_SERVER['DB_PORT'] . ';host=' . $_SERVER['DB_HOST'], $_SERVER['DB_USER'], $_SERVER['DB_PASS']);
        $db->query("SET search_path TO legrosprojet_dodeyk;");
        $status['DB2'] = true;

        // Fetch tasks
        $result = $db->query("SELECT * FROM taches");
    } catch (\Exception $e) {
        $status['DB2'] = false;
        $errors['DB2'] = $e->getMessage();
    }
    ?>

    <h1>Les tâches</h1>
    <?php
    echo "<ul id='taches'>";
    while ($row = $result->fetch((PDO::FETCH_ASSOC))) {
        $classe = $row['coche'] ? 'cochee' : 'pas_cochee';
        echo "<li class='tache $classe' id='tache-" . $row['id_tache'] . "'>";
        echo "<form method='post' class='delete-form'>";
        echo "<button type='submit' formaction='coche.php'>" . ($row['coche'] ? '✅' : '🟩') . "</button>";
        echo "<button type='button' class='delete-button'>💣</button>";
        echo "<div class='libelle'>" . htmlspecialchars($row["libelle_tache"]) . "</div>";
        echo "<input type='hidden' name='id_tache' value='" . $row["id_tache"] . "'/>";
        echo "</form>";
        echo "</li>";
    }
    echo "</ul>";
    ?>

<script>
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
</script>


    <section>
        <h2>Ajouter une tâche</h2>
        <form method="post" action="add.php">
            <div>
                <label>Description de la tâche :</label>
                <input type="text" name="libelle">
            </div>
            <div>
                <label></label>
                <input type="submit" name="option" value="Ajouter">
                <?php
                if (isset($_SESSION["error"]))
                    echo "<p class='error'>" . htmlspecialchars($_SESSION["error"]) . "</p>";
                ?>
            </div>
        </form>
    </section>
</body>
</html>
