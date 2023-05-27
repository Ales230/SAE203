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

// Vérifier si l'utilisateur a le rôle d'administrateur
if ($_SESSION['ID_role'] !== '2') {
    // Rediriger l'utilisateur vers une autre page s'il n'a pas le rôle d'administrateur
    header('Location: SAE203.php');
    exit();
}

// Vérifier si l'identifiant du matériel est spécifié dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Récupérer les informations du matériel depuis la base de données avec l'identifiant spécifié
    $query = "SELECT * FROM materiel WHERE ID_materiel = :id";
    $statement = $bdd->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $materiel = $statement->fetch(PDO::FETCH_ASSOC);

    // Vérifier si le matériel existe
    if ($materiel) {
        // Vérifier si le formulaire de confirmation de suppression a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
            // Supprimer le matériel de la base de données
            $query = "DELETE FROM materiel WHERE ID_materiel = :id";
            $statement = $bdd->prepare($query);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();

            // Rediriger l'utilisateur vers la page de liste des matériels après la suppression
            header('Location: liste.php');
            exit();
        }
// Récupérer le rôle de l'utilisateur
$role = $_SESSION['ID_role'];

$estAdministrateur = false; // Par défaut, l'utilisateur n'est pas administrateur
if ($role === '2') {
    $estAdministrateur = true;
}
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
            <link rel="stylesheet" type="text/css" href="styles/supprimer_materiel.css">
            <title>Supprimer le matériel</title>
        </head>
        <body>
        <header>
            
<nav>
<img src = "Ressources/logouniv.png">
<ul>
          <li><a href="a_SAE203.php">Accueil</a></li>
          <li><a href="reservation.php">Réserver</a></li>
          <li><a id="liste" href="liste.php">Matériel disponible</a></li>
          <?php
          // Afficher le lien "Ajouter du matériel" uniquement si l'utilisateur est un administrateur
          if ($estAdministrateur) {
              echo '<li><a href="ajoutmateriel.php">Ajouter du matériel</a></li>';
          }
          ?>
          <li><a href="reservation_liste.php">Mes reservations</a></li>
          <a href="deconnexion.php" class="btn btn-danger btn-lg">Déconnexion</a>
        </ul>
      </nav>
      <p class="role"><?php afficherRoleNavigation($role); ?></p>
    </header>
    <div class="container">
            <h1>Supprimer le matériel</h1>
            <form action="" method="POST">
            <p>Voulez-vous vraiment supprimer le matériel suivant :</p>

            <p>Nom : <?php echo $materiel['nom']; ?></p>
            <p>Type : <?php echo $materiel['type']; ?></p>
            <p>Référence : <?php echo $materiel['reference']; ?></p>
            <p>Description : <?php echo $materiel['description']; ?></p>

            
                <input type="submit" name="confirm" value="Confirmer la suppression">
            </form>
            <a id="back"href="javascript:history.go(-1)">Retour</a> <!-- Lien pour revenir à la page précédente -->
    </div>
    <footer>
      <p>Université Gustave Eiffel - Emprunt de matériel audiovisuel - Tous droits réservés</p>
    </footer>
        </body>
        </html>

        <?php
    } else {
        // Rediriger l'utilisateur vers une autre page si le matériel n'existe pas
        header('Location: a_SAE203.php');
        exit();
    }
} else {
    // Rediriger l'utilisateur vers une autre page si l'identifiant du matériel n'est pas spécifié
    header('Location: a_SAE203.php');
    exit();
}
?>
