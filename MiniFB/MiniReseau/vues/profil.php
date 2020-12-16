<link rel="stylesheet" href="./css/profil_style.css">
<?php
    //echo "Page d'accueil.";
    if(!(isset($_SESSION["id"])) || !(isset($_SESSION["login"]))){
            //message("Création de la session");
            header('Location: index.php?action=accueil');
    }
?>

<div class="my_profil">
        <div id="banner_myprofil">
            <img src="./css/src/igloo.png">
            
            <p>De retour chez soi!</p>
            
            <h2 id="myprofil_title">Profil</h2>
            
            <a href="index.php?action=mur&id=<?php echo $_SESSION["id"]; ?>">Mur</a>
            
            <a href="index.php?action=amis&id=<?php echo $_SESSION["id"]; ?>" id="lien_amis">Mes amis</a>
            
            <a href="index.php?action=deconnexion" id="lien_deco">Déconnexion</a>
        </div>
    
     <div id="myprofil_content">
        <div class="container_profil">
            <?php
                $sql = "SELECT * FROM user where id=?";
                
                $q = $pdo->prepare($sql);               
                
                $q->execute(array($_GET["id"]));
            
                $line = $q->fetch();

            
                if(!$line){
                    header("Location: index.php?action=accueil");
                }
            
                else{
                
            ?>
                <div id="profil_infos">
                      Profil de : <span id="profil_login"><?php  echo ucwords($line["login"]); ?></span>
                    </div>
         

            
            
            
            
            
            
             <?php
                    
                    $ok = false;
                    $ami = false;
                    
                    if($_GET["id"]==$_SESSION["id"]){
                        $ok = true;
            
                        $sql_demande = "SELECT user.* FROM user WHERE id IN(SELECT idUtilisateur1 FROM lien WHERE idUtilisateur2=? AND etat='attente') ORDER BY user.login";

                        $q3 = $pdo->prepare($sql_demande);

                        $q3->execute(array($_SESSION["id"]));

                        while($line3 = $q3->fetch()){
                            /*echo "<pre>";
                            print_r($line3);
                            echo "</pre>";*/
                            ?>
                            <div class="voir_ami">
                            
                                <span class="etat_ami">Demande reçue</span>
                                <span class="ami_name"> de la part de <?php echo $line3["login"]; ?></span>
                                <a class="bouton-accept" href="index.php?action=acceptamis&id=<?php echo $line3["id"]; ?>"> Accepter</a>
                                <a class="bouton-reject" href="index.php?action=refusamis&id=<?php echo $line3["id"]; ?>">Refuser</a>
                            </div>
                            <?php
                        }
                    ?>
            
            
            
            
            
            
            
            
            
            
            
         </div>   
             <div id="liste_amis">
            <ul>
                 <h3 id="titre_amis">Amis : </h3>
                <?php
                     $sql ="SELECT * FROM user WHERE id IN ( SELECT user.id FROM user INNER JOIN lien ON idUtilisateur1=user.id AND etat='amis' AND idUtilisateur2=? UNION SELECT user.id FROM user INNER JOIN lien ON idUtilisateur2=user.id AND etat='amis' AND idUtilisateur1=?)";

                     $q = $pdo->prepare($sql);

                     $q->execute(array($_SESSION["id"], $_SESSION["id"]));

                     while($line = $q->fetch()){
    
                 ?>
               
                <li>
                    <a href="index.php?action=profil&id=<?php echo $line["id"]; ?>" class="lien_ami"><?php echo $line["login"];?></a></li>
             
                 <?php
                     }
                 ?>
            </ul>
        </div>
                
            
                           <div class="nouveaupost">
        
         <form action="index.php?action=ajoutpost" method="post">
            <div class="form-group">
              <label for="content">Ecrire un nouveau post sur ton mur :</label>
              <textarea name="content" id="contenttext" rows="3"  placeholder="Tu peux écrire un nouveau statut">
                </textarea>
            <input type="hidden" name="profile-id" value="<?= $_SESSION['id'] ?>">
             </div>
             <div class="form-group">
              <input type="submit" id="boutonpublier" name="publier" value="Publier">
             
             </div>
      
         </form>
   
    </div>
    
  </div> 
            
            <div id="profil_post">
                    <h3 id="title_profil_post">Mes posts</h3>
                    <?php
                        //Liste des posts
                        $sql_posts = "SELECT ecrit.*, user.*, ecrit.id AS ID FROM ecrit JOIN user ON user.id=ecrit.idAmi WHERE ecrit.idAuteur=? OR ecrit.idAmi=? ORDER BY ecrit.dateEcrit DESC";

                        $q_posts = $pdo->prepare($sql_posts);
                        
                        $q_posts->execute(array($_GET["id"], $_GET["id"]));
                        
                        while($line_posts = $q_posts->fetch()){
                            /*echo "<pre>";
                            var_dump($line_posts);
                            echo "</pre>";*/
                    ?>
                    <div class="post_perso">
                        <div class="main_post">
                            <div class="ecrit_post">
                                <p class="login_auteur">Écrit par : <?php echo $line_posts["login"]; ?></p>
                                <p class="title_auteur"><?php echo $line_posts["titre"]; ?></p>
                                <p class="post_auteur"><?php echo $line_posts["contenu"]; ?></p>
                                <p class="date_post">Posté par <?php echo $line_posts["login"]; ?> le <?php echo $line_posts["dateEcrit"]; ?></p>
                                <hr>
                            </div>
                        </div>
                      
                       
                  <?php
                        }

              }
  
                    
                    else{
                        // Verifions si on est amis avec cette personne
                        $sql_verif = "SELECT * FROM lien WHERE (idUtilisateur1=? AND idUtilisateur2=?) OR (idUtilisateur1=? AND idUtilisateur2=?)";
                        $q_verif = $pdo->prepare($sql_verif);

                        $q_verif->execute(array($_GET["id"], $_SESSION["id"], $_SESSION["id"], $_GET["id"]));

                        $line_verif = $q_verif->fetch();

                        if(!$line_verif){
                            $ok = false;
                        }else{
                            $ok = true;   
                            if($line_verif["etat"]=="amis"){
                                $ami = true;
                            }else{
                                $ami = false;
                            }
                        }                    
                    }
                    

                    
                    if($ok == false){
                ?>
                    <div id="message_ok">
                        <p>Vous n'êtes pas encore amoose. Vous ne pouvez pas voir ce profil !</p>
                        <a href="index.php?action=demandeamis&id=<?php echo $_GET["id"]; ?>" id="demande_ami_lien">Faire une demande d'amoose</a>
                    </div>
                <?php
                    }else{
                        if($ami == false){
                ?>
                            <div id="message_ok">
                                <p><b>Vous êtes connecté sur votre page de profil</b></p>
                                
                            </div>
                <?php
                        }else{
                ?>        
                
                  <div class="nouveaupost">
        
         <form action="index.php?action=ajoutpost" method="post">
            <div class="form-group">
              <label for="content"> Écrire sur le mur de votre ami ! </label>
              <textarea name="content" id="contenttext" rows="3"  placeholder="Tu peux écrire un nouveau statut">
                </textarea>
            <input type="hidden" name="profile-id" value="<?= $_SESSION['id'] ?>">
             </div>
             <div class="form-group">
              <input type="submit" id="boutonpublier" name="publier" value="Publier">
             
             </div>
      
         </form>
   
    </div>
    
  </div> 
                <div id="profil_amis">
                    <h3 id="amis_title">Mes amis</h3>
                    <?php
                    if($line["id"] == $_SESSION["id"]){
                        //Liste d'envoi d'amis
                        $sql_envoi = "SELECT user.* FROM users INNER JOIN lien ON user.id=idUtilisateur2 AND etat='attente' AND idUtilisateur1=? ORDER BY user.login";

                        $q2 = $pdo->prepare($sql_envoi);

                        $q2->execute(array($_SESSION["id"]));

                        while($line2 = $q2->fetch()){
                            /*echo "<pre>";
                            print_r($line2);
                            echo "</pre>";*/
                            ?>
                            <div class="voir_ami">
                                <span class="login_ami"><?php echo $line["login"]?></span>
                                <span class="etat_ami">Demande envoyée</span>
                            </div>
                            <?php
                        }                  
                    }
                    ?>
                    <?php
                    if($line["id"] == $_SESSION["id"]){
                        //Liste de demande d'amis
                        $sql_demande = "SELECT user.* FROM user WHERE id IN(SELECT idUtilisateur1 FROM lien WHERE idUtilisateur2=? AND etat='attente') ORDER BY user.login";

                        $q3 = $pdo->prepare($sql_demande);

                        $q3->execute(array($_SESSION["id"]));

                        while($line3 = $q3->fetch()){
                            /*echo "<pre>";
                            print_r($line3);
                            echo "</pre>";*/
                            ?>
                            <div class="voir_ami">
                                <span class="ami_name"><?php echo $line3["login"]; ?></span>
                                <span class="etat_ami">Demande reçue</span>
                                <a class="bouton-accept" href="index.php?action=acceptamis&id=<?php echo $line3["id"]; ?>">Accepter</a>
                                <a class="bouton-reject" href="index.php?action=refusamis&id=<?php echo $line3["id"]; ?>">Refuser</a>
                            </div>
                            <?php
                        }                  
                    }
                    ?>
                    <?php
                    //Liste d'amis confirmés
                    $sql_amis = "SELECT * FROM user WHERE id IN ( SELECT user.id FROM user INNER JOIN lien ON idUtilisateur1=user.id AND etat='ami' AND idUtilisateur2=? UNION SELECT user.id FROM user INNER JOIN lien ON idUtilisateur2=users.id AND etat='ami' AND idUtilisateur1=?) ORDER BY user.login";
                
                    $q4 = $pdo->prepare($sql_amis);
                    
                    if($line["id"] == $_SESSION["id"]){
                        $q4->execute(array($_SESSION["id"], $_SESSION["id"]));
                    }else{
                        $q4->execute(array($_GET["id"], $_GET["id"]));
                    }
                        

                    while($line4 = $q4->fetch()){
                        /*echo "<pre>";
                        print_r($line4);
                        echo "</pre>";*/
                        ?>
                        <div class="voir_ami">
                            <span class="ami_name"><?php echo $line4["login"]; ?></span>
                            <span class="etat_ami">Vous êtes amis</span>
                        </div>
                        <?php
                    }                  
                    
                    ?>
                </div>
                <div id="profil_post">
                    <h3 id="title_profil_post">Mes posts</h3>
                    <?php
                        //Liste des posts
                        $sql_posts = "SELECT ecrit.*, user.*, ecrit.id AS ID FROM ecrit JOIN user ON user.id=ecrit.idAmi WHERE ecrit.idAuteur=? OR ecrit.idAmi=? ORDER BY ecrit.dateEcrit DESC";

                        $q_posts = $pdo->prepare($sql_posts);
                        
                        $q_posts->execute(array($_GET["id"], $_GET["id"]));
                        
                        while($line_posts = $q_posts->fetch()){
                            /*echo "<pre>";
                            var_dump($line_posts);
                            echo "</pre>";*/
                    ?>
                    <div class="post_perso">
                        <div class="main_post">
                            <div class="ecrit_post">
                                <p class="login_auteur"><?php echo $line_ecrit["login"]; ?></p>
                                <p class="title_auteur"><?php echo $line_ecrit["titre"]; ?></p>
                                <p class="post_auteur"><?php echo $line_ecrit["contenu"]; ?></p>
                                <p class="date_post">Posté par <?php echo $line_posts["login"]; ?> le <?php echo $line_posts["dateEcrit"]; ?></p>
                            </div>
                        </div>
                        <div class="commentaire_post">
                            <h4 class="conmmentaire_title">Commentaires</h4>
                            
                            <div id="ecrit-commentaire">
                                <form action="index.php?action=ajoutCommentaire" method="post">
                                    <textarea id="contenu" name="contenu" placeholder="Commentez ici..." required></textarea>
                                    <input type="hidden" name="idPost" value="<?php echo $line_commentaire["idPost"]; ?>" />
                                    <input type="submit" value="Envoyer">
                                </form>
                            </div>
                            
                            <?php
                                //Liste des posts
                                $sql_comments = "SELECT commentaire.*, user.* FROM commentaire JOIN user ON user.id=commentaire.idUser WHERE commentaire.idPost=? ORDER BY commentaire.dateCommentaire DESC";

                                $q_comments = $pdo->prepare($sql_comments);

                                $q_comments->execute(array($line_posts["idPost"]));

                                while($line_comments = $q_comments->fetch()){
                                    /*echo "<pre>";
                                    var_dump($line_comments);
                                    echo "</pre>";*/
                            ?>
                            <div class="commentaire">
                                <div class="main_commentaire">
                                    <p class="commentaire_user"><?php echo $line_commentaire["contenu"]; ?></p>
                                    <p class="date_commentaire">Posté par <?php echo $line_commentaire["login"]; ?> le <?php echo $line_comments["dateCommentaire"]; ?></p>
                                </div>
                            </div>
                            <?php
                                }
                  
                        }
                }
                   
                            
                        }

                    }
                                     
                ?>
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
</div>
<!-- </body> -->