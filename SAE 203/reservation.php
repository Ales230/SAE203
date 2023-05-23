<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Demande de réservation</title>
</head>
<body>
  <h1>Demande de réservation</h1>
  
  <form action="traitement_reservation.php" method="POST">
    <label for="materiel">Matériel :</label>
    <select id="materiel" name="materiel" required>
      <option value="">Sélectionner un matériel</option>
      <?php
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

      // Récupérer les matériels depuis la base de données
      $query = "SELECT * FROM materiel";
      $result = $bdd->query($query);
      $materiels = $result->fetchAll(PDO::FETCH_ASSOC);

      foreach ($materiels as $materiel) {
          echo "<option value='" . $materiel['id'] . "'>" . $materiel['nom'] . "</option>";
      }
      ?>
    </select>
    <br>

    <label for="date_debut">Date de début :</label>
    <input type="date" id="date_debut" name="date_debut" required>
    <br>

    <label for="date_fin">Date de fin :</label>
    <input type="date" id="date_fin" name="date_fin" required>
    <br>

    <input type="submit" value="Demander la réservation">
  </form>
</body>
</html>
