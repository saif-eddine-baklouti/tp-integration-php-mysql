<form method="POST">

    <label for="titre">Titre</label>
    <input type="text" name="titre" id="titre"><br>
    <label for="texte">Texte</label><br>
    <textarea name="texte" id="texte" cols="30" rows="10"></textarea><br>
    <input type="hidden" name="commande" value="CreationArticle">
    <input type="hidden" name="auteur" value=<?=$_SESSION["username"]?>>
    <button type="submit">Creation</button>

</form>
<p><?php if(isset($_REQUEST["message"])) echo $_REQUEST["message"]; ?></p>

<a href='index.php'>Retourner à la liste d'articles</a>