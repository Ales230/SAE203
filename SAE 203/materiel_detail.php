<?php
session_start(); 

if (!isset($_SESSION['ID_role'])) {
    header("Location: SAE203.php"); 
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: SAE203.php"); 
    exit();
}

$id_materiel = $_GET['id'];

try {
    $bdd = new PDO(
        'mysql:host=localhost;dbname=location_materiel;charset=utf8',
        'root'
    );
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die(print_r($e));
}

$query = "SELECT * FROM materiel WHERE ID_materiel = :id_materiel";
$stmt = $bdd->prepare($query);
$stmt->bindParam(':id_materiel', $id_materiel, PDO::PARAM_INT);
$stmt->execute();
$reservation = $stmt->fetch(PDO::FETCH_ASSOC);

$role = $_SESSION['ID_role'];

function afficherRoleNavigation($role)
{
    if ($role === '2') {
        echo 'Connecté en tant qu\'administrateur';
    } elseif ($role === '1') {
        echo 'Connecté en tant qu\'étudiant';
    }
}

$estAdministrateur = false; 
if ($role === '2') {
    $estAdministrateur = true;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Styles/reservation_detail.css" />
    <title>Détails de la réservation</title>
</head>
<body>
    <header>
        <nav>
            <img src="Ressources/logouniv.png">
            <ul>
                <li><a href="a_SAE203.php">Accueil</a></li>
                <li><a href="reservation.php">Réserver</a></li>
                <li><a id="accueil"href="liste.php">Matériel disponible</a></li>
                <?php
                // Display the "Ajouter du matériel" link only if the user is an administrator
                if ($estAdministrateur) {
                    echo '<li><a href="ajoutmateriel.php">Ajouter du matériel</a></li>';
                }
                ?>
                <li><a  href="reservation_liste.php">Mes reservations</a></li>
                <a href="deconnexion.php" class="btn btn-danger btn-lg">Déconnexion</a>
            </ul>
        </nav>
        <p class="role"><?php afficherRoleNavigation($role); ?></p>
    </header>
    <div class="container">
    <h1>Détails des matériels</h1>

    <table>
        <tr>
            <th>ID du matériel</th>
            <td><?php echo $reservation['ID_materiel']; ?></td>
        </tr>
        <tr>
            <th>Nom du matériel</th>
            <td><?php echo $reservation['nom']; ?></td>
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
            <th>description</th>
            <td><?php echo $reservation['description']; ?></td>
        </tr>
        
    </table>
    <a id="back"href="javascript:history.go(-1)">Retour</a> 

</div>
