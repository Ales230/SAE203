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

// Vérifier si la réservation en cours d'approbation entre en conflit avec une réservation existante
$query = "SELECT * FROM reserve WHERE ID_materiel = :id_materiel AND ID_reservation <> :id_reservation 
          AND (dateDebut <= :dateFin AND dateFin >= :dateDebut)
          AND (statut = 'acceptée' OR statut = 'en attente')";
$stmt = $bdd->prepare($query);
$stmt->bindParam(':id_materiel', $reservation['ID_materiel'], PDO::PARAM_INT);
$stmt->bindParam(':id_reservation', $id_reservation, PDO::PARAM_INT);
$stmt->bindParam(':dateDebut', $reservation['dateDebut'], PDO::PARAM_STR);
$stmt->bindParam(':dateFin', $reservation['dateFin'], PDO::PARAM_STR);

$stmt->execute();
$conflictingReservation = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifier s'il y a un conflit de dates avec une réservation existante
if ($conflictingReservation) {
    // Informer l'utilisateur du conflit de dates
    echo "La demande de réservation entre en conflit avec une autre réservation existante.";
    // Vous pouvez ajouter ici d'autres actions à effectuer en cas de conflit de dates
} else {
    // Mettre à jour le statut de la réservation
    $query = "UPDATE reserve SET statut = 'acceptée' WHERE ID_reservation = :id_reservation";
    $stmt = $bdd->prepare($query);
    $stmt->bindParam(':id_reservation', $id_reservation, PDO::PARAM_INT);
    $stmt->execute();
    
    // Redirection vers la page de liste des réservations
    header("Location: reservation_liste.php?id=$id_reservation");
    exit();
}
?>
