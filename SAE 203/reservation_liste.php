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
    $query = $query = "SELECT reserve.ID_reservation, utilisateur.nom AS nom_utilisateur, materiel.nom AS nom_materiel, reserve.dateDebut, reserve.dateFin, reserve.statut FROM reserve JOIN utilisateur ON reserve.ID_utilisateur = utilisateur.ID_utilisateur JOIN materiel ON reserve.ID_materiel = materiel.ID_materiel WHERE reserve.statut IN ('en attente', 'acceptée', 'rejetée')";
    ;
} else {
    $id_utilisateur = $_SESSION['ID_utilisateur'];
    $query = "SELECT reserve.ID_reservation, utilisateur.nom AS nom_utilisateur, materiel.nom AS nom_materiel, reserve.dateDebut, reserve.dateFin, reserve.statut FROM reserve JOIN utilisateur ON reserve.ID_utilisateur = utilisateur.ID_utilisateur JOIN materiel ON reserve.ID_materiel = materiel.ID_materiel WHERE reserve.ID_utilisateur = :id_utilisateur";
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
          <?php
          // Afficher le lien "Ajouter du matériel" uniquement si l'utilisateur est un administrateur
          if ($estAdministrateur) {
              echo '<li><a href="ajoutmateriel.php">Ajouter du matériel</a></li>';
          }
          ?>
          <li><a id="accueil" href="reservation_liste.php">Mes reservations</a></li>
          <a href="deconnexion.php" class="btn btn-danger btn-lg">Déconnexion</a>
        </ul>
      </nav>
      <p class="role"><?php afficherRoleNavigation($role); ?></p>
    </header>
    <div id="div_tab">
    
    
    <?php
          // Afficher le lien "Ajouter du matériel" uniquement si l'utilisateur est un administrateur
          if ($estAdministrateur) {
              echo '<h1>Liste des réservations en attente</h1>';
          }
          ?>
    <?php if ($_SESSION['ID_role'] === '2') { ?>
        
        <table>
            <thead>
                <tr>
                    <th>Nom de l'utilisateur</th>
                    <th>Nom du matériel</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Statut</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation) { ?>
                    <?php if ($reservation['statut'] === 'en attente') { ?>
                        <tr>
                            <td><?php echo $reservation['nom_utilisateur']; ?></td>
                            <td><?php echo $reservation['nom_materiel']; ?></td>
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

        <h1>Liste de mes réservations</h1>
        
        <table>
            <thead>
                <tr>
                    <th>Nom de l'utilisateur</th>
                    <th>Nom du matériel</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Statut</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation) { ?>
                    <?php if ($reservation['statut'] !== 'en attente') { ?>
                        <tr>
                            <td><?php echo $reservation['nom_utilisateur']; ?></td>
                            <td><?php echo $reservation['nom_materiel']; ?></td>
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
                    <th>Nom du matériel</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Statut</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation) { ?>
                    <tr>
                        <td><?php echo $reservation['nom_materiel']; ?></td>
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

    <a id="back"href="javascript:history.go(-1)">Retour</a> 
    <footer>
      <p>Université Gustave Eiffel - Emprunt de matériel audiovisuel - Tous droits réservés</p>
    </footer>
</body>
</html>