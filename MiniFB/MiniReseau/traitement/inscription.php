<?php
$valid = true; //Vérification du formulaire
$erreur = "";

if(isset($_POST) && count($_POST)!=0){
    /*echo "<pre>";
    print_r($_POST);
    echo "</pre>";*/
    
    //Vérification du nom et prénom
    if(!isset($_POST["login"])){
        $valid = false;
        $erreur = $erreur . " Données invalides (identifiant).";
    }
    
    //Vérification du e-mail
    if(!isset($_POST["mail"]) || filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)==false){
        $valid = false;
        $error = $error . " Données invalides (e-mail).";
    }
    
    //Vérification du mot de passe
    if(!isset($_POST["password"])){
        $valid = false;
        $error = $error . " Données invalides (mots de passe).";
    }
    
    if($valid == true){
   
        $sql = "SELECT * FROM user WHERE email=?";
        
        // Etape 1  : preparation
        $q = $pdo->prepare($sql);

        // Etape 2 : execution
        $q->execute(array(
            $_POST["mail"]
        ));
        
        $line=$q->fetch();
        
        if($line != false){
            
            //Redirection si compte déjà existant
            echo "Compte déjà existant. Redirection vers le formulaire d'inscription.";
            header("location: index.php?action=login");
            
        }else{
            
            //Création du compte si non existant
            $sql = "INSERT INTO user(login, email, mdp) VALUES(? , ? , PASSWORD(?))";

            // Etape 1  : preparation
            $q = $pdo->prepare($sql);

            // Etape 2 : execution : 7 paramètres dans la requêtes !!
            $q->execute(array(
                $_POST["login"],
                $_POST["mail"],
                $_POST["password"]
            ));

            echo "Formulaire validé et enregistré dans la base de donnée.";
            header("location: index.php?action=accueil");
            
        }
        
    }else{
        echo "<b>Erreur dans la validation du formulaire ! Erreur(s) :$error</b><br/>";
       header("location: index.php?action=signin");
  }
    
}else{
    echo "Erreur !!! Aucun formulaire a été envoyé. Veuillez recommencer.";
    header("location: index.php?action=connexion_inscription");
}
