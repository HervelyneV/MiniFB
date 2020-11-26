<link rel="stylesheet" href="../css/login_style.css">

<section id="login">
    <div id="login_champ">
        <h2>Connecte-toi</h2>
        <form action="index.php?action=connexion" method="post">
            <input type="text" placeholder="Identifiant" name="login" required/> <br>
            <input type="password" placeholder="Mot de passe" name="password" required/> 
            <br>
            <input id="envoyer_input" type="submit" name="Connexion" value="Connexion"/>
        </form>
       <a id="inscristoi" href="index.php?action=signin">Pas encore de compte? Rejoins nous !</a>
    </div>
    
    <div id="right_moose">
        <h1>Moose</h1>
        <div>
            <p>Content de te revoir !</p>
            <img src="css/src/moose.png">
        </div>
    </div>
    
</section>