<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ajout de nouveau matériel</title>
</head>
<body>
  <h1>Ajout de nouveau matériel</h1>
  
  <form action="traitement_materiel.php" method="POST">
    <label for="nom">Nom :</label>
    <input type="text" id="nom" name="nom" required>
    <br>

    <label for="type">Type :</label>
    <select id="type" name="type" required>
      <option value="">Sélectionner un type</option>
      <option value="type1">Audio</option>
      <option value="type2">Video</option>
    </select>
    <br>

    <label for="reference">Référence :</label>
    <input type="text" id="reference" name="reference" required>
    <br>

    <label for="description">Description :</label>
    <textarea id="description" name="description" required></textarea>
    <br>

    <input type="submit" value="Ajouter">
  </form>
</body>
</html>
