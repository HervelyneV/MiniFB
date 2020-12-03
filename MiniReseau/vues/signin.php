
<link rel="stylesheet" href="../css/signin_style.css">

<section id="signin">
    <div id="signin_champ">
        <h2>Inscrit toi</h2>
        <form  name="inscription" action="index.php?action=inscription" method="post">
            <?php
            //si erreur sur le mail on affiche l'erreur
            
            if (isset($mainotok)){
            ?>
            <div> <?= $mailnotok ?> </div>
            <?php
            }
            ?>
            <input type="text" placeholder="Adresse Mail" name="mail" value="<?php if(isset($mail)) { echo $mail; }?>" required/> <br>
            
            <?php
            //si erreur sur le login on affiche l'erreur
            
            if (isset($loginnotok)){
            ?>
            <div> <?= $loginnotok ?> </div>
            <?php
            }
            ?>
            <input type="text" placeholder="Identifiant" name="login" value="<?php if(isset($login)) { echo $login; }?>" required/> <br>
            
            <?php
            //si erreur sur le mdp on affiche l'erreur
            
            if (isset($passwordnotok)){
            ?>
            <div> <?= $passwordnotok ?> </div>
            <?php
            }
            ?>
            
            <input type="password" placeholder="Mot de passe" name="password" value="<?php if(isset($password)) { echo $password; }?>" required/> 
            <br>
            <input id="envoyer_input" type="submit" name="Connexion" value="Inscription"/>
        </form>
    </div>
    
    <div id="right_moose">
        <h1>Moose</h1>
        <div>
            <p>Bienvenue l'ami !</p>
            <img src="css/src/moose.png">
        </div>
    </div>
    
</section>

/* 