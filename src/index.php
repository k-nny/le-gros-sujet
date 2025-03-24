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
    echo "<li class='tache'>".$row["libelle_tache"];
    echo "<form method='post'>";
    echo "<input type='hidden' name='id_tache' value='".$row["id_tache"]."'/>";
    echo "<input type='submit' name='action' value='submit'/>";
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