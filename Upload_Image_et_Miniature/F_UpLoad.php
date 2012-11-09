
<?php

// =======================================================================
// Fonction d'upload d'image (adaptable a d'autre types de fichiers)
// La fonction renvoie un booleen selon que l'operation s'est bien ou mal passee
// Elle renvoie par un parametre en E/S le nom de l'image qui a ete stockee sur le serveur.
// Le script cree un nom d'image uploade unique (permet plusieurs upload par plusieurs
// connexion d'images de nom identique).
// =======================================================================
//     Jean-Luc Husson <husson@loria.fr>     --    mars 2005
// =======================================================================

        // --------------------------------------------------------------------------------
        // Ici on definit une constante qui represente la taille max des fichiers
        // en KO dont on autorise dans ce script l'upload. A priori, cette taille limite
        // est donc inferieure a la taille max autorisee par Apache.
        // --------------------------------------------------------------------------------

        define ( "MAX_KO_UPLOAD" , 600 , TRUE ) ;


        // -------------------------------------------------------------------------------
        // Attention : il faut verifier que vous avez bien ajoute les 2 attributs enctype
        // et method dans le formulaire d'upload.
        // En effet, pour qu'un upload puisse avoir lieu, le formulaire doit etre de la forme :
        // <FORM action="script.php" enctype="multipart/form-data"  method="post">
        // -------------------------------------------------------------------------------
                
        // --------------------------------------------------------------------------------
        // Attention : dans le fichier php.ini d'Apache (meme en EasyPHP),
        // il y a une taille maximale (fixee par defaut a 2MO) des fichiers uploades.
        // --------------------------------------------------------------------------------



        // ============================================================================================
        function Gere_Upload_Photo ( $NomChampFile , &$NomPhoto , $Repertoire_Destination )
        // ============================================================================================
        {
            // --------------------------------------------------------------------------------
            // En cas de gros upload et de reseau lent, il faut eventuellement augmenter
            // le timeout avec la fonction : set_time_limit ( NbreSecondes ) ;
            // --------------------------------------------------------------------------------

            set_time_limit ( 60 ) ;

            // --------------------------------------------------------------------------------
            // On recupere ici les informations sur le fichier transmis par upload
            // On fait reference dans la premiere dimension (associative) du tableau
            // $_FILES au nom du champ <INPUT type="file" ...> du formulaire d'upload.
            // --------------------------------------------------------------------------------
                        
                        if ( empty ($_FILES[$NomChampFile]["tmp_name"]) )
                        {
                                echo ( "Pas de photo uploadee" ) ;
                                $Resultat = FALSE ;
                        }
                        else
                        {
                                $nomReception     = $_FILES[$NomChampFile]["tmp_name"] ;
                                        
                                // Le nom de reception est un nom "special" attribue par le serveur
                                // qui n'est pas le nom du fichier initial (nomOriginal)
                                        
                                $nomOriginal      = $_FILES[$NomChampFile]["name"] ;   // Le nom original du fichier envoye par l'utilisateur
                                $tailleFichier    = $_FILES[$NomChampFile]["size"] ;   // En octets
                                $typeMimeFichier  = $_FILES[$NomChampFile]["type"] ;   // Type mime (non utilise dans la suite) : cf. http://www.commentcamarche.net/systemes/mime.php3.
                        
                                // On recupere l'extension du fichier transmis
        
                                $TabComposants = explode ( "." , $nomOriginal ) ;
                                $NbreComposants = count ( $TabComposants ) ;
                                $Extention = $TabComposants [ $NbreComposants-1 ] ;
                        
                                        
                                // --------------------------------------------------------------------------------
                                // On verifie si l'operation d'upload s'est bien passée
                                // --------------------------------------------------------------------------------
                        
                                if ( is_uploaded_file ( $nomReception ) == TRUE )
                                {
                                                        if ( $tailleFichier > ( MAX_KO_UPLOAD * 1024 ) )
                                                        {
                                                                        // --------------------------------------------------------------------------------
                                                                        // On teste ici la taille du fichier si jamais on a impose une taille maximale
                                                                        // --------------------------------------------------------------------------------
                                                        
                                                                        printf ( "Le fichier envoye (taille %.2f ko) est supérieure au maximum autorise (%.2f ko)\n." , ( $tailleFichier / 1024 ) , MAX_KO_UPLOAD ) ;
        
                                                                        $Resultat = FALSE ;
                                                        }
                                                        else if ( ( $Extention != "jpeg" ) and ( $Extention != "jpg" ) )
                                                        {
                                                                        // --------------------------------------------------------------------------------
                                                                        // On verifie le format du fichier (l'extension du fichier envoye plutot que le type mime)
                                                                        // La liste pourrait etre etendue a d'autres format images.
                                                                        // --------------------------------------------------------------------------------
                                                                        
                                                                        printf ( "Le fichier envoye est d'un format (%s) non autorise dans cette application.\n" ,  $Extention ) ;
        
                                                                        $Resultat = FALSE ;
                                                        }
                                                        else
                                                        {
                                                                        // --------------------------------------------------------------------------------
                                                                        // On deplace le fichier recu au bon endroit, cad dans le repertoire de destination.
                                                                        // Nom sous lequel sera stocké l'image sur le serveur
                                                                        // Le nom de l'image (la grande) est prefixee par "img_" puis par le timestamp actuel.
                                                                        // On suppose que 2 photos sont pas inserees dans la meme seconde...
                                                                        // --------------------------------------------------------------------------------
                                        
                                                                        $Now = time () ;
                                                                        
                                                                        $NouveauNomGd = "img_" . $Now . "_" . $nomOriginal ;
                                                                        
                                                                        $nomDestination   = $Repertoire_Destination . "/" . $NouveauNomGd ;
                                        
                                                                        echo (  "<BR>" . $nomReception . " - " . $nomDestination . "<BR>" ) ;
                                        
                                                                        if ( rename ( $nomReception , $nomDestination ) == TRUE )
                                                                        {
                                                                                        echo ( "<BR>Le fichier " . $nomOriginal . " a bien été uploadé vers " . $nomDestination ) ;
                                                                                        echo ( "<BR>La taille du fichier est : " . $tailleFichier . " octets" ) ;
                                                                                        echo ( "<BR>Le type du fichier est : " . $typeMimeFichier ) ;
        
                                                                                        $NomPhoto = $NouveauNomGd ;
                                                                                        
                                                                                        $Resultat = TRUE ;
                                                                
                                                                // On affecte les nouveaux droits sur le fichiers
                                                                // Lecture et écriture pour le propriétaire, lecture pour les autres
                                                                
                                                                chmod ( $nomDestination , 0644 ) ;
                                                                
                                                                        }
                                                                        else
                                                                        {
                                                                                        echo ( "<BR>Le déplacement du fichier temporaire " . $nomReception . " a échoué. Vérifiez
                                                                                        l'existence du répertoire " . $repertoireDestination ) ;
                        
                                                                                        $Resultat = FALSE ;
                                                                        }
                                                        }
                                        }
                                        else
                                        {
                                                        echo ( "<BR>ERREUR : Le fichier n'a pas été correctement uploade." ) ;
                                                        
                                                        $Resultat = FALSE ;
                                        }
                                }
        
                return ( $Resultat ) ;
        
        }
            
?>



