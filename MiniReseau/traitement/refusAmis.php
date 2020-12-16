<?php
    echo "Amitié refusée !";
    
    $sql = "UPDATE lien SET etat='refus' WHERE idUtilisateur1=? AND idUtilisateur2=?";

    $q = $pdo->prepare($sql);

    $q->execute(array($_GET["id"], $_SESSION["id"]));
    
    header("Location: index.php?action=profil&id=");
?>