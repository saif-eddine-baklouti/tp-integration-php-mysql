



<form action="index.php" method='POST'>
    <label>Username : 
    <input type="text" name="username" >
    </label>
    <label>Password :
    <input type="password" name="password" >
    </label>
    <input type="hidden" name="commande" value="Login">
    <p><?php if(isset($_REQUEST["message"])) echo $_REQUEST["message"]; ?></p>
    <button> connexion</button>

</form>
<a href='index.php'>Retourner à la liste d'articles</a>