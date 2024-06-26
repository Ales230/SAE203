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

// Récupérer la liste des matériels depuis la base de données
$query = "SELECT * FROM materiel";
$result = $bdd->query($query);
$matériels = $result->fetchAll(PDO::FETCH_ASSOC);

// Validation du formulaire de réservation
$errors = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_materiel = $_POST['materiel'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $statut = $_POST['statut'];

    // Vérifier si les champs sont vides
    if (empty($id_materiel) || empty($date_debut) || empty($date_fin)) {
        $errors[] = "Tous les champs sont requis.";
    } else {
        // Vérifier si le matériel est disponible pour les dates demandées
        $query = "SELECT * FROM reserve WHERE ID_materiel = :id_materiel AND (statut = 'acceptée' ) AND (:date_debut BETWEEN dateDebut AND dateFin OR :date_fin BETWEEN dateDebut AND dateFin)";
        $stmt = $bdd->prepare($query);
        $stmt->execute(array(
            'id_materiel' => $id_materiel,
            'date_debut' => $date_debut,
            'date_fin' => $date_fin
        ));
        $reservation_exists = $stmt->rowCount() > 0;

        if ($reservation_exists) {
            $errors[] = "Ce matériel est déjà réservé pour les dates sélectionnées.";
        } else {
            // Sauvegarder la demande de réservation en base de données
            $id_utilisateur = isset($_SESSION['ID_utilisateur']) ? $_SESSION['ID_utilisateur'] : null;
            $statut = ($role === '2') ? 'acceptée' : 'en attente';

            $query = "INSERT INTO reserve (ID_utilisateur, ID_materiel, dateDebut, dateFin, statut)
                      VALUES (:id_utilisateur, :id_materiel, :date_debut, :date_fin, :statut)";
            $stmt = $bdd->prepare($query);
            $stmt->execute(array(
                'id_utilisateur' => $id_utilisateur,
                'id_materiel' => $id_materiel,
                'date_debut' => $date_debut,
                'date_fin' => $date_fin,
                'statut' => $statut
            ));

            // Redirection vers la liste des réservations
            header("Location: reservation_liste.php");
            exit();
        }
    }
}

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
    <link rel="stylesheet" href="Styles/reservation.css" />
    <title>Demande de réservation</title>
</head>
<body>
<header>
    <nav>
        <img src="Ressources/logouniv.png">
        <ul>
            <li><a href="a_SAE203.php">Accueil</a></li>
            <li><a id="reserver" href="reservation.php">Réserver</a></li>
            <li><a href="liste.php">Matériel disponible</a></li>
            <?php
            // Afficher le lien "Ajouter du matériel" uniquement si l'utilisateur est un administrateur
            if ($estAdministrateur) {
                echo '<li><a href="ajoutmateriel.php">Ajouter du matériel</a></li>';
            }
            ?>
            <li><a href="reservation_liste.php">Mes réservations</a></li>
            <a href="deconnexion.php" class="btn btn-danger btn-lg">Déconnexion</a>
        </ul>
    </nav>
    <p class="role"><?php afficherRoleNavigation($role); ?></p>
</header>

<?php if (!empty($errors)) { ?>
    <div>
        <ul>
            <?php foreach ($errors as $error) { ?>
                <li><?php echo $error; ?></li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>
<div class="container">
    <form method="POST" action="">
        <h1>Demande de réservation</h1>
        <label for="materiel">Matériel :</label>
        <select id="materiel" name="materiel">
            <?php foreach ($matériels as $matériel) { ?>
                <option value="<?php echo $matériel['ID_materiel']; ?>"><?php echo $matériel['nom']; ?></option>
            <?php } ?>
        </select>
        <br>
        <label for="date_debut">Date de début :</label>
        <input type="date" id="date_debut" name="date_debut">
        <br>
        <label for="date_fin">Date de fin (inclus) :</label>
        <input type="date" id="date_fin" name="date_fin">
        <br>
        <input type="submit" value="Réserver">
    </form>
    <a id="back" href="javascript:history.go(-1)">Retour</a> 
</div>

<footer>
    <p>Université Gustave Eiffel - Emprunt de matériel audiovisuel - Tous droits réservés</p>
</footer>
</body>
</html>
