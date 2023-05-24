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
    header('Location: a_SAE203.php');
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
        // Vérifier si le formulaire de modification a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $nom = $_POST['nom'];
            $type = $_POST['type'];
            $reference = $_POST['reference'];
            $description = $_POST['description'];

            // Valider et traiter les données de modification du matériel
            // ...

            // Exemple de mise à jour du matériel dans la base de données
            $query = "UPDATE materiel SET nom = :nom, type = :type, reference = :reference, description = :description WHERE ID_materiel = :id";
            $statement = $bdd->prepare($query);
            $statement->bindValue(':nom', $nom, PDO::PARAM_STR);
            $statement->bindValue(':type', $type, PDO::PARAM_STR);
            $statement->bindValue(':reference', $reference, PDO::PARAM_STR);
            $statement->bindValue(':description', $description, PDO::PARAM_STR);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();

            // Rediriger l'utilisateur vers la page de liste des matériels après la modification
            header('Location: liste.php');
            exit();
        }

        ?>

<!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Modifier le matériel</title>
        </head>
        <body>
            <h1>Modifier le matériel</h1>

            <form action="" method="POST">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" value="<?php echo $materiel['nom']; ?>" required>
                <br>

                <label for="type">Type :</label>
                <select id="type" name="type" required>
                    <option value="Type 1" <?php if ($materiel['type'] === 'Type 1') echo 'selected'; ?>>Audio</option>
                    <option value="Type 2" <?php if ($materiel['type'] === 'Type 2') echo 'selected'; ?>>Video</option>
                </select>
                <br>

                <label for="reference">Référence :</label>
                <input type="text" id="reference" name="reference" value="<?php echo $materiel['reference']; ?>" required>
                <br>

                <label for="description">Description :</label>
                <textarea id="description" name="description" required><?php echo $materiel['description']; ?></textarea>
                <br>

                <input type="submit" value="Modifier">
            </form>
        </body>
        </html>


<?php
    } else {
        // Rediriger l'utilisateur vers une autre page si le matériel n'existe pas
        header('Location: accueil.php');
        exit();
    }
} else {
    // Rediriger l'utilisateur vers une autre page si l'identifiant du matériel n'est pas spécifié
    header('Location: accueil.php');
    exit();
}
?>