<?php
session_start(); // Démarrage de la session

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
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="Styles/.css" />

  <title>Ajout de nouveau matériel</title>
</head>
<body>

  <h1>Ajout de nouveau matériel</h1>
  
  <form action="traitement_materiel.php" method="POST">
    <label for="nom">Nom :</label>
    <input type="text" id="nom" name="nom" required autocomplete="on">
    <br>

    <label for="type">Type :</label>
    <select id="type" name="type" required>
      <option value="">Sélectionner un type</option>
      <option value="audio">Audio</option>
      <option value="video">Video</option>
    </select>
    <br>

    <label for="reference">Référence :</label>
    <input type="text" id="reference" name="reference" required autocomplete="off">
    <br>

    <label for="description">Description :</label>
    <textarea id="description" name="description" required autocomplete="off"></textarea>
    <br>

    <input type="submit" value="Ajouter">
  </form>
  <a href="javascript:history.go(-1)">Retour</a> <!-- Lien pour revenir à la page précédente -->

</body>
</html>
