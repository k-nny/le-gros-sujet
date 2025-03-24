<?php
session_start();

$db = new PDO('pgsql:dbname=' . $_SERVER['DB_NAME'] . ';port=' . $_SERVER['DB_PORT'] . ';host=' . $_SERVER['DB_HOST'], $_SERVER['DB_USER'], $_SERVER['DB_PASS']);
$db->query("SET search_path TO legrosprojet_dodeyk;");

try {
    // Requête SQL avec des paramètres préparés
    $query = "SELECT * FROM tache WHERE libelle_tache = :value";
    $statement = $pdo->prepare($query);

    // Associer un paramètre avec une valeur
    $valueToEscape = "example_value";
    $statement->bindParam(':value', $valueToEscape, PDO::PARAM_STR);

    // Exécuter la requête
    $statement->execute();

    // Récupérer les résultats avec PDO::FETCH_ASSOC
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Afficher les résultats
    foreach ($results as $row) {
        print_r($row);
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$libelle_tache = pg_escape_string($_POST["libelle_tache"]);

//TEST DE Validité des données --> si champ vide, ne rien insérer
if (empty($libelle_tache)){
    $_SESSION["error"]="Champs obligatoires !";
} else{
    pg_query("insert into game(libelle_tache)
            values('$libelle_tache')");
    unset($_SESSION["error"]);
}
header("Location: .");