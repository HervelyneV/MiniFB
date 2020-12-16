<link rel="stylesheet" href="./css/amis_style.css">

<?php
    //echo "Page d'amis.";
    if(!(isset($_SESSION["id"])) || !(isset($_SESSION["login"]))){
            //message("Création de la session");
            header('Location: index.php?action=accueil');
    }
?>

<!-- <body> -->
<!--PAGE D'AMIS-->
 <div id="header">
    <div class="page_accueil">
    <div id="sidebar-menu">
        <div id="profil">
            <p id="prenomNom" onclick="viewProfil(<?php echo $_SESSION["id"]; ?>)">Bonjour <?php echo str_replace("_", " ", $_SESSION["login"]); ?></p>
        </div>
</div>
        <nav id="menu-liens">
            <a href="index.php?action=accueil">Accueil</a>
            <a href="index.php?action=amis">Amis</a>
            <a href="index.php?action=profil&id=<?php echo $_SESSION["id"]; ?>">Mon profil</a>
            <a href="index.php?action=deconnexion" id="lien-deconnexion">Déconnexion</a>
        </nav>
         </div>
         </div>

        <div id="liste-amis">
            <p id="titre_amis"> Liste d'amis : </p>
            <ul>
                <?php
                     $sql = "SELECT * FROM user WHERE id IN ( SELECT user.id FROM user INNER JOIN lien ON idUtilisateur1=user.id AND etat='amis' AND idUtilisateur2=? UNION SELECT user.id FROM user INNER JOIN lien ON idUtilisateur2=user.id AND etat='amis' AND idUtilisateur1=?) LIMIT 0, 5";

                     $q = $pdo->prepare($sql);

                     $q->execute(array($_SESSION["id"], $_SESSION["id"]));

                     while($line = $q->fetch()){
                         /*echo "<pre>";
                         var_dump($line);
                         echo "</pre>";*/
                 ?>
                 <li><a href="index.php?action=profil&id=<?php echo $line["id"]; ?>" class="ami-lien"><?php echo $line["login"]; ?></a></li>
                 <?php
                     }
                 ?>
            </ul>
        </div>

        
   

    <div id="main-contain">

        <div id="recherche">
            <input type="search" id="friend-search" name="fs" placeholder="Rechercher un ami" onkeyup="searchPerson(this.value.toLowerCase());">
        </div>

        <div class="contain contain-amis">
            <?php
                $sql2 = "SELECT user.id AS idUser, user.* FROM user WHERE user.id != ? ORDER BY user.login";
                //INNER JOIN friends ON users.id=friends.idUser1 OR users.id=friends.idUser2     

                $q2 = $pdo->prepare($sql2);

                $q2->execute(array($_SESSION["id"]));

                while($line2 = $q2->fetch()){
                    /*echo "<pre>";
                    var_dump($line2);
                    echo "</pre>";*/
            ?>

            <div class="carte-ami" onclick="viewProfil(<?php echo $line2["idUser"]; ?>);">
                <span class="nom-ami"><?php echo $line2["login"]; ?></span>
                <?php
                    //Attribution de l'état de l'amitié                
                    $sql3 = "SELECT * FROM lien WHERE (idUtilisateur1=? AND idUtilisateur2=?) OR (idUtilisateur1=? AND idUtilisateur2=?)";


                    $q3 = $pdo->prepare($sql3);

                    $q3->execute(array($_SESSION["id"], $line2["idUser"], $line2["idUser"], $_SESSION["id"]));

                    $line3 = $q3->fetch();

                    /*echo "<pre>";
                    var_dump($line3);
                    echo "</pre>";*/

                    if(!$line3){
                ?>
                        <span class="status-ami">Inconnu</span>
                <?php
                    }else{
                        if($line3["etat"]=="amis"){
                ?>
                        <span class="status-ami">Vous êtes amis</span>
                <?php
                        }else if($line3["idUtilisateur1"]==$_SESSION["id"] && $line3["etat"]=="attente"){
                ?>
                        <span class="status-ami">Demande envoyée</span> <br/>
                <?php
                        }else if($line3["idUtilisateur2"]==$_SESSION["id"] && $line3["etat"]=="attente"){
                ?>
                        <span class="status-ami">Demande reçue</span>
                        <a class="bouton-accept" href="index.php?action=accept&id=<?php echo $line3["idUtilisateur1"]; ?>">Accepter</a>
                        <a class="bouton-reject" href="index.php?action=reject&id=<?php echo $line3["idUtilisateur1"]; ?>">Refuser</a>
                <?php
                        }else if($line3["etat"]=="refus"){
                ?>
                        <span class="status-ami">Vous n'êtes pas amis</span>
                <?php  
                        }
                    }
                ?>
            </div>
            <?php
                }
            ?>

            <!-- Mettre le code ici -->        
        </div>
    </div>
    
    <div id="footer">
            <a id="lien_accueil" href="index.php?action=accueil"><img id="logo" src="./css/src/Logo_moose.png" alt="Logo_moose" /></a>
            <p id="copyright-text">
                Copyright ©2020<br/>
                Tout droits réservés à Moose
            </p>
        </div>
    
</div>
<!-- </body> -->