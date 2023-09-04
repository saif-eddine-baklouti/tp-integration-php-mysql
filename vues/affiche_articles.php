

<h1>Les articles</h1>
<p><?php if(isset($_SESSION["message"])) { 
echo $_SESSION["message"]; ?>
<a href='index.php?commande=Logout'>Log out</a>
<?php
}
?></p></br>
<form method="GET" >
    <input type="text" name="recherche" id="recherche">
    <input type="hidden" name="commande" value="RechercheArticles">
    <button>Recherche</button>
</form>
<?php if (!isset($_SESSION["username"])) {
    ?>
    <a href='index.php?commande=Authentification'>Authentification</a></br>
<?php
}
?>
<p><?php if(isset($_REQUEST["message"])) echo $_REQUEST["message"]; ?></p>

<?php
if (isset($_SESSION['username'])) { ?>
    <a href="index.php?commande=FormCreationArticle">Creation d'article</a>
    
    <?php

} 
?></br></br></br></br></br></br>

<p><?php if(isset($_REQUEST["resultats"])) echo $_REQUEST["resultats"]; ?></p>
<?php
while($rangee = mysqli_fetch_assoc($articles))
{
    if (isset($_SESSION['username']) && $rangee['auteur'] == $_SESSION['username']) {
        ?>
        <a href="index.php?commande=FormModifieArticle&id=<?= $rangee["id"] ?>">Modifier d'article</a>
        <a href="index.php?commande=SupprimerArticle&id=<?= $rangee["id"] ?>">Supprimer d'article</a>
        <?php
    };
?>
    <li> <?= $rangee["id"] ?> .<?=$rangee['titre'] ?>. </br>. <?= $rangee['texte'] ?> .</br>.<?= $rangee['auteur'] ?></li><br><br>
<?php
}
?>