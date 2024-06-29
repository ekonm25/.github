<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    
    $photo = $_FILES['photo'];
    $photoName = basename($photo['name']);
    $photoTmpName = $photo['tmp_name'];
    $photoSize = $photo['size'];
    $photoError = $photo['error'];
    $photoType = $photo['type'];
    
    $photoExt = explode('.', $photoName);
    $photoActualExt = strtolower(end($photoExt));
    
    $allowed = array('jpg', 'jpeg', 'png', 'pdf');
    
    if (in_array($photoActualExt, $allowed)) {
        if ($photoError === 0) {
            if ($photoSize < 1000000) {
                $photoNewName = uniqid('', true) . "." . $photoActualExt;
                $photoDestination = 'uploads/' . $photoNewName;
                move_uploaded_file($photoTmpName, $photoDestination);
                
                $file = 'submissions/' . uniqid() . '.txt';
                $content = "Nama: $name\nEmail: $email\nTelepon: $phone\nAlamat: $address\nFoto: $photoNewName\n";
                
                file_put_contents($file, $content);
                
                echo "Pendaftaran berhasil!";
            } else {
                echo "Ukuran file terlalu besar!";
            }
        } else {
            echo "Ada masalah saat mengunggah file!";
        }
    } else {
        echo "Tipe file tidak diizinkan!";
    }
}
?>
