<div class="accueil">
        <div id="profil">
            <?php echo $_SESSION["login"]; ?>
        </div>
        <div id="liste-amis">
            <ul>
                <?php
                     $sql = "SELECT * FROM user WHERE id IN ( SELECT user.id FROM user INNER JOIN lien ON idUtilisateur1=user.id AND etat='ami' AND idUtilisateur2=? UNION SELECT user.id FROM user INNER JOIN lien ON idUtilisateur2=user.id AND etat='ami' AND idUtilisateur1=?) LIMIT 0, 5";

                     $q = $pdo->prepare($sql);

                     $q->execute(array($_SESSION["id"], $_SESSION["id"]));

                     while($line = $q->fetch()){
                         /*echo "<pre>";
                         var_dump($line);
                         echo "</pre>";*/
                 ?>
                 <li><a href="index.php?action=profil&id_profil=<?php echo $line["id"]; ?>" class="lien_ami"><?php echo $line["login"];?></a></li>
                 <?php
                     }
                 ?>
            </ul>
        </div>

        <a href="index.php?action=deconnexion" id="lien_deco">Déconnexion</a>
    </div>

    <div id="profil_content">
        <div class="container_profil">
            <?php
                $sql = "SELECT * FROM user where id=?";
                
                $q = $pdo->prepare($sql);               
                
                $q->execute(array($_GET["id_profil"]));
            
                $line = $q->fetch();
                /*echo "<pre>";
                print_r($line);
                echo "</pre>";*/
            
                if(!$line){
                    header("Location: index.php?action=accueil");
                }else{
                
            ?>
            <div id="profil">
                <div id="profil_infos">
                        <span id="profil_login"><?php  echo ucwords($line["login"]); ?></span>
                    </div>
                </div>
                
                <?php
                    
                    $ok = false;
                    $ami = false;
                    
                    if($_GET["id_profil"]==$_SESSION["id"]){
                        $ok = true;
                    }else{
                        // Verifions si on est amis avec cette personne
                        $sql_verif = "SELECT * FROM lien WHERE (idUtilisateur1=? AND idUtilisateur2=?) OR (idUtilisateur1=? AND idUtilisateur2=?)";
                        $q_verif = $pdo->prepare($sql_verif);

                        $q_verif->execute(array($_GET["id_profil"], $_SESSION["id"], $_SESSION["id"], $_GET["id_profil"]));

                        $line_verif = $q_verif->fetch();
                        /*echo "<pre>";
                        print_r($line_verif);
                        echo "</pre>";*/

                        if(!$line_verif){
                            $ok = false;
                        }else{
                            $ok = true;   
                            if($line_verif["etat"]=="ami"){
                                $ami = true;
                            }else{
                                $ami = false;
                            }
                        }                    
                    }
                    
                    //var_dump($ok);
                    
                    if($ok == false){
                ?>
                    <div id="message-autorisation">
                        <p>Vous n'êtes pas encore amoose</p>
                        <a href="index.php?action=demande&id=<?php echo $_GET["id_profil"]; ?>" id="demande_ami_lien">Faire une demande d'amoose</a>
                    </div>
                <?php
                    }else{
                        if($ami == false){
                ?>
                            <div id="message-autorisation">
                                <p>Vous n'êtes pas amoose. Dommage!</p>
                            </div>
                <?php
                        }else{
                ?>        
                
                <div id="ecrit-post">
                    <form action="index.php?action=ajouterpost" method="post">
                        <textarea id="content" name="content" placeholder="Écrivez votre poste ici..." required></textarea>
                        <?php
                            if($line["id"] != $_SESSION["id"]){
                                echo "<input type='hidden' name='idAmi' value='".$line['id']."' />";
                            }
                        ?>
                        <input type="submit" value="Envoyer">
                    </form>
                </div>
                <div id="profil-amis">
                    <h3 id="amis-titre">Mes amis</h3>
                    <?php
                    if($line["id"] == $_SESSION["id"]){
                        //Liste d'envoi d'amis
                        $sql_envoi = "SELECT users.* FROM users INNER JOIN friends ON users.id=idUser2 AND state='attente' AND idUser1=? ORDER BY users.family_name, user_name";

                        $q2 = $pdo->prepare($sql_envoi);

                        $q2->execute(array($_SESSION["id"]));

                        while($line2 = $q2->fetch()){
                            /*echo "<pre>";
                            print_r($line2);
                            echo "</pre>";*/
                            ?>
                            <div class="carte-ami">
                                <img class="photo-profil-ami" src="images/img_profil.png" alt="Photo_de_profil_de_<?php echo $line2["family_name"]."_".$line2["user_name"]; ?>" />
                                <span class="nom-ami"><?php echo $line2["family_name"]." ".$line2["user_name"]; ?></span>
                                <span class="status-ami">Demande envoyée</span>
                            </div>
                            <?php
                        }                  
                    }
                    ?>
                    <?php
                    if($line["id"] == $_SESSION["id"]){
                        //Liste de demande d'amis
                        $sql_demande = "SELECT users.* FROM users WHERE id IN(SELECT idUser1 FROM friends WHERE idUser2=? AND state='attente') ORDER BY users.family_name, user_name";

                        $q3 = $pdo->prepare($sql_demande);

                        $q3->execute(array($_SESSION["id"]));

                        while($line3 = $q3->fetch()){
                            /*echo "<pre>";
                            print_r($line3);
                            echo "</pre>";*/
                            ?>
                            <div class="carte-ami">
                                <img class="photo-profil-ami" src="images/img_profil.png" alt="Photo_de_profil_de_<?php echo $line3["family_name"]."_".$line3["user_name"]; ?>" />
                                <span class="nom-ami"><?php echo $line3["family_name"]." ".$line3["user_name"]; ?></span>
                                <span class="status-ami">Demande reçue</span>
                                <a class="bouton-accept" href="index.php?action=accept&id=<?php echo $line3["id"]; ?>">Accepter</a>
                                <a class="bouton-reject" href="index.php?action=reject&id=<?php echo $line3["id"]; ?>">Refuser</a>
                            </div>
                            <?php
                        }                  
                    }
                    ?>
                    <?php
                    //Liste d'amis confirmés
                    $sql_amis = "SELECT * FROM users WHERE id IN ( SELECT users.id FROM users INNER JOIN friends ON idUser1=users.id AND state='ami' AND idUser2=? UNION SELECT users.id FROM users INNER JOIN friends ON idUser2=users.id AND state='ami' AND idUser1=?) ORDER BY users.family_name, user_name";
                
                    $q4 = $pdo->prepare($sql_amis);
                    
                    if($line["id"] == $_SESSION["id"]){
                        $q4->execute(array($_SESSION["id"], $_SESSION["id"]));
                    }else{
                        $q4->execute(array($_GET["id_profil"], $_GET["id_profil"]));
                    }
                        

                    while($line4 = $q4->fetch()){
                        /*echo "<pre>";
                        print_r($line4);
                        echo "</pre>";*/
                        ?>
                        <div class="carte-ami">
                            <img class="photo-profil-ami" src="images/img_profil.png" alt="Photo_de_profil_de_<?php echo $line4["family_name"]."_".$line4["user_name"]; ?>" />
                            <span class="nom-ami"><?php echo $line4["family_name"]." ".$line4["user_name"]; ?></span>
                            <span class="status-ami">Vous êtes amis</span>
                        </div>
                        <?php
                    }                  
                    
                    ?>
                    <!--<div class="carte-ami">
                        <img class="photo-profil-ami" src="images/img_profil.png" alt="Photo_de_profil_de_#" />
                        <span class="nom-ami">Prénom Nom</span>
                        <span class="status-ami">Vous êtes déjà ami</span>
                    </div>-->
                </div>
                <div id="profil-post">
                    <h3 id="post-titre">Mes posts</h3>
                    <?php
                        //Liste des posts
                        $sql_posts = "SELECT posts.*, users.*, posts.id AS IDPost FROM posts JOIN users ON users.id=posts.idAmi WHERE posts.idAuteur=? OR posts.idAmi=? ORDER BY posts.datePost DESC";

                        $q_posts = $pdo->prepare($sql_posts);
                        
                        $q_posts->execute(array($_GET["id_profil"], $_GET["id_profil"]));
                        
                        while($line_posts = $q_posts->fetch()){
                            /*echo "<pre>";
                            var_dump($line_posts);
                            echo "</pre>";*/
                    ?>
                    <div class="post-perso">
                        <div class="main-post">
                            <div class="photo-profil-auteur">
                                <img class="photo-auteur" src="images/img_profil.png" alt="Photo_de_profil_de_<?php echo $line_posts["family_name"]."_".$line_posts["user_name"]; ?>" />
                            </div>
                            <div class="text-post">
                                <p class="nom-auteur"><?php echo $line_posts["family_name"]." ".$line_posts["user_name"]; ?></p>
                                <p class="titre-auteur"><?php echo $line_posts["title"]; ?></p>
                                <p class="post-auteur"><?php echo $line_posts["content"]; ?></p>
                                <p class="date-post">Posté par <?php echo $line_posts["family_name"]." ".$line_posts["user_name"]; ?> le <?php echo $line_posts["datePost"]; ?></p>
                            </div>
                        </div>
                        <div class="commentaire-post">
                            <h4 class="titre-commentaire">Commentaires</h4>
                            
                            <div id="ecrit-commentaire">
                                <form action="index.php?action=ajoutCommentaire" method="post">
                                    <textarea id="content" name="content" placeholder="Écrivez votre poste ici..." required></textarea>
                                    <input type="hidden" name="idPost" value="<?php echo $line_posts["IDPost"]; ?>" />
                                    <input type="submit" value="Envoyer">
                                </form>
                            </div>
                            
                            <?php
                                //Liste des posts
                                $sql_comments = "SELECT comments.*, users.* FROM comments JOIN users ON users.id=comments.idUser WHERE comments.idPost=? ORDER BY comments.dateComment DESC";

                                $q_comments = $pdo->prepare($sql_comments);

                                $q_comments->execute(array($line_posts["IDPost"]));

                                while($line_comments = $q_comments->fetch()){
                                    /*echo "<pre>";
                                    var_dump($line_comments);
                                    echo "</pre>";*/
                            ?>
                            <div class="commentaire">
                                <div class="photo-commentateur">
                                    <img class="photo-profil-commentateur" src="images/img_profil.png" alt="Photo_de_profil_de_<?php echo $line_comments["family_name"]."_".$line_comments["user_name"]; ?>" />
                                </div>
                                <div class="main-commentaire">
                                    <p class="commentaire-commentateur"><?php echo $line_comments["content"]; ?></p>
                                    <p class="date-commentaire">Posté par <?php echo $line_comments["family_name"]." ".$line_comments["user_name"]; ?> le <?php echo $line_comments["dateComment"]; ?></p>
                                </div>
                            </div>
                            <?php
                                }
                            ?>
                            <!--<div class="commentaire">
                                <div class="photo-commentateur">
                                    <img class="photo-profil-commentateur" src="images/img_profil.png" alt="Photo_de_profil_de_#" />
                                </div>
                                <div class="main-commentaire">
                                    <p class="commentaire-commentateur">Lorem ipsum aaaaaaaaaaa</p>
                                    <p class="date-commentaire">Posté par PRENOM NOM le DATE à HEURE</p>
                                </div>
                            </div>-->
                        </div>                            
                    </div>
                    
                    <?php
                        }
                }
                    ?>                    
                    
                    <!--<div class="post-perso">
                        <div class="main-post">
                            <div class="photo-profil-auteur">
                                <img class="photo-auteur" src="images/img_profil.png" alt="Photo_de_profil_de_#" />
                            </div>
                            <div class="text-post">
                                <p class="nom-auteur">PRENOM NOM</p>
                                <p class="post-auteur">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec et enim neque. Cras tincidunt hendrerit dignissim. Integer et ligula porttitor, pharetra erat id, lacinia justo. Vivamus ipsum sapien, auctor quis lectus eget, volutpat feugiat nisl. Nam consectetur, mauris vitae aliquam sagittis, justo velit interdum felis, dapibus lacinia velit augue sit amet odio. Fusce bibendum congue leo sed vestibulum. Vivamus mauris quam, suscipit sed porta bibendum, ultricies eget sapien. Phasellus id tempus lorem. Morbi id gravida urna, eget semper leo. Donec eu volutpat enim.</p>
                                <p class="date-post">Posté par PRENOM NOM le DATE à HEURE</p>
                            </div>
                        </div>
                        <div class="commentaire-post">
                            <h4 class="titre-commentaire">Commentaires</h4>
                            <div class="commentaire">
                                <div class="photo-commentateur">
                                    <img class="photo-profil-commentateur" src="images/img_profil.png" alt="Photo_de_profil_de_#" />
                                </div>
                                <div class="main-commentaire">
                                    <p class="commentaire-commentateur">Lorem ipsum aaaaaaaaaaa</p>
                                    <p class="date-commentaire">Posté par PRENOM NOM le DATE à HEURE</p>
                                </div>
                            </div>
                            <div class="commentaire">
                                <div class="photo-commentateur">
                                    <img class="photo-profil-commentateur" src="images/img_profil.png" alt="Photo_de_profil_de_#" />
                                </div>
                                <div class="main-commentaire">
                                    <p class="commentaire-commentateur">Lorem ipsum aaaaaaaaaaa</p>
                                    <p class="date-commentaire">Posté par PRENOM NOM le DATE à HEURE</p>
                                </div>
                            </div>
                        </div>                            
                    </div>-->
                </div>
                <?php
                            
                        }

                    }
                                     
                ?>
            </div>
        </div>
        <div id="copyright">
            <a id="lien-accueil" href="index.php?action=accueil"><img id="logo" src="images/logo.png" alt="Logo_Wolface" /></a>
            <p id="copyright-text">
                Copyright ©2020<br/>
                Tout droits réservés à Wolface
            </p>
        </div>
    </div>
</div>
<!-- </body> -->