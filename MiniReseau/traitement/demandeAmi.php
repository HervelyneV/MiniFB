<?php
    echo "Demande d'amitié envoyée !";
    
    $sql = "INSERT INTO lien VALUES(NULL,?,?,'attente')";

    $q = $pdo->prepare($sql);

    $q->execute(array($_SESSION["id"], $_GET["id"]));
    
    header("Location: index.php?action=profil&id=");


?>