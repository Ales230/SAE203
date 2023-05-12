<!DOCTYPE html>
<html>
  <head>
    <title>Inscription</title>
    <link rel="stylesheet" type="text/css" href="Styles/i_SAE203.css"> 
  </head>
  <body>
    <div class="container">
      <form>
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
        <p class="p_c">Vous avez déjà un compte ? <a href="http://localhost/index.html/SAE%20203/SAE203.php"> Connectez-vous ici !</a></p>
      </form>
    </div>
  </body>
</html>