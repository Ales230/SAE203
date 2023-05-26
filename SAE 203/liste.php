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

// Vérifier le rôle de l'utilisateur
$role = isset($_SESSION['ID_role']) ? $_SESSION['ID_role'] : 'utilisateur';

// Récupérer les matériels depuis la base de données
$query = "SELECT * FROM materiel";
$result = $bdd->query($query);
$matériels = $result->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles/liste.css">
    <title>Liste des matériels</title>
</head>
<body>
<header>
<nav>
<img src = "Ressources/logouniv.png">
<ul>
          <li><a href="a_SAE203.php">Accueil</a></li>
          <li><a id="reserver" href="reservation.php">Réserver</a></li>
          <li><a href="liste.php">Matériel disponible</a></li>
          <li><a href="reservation_liste.php">Mes reservations</a></li>
        </ul>
      </nav>
    </header>

    <h1>Liste des matériels</h1>

    <table>
        <tr>
            <th>Nom</th>
            <th>Type</th>
            <th>Référence</th>
            <th>Description</th>
            <?php if ($role === '2') { ?> <!-- Vérifier si l'utilisateur a le rôle d'administrateur -->
                <th>Actions</th>
            <?php } ?>
        </tr>
        <?php foreach ($matériels as $matériel) { ?>
            <tr>
                <td><?php echo $matériel['nom']; ?></td>
                <td><?php echo $matériel['type']; ?></td>
                <td><?php echo $matériel['reference']; ?></td>
                <td><?php echo $matériel['description']; ?></td>
                <?php if ($role === '2') { ?> <!-- Vérifier si l'utilisateur a le rôle d'administrateur -->
                    <td>
                        <!-- Liens pour la modification et la suppression du matériel -->
                        <a href="modification_materiel.php?id=<?php echo $matériel['ID_materiel']; ?>">Modifier</a>
                        <a href="supprimer_materiel.php?id=<?php echo $matériel['ID_materiel']; ?>">Supprimer</a>
                    </td>
                <?php } ?>
            </tr>
        <?php } ?>
    </table>
    <a href="javascript:history.go(-1)">Retour</a> <!-- Lien pour revenir à la page précédente -->
    <footer>
      <p>Université Gustave Eiffel - Emprunt de matériel audiovisuel - Tous droits réservés</p>
    </footer>
</body>
</html>