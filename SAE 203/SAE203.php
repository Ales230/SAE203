<?php 
                if(isset($_GET['login_err']))
                {
                    $err = htmlspecialchars($_GET['login_err']);

                    switch($err)
                    {
                        case 'password':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> email ou mot de passe incorrect
                            </div>
                        <?php
                        break;

                        case 'email':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> email ou mot de passe incorrect
                            </div>
                        <?php
                        break;

                        case 'already':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> email ou mot de passe incorrect
                            </div>
                        <?php
                        break;
                    }
                }
                ?>                 
                            
                        
<!DOCTYPE html>
<html>
  <head>
    <title>Connexion</title>
    <link rel="stylesheet" type="text/css" href="styles/SAE203.css"> 
  </head>
  <body>
    <div class="container">
      
      <form method="POST" action="fconnexion.php"> 
        <h1>Connectez-vous !</h1>
        <label for="email">Adresse e-mail :</label>
        <input type="email" id="email" name="email" placeholder="Entrez votre adresse e-mail" required>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>
        <button type="submit">Se connecter</button>
        <p class="p_c">Vous n'avez pas de compte ? <a href="i_SAE203.php"> Inscrivez vous ici !</a></p>
    </div>
  </body>
</html>