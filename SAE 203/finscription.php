<?php 
try {
    $bdd = new PDO(
        'mysql:host=localhost;dbname=location_materiel;charset=utf8',
        'root'
    );
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die(print_r($e));
}
    // Si les variables existent et qu'elles ne sont pas vides
    if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['datenaiss']) && !empty($_POST['password'])) 
    {
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $email = htmlspecialchars($_POST['email']);
        $datenaiss = htmlspecialchars($_POST['datenaiss']);
        $password = htmlspecialchars($_POST['password']);

        // On vérifie si l'utilisateur existe
        $check = $bdd->prepare('SELECT nom, prenom, email, datenaiss, password FROM utilisateur WHERE email = ?');
        $check->execute(array($email));
        $data = $check->fetch();
        $row = $check->rowCount();

        $email = strtolower($email); // on transforme toute les lettres majuscule en minuscule pour éviter que Foo@gmail.com et foo@gmail.com soient deux compte différents ..
        
        // Si la requete renvoie un 0 alors l'utilisateur n'existe pas 
        if($row == 0){ 
                            // On hash le mot de passe avec Bcrypt, via un coût de 12
                            $cost = ['cost' => 12];
                            $password = password_hash($password, PASSWORD_BCRYPT, $cost);
                            
                            // On stock l'adresse IP
                            // On insère dans la base de données
                            $insert = $bdd->prepare('INSERT INTO utilisateur(ID_utilisateur, nom, prenom, email, datenaiss, password, ID_role) VALUES(FLOOR(RAND() * 1000000), :nom, :prenom, :email, :datenaiss, :password, 1)');
                            $insert->execute(array(
                                'nom' => $nom,
                                'prenom' => $prenom,
                                'email' => $email,
                                'datenaiss' => $datenaiss,
                                'password' => $password,
                            ));                            
                            // On redirige avec le message de succès
                            header('Location: i_SAE203.php?reg_err=success');
                            die();
                        }else{ header('Location: i_SAE203.php?reg_err=password'); die();}
                    }else{ header('Location: i_SAE203.php?reg_err=email'); die();}
?>  