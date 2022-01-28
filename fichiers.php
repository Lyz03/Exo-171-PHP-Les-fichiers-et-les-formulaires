<?php


function getRandomFileName(string $fileName) : string {
    $info  =pathinfo($fileName);

    try {
        $byte = random_bytes(15);
    } catch (Exception $e) {
        $byte = openssl_random_pseudo_bytes(15);
    }

    return bin2hex($byte) . '.' . $info['extension'];
}


if (isset($_FILES["userFile"]) && $_FILES['userFile']['error'] === 0) {

    $allowedMimeTypes = ['image/jpeg', 'image/jpg'];

    if (in_array($_FILES['userFile']['type'], $allowedMimeTypes)) {

        $maxSize = 3 * 1024 * 1024;
        if ((int)$_FILES['userFile']['size'] <= $maxSize) {

            echo 'Fichier enregistré';

            $tmp_name = $_FILES['userFile']['tmp_name'];
            $name = getRandomFileName($_FILES['userFile']['name']);

            // create the dir if it doesn't exist yet
            if (!is_dir('upload')) {
                mkdir('upload'); // + permission 0755 if needed
            }

            move_uploaded_file($tmp_name, 'upload/' . $name);

        } else {
            echo 'fichier trop volumineux';
        }

    } else {
        echo "mauvais type";
    }

} else {
    echo "erreur d'upload";
}

