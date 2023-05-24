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
    <title>Liste des matériels</title>
</head>
<body>

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

</body>
</html>
