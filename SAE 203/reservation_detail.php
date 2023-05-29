<?php
session_start(); // Démarrage de la session

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['ID_role'])) {
    header("Location: SAE203.php"); // Redirection vers la page de connexion
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

// Récupérer les détails de la réservation
$query = $query = $query = $query = "SELECT reserve.ID_reservation, reserve.ID_utilisateur, reserve.ID_materiel, utilisateur.nom AS nom, materiel.nom AS nom_materiel, materiel.reference, materiel.type, materiel.description, reserve.dateDebut, reserve.dateFin, reserve.statut FROM reserve JOIN utilisateur ON reserve.ID_utilisateur = utilisateur.ID_utilisateur JOIN materiel ON reserve.ID_materiel = materiel.ID_materiel WHERE ID_reservation = :id_reservation";
$stmt = $bdd->prepare($query);
$stmt->bindParam(':id_reservation', $id_reservation, PDO::PARAM_INT);
$stmt->execute();
$reservation = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifier si la réservation existe
if (!$reservation) {
    header("Location: reservation_liste.php"); // Redirection vers la page principale si la réservation n'existe pas
    exit();
}

// Vérifier le rôle de l'utilisateur
$role = $_SESSION['ID_role'];
function afficherRoleNavigation($role)
{
    if ($role === '2') {
        echo 'Connecté en tant que administrateur';
    } elseif ($role === '1') {
      echo 'Connecté en tant que étudiant';
        // Ajoutez ici d'autres éléments spécifiques aux étudiants si nécessaire
    }
}
// Récupérer le rôle de l'utilisateur
$role = $_SESSION['ID_role'];

$estAdministrateur = false; // Par défaut, l'utilisateur n'est pas administrateur
if ($role === '2') {
    $estAdministrateur = true;
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/reservation_detail.css"/>
    <title>Détails de la réservation</title>
</head>
<body>
<header>
      <nav>
        <img src = "Ressources/logouniv.png">
        <ul>
          <li><a href="a_SAE203.php">Accueil</a></li>
          <li><a href="reservation.php">Réserver</a></li>
          <li><a href="liste.php">Matériel disponible</a></li>
          <?php
          // Afficher le lien "Ajouter du matériel" uniquement si l'utilisateur est un administrateur
          if ($estAdministrateur) {
              echo '<li><a href="ajoutmateriel.php">Ajouter du matériel</a></li>';
          }
          ?>
          <li><a id="accueil"href="reservation_liste.php">Mes reservations</a></li>
          <a href="deconnexion.php" class="btn btn-danger btn-lg">Déconnexion</a>
        </ul>
      </nav>
      <p class="role"><?php afficherRoleNavigation($role); ?></p>
    </header>
    <div class="container">
    <h1>Détails de la réservation</h1>

    <table>
        <tr>
            <th>ID de réservation</th>
            <td><?php echo $reservation['ID_reservation']; ?></td>
        </tr>
        <tr>
            <th>ID de l'utilisateur</th>
            <td><?php echo $reservation['ID_utilisateur']; ?></td>
        </tr>
        <tr>
            <th>Nom de l'utilisateur</th>
            <td><?php echo $reservation['nom']; ?></td>
        </tr>
        <tr>
            <th>ID du matériel</th>
            <td><?php echo $reservation['ID_materiel']; ?></td>
        </tr>
        <tr>
            <th>Nom du matériel</th>
            <td><?php echo $reservation['nom_materiel']; ?></td>
        </tr>
        <tr>
            <th>Référence</th>
            <td><?php echo $reservation['reference']; ?></td>
        </tr>
        <tr>
            <th>Type</th>
            <td><?php echo $reservation['type']; ?></td>
        </tr>
        <tr>
            <th>Description</th>
            <td><?php echo $reservation['description']; ?></td>
        </tr>
        <tr>
            <th>Date de début</th>
            <td><?php echo $reservation['dateDebut']; ?></td>
        </tr>
        <tr>
            <th>Date de fin</th>
            <td><?php echo $reservation['dateFin']; ?></td>
        </tr>
        <tr>
            <th>Statut</th>
            <td><?php echo $reservation['statut']; ?></td>
        </tr>
    </table>
</div>
<div>
    <?php if ($role == '2') { // Afficher les actions pour l'administrateur ?>
        <?php if ($reservation['statut'] == 'en attente') { ?>
            <a id="accepter"href="reservation_accepte.php?id=<?php echo $reservation['ID_reservation']; ?>">Accepter</a>
            <a id="rejeter"href="reservation_rejete.php?id=<?php echo $reservation['ID_reservation']; ?>">Rejeter</a>
        <?php } ?>
    <?php } else { // Afficher le statut pour l'utilisateur ?>
        <p id="statut">Statut de la demande : <?php echo $reservation['statut']; ?></p>
    <?php } ?>
    </div>
    <a href="javascript:history.go(-1)"id="back">Retour</a> <!-- Lien pour revenir à la page précédente -->
    <footer>
      <p>Université Gustave Eiffel - Emprunt de matériel audiovisuel - Tous droits réservés</p>
    </footer>
</body>
</html>

