<link rel="stylesheet" href="./css/traitement_style.css">
 <div id="container-amis">
<?php
    echo "Amitié établie !";
    
    $sql = "UPDATE lien SET etat='amis' WHERE idUtilisateur1=? AND idUtilisateur2=?";

    $q = $pdo->prepare($sql);

    $q->execute(array($_GET["id"], $_SESSION["id"]));
    
?>
<br/> 
<a href="index.php?action=mur&id=<?php echo $_SESSION["id"]; ?>">Revenir sur le mur</a>
     </div>