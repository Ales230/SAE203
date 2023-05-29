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


// Vérifier si un message de succès est disponible
if (isset($_SESSION['success_message'])) {
    echo '<p class="success-message">' . $_SESSION['success_message'] . '</p>';
    unset($_SESSION['success_message']); // Supprimer le message de succès de la session
}

// Vérifier si un message d'erreur est disponible
if (isset($_SESSION['error_message'])) {
    echo '<p class="error-message">' . $_SESSION['error_message'] . '</p>';
    unset($_SESSION['error_message']); // Supprimer le message d'erreur de la session
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
  <link rel="stylesheet" href="Styles/ajoutmateriel.css" />

  <title>Ajout de nouveau matériel</title>
</head>
<body>
  
<header>

      <nav>
        <img src = "Ressources/logouniv.png">
        <ul>
          <li><a href="a_SAE203.php">Accueil</a></li>
          <li><a href="reservation.php">Réserver</a></li>
          
          <li><a href="liste.php">Matériel disponible</a></li>
          <li><a id="ajout"href="ajoutmateriel.php">Ajouter du matériel</a></li>
          <li><a href="reservation_liste.php">Mes reservations</a></li>
          
          <a href="deconnexion.php" class="btn btn-danger btn-lg">Déconnexion</a>

        </ul>
      </nav>
      <p class="role"><?php afficherRoleNavigation($role); ?></p>
    </header>
    <div class="container">
  <h1>Formulaire d'ajout de matériel</h1>
  
  <form action="traitement_materiel.php" method="POST">
    <label for="nom">Nom :</label>
    <input type="text" id="nom" name="nom" required autocomplete="off">
    <br>

    <label for="type">Type :</label>
    <select id="type" name="type" required>
      <option value="">Sélectionner un type</option>
      <option value="audio">Audio</option>
      <option value="video">Video</option>
      <option value="video">Autre type de matériel</option>
    </select>
    <br>

    <label for="reference">Référence :</label>
    <input type="text" id="reference" name="reference" required autocomplete="off">
    <br>

    <label for="description">Description :</label>
    <textarea id="description" name="description" required autocomplete="off"></textarea>
    <br>

    <input type="submit" value="Ajouter">
    <a id="back" href="javascript:history.go(-1)">Retour</a> 
  </form>
  
</div>
  <footer>
      <p>Université Gustave Eiffel - Emprunt de matériel audiovisuel - Tous droits réservés</p>
    </footer>
</body>
</html>
