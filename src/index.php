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

    // Exemple de message reçu
    $message = $_GET['message'] ?? '';

    // Vérifiez si le message commence par "Erreur"
    if (strpos($message, 'Erreur') === 0) {
        $class = 'messageerreur';
    } else {
        $class = '';
    }

    // Affichage du message avec la classe appropriée
    if ($message) {
        echo "<p class='message $class'>" . htmlspecialchars($message) . "</p>";
    }

    try {
        $db = new PDO('pgsql:dbname=' . $_SERVER['DB_NAME'] . ';port=' . $_SERVER['DB_PORT'] . ';host=' . $_SERVER['DB_HOST'], $_SERVER['DB_USER'], $_SERVER['DB_PASS']);
        $db->query("SET search_path TO legrosprojet_dodeyk;");
        $status['DB2'] = true;

        // Fetch tasks
        $tachesrestantes = $db->query("SELECT * FROM taches where coche is false");
        $tachesrestantespourleif = $db->query("SELECT * FROM taches where coche is false");
        $tachesfinies = $db->query("SELECT * FROM taches where coche is true");
        $tachesfiniespourleif = $db->query("SELECT * FROM taches where coche is true");
    } catch (\Exception $e) {
        $status['DB2'] = false;
        $errors['DB2'] = $e->getMessage();
    }

    if ($tachesrestantespourleif->fetch((PDO::FETCH_ASSOC))) {
        echo "<h1>Les tâches restantes :</h1>";
    }
    echo "<ul id='taches'>";
    while ($row = $tachesrestantes->fetch((PDO::FETCH_ASSOC))) {
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
    
    if ($tachesfiniespourleif->fetch((PDO::FETCH_ASSOC))) {
        echo "<h1>Les tâches terminées :</h1>";
    }

    echo "<ul id='taches'>";
    while ($row = $tachesfinies->fetch((PDO::FETCH_ASSOC))) {
        $classe = $row['coche'] ? 'cochee' : 'pas_cochee';
        if ($classe=='cochee'){
        echo "<li class='tache $classe' id='tache-" . $row['id_tache'] . "'>";
        echo "<form method='post' class='delete-form'>";
        echo "<button type='submit' formaction='coche.php'>" . ($row['coche'] ? '✅' : '🟩') . "</button>";
        echo "<button type='button' class='delete-button'>💣</button>";
        echo "<div class='libelle'>" . htmlspecialchars($row["libelle_tache"]) . "</div>";
        echo "<input type='hidden' name='id_tache' value='" . $row["id_tache"] . "'/>";
        echo "</form>";
        echo "</li>";
    }}
    echo "</ul>";
    ?>

<script src="explosion.js"></script>
<script src="main.js" defer></script>


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
