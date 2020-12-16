<link rel="stylesheet" href="./css/traitement_style.css">
 <div id="container-amis">
<?php
    echo "Demande d'amitié envoyée !";
    
    $sql = "INSERT INTO lien VALUES(NULL,?,?,'attente')";

    $q = $pdo->prepare($sql);

    $q->execute(array($_SESSION["id"], $_GET["id"]));
    
    
?>
<br/> 
<a href="index.php?action=mur&id=<?php echo $_SESSION["id"]; ?>">Revenir sur le mur</a>
     
</div>