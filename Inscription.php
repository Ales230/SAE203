<!DOCTYPE html>
<html>
  <head>
    <title>Page de connexion</title>
    <link rel="stylesheet" href="Styles/s.css">
    <link rel="stylesheet" type="text/css" href="styles/p.css">
<link rel="stylesheet" href="https://pyscript.net/latest/pyscript.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="path/to/lightbox.css">
  </head>
  <body>
  <header>
        <nav>
          <ul>
            <li><a href="#accueil">Accueil <i class="fa fa-home"></i></a></li>
            <li><a href="#meteriel">Matériel <i class="fa fa-info-circle"></i></a></li>
            <li><a href="#reservation">Réservation de matériel <i class="fa fa-file-text-o"></i></a></li>
            <li><a href="#reservation">Mon compte <i class="fa fa-file-text-o"></i></a></li>

          </ul>
        </nav>
      </header>
  <?php

// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  // Récupère les données du formulaire
  $nom = $_POST["nom"];
  $prenom = $_POST["prenom"];
  $email = $_POST["email"];
  $date_naissance = $_POST["date_naissance"];
  $mot_de_passe = $_POST["mot_de_passe"];
  
  // Validation des données
  if (empty($nom)) {
    $error_message = "Veuillez entrer votre nom.";
  } elseif (empty($prenom)) {
    $error_message = "Veuillez entrer votre prénom.";
  } elseif (empty($email)) {
    $error_message = "Veuillez entrer votre adresse email.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error_message = "Veuillez entrer une adresse email valide.";
  } elseif (empty($date_naissance)) {
    $error_message = "Veuillez entrer votre date de naissance.";
  } elseif (empty($mot_de_passe)) {
    $error_message = "Veuillez entrer un mot de passe.";
  } elseif (strlen($mot_de_passe) < 6) {
    $error_message = "Le mot de passe doit contenir au moins 6 caractères.";
  } else {
    // Connexion à la base de données
    $host = "localhost";
    $user = "utilisateur";
    $password = "mot_de_passe";
    $database = "ma_base_de_donnees";
    $conn = mysqli_connect($host, $user, $password, $database);
    
    // Vérification de la connexion
    if (!$conn) {
      die("La connexion à la base de données a échoué : " . mysqli_connect_error());
    }
    
    // Hachage du mot de passe
    $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_DEFAULT);
    
    // Insertion des données dans la base de données
    $sql = "INSERT INTO utilisateurs (nom, prenom, email, date_naissance, mot_de_passe)
            VALUES ('$nom', '$prenom', '$email', '$date_naissance', '$mot_de_passe_hache')";
    
    if (mysqli_query($conn, $sql)) {
      echo "Votre compte a été créé avec succès !";
    } else {
      echo "Erreur lors de la création du compte : " . mysqli_error($conn);
    }
    
    // Fermeture de la connexion à la base de données
    mysqli_close($conn);
  }
  
  // Affichage des erreurs
  if (!empty($error_message)) {
    echo $error_message;
  }
}

?>






    <div class="container">
      <!DOCTYPE html>
<html>
<head>
	<title>Inscription</title>
</head>
<body>
	<h2>Inscription</h2>
	<form action="traitement.php" method="post">
		<label for="email">Email :</label>
		<input type="email" id="email" name="email" required><br>

		<label for="nom">Nom :</label>
		<input type="text" id="nom" name="nom" required><br>

		<label for="prenom">Prénom :</label>
		<input type="text" id="prenom" name="prenom" required><br>

		<label for="date_naissance">Date de naissance :</label>
		<input type="date" id="date_naissance" name="date_naissance" required><br>

		<label for="mot_de_passe">Mot de passe :</label>
		<input type="password" id="mot_de_passe" name="mot_de_passe" minlength="6" required><br>

		<input type="submit" value="S'inscrire">
	</form>
</body>
</html>
      </form>
    </div>
  </body>
</html>