 <?php 
                if(isset($_GET['reg_err']))
                {
                    $err = htmlspecialchars($_GET['reg_err']);

                    switch($err)
                    {
                        case 'success':
                        }
                      }
                        ?>
                        <div class="alert alert-success">
                                <strong>Succès</strong> inscription réussie !
                            </div>
<html>
  <head>
    <title>Inscription</title>
    <link rel="stylesheet" type="text/css" href="Styles/i_SAE203.css"> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  </head>
  <body>
    <div class="container">
    <form action="finscription.php" method="post">
        <h1>Inscrivez-vous !</h1>
        

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" placeholder="Entrez votre nom" required>
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" placeholder="Entrez votre prénom" required>
        
        
        <label for="email">Adresse e-mail :</label>
        <input type="email" id="email" name="email" placeholder="Entrez une adresse e-mail valide" required>
        <label for="datenaiss">Date de naissance :</label>
        <input type="date" id="datenaiss" name="datenaiss" placeholder="" required>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required >
        
        <button type="submit">S'inscrire</button>
        <p class="p_c">Vous avez déjà un compte ? <a href="SAE203.php"> Connectez-vous ici !</a></p>
      </form>
    </div>
  </body>
</html>