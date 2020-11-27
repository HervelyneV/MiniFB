<?php

session_start();

include('../config/bd.php');

//Si session deja ok, on ne retourne plus sur signin
if(isset($_SESSION['id'])){
    header('Location: index.php?action=login');
    exit;
}

//Si la variable $_POST est remplie, on traite le form
if(!empty($_POST)){
    extract($_POST);
    $valid = true; 

    // On prend le bon formulaire grâce au "name" de la balise "input"
    if(isset($_POST['inscription'])){
    
        $mail = htmlentities(strtolower(trim($mail)));
        $login = htmlentities(trim($login));
        $password = trim($password);

        //verif
        if(empty($mail)){
            $valid = false;
            $mailnotok = "Le mail ne peux pas être vide";
        }

        elseif(!preg_match("(^[-\w\.]+@([-a-z0-9]+\.)+[a-z]{2,3}$)i", $mail)){
            $valid = false;
            $mailnotok = "Le mail n'est pas valide";
        }
        
        else{
            $dispo_mail = $sql->query("SELECT email FROM user WHERE mail = ?",
            array($mail));
    
            $dispo_mail = $dispo_mail->fetch();
    
            if ($dispo_mail['email'] <> ""){
                $valid = false;
                $mailnotok = "Ce mail existe déjà";
            }
        }

        
            if(empty($login)){
                $valid=false;
                $loginnotok = "le login ne peux pas être vide";
            }

            if(empty($password)){
                $valid=false;
                $passwordnotok = "le mot de passe ne peux pas être vide";
            }
    
            if($valid){
                $password = crypt($password, '$6$rounds=5000$ACNKFOjdge*u052$');

                //insertion données dans la table 
                $sql->insert("INSERT INTO user (email, login, password) VALUES (?, ?, ?)",
                array($mail, $login, $password));
    
                header('Location: index.php?action=mur');
                exit;
            }
    }
}
?>   
    