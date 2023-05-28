<a href="javascript:history.go(-1)"id="back">Retour</a> <!-- Lien pour revenir à la page précédente -->
<br>

<?php
session_start(); // Démarrage de la session

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['ID_role'])) {
    header("Location: SAE203.php"); // Redirection vers la page de connexion
    exit();
}

// Vérifier si l'ID de réservation est spécifié dans l'URL
if (!isset($_GET['id'])) {
    header("Location: SAE203.php"); // Redirection vers la page principale si l'ID de réservation n'est pas spécifié
    exit();
}

// Récupérer l'ID de réservation depuis l'URL
$id_reservation = $_GET['id'];

// Connexion à la base de données
try {
    $bdd = new PDO(
        'mysql:host=localhost;dbname=location_materiel;charset=utf8',
        'root'
    );
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die(print_r($e));
}

// Récupérer les détails de la réservation en cours d'approbation
$query = "SELECT * FROM reserve WHERE ID_reservation = :id_reservation";
$stmt = $bdd->prepare($query);
$stmt->bindParam(':id_reservation', $id_reservation, PDO::PARAM_INT);
$stmt->execute();
$reservation = $stmt->fetch(PDO::FETCH_ASSOC);


// Vérifier le rôle de l'utilisateur
$role = $_SESSION['ID_role'];

// Vérifier si l'utilisateur est un administrateur
if ($role != '2') {
    header("Location: SAE203.php"); // Redirection vers la page principale si l'utilisateur n'est pas un administrateur
    exit();
}

// Vérification des conflits de dates
if ($role === '2' && $reservation['statut'] === 'en attente') {
    $query = "SELECT ID_reservation FROM reserve WHERE ID_materiel = :id_materiel AND statut = 'acceptée' AND (dateDebut BETWEEN :dateDebut AND :dateFin OR dateFin BETWEEN :dateDebut AND :dateFin)";
    $stmt = $bdd->prepare($query);
    $stmt->bindParam(':id_materiel', $reservation['ID_materiel'], PDO::PARAM_INT);
    $stmt->bindParam(':dateDebut', $reservation['dateDebut']);
    $stmt->bindParam(':dateFin', $reservation['dateFin']);
    $stmt->execute();
    $conflictingReservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($conflictingReservations)) {
        // Il y a un conflit de dates, afficher un message d'erreur et bloquer l'approbation de la demande
        echo "Il y a un conflit de dates avec d'autres demandes déjà acceptées.";
        // Vous pouvez ajouter ici d'autres actions à effectuer en cas de conflit
        
        exit();
    }
}
?>
