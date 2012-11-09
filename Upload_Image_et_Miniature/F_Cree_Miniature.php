<?php

// =======================================================================
// Fonction de creation d'une miniature a partir d'une image situee sur le serveur
// Dans la solution retenue ici, les proportions de l'image initiale ne seront pas
// respectees (c'est possible bien sur...) car la taille de la miniature est fixee
// (cf. constantes ci-dessous)
// =======================================================================
//     Jean-Luc Husson <husson@loria.fr>     --    mars 2005
// =======================================================================

          // Definir ici la taille largxlong de l'image miniature
          
        define ( "LARGEUR_MINIATURE" , 80 , TRUE ) ;
        define ( "HAUTEUR_MINIATURE" ,  50 , TRUE ) ;
        
          // Definir ici le prefixe qui sera ajoutee au nom de l'image initiale
          // pour former le nom de la miniature cree
          
        define ( "PREFIXE" ,  "mini_" , TRUE ) ;

          
        // ============================================================================================
        function Cree_Miniature ( $Repertoire , $NomImageOrig , &$NomFichierDestination )
        // ============================================================================================
        {
                // Récuperation de la taille de l'image originale

                $NomFichierOriginal = $Repertoire . "/" . $NomImageOrig ;

                // Creation du nom de fichier pour la miniature

                $NomFichierDestination = PREFIXE . $NomImageOrig ;

                $NomFichierDestinationComplet = $Repertoire . "/" . PREFIXE . $NomImageOrig ;

                $TabTailles = GetImageSize ( $NomFichierOriginal );
                
                $LargeurOriginale = $TabTailles [0] ;
                $HauteurOriginale = $TabTailles [1] ;

                echo ( "<b>Taille de l'image source : </b> : " . $LargeurOriginale . "x" . $HauteurOriginale . "<br>" ) ;
                echo ( "<b>Taille de l'image destination : </b> : " . LARGEUR_MINIATURE . "x" . HAUTEUR_MINIATURE . "<br>" ) ;

                // Initialisation des variables correspondant à l'image source et à l'image de destination

                $ImageSource = ImageCreateFromJPEG ( $NomFichierOriginal ) ;
                $ImageDestination = ImageCreate ( LARGEUR_MINIATURE , HAUTEUR_MINIATURE ) ;
                
                // Attention : possibilite d'utiliser ImageCreateTrueColor() a la place de ImageCreate()

                // Copie de la source dans une image "vierge" avec les dimensions choisies

                ImageCopyResized ( $ImageDestination , $ImageSource ,
                                   0 , 0 , 0 , 0 ,
                                   LARGEUR_MINIATURE , HAUTEUR_MINIATURE ,
                                   $LargeurOriginale , $HauteurOriginale ) ;

                // Attention : la fonction ImageCopyResampled() peut etre utilisee a la place de ImageCopyResized()
                // Avec car et ImageCreateTrueColor(), la qualite de rendu de la miniature est meilleure

                // Creation du fichier miniature
				// utilisation de :  imagejpeg ( resource image , string filename , int quality)
				// Om met 100 pr la qualite maximale
				
                ImageJPEG ( $ImageDestination , $NomFichierDestinationComplet , 100 ) ;
				
				
				
        }
?>

