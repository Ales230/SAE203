<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirection en cours...</title>
    <script>
        // Function to redirect after a specified time
        function redirectWithCountdown(url, seconds) {
            var countdown = document.getElementById('countdown');
            countdown.textContent = seconds; // Display initial countdown value

            // Update countdown every second
            var timer = setInterval(function() {
                seconds--;
                countdown.textContent = seconds; // Update countdown value

                // Redirect when countdown reaches 0
                if (seconds <= 0) {
                    clearInterval(timer); // Stop the countdown
                    window.location.href = url; // Redirect to the specified URL
                }
            }, 1000); // 1000 milliseconds = 1 second
        }

        // Call the redirectWithCountdown function when the page loads
        window.onload = function() {
            var redirectUrl = "reservation_detail.php"; // Change this to the actual URL of the reservation_accepte page
            var countdownSeconds = 5; // Set the countdown duration in seconds
            redirectWithCountdown(redirectUrl, countdownSeconds);
        };
    </script>
</head>
<body>
    <h1>Redirection en cours...</h1>
    <p>Vous serez redirigé vers la page "reservation_accepte" dans <span id="countdown"></span> secondes.</p>
</body>
</html>
<a href="reservation_detail.php">Retour</a>
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
    header("Location: SAE203.php"); 
    exit();
}

if ($reservation['statut'] == 'en attente') {
    $query = "SELECT ID_reservation FROM reserve WHERE ID_materiel = :id_materiel AND statut = 'acceptée' AND (dateDebut BETWEEN :dateDebut AND :dateFin OR dateFin BETWEEN :dateDebut AND :dateFin)";
    $stmt = $bdd->prepare($query);
    $stmt->bindParam(':id_materiel', $reservation['ID_materiel'], PDO::PARAM_INT);
    $stmt->bindParam(':dateDebut', $reservation['dateDebut']);
    $stmt->bindParam(':dateFin', $reservation['dateFin']);
    $stmt->execute();
    $conflictingReservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($conflictingReservations)) {
        echo "Il y a un conflit de dates avec d'autres demandes déjà acceptées.";
        exit();
    } else {
        $query = "UPDATE reserve SET statut = 'acceptée' WHERE ID_reservation = :id_reservation";
        $stmt = $bdd->prepare($query);
        $stmt->bindParam(':id_reservation', $id_reservation, PDO::PARAM_INT);
        $stmt->execute();

        // Redirection vers la page de détails de la réservation
        header("Location: reservation_liste.php?id=$id_reservation");
        exit();
    }
} else {
    // Handle the case when the reservation is not in 'en attente' status
    echo "La réservation n'est pas en attente d'approbation.";
    exit();
}
?>

