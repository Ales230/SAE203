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
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="styles/a_SAE203.css" />
    <title>Université Gustave Eiffel : Emprunt de matériel audiovisuel</title>
    <link rel="stylesheet" integrity="sha512-KXe4Y+xx4msPQsYm0fZJgWK+O1SbHUCRSBxTiyJXnwLu0Nkf+zcYvJ/d1N3+vq3H8WtMk33t/9gJxBzXcvL//w==" crossorigin="anonymous" referrerpolicy="no-referrer" />


  </head>
  <body>

    <header>
      <nav>
        <img src = "Ressources/logouniv.png">
        <ul>
          <li><a id="accueil"href="a_SAE203.php">Accueil</a></li>
          <li><a href="reservation.php">Réserver</a></li>
          <li><a href="liste.php">Matériel disponible</a></li>
          <li><a href="reservation_liste.php">Mes reservations</a></li>
          <a href="deconnexion.php" class="btn btn-danger btn-lg">Déconnexion</a>
        </ul>
      </nav>
    </header>
    <main>
      <section id="intro">
        <h1>Bienvenue sur le site d'emprunt de matériel audiovisuel de l'IUT de Meaux</h1>
        <p class="p_titre">
          Nous proposons à tous les étudiants, enseignants et membres du
          personnel de l'université Gustave Eiffel de réserver gratuitement du matériel
          audiovisuel pour leurs projets et activités pédagogiques.
        </p>
      </section>
      <section id="services">
        <h2>Notre stock disponible</h2>
        <ul>
        <li><i class="micro"></i><p class=tm>Audio : </p><a href="liste.php">Consulter le matériel audio</a></li>
          <li><i class="micro"></i><p class=tm>Vidéo : </p><a href="liste.php">Consulter le matériel vidéo</a></li>
          <li><i class="autres"></i><p class=tm>Autres : </p><a href="liste.php">Consulter les accessoires audiovisuels</a></li>
        </ul>
      </section>
      <section id="reservation">
        <h2>Comment réserver du matériel ?</h2>
        <ul>
          1. <a href="#">Connectez-vous</a> à votre compte utilisateur.<br>
          <p style="margin-bottom: 20px;"> 2. <a href="#">Consultez</a> la liste des matériels disponibles.<br>
          <p style="margin-bottom: 20px;"> 3. <a href="#">Sélectionnez</a> le matériel que vous souhaitez réserver.<br>
          <p style="margin-bottom: 20px;"> 4. Choisissez la date et l'heure de la réservation.<br>
          <p style="margin-bottom: 20px;"> 5. Validez votre réservation.
        </ul>
        <p>
        <p style="margin-top: 75px;">
        <p style="font-weight:bold;"> Si vous rencontrez des difficultés pour réserver du matériel, n'hésitez pas à contacter notre service d'assistance.
        </p>
      </section>
    </main>
    <footer>
      <p>Université Gustave Eiffel - Emprunt de matériel audiovisuel - Tous droits réservés</p>
    </footer>
  </body>
</html>