<?php
    echo "Amitié établie !";
    
    $sql = "UPDATE lien SET etat='amis' WHERE idUtilisateur1=? AND idUtilisateur2=?";

    $q = $pdo->prepare($sql);

    $q->execute(array($_GET["id"], $_SESSION["id"]));
    
    header("Location: index.php?action=profil");
?>