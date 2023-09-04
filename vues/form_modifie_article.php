<form method="POST">

    <label for="titre">Titre</label>
    <input type="text" name="titre" id="titre" value=<?=$article["titre"]?>><br>
    <label for="texte">Texte</label><br>
    <textarea name="texte" id="texte" cols="30" rows="10"><?=$article["texte"]?></textarea><br>
    <input type="hidden" name="commande" value="ModifieArticle">
    <input type="hidden" name="auteur" value=<?=$_SESSION["username"]?>>
    <input type="hidden" name="id" value=<?=$article["id"]?>>
    <button type="submit">Modifie</button>

</form>
<p><?php if(isset($_REQUEST["message"])) echo $_REQUEST["message"]; ?></p>

<a href='index.php'>Retourner à la liste d'articles</a>