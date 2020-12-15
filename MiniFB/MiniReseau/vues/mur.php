<link rel="stylesheet" href="./css/mur_style.css">
<script src="./js/mur.js"></script>

    <?php
include("./config/bd.php"); 
?>

<header>
<div id="header">
    
  <img src="./css/src/Logo_moose.png" alt="LOGO DU SITE" width="90px" >
  <a href="index.php?action=profil&id=<?php echo $_SESSION['id']?>">
    <img src="./css/src/profil.png" alt="ICONE PROFIL" width="100px"></a>
    
<ul>
  <li><input id="searchbox"type="search" placeholder="Chercher un Amoose" name="rep">
    <div id="resultat-recherche">
       <div id="box_user">
        <a href="#">
        <img src="./css/src/moose.png" width="20px">
         Zelia tiran <br>
         zelia@gmail.com
           </a>
        </div>
        <div id="box_user">
        <a href="#">
        <img src="./css/src/moose.png" width="20px">
         Zelia tiran <br>
         zelia@gmail.com
           </a>
        </div>
      
      </div>    
    </li>
</ul>
    <a id="deconex" href="index.php?action=deconnexion">Déconnexion</a>
</div>

</header>

<main>
    

    <!--<form action="index.php?action=mur" method="get">
    
    <input type="search"  id="searchbox" name="rep" placeholder="rechercher un amoose"/>
    <input type="submit" value="valider"/>--!>
    
<?php
        
    $rep = htmlspecialchars($_GET['rep']);
	$sql = 'SELECT login FROM user WHERE login LIKE "%'.$rep.'%" ORDER BY id DESC';  
	$query = $pdo->prepare($sql); 
	
	$query->execute(); 
	
	
	while($line = $query->fetch()) { 
		$nom = $line['login'];
		echo "<option>$nom</option>";
    }
?>
    
    
    
    
    
    
    
 <div >
    <div class="nouveaupost">
        
         <form action="index.php?action=ajoutpost" method="post">
            <div class="form-group">
              <label for="content">Statut:</label>
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
    
    
<div id="mur-container">

    
<div id="all_post">
    <?php
    $mypostsql = "SELECT * FROM ecrit INNER JOIN user WHERE ecrit.idAuteur = user.id";

    $query = $pdo->prepare($mypostsql);
    $query->execute([]);
    ?>
    <?php
    while($line = $query->fetch()) {
        ?>
        <div class="div-post">
            <h2><?= $line["login"] ?></h2>
            <p><?= $line["contenu"]?></p>
            <input type="submit" id="" name="supprimer" value="Supprimer">
        </div>
        <?php
    }
?> 
</div>
    
    


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
       
        $sql = "SELECT * FROM ecrit WHERE idAmi=? ORDER BY dateEcrit DESC";
    }
?>