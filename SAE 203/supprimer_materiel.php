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
    header('Location: accueil.php');
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

        ?>

        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Supprimer le matériel</title>
        </head>
        <body>
            <h1>Supprimer le matériel</h1>

            <p>Voulez-vous vraiment supprimer le matériel suivant :</p>

            <p>Nom : <?php echo $materiel['nom']; ?></p>
            <p>Type : <?php echo $materiel['type']; ?></p>
            <p>Référence : <?php echo $materiel['reference']; ?></p>
            <p>Description : <?php echo $materiel['description']; ?></p>

            <form action="" method="POST">
                <input type="submit" name="confirm" value="Confirmer la suppression">
            </form>
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
