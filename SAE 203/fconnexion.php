<?php 
session_start(); // Démarrage de la session

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

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    // Patch XSS
    $email = htmlspecialchars($_POST['email']); 
    $password = htmlspecialchars($_POST['password']);
    
    $email = strtolower($email); // email transformé en minuscule
    
    // On regarde si l'utilisateur est inscrit dans la table utilisateurs
    $check = $bdd->prepare('SELECT ID_utilisateur, email, password, nom, ID_role FROM utilisateur WHERE email = ?');
    $check->execute(array($email));
    $data = $check->fetch();
    $row = $check->rowCount();

    // Si > à 0 alors l'utilisateur existe
    if ($row > 0) {
        // Si le mail est bon niveau format
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Si le mot de passe est le bon
            if (password_verify($password, $data['password'])) {
                $_SESSION['ID_utilisateur'] = $data['ID_utilisateur'];
                $_SESSION['ID_role'] = $data['ID_role'];
                
                if ($_SESSION['ID_role'] === '1') {
                    // Rediriger les utilisateurs ayant le rôle "admin" vers une autre page
                    header('Location: a_SAE203.php');
                    die();  
                } elseif ($_SESSION['ID_role'] === '2') {
                    // Rediriger les utilisateurs ayant le rôle "étudiant" vers une autre page
                    header('Location: a_SAE203.php');
                    die();  
                } 
            } else {
                header('Location: SAE203.php?login_err=password');
                die();
            }
        } else {
            header('Location: SAE203.php?login_err=email');
            die();
        }
    } else {
        header('Location: SAE203.php?login_err=already');
        die();
    }
} else {
    header('Location: SAE203.php');
    die();
}
?>
