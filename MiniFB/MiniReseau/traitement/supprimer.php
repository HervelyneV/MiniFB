<?php
$supprimerPostID = $_POST['supprimer-post-id'];
$sql = "DELETE FROM ecrit WHERE id = ?";

$query = $pdo->prepare($sql);
$query->execute([$supprimerPostID]);
header('Location: index.php?action=mur&id='.$_SESSION['id']);
exit();
?>