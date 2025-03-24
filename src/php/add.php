<?php
require "../../vendor/autoload.php";

// Chargement des variables d'environnement (.env)
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$status = [];
$errors = [];

try {
    // Connexion à la base de données
    $db = new PDO('pgsql:dbname=' . $_SERVER['DB_NAME'] . ';port=' . $_SERVER['DB_PORT'] . ';host=' . $_SERVER['DB_HOST'], $_SERVER['DB_USER'], $_SERVER['DB_PASS']);
    $db->query("SET search_path TO legrosprojet_dodeyk;"); // Schéma

    // Gérer la soumission du formulaire
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['option']) && $_POST['option'] === 'Ajouter') {
        $libelle = $_POST['libelle'] ?? '';

        // Validation du champ "libelle"
        if (!empty($libelle)) {
            $query = "INSERT INTO taches (libelle_tache) VALUES (:libelle)";
            $statement = $db->prepare($query);
            $statement->bindParam(':libelle', $libelle, PDO::PARAM_STR);
            $statement->execute();

            // Redirection vers la page principale avec un message de confirmation
            header("Location: ../index.php?message=Tâche ajoutée avec succès");
            exit();
        } else {
            header("Location: ../index.php?message=Erreur : le champ de la tâche est vide");
            exit();
        }
    }
} catch (\Exception $e) {
    header("Location: ../index.php?message=Erreur lors de la connexion ou de l'exécution");
    exit();
}
?>
