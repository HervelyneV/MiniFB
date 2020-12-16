<?php

    $title = "";
    $content = $_POST["content"];
    $date = "";
    $image = "";
    $auteur = $_POST['profile-id'];
    $ami = "";

    $query = $pdo->prepare('INSERT INTO ecrit(titre, contenu, dateEcrit, image, idAuteur, idAmi) VALUES(:titre, :contenu, :dateEcrit, :image, :idAuteur, :idAmi)');
    $query->execute(array(
        'titre' => "",
        'contenu' => $content,
        'dateEcrit' => date('d-m-y h:i:s'),
        'image' => "",
        'idAuteur' => $_SESSION['id'],
        'idAmi' => "$auteur"));
    header('Location: index.php?action=mur&id='.$_SESSION['id']);
    exit();

?>