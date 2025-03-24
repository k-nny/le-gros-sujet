 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
 </head>
 <body>
    
 </body>
 </html>

 <?php
require "../vendor/autoload.php";

// Chargement des variables d'environnement (.env)
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


$status = [];
$errors = [];


try {
    $db = new PDO('pgsql:dbname=' . $_SERVER['DB_NAME'] . ';port=' . $_SERVER['DB_PORT'] . ';host=' . $_SERVER['DB_HOST'], $_SERVER['DB_USER'], $_SERVER['DB_PASS']);
    $db->query("SET search_path TO legrosprojet_dodeyk;"); // SCHEMA
    $status['DB2'] = TRUE;
}
catch (\Exception $e) {
    $status['DB2'] = FALSE;
    $errors['DB2'] = $e->getMessage();
}

// REQUETE (interessant)
$result = $db->query("select * from taches");

// TRAITEMENT DES RESULTATS (boucle)
echo "<ul id='taches'>";
while ($row = $result->fetch((PDO::FETCH_ASSOC))) {
    echo "<li class='tache'>";
    echo "<form method='post' action='/'>";
    echo "<button type='submit'><div>❎</div></button>";
    echo "<div>".$row["libelle_tache"]."</div>";
    echo "<input type='hidden' name='id_tache' value='".$row["id_tache"]."'/>";
    echo "</form>";
    echo "</li>";
}

echo "</ul>";

echo "<ul>";

foreach ($status as $key => $statu) {
    echo "<li>$key : " . ($statu ? '🟩' : '🟥') . '</li>';
}
echo "</ul>";

if(count($errors)) {
    echo "<h1>Tu veux du log d'erreur ?</h1>";
    echo "<ul>";
    foreach ($errors as $key => $error) {
        echo "<li>$key : $error";
    }
    echo "</ul>";
}
?>
    </section>
    <section>
        <h2>Ajouter un jeu</h2>
        <form method="post" action="add.php">
            <div>
                <label>Description de la tâche</label>
                <input type="text"name="libelle">
            </div>
            <div>
                <label></label>
                <input type="submit"name="option" value="Ajouter">
                <?php
                    if (isset($_SESSION["error"]))
                        echo "<p class='error'>".$_SESSION["error"]."</p>";
                ?>
            </div>
        </form>
    </section>