<?php
    date_default_timezone_set('Europe/Paris');
    echo "<pre>";
    var_dump($_POST);
    echo "</pre>";

    echo "Post envoyé !";

    $title = $_POST["titre"];
    $content = $_POST["contenu"];
    $date = $_POST["date"];
    $image = "";
    $auteur = $_SESSION["id"];
    if(isset($_POST["idAmi"]) && is_numeric($_POST["idAmi"])){
        $ami = $_POST["idAmi"];
    }else{
        $ami = $_SESSION["id"];
    }

    var_dump($date);

    $sql = "INSERT INTO ecrit VALUES(NULL, titre, contenu, date, image, idAuteur, idAmi)";

    $q = $pdo->prepare($sql);

    $q->execute(array(
        'titre' => $titre,
        'contenu' => $contenu,
        'date' => $date,
        'image' => $image,
        'idAuteur' => $auteur,
        'idAmi' => $ami
    ));

    header("Location: index.php?action=mur");

?>