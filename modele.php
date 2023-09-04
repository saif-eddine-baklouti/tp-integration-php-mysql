<?php 

    /* 
        modele.php est le fichier qui représente notre modèle dans notre architecture MVC modulaire. 
        C'est donc dans ce fichier que nous retrouverons TOUTES les requêtes SQL sans AUCUNE exception. C'est aussi ici que se trouvera la CONNEXION à la base de données ET les informations de connexion relatives à celle-ci. 
    */
    //à modifier pour déployer sur Webdev
    define("SERVER", "localhost");
    define("USERNAME", "root");
    define("PASSWORD", "");
    define("DBNAME", "blog");

    //exemple de version webdev
    /*define("SERVER", "localhost");
    define("USERNAME", "e1123980");
    define("PASSWORD", "lemotdepassequiestdanslefichier:my.cnf");
    define("DBNAME", "e1123980");
    */

    function connectDB()
    {
        //se connecter à la base de données
        $c = mysqli_connect(SERVER, USERNAME, PASSWORD, DBNAME);

        if(!$c)
            die("Erreur de connexion : " . mysqli_connect_error());

        //s'assurer que la connexion traite tout en UTF-8
        mysqli_query($c, "SET NAMES 'utf8'");   
        
        return $c;
    }

    //le seul appel à connectDB dont vous avez besoin, puisque vos fonctions vont utiliser cette connexion via l'utilisation du mot-clé global 
    $connexion = connectDB();

    // function obtenir_equipes()
    // {
    //     global $connexion;

    //     //avant de continuer on teste la requête dans PHPMYADMIN
    //     $requete = "SELECT id, nom, ville, nb_victoires FROM equipe";

    //     //exécuter la requête avec mysqli_query 
    //     $resultats = mysqli_query($connexion, $requete);

    //     return $resultats;
    // }

    function obtenir_articles()
    {
        global $connexion;

        //avant de continuer on teste la requête dans PHPMYADMIN
        $requete = "SELECT id, titre, texte, auteur FROM article ORDER BY id DESC   ";

        //exécuter la requête avec mysqli_query 
        $resultats = mysqli_query($connexion, $requete);

        return $resultats;
    }

    function login($user, $pass)
    {
        //obtenir la connexion
        global $connexion;

        //1. déclarer la requête avec des ? là où il y aura des entrées de l'usager
        $requete = "SELECT username, password FROM usagers WHERE username = ?";
        
        //2. préparer la requête
        $reqPrep = mysqli_prepare($connexion, $requete);

        //3. est-ce que la requête préparée est valide
        if($reqPrep)
        {
            //4. faire le lien entre les paramètres (?) et les valeurs envoyées
            mysqli_stmt_bind_param($reqPrep, "s", $user);

            //5. exécuter la requête préparée
            mysqli_stmt_execute($reqPrep);

            //6. comme c'est un select, j'ai besoin des résultats
            $resultats = mysqli_stmt_get_result($reqPrep);

            //s'il y a un usager correspondant
            if(mysqli_num_rows($resultats) > 0)
            {
                $rangee = mysqli_fetch_assoc($resultats);
                $test = password_verify( $pass, $rangee["password"]);
                if($test)
                {
                    //c'est la bonne combinaison username / password
                    return $rangee["username"];
                }
                else 
                    return false;
            }
            else 
                return false;
        }
        else 
            die("Erreur mysqli.");
        

    }

    function supprime_article($id)
    {
        global $connexion;

        //avant de continuer on teste la requête dans PHPMYADMIN
        $requete = "DELETE FROM article WHERE id = " . $id;

        //exécuter la requête avec mysqli_query 
        $resultats = mysqli_query($connexion, $requete);

        return $resultats;

    }
    
    function creation_article($titre, $texte, $auteur)
    {
        global $connexion;

        $requete = "INSERT INTO article(titre, texte, auteur) VALUES(?, ?, ?)";

        //2. préparer la requête
        $reqPrep = mysqli_prepare($connexion, $requete);

        //3. est-ce que la requête préparée est valide
        if($reqPrep)
        {
            //4. faire le lien entre les paramètres (?) et les valeurs envoyées
            mysqli_stmt_bind_param($reqPrep, "sss", $titre, $texte, $auteur);

            //5. exécuter la requête préparée
            $test = mysqli_stmt_execute($reqPrep);

            if($test)
            {
                $id = mysqli_insert_id($connexion);
                return $id;
            }
            else 
                return false;
        }
        else 
            die("Erreur mysqli.");
    }

    function recherhce_articles($chain) {
        
        global $connexion;
        
        $aChercher = "%".$chain."%";
        
        $requete = "SELECT id, titre, texte, auteur FROM article WHERE CONCAT(titre,'',texte)  LIKE ? ";
        
        $reqPrep = mysqli_prepare($connexion, $requete);
        
        
        if($reqPrep)
        {
            
            //4. faire le lien entre les paramètres (?) et les valeurs envoyées
            mysqli_stmt_bind_param($reqPrep, "s", $aChercher);

            // //5. exécuter la requête préparée
            $test = mysqli_stmt_execute($reqPrep);

            if($test)
            { 
                
                $resultats = mysqli_stmt_get_result($reqPrep) ;
            
                return $resultats;
                }
            else 
                return false;
        }
        else 
            die("Erreur mysqli.");
        //exécuter la requête avec mysqli_query 
        $resultats = mysqli_query($connexion, $requete);
        
        return $resultats;
    }

    function modifie_article($id, $titre, $texte, $auteur)
    {
        global $connexion;

        //avant de continuer on teste la requête dans PHPMYADMIN
        $requete = "UPDATE article SET titre=?, texte=? WHERE auteur =? AND id=?";
        // $requete = "UPDATE joueur SET prenom='$prenom', nom='$nom', nb_buts=$nb_buts, nb_passes =$nb_passes, id_equipe=$id_equipe  WHERE ID=$id";
        
        //2. préparer la requête
        $reqPrep = mysqli_prepare($connexion, $requete);

        //3. est-ce que la requête préparée est valide
        if($reqPrep)
        {
            //4. faire le lien entre les paramètres (?) et les valeurs envoyées
            mysqli_stmt_bind_param($reqPrep, "sssi", $titre, $texte, $auteur, $id);

            //5. exécuter la requête préparée
            $test = mysqli_stmt_execute($reqPrep);

            return $test;
        }
        else 
            die("Erreur mysqli.");
        //exécuter la requête avec mysqli_query 
        $test = mysqli_query($connexion, $requete);
        
        return $test;
        
    };

    function obtenir_article_par_id($id)
    {
        global $connexion;

        //avant de continuer on teste la requête dans PHPMYADMIN
        $requete = "SELECT id, titre, texte, auteur FROM article WHERE id = ?";

        $reqPrep = mysqli_prepare($connexion, $requete);
        
        
        if($reqPrep)
        {
            
            //4. faire le lien entre les paramètres (?) et les valeurs envoyées
            mysqli_stmt_bind_param($reqPrep, "s", $id);

            // //5. exécuter la requête préparée
            $test = mysqli_stmt_execute($reqPrep);

            if($test)
            { 
                
                $resultats = mysqli_stmt_get_result($reqPrep) ;
                $rangee = mysqli_fetch_assoc($resultats);
            
                return $rangee;
                }
            else 
                return false;
        }
        else 
            die("Erreur mysqli.");
        //exécuter la requête avec mysqli_query 
        $resultats = mysqli_query($connexion, $requete);

        
        
        return $resultats;
    }
    
?>