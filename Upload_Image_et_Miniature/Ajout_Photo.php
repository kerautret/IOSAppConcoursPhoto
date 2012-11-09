<?php
        require ( "F_UpLoad.php" ) ;
        require ( "F_Cree_Miniature.php" ) ;
        
	  // Indiquer ici le chemin (relatif depuis le dossier de ce script) vers le dossier qui stockera
	  // les medias uploades.
	  
        define ( "REPERTOIRE_DESTINATION" , "medias" , TRUE ) ;
?>

<HTML>
        <HEAD>
                <TITLE>Ajout d une photo dans la galerie</TITLE>                
        </HEAD>
        <BODY>

<?php
        // -------------------------------------------------------------------------------
        // On commence par gerer l'upload de l'image. La fonction Gere_Upload_Photo
        // renvoie par le return si ca s'est bien passe ou pas (booleen) et par un parametre
        // en E/S le nom de l'image stockee sur le serveur. Ce nom seulement sera stocke dans la BDD,
        // pas le fichier image en tant que tel. Attention, "UnePhoto" est le nom du champ
	  // <INPUT type="file"> fu formulaire.
        // -------------------------------------------------------------------------------

        $Succes = Gere_Upload_Photo ( "UnePhoto" , $NomPhotoUploadee , REPERTOIRE_DESTINATION ) ;

        if ( $Succes == FALSE )
        {
                echo ( "<P>Attention : La tentative d'upload a echoue :(</P>" ) ;
        }
        else
        {
                echo ( "<P>On a bien uploade une photo correcte (taille, format, poids) : " . $NomPhotoUploadee . "</P>" ) ;
                echo ( "<P>On effectue la creation de la miniature...</P>" ) ;

                Cree_Miniature ( REPERTOIRE_DESTINATION , $NomPhotoUploadee , $NomPhotoMiniature ) ;
                
                // C'est ici qu'il faudrait mettre a jour la BDD avec les diverses infos
                // dont les noms des images originale et miniature $NomPhotoUploadee et $NomPhotoMiniature
	  }
?>

        </BODY>
</html>
