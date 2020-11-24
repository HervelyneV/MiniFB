<link rel="stylesheet" href="../css/mur_style.css">


<header>
<div id="header">
    
<img src="logo.png" alt="LOGO DU SITE"  >
<img src="home.png" alt="ICONE HOME">
<img src="profil.png" alt="ICONE PROFIL">
<img src="parametre.png" alt="ICONE PARAMETRE">

<input type="search" placeholder="Chercher un Amoose" name="rechercher">
</div>

</header>

<main>

<div id="mur">
    <div id="statut">
    <h1>THEO CREMERS</h1>
    
    <p>Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard Le Lorem Ipsum est simplement Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum </p>
    </div>
    
    
    
    
</div>

</main>

<?php
    if(!isset($_SESSION["id"])) {
        // On n est pas connecté, il faut retourner à la pgae de login
        header("Location:index.php?action=login");
    }

    // On veut affchier notre mur ou celui d'un de nos amis et pas faire n'importe quoi
    $ok = false;

    if(!isset($_GET["id"]) || $_GET["id"]==$_SESSION["id"]) {
        $id = $_SESSION["id"];
        $ok = true; // On a le droit d afficher notre mur
    } else {
        $id = $_GET["id"];
        // Verifions si on est amis avec cette personne
        $sql = "SELECT * FROM lien WHERE etat='ami'
                AND ((idUtilisateur1=? AND idUtilisateur2=?) OR ((idUtilisateur1=? AND idUtilisateur2=?)))";

        // les deux ids à tester sont : $_GET["id"] et $_SESSION["id"]
        // A completer. Il faut récupérer une ligne, si il y en a pas ca veut dire que lon est pas ami avec cette personne
    }
    if($ok==false) {
        echo "Vous n êtes pas encore ami, vous ne pouvez voir son mur !!";       
    } else {
    // A completer
    // Requête de sélection des éléments dun mur
     // SELECT * FROM ecrit WHERE idAmi=? order by dateEcrit DESC
     // le paramètre  est le $id
    }
?>