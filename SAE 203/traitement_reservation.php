<?php
session_start(); // Démarrage de la session

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

// Vérifier le rôle de l'utilisateur
$ID_role = isset($_SESSION['ID_role']) ? $_SESSION['ID_role'] : 1 or 2;

// Récupérer les données du formulaire
$ID_materiel = $_POST['ID_materiel'];
$dateDebut = $_POST['dateDebut'];
$dateFin = $_POST['dateFin'];

// Valider les données
if (empty($ID_materiel) || empty($dateDebut) || empty($dateFin)) {
    // Afficher un message d'erreur et rediriger vers le formulaire
    echo "Veuillez remplir tous les champs du formulaire.";
    header("Location: reservation.php");
    exit();
}

// Vérifier la disponibilité du matériel aux dates spécifiées
$query = "SELECT * FROM reservations WHERE ID_materiel = :ID_materiel
          AND ((dateDebut <= :dateDebut AND dateFin >= :dateDebut)
          OR (dateDebut <= :dateFin AND dateFin >= :dateFin))";
$stmt = $bdd->prepare($query);
$stmt->bindParam(':ID_materiel', $ID_materiel);
$stmt->bindParam(':dateDebut', $dateDebut);
$stmt->bindParam(':dateFin', $dateFin);
$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($reservations) > 0) {
    // Afficher un message d'erreur et rediriger vers le formulaire
    echo "Le matériel est déjà réservé aux dates spécifiées.";
    header("Location: reservation.php");
    exit();
}

// Enregistrer la demande de réservation
$query = "INSERT INTO reservations (ID_materiel, dateDebut, dateFin) 
          VALUES (:ID_materiel, :dateDebut, :dateFin)";
$stmt = $bdd->prepare($query);
$stmt->bindParam(':ID_materiel', $IDmateriel);
$stmt->bindParam(':dateDebut', $dateDebut);
$stmt->bindParam(':dateFin', $dateFin);
$stmt->execute();

// Afficher un message de succès
echo "La demande de réservation a été enregistrée avec succès.";

// Rediriger l'utilisateur vers la liste des réservations appropriée
if ($role === 'Administrateur') {
    header("Location: liste_reservations_admin.php");
} else {
    header("Location: liste_reservations_etudiant.php");
}
exit();
?>
