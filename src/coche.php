<?php
require "../vendor/autoload.php";

// Chargement des variables d'environnement (.env)
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

try {
    // Connexion à la base de données
    $db = new PDO('pgsql:dbname=' . $_SERVER['DB_NAME'] . ';port=' . $_SERVER['DB_PORT'] . ';host=' . $_SERVER['DB_HOST'], $_SERVER['DB_USER'], $_SERVER['DB_PASS']);
    $db->query("SET search_path TO legrosprojet_dodeyk;"); // Schéma

    // Vérifier si une tâche est sélectionnée via le formulaire
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_tache'])) {
        $id_tache = $_POST['id_tache'];

        // Récupérer l'état actuel de la colonne 'coche' pour cette tâche
        $query = "SELECT coche FROM taches WHERE id_tache = :id_tache";
        $statement = $db->prepare($query);
        $statement->bindParam(':id_tache', $id_tache, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // Inverser l'état de 'coche'
            $newCoche = !$result['coche']; // Si 'coche' est false, ça devient true, et vice versa

            // Mettre à jour la colonne 'coche' dans la base de données
            $updateQuery = "UPDATE taches SET coche = :new_coche WHERE id_tache = :id_tache";
            $updateStatement = $db->prepare($updateQuery);
            $updateStatement->bindParam(':new_coche', $newCoche, PDO::PARAM_BOOL);
            $updateStatement->bindParam(':id_tache', $id_tache, PDO::PARAM_INT);
            $updateStatement->execute();

            // Rediriger vers la page principale avec un message de succès
            header("Location: index.php");
            exit();
        } else {
            // Si la tâche n'existe pas
            header("Location: index.php");
            exit();
        }
    }
} catch (\Exception $e) {
    // En cas d'erreur
    header("Location: ./index.php?message=Erreur : " . $e->getMessage());
    exit();
}
?>
