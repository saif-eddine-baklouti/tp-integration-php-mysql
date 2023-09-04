<?php 
    /* 

        index.php est le CONTRÔLEUR de notre application de type MVC modulaire.

        TOUTES les requêtes de notre application, sans AUCUNE exception, que ce soit via un lien ou un formulaire devront passer par CE FICHIER. Tous les liens et les formulaires auront donc comme destination index.php, suivi des paramètres dans la query string (après le ?)

    */

    //réception du paramètre commande, qui peut arriver soit en GET, soit en POST
    if(isset($_REQUEST["commande"]))
    {
        $commande = $_REQUEST["commande"];
    }
    else 
    {
        //si j'arrive ici sans paramètre commande, il devrait y avoir une commande par défaut
        $commande = "AfficheArticles";
    }
    //inclusion des fonctions du modèle
    require_once("modele.php");

    //coeur du contrôleur - structure décisionnelle
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
                // valider la combinaison
                if($test != false)
                {
                    $_SESSION["username"] = $test;
                    $_SESSION["message"] = "Bienvenue ".$_SESSION["username"];
                    header("Location: index.php?commande=AfficheArticles");
                
                }
                else 
                {
                    header("Location: index.php?commande=Authentification&message=La combinaison username/password est invalide.");
                }
            }
            break;
        case "Logout":
            // Détruit toutes les variables de session
            $_SESSION = array();
            
            // Si vous voulez détruire complètement la session, effacez également
            // le cookie de session.
            // Note : cela détruira la session et pas seulement les données de session !
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }
        
            // Finalement, on détruit la session.
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
            case "SupprimerArticle":

                if(!isset($_REQUEST["id"] ))
            {
                header("Location: index.php");
                die();
            }
            
            $test = supprime_article($_REQUEST["id"]);
            if($test)
            {
                header("Location: index.php?commande=AfficheArticles&message=Suppression réussie.");
                die();
            }
            else 
            {
                //si il y a un bug
                header("Location: index.php?commande=AfficheArticles&message=Échec de la suppression.");
                die();
            }

            break;    
            
        case "CreationArticle":
            //valider le contenu des inputs
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
                        //insérer
                        $test = creation_article($titre, $texte, $auteur);
                        if($test !== false)
                        {
                            //l'ajout a fonctionné
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
                        //le formulaire a été mal rempli
                        header("Location: index.php?commande=FormCreationArticle&message=le formulaire a été mal rempli.");
                        die();
                    }
                }
                else
                {
                    //on arrive pas du formulaire
                    header("Location: index.php");
                    die();
                }
            
            
            break;
        case "RechercheArticles":
                session_start();
                $articles = obtenir_articles();
                $chain = trim($_REQUEST["recherche"]);
                $chain = htmlspecialchars($chain);
            if (!isset($chain)) {
                require_once("vues/header.php");
                require("vues/affiche_articles.php");
                require_once("vues/footer.php");
            }
            else 
            {
                $resultatsRecherche = recherhce_articles($chain);
                
                if (mysqli_num_rows($resultatsRecherche) != 0 && $chain != "" ) 
                {
                    require_once("vues/header.php");
                    require("vues/resultats_recherche_articles.php");
                    require_once("vues/footer.php");
                } else 
                {
                    header("Location: index.php?commande=AfficheArticles&resultats=aucun résultat.");
                        die();
                    
                }
            }
            break;            

        case "FormModifieArticle":
            session_start();
            $article = obtenir_article_par_id($_REQUEST['id']);

            if (isset($_SESSION["username"])) {
                require_once("vues/header.php");
                require("vues/form_modifie_article.php");
                require_once("vues/footer.php");
            }
            break;    
        case "ModifieArticle":
            session_start();
            
            //valider le contenu des inputs
            
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
                    //formulaire mal rempli
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
            //erreur 404, commande introuvable
            require_once("vues/header.php");
            require("vues/404.html");
            require_once("vues/footer.php");
            break;
    }



    function valide_equipe($nom, $ville, $nb_victoires)
    {
        $valide = true; 

        $nom = trim($_REQUEST["nom"]);
        $ville = trim($_REQUEST["ville"]);
        $nb_victoires = $_REQUEST["nb_victoires"];

        if($nom == "" || $ville == "" || !is_numeric($nb_victoires))
        {
            $valide = false;
        }

        return $valide;
    }

    function valide_joueur($prenom, $nom, $nb_buts, $nb_passes, $id_equipe)
    {
        $valide = true; 

        $nom = trim($_REQUEST["nom"]);
        $prenom = trim($_REQUEST["prenom"]);
        $nb_buts = $_REQUEST["nb_buts"];
        $nb_passes = $_REQUEST["nb_passes"];
        $id_equipe = $_REQUEST["id_equipe"];


        if($nom == "" || $prenom == "" || !is_numeric($nb_buts) || !is_numeric($nb_passes) || !is_numeric($id_equipe))
        {
            $valide = false;
        }

        return $valide;
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