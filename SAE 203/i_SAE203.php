<?php 
                if(isset($_GET['reg_err']))
                {
                    $err = htmlspecialchars($_GET['reg_err']);

                    switch($err)
                    {
                        case 'success':
                        ?>
                            <div class="alert alert-success">
                                <strong>Succès</strong> inscription réussie !
                            </div>
                        <?php
                        break;

                        case 'password':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> mot de passe différent
                            </div>
                        <?php
                        break;

                        case 'email':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> email non valide
                            </div>
                        <?php
                        break;

                        case 'email_length':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> email trop long
                            </div>
                        <?php 
                        break;

                        case 'pseudo_length':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> pseudo trop long
                            </div>
                        <?php 
                        case 'already':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> compte deja existant
                            </div>
                        <?php 

                    }
                }
                ?>
<html>
  <head>
    <title>Inscription</title>
    <link rel="stylesheet" type="text/css" href="styles/i_SAE203.css"> 
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
        <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe (6 caractères)" required pattern=".{6,}" title="Le mot de passe doit comporter au moins 6 caractères.">
        
        <button type="submit">S'inscrire</button>
        <p class="p_c">Vous avez déjà un compte ? <a href="SAE203.php"> Connectez-vous ici !</a></p>
      </form>
    </div>
  </body>
</html>