<?php 

    if(isset($_REQUEST["commande"]))
    {
        $commande = $_REQUEST["commande"];
    }
    else 
    {
        $commande = "AfficheArticles";
    }
    require_once("modele.php");

    switch($commande)
    {
        case "AfficheArticles":
            session_start();
            $titre = "Les Articles";
            $articles = obtenir_articles();
            require_once("vues/header.php");
            require("vues/affiche_articles.php");
            require_once("vues/footer.php");
            break;
        case "Authentification":
            require_once("vues/header.php");
            require("vues/authentification.php");
            require_once("vues/footer.php");
            break;
        case "Login":
            session_start();
            if(isset($_REQUEST["username"], $_REQUEST["password"]))
            {
                $test = login(htmlspecialchars($_REQUEST["username"]), htmlspecialchars($_REQUEST["password"]));

                echo $test ;

                if($test != false)
                {
                    $_SESSION["username"] = $test;
                    $_SESSION["message"] = "Bienvenue  ".$_SESSION["username"];
                    header("Location: index.php?commande=AfficheArticles");
                
                }
                else 
                {
                    header("Location: index.php?commande=Authentification&message=La combinaison username/password est invalide.");
                }
            }
            break;
        case "Logout":
            
            $_SESSION = array();
            
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }
        
            session_destroy();
            
            header("Location: index.php");
            break;
        case "FormCreationArticle":
            session_start();
            if (isset($_SESSION["username"])) {
                require_once("vues/header.php");
                require("vues/form_creation_article.php");
                require_once("vues/footer.php");
            }
            break;    
        
            
        case "CreationArticle":
            
            session_start();
            $articles = obtenir_articles();
            $titre = htmlspecialchars($_REQUEST["titre"]);
            $texte = htmlspecialchars($_REQUEST["texte"]);
            $auteur = htmlspecialchars($_SESSION["username"]);

            while ($rangee = mysqli_fetch_assoc($articles)) {
                if ($rangee["titre"] ==  $titre ) {
                    header("Location: index.php?commande=FormCreationArticle&message=Cette équipe existe déjà dans la base de données.");
                    die();
                }
            }
                if (isset($titre, $texte, $auteur))
                {
                    if(valide_article($titre, $texte, $auteur))
                    {
                        
                        $test = creation_article($titre, $texte, $auteur);
                        if($test !== false)
                        {
                            header("Location: index.php");
                            die();
    
                        }
                        else 
                        {
                            echo "Erreur MySQL - ici c'est un bug";
                            die();
                        }
                    }
                    else 
                    {
                        header("Location: index.php?commande=FormCreationArticle&message=le formulaire a été mal rempli.");
                        die();
                    }
                }
                else
                {
                    header("Location: index.php");
                    die();
                }
            
            
            break;
        case "SupprimerArticle":
                session_start();
    
                    if(!isset($_REQUEST["id"] ))
                {
                    header("Location: index.php");
                    die();
                }
                
                if ( isset($_SESSION["username"]) && $_SESSION["username"] == $_REQUEST["name"] ) {
                    $test = supprime_article($_REQUEST["id"]);
                    
                    if($test)
                    {
                        header("Location: index.php?commande=AfficheArticles&message=Suppression réussie.");
                        die();
                    }
                }
                else 
                {
                    header("Location: index.php?commande=AfficheArticles&message=Échec de la suppression.");
                    die();
                }
    
                break;    
        case "RechercheArticles":
                session_start();
                $articles = obtenir_articles();
                $chain = trim($_REQUEST["recherche"]);
                $chain = htmlspecialchars($chain);
                $resultatsRecherche = recherhce_articles($chain);
                
                if (mysqli_num_rows($resultatsRecherche) != 0 && $chain != "" ) 
                {
                    require_once("vues/header.php");
                    require("vues/affiche_articles.php");
                    require_once("vues/footer.php");
                } 
                else 
                {
                    header("Location: index.php?commande=AfficheArticles&resultats=aucun résultat.");
                        die();
                }
            
            break;            

        case "FormModifieArticle":
            session_start();
            $article = obtenir_article_par_id($_REQUEST['id']);

            if (isset($_SESSION["username"]) && $_SESSION["username"] == $article["auteur"]) {
                require_once("vues/header.php");
                require("vues/form_modifie_article.php");
                require_once("vues/footer.php");
            }
            else 
            {
                header("Location: index.php?commande=AfficheArticles&resultats=Vous n'avez pas le droit de modifier cet article.");
                    die();
            }
            break;    
        case "ModifieArticle":
            session_start();
            if(isset($_REQUEST["id"], $_REQUEST["titre"], $_REQUEST["texte"]))
            {
                if(valide_article($_REQUEST["titre"], $_REQUEST["texte"], $_SESSION["username"]))
                {
                    $id = htmlspecialchars($_REQUEST["id"]);
                    $titre = htmlspecialchars($_REQUEST["titre"]);
                    $texte = htmlspecialchars($_REQUEST["texte"]);
                    $auteur = htmlspecialchars($_SESSION["username"]);

                    $test = modifie_article($id, $titre, $texte, $auteur);
                    if($test)
                        header("Location: index.php?commande=AfficheArticles&resultats=Modification réussie.");
                    else
                        header("Location: index.php?commande=FormModifieArticle&message=Échec de la modification.");
                }
                else
                {
                    header("Location: index.php?commande=FormModifieArticle&id=". $id."&message=le formulaire a été mal rempli.");
                }
            }
            else 
            {
                header("Location: index.php");
                die();
            } 
            break;    
            
            default: 
            $titre = "Erreur 404";
            require_once("vues/header.php");
            require("vues/404.html");
            require_once("vues/footer.php");
            break;
    }

    function valide_article($titre, $texte, $auteur)
    {
        $valide = true; 

        
        $titre = trim($_REQUEST["titre"]);
        $texte = trim($_REQUEST["texte"]);
        $auteur = trim($_SESSION["username"]);

        if($titre == "" || $texte == "" || $auteur == "" )
        {
            $valide = false;
        }

        return $valide;
    }

?>