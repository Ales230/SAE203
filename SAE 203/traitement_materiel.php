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

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $type = $_POST['type'];
    $reference = $_POST['reference'];
    $description = $_POST['description'];
    $query = "INSERT INTO materiel (ID_materiel, nom, type, reference, description) VALUES (FLOOR(RAND() * 1000000), :nom, :type, :reference, :description)";
    $stmt = $bdd->prepare($query);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':reference', $reference);
    $stmt->bindParam(':description', $description);
    if ($stmt->execute()) {
        // L'insertion a réussi
        $_SESSION['success_message'] = "Le matériel a été ajouté avec succès.";
    } else {
        // L'insertion a échoué
        $_SESSION['error_message'] = "Erreur : Impossible d'ajouter le matériel.";
    }
} else {
    // Les données sont invalides
    $_SESSION['error_message'] = "Erreur : Les données saisies sont incorrectes.";
}

// Rediriger vers la page "ajout_materiel.php"
header('Location: ajoutmateriel.php');
exit;

?>
