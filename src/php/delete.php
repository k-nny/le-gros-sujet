<?php
require "../../vendor/autoload.php";

// Chargement des variables d'environnement (.env)
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

try {
    // Connexion à la base de données PostgreSQL
    $db = new PDO('pgsql:dbname=' . $_SERVER['DB_NAME'] . ';port=' . $_SERVER['DB_PORT'] . ';host=' . $_SERVER['DB_HOST'], $_SERVER['DB_USER'], $_SERVER['DB_PASS']);
    $db->query("SET search_path TO legrosprojet_dodeyk;"); // Schéma spécifique (modifiez si nécessaire)

    // Vérification de la requête POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_tache'])) {
        $id_tache = $_POST['id_tache']; // Récupérer l'identifiant envoyé

        // Suppression de la ligne avec cet ID
        $query = "DELETE FROM taches WHERE id_tache = :id_tache";
        $statement = $db->prepare($query);
        $statement->bindParam(':id_tache', $id_tache, PDO::PARAM_INT);
        $statement->execute();

        // Redirection après la suppression
        header("Location: ../index.php?message=Tâche supprimée avec succès");
        exit();
    } else {
        // Si aucune donnée n'est envoyée ou ID manquant
        header("Location: ../index.php?message=Erreur : ID de la tâche manquant");
        exit();
    }
} catch (Exception $e) {
    // Gérer les erreurs
    header("Location: ../index.php?message=Erreur lors de la suppression : " . $e->getMessage());
    exit();
}
