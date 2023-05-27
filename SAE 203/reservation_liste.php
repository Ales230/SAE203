<?php
session_start(); // Démarrage de la session

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['ID_role'])) {
    header("Location: SAE203.php"); // Redirection vers la page de connexion
    exit();
}

// Récupérer le rôle de l'utilisateur
$role = $_SESSION['ID_role'];

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

// Récupérer les réservations en fonction du rôle de l'utilisateur
if ($_SESSION['ID_role'] === '2') {
    $query = "SELECT * FROM reserve";
} else {
    $id_utilisateur = $_SESSION['ID_utilisateur'];
    $query = "SELECT * FROM reserve WHERE ID_utilisateur = :id_utilisateur";
}

$stmt = $bdd->prepare($query);

if ($_SESSION['ID_role'] !== '2') {
    $stmt->bindParam(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
}

$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
function afficherRoleNavigation($role)
{
    if ($role === '2') {
        echo 'Connecté en tant que administrateur';
    } elseif ($role === '1') {
      echo 'Connecté en tant que étudiant';
        // Ajoutez ici d'autres éléments spécifiques aux étudiants si nécessaire
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/reservation_liste.css" />
    <title>Liste des réservations</title>
</head>
<body>
<header>
      <nav>
        <img src = "ressources/logouniv.png">
        <ul>
          <li><a href="a_SAE203.php">Accueil</a></li>
          <li><a href="reservation.php">Réserver</a></li>
          <li><a href="liste.php">Matériel disponible</a></li>
          <li><a id="accueil" href="reservation_liste.php">Mes reservations</a></li>
          <a href="deconnexion.php" class="btn btn-danger btn-lg">Déconnexion</a>
        </ul>
      </nav>
      <p class="role"><?php afficherRoleNavigation($role); ?></p>
    </header>
    <div id="div_tab">
    

    <?php if ($_SESSION['ID_role'] === '2') { ?>
        <h1>Liste des réservations</h1>
        <h2>Demandes de réservation en attente</h2>
        <table>
            <thead>
                <tr>
                    <th>ID de réservation</th>
                    <th>ID de l'utilisateur</th>
                    <th>ID du matériel</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation) { ?>
                    <?php if ($reservation['statut'] === 'en attente') { ?>
                        <tr>
                            <td><?php echo $reservation['ID_reservation']; ?></td>
                            <td><?php echo $reservation['ID_utilisateur']; ?></td>
                            <td><?php echo $reservation['ID_materiel']; ?></td>
                            <td><?php echo $reservation['dateDebut']; ?></td>
                            <td><?php echo $reservation['dateFin']; ?></td>
                            <td><?php echo $reservation['statut']; ?></td>
                            <td>
                                <a href="reservation_detail.php?id=<?php echo $reservation['ID_reservation']; ?>">Détails</a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
                    </div>

        <h2>Réservations acceptées ou rejetées</h2>
        <table>
            <thead>
                <tr>
                    <th>ID de réservation</th>
                    <th>ID de l'utilisateur</th>
                    <th>ID du matériel</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation) { ?>
                    <?php if ($reservation['statut'] !== 'en attente') { ?>
                        <tr>
                            <td><?php echo $reservation['ID_reservation']; ?></td>
                            <td><?php echo $reservation['ID_utilisateur']; ?></td>
                            <td><?php echo $reservation['ID_materiel']; ?></td>
                            <td><?php echo $reservation['dateDebut']; ?></td>
                            <td><?php echo $reservation['dateFin']; ?></td>
                            <td><?php echo $reservation['statut']; ?></td>
                            <td>
                                <a href="reservation_detail.php?id=<?php echo $reservation['ID_reservation']; ?>">Détails</a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
                    
        </table>
    <?php } else { ?>
        <table>
            <thead>
                <tr>
                    <th>ID de réservation</th>
                    <th>ID du matériel</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation) { ?>
                    <tr>
                        <td><?php echo $reservation['ID_reservation']; ?></td>
                        <td><?php echo $reservation['ID_materiel']; ?></td>
                        <td><?php echo $reservation['dateDebut']; ?></td>
                        <td><?php echo $reservation['dateFin']; ?></td>
                        <td><?php echo $reservation['statut']; ?></td>
                        <td>
                            <a href="reservation_detail.php?id=<?php echo $reservation['ID_reservation']; ?>">Détails</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>

    <a id="back"href="javascript:history.go(-1)">Retour</a> <!-- Lien pour revenir à la page précédente -->
    <footer>
      <p>Université Gustave Eiffel - Emprunt de matériel audiovisuel - Tous droits réservés</p>
    </footer>
</body>
</html>
