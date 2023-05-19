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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $type = $_POST['type'];
    $reference = $_POST['reference'];
    $description = $_POST['description'];

    // Validation des données (exemple : vérification si les champs ne sont pas vides)
    if (empty($nom) || empty($type) || empty($reference) || empty($description)) {
        // Affichage d'un message d'erreur
        echo "Veuillez remplir tous les champs obligatoires.";
    } else {
        // Insertion du nouveau matériel dans la base de données
        $insertion = $bdd->prepare('INSERT INTO materiel (ID_materiel, nom, type, reference, description) VALUES (FLOOR(RAND() * 1000000), ?, ?, ?, ?)');
        $insertion->execute([$nom, $type, $reference, $description]);

    }
}

?>
