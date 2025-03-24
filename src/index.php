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
echo "<table>";
while ($row = $result->fetch((PDO::FETCH_ASSOC))) {
    echo "<tr>";
    echo "<td>".$row["libelle_tache"]."</td>";
    echo "<td>";
    echo "<form method='post' action='coche.php'>";
    echo "<input type='hidden' name='idgame' value='".$row["idgame"]."'/>";
    echo "<input type='submit' name='action' value=''/>";
    echo "</form>";
    echo "</td>";

    echo "</tr>";
}
echo "</table>";

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

