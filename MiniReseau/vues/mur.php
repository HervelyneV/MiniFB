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
    <a id="deconex" href="index.php?action=deconnexion">Déconnexion</a>

 <form action='' method="POST">
    
    <input type="text"  id="searchbox" name="searchValue" required='required' placeholder="rechercher un amoose"/>
    <input type="submit" name="search"   value="valider"/>
    
<?php
 if (isset($_POST["search"])) { 
    $text = strtolower($_POST['searchValue']);
	$sql = "SELECT * FROM user WHERE lower(`login`) LIKE '%$text%'";  
	$query = $pdo->prepare($sql); 
	$query->execute(); 
	
	echo "<div id='personne'>";
	while($line = $query->fetch()) { 
		echo "<a href= 'index.php?action=mur&id=".$line['id']."'class='nom'>".$line['login']."</a><br/>";
	}       
     echo "</div>";
     }
?>
    

   
</div>
</header>

<main>
    

   
    
    
    
    
    
    
 <div >
    <div class="nouveaupost">
        
         <form action="microposts.php" method="post" dara-parsley-validate>
            <div class="form-group">
              <label for="content">Statut:</label>
              <textarea name="content" id="contenttext" rows="3"  placeholder="Tu peux écrire un nouveau statut">
                </textarea>
             
             </div>
             <div class="form-group">
              <input type="submit" id="boutonpublier" name="publier" value="Publier">
             
             </div>
      
         </form>
   
    </div>
    
  </div>  
    
    
<div id="mur-container">

    
<div id="post1">
    <div id="statut">
     <img src="./css/src/moose.png" width="50px" id="Photodeprofil">
     <h1>THEO CREMERS</h1>
    
    <p>Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard Le Lorem Ipsum est simplement Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum </p>
    </div>
    
    <div id="Commentaire">
    <h3>Zelia tiran</h3>
    
    <p>Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard Le Lorem Ipsum est simplement Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum </p>
    </div>
    <div id="ajoutcommentaire">
     <input type="text" placeholder="Ajouter un commentaire" name="Ajoutdecom" required/>
    </div>
    
    
</div>
    
    <div id="post2">
    <div id="statut">
    <h1>THEO CREMERS</h1>
    
    <p>Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard Le Lorem Ipsum est simplement Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum </p>
    </div>
    
    <div id="Commentaire">
    <h3>Zelia tiran</h3>
    
    <p>Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard Le Lorem Ipsum est simplement Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum </p>
    </div>
    <div id="ajoutcommentaire">
   <input type="text" placeholder="Ajouter un commentaire" name="Ajoutdecom" required/>
    </div>
    
    
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