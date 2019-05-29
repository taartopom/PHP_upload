<?php
/* gestion de l'upload d'un fichier */

    if (isset($_POST['btn_upload'])) {

        // fileCV contient des informations sur le
        // fichier envoyé (comme son nom, sa taille,
        // et l'endroit où il a été placé sur le serveur provisoirement)

        $fileCV = $_FILES['cv'];
        var_dump($fileCV);

        // il est possible que PHP bloque directement l'upload de fichier :
        // la taille du fichier est supérieur à ce que est définie
        // dans les fichiers de configuration :
        // sur windows : xampp c:\xampp\php\php.ini et wampserver : c:\wamp64\bin\php\phpVERSION\php.ini
        // upload_max_filesize à modifier ainsi que post_max_size
        // puis redémarrer le serveur apache pour qu'il prenne en compte les modifs

        if ($fileCV["error"] == 0) {
            $acceptedType = ['application/pdf', 'video/mp4'];

            // vérifier que le type du fichier est bien dans les valeurs
            // 'application/pdf' ou 'video/mp4'
            // ou que le type de fichier commence par "image/"
            if (in_array($fileCV["type"], $acceptedType)
                || substr($fileCV["type"], 0, 6) == "image/") {
                if ($fileCV["size"] <= 4194304) {
                    // générer un nom unique de fichier
                    $filename = md5(uniqid(rand(), true));
                    // récupérer l'extension du fichier envoyé
                    $extension = pathinfo($fileCV['name'], PATHINFO_EXTENSION);

                    if (move_uploaded_file($fileCV['tmp_name'], $filename.".".$extension)) {
                        echo "Upload bien réussi";
                    }
                    else {
                        echo "Erreur pendant l'upload";
                    }
                }
                else {
                    echo "Veuillez sélectionner un fichier de maximum 1MO";
                }
            }
            else {
                echo "Veuillez sélectionner un fichier au bon format";
            }
        }
        else {
            echo "Une erreur est survenue";
        }


    }
?>

<form method="post" enctype="multipart/form-data">
    <label>Veuillez sélectionner votre CV</label>

    <!-- Attribut accept pour restreindre le choix des fichiers dans la boite de dialogue,
    restriction uniquement côté navigateur -->

    <input type="hidden" name="MAX_FILE_SIZE" value="4194304" />
    <input type="file" name="cv" required accept="application/pdf,video/mp4,image/*"/><br>

    <input type="submit" name="btn_upload"/>
</form>
