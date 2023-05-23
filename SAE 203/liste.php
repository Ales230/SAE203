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
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'Etudiant';

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
            <?php if ($role === 'admin') { ?>
                <th>Actions</th>
            <?php } ?>
            <?php foreach ($matériels as $matériel) { ?>
    <tr>
        <td>
                <?php echo $matériel['nom']; ?>
            </a>
        </td>
        <td><?php echo $matériel['type']; ?></td>
        <td><?php echo $matériel['reference']; ?></td>
        <td><?php echo $matériel['description']; ?></td>
        <?php if ($role === 'admin') { ?>
            <td>
                <!-- Liens pour la modification et la suppression du matériel -->
                <a href="modifier_materiel.php?id=<?php echo $matériel['id']; ?>">Modifier</a>
                <a href="supprimer_materiel.php?id=<?php echo $matériel['id']; ?>">Supprimer</a>
            </td>
        <?php } ?>
    </tr>
<?php } ?>
    </table>
</body>
</html>
