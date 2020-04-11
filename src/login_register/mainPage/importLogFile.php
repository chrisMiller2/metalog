<?php
if (isset($_FILES['myfile'])) {
    $errors = array();
    $file_name = $_FILES['myfile']['name'];
    $file_size = $_FILES['myfile']['size'];
    $file_tmp = $_FILES['myfile']['tmp_name'];
    $file_type = $_FILES['myfile']['type'];
    $fileNameExplode = explode(".", $file_name);
    $file_ext = strtolower(end($fileNameExplode));

    //accepted extensions
    $extensions = array("txt", "log", "TXT", "LOG");

    //ERROR extension
    if (in_array($file_ext, $extensions) === false) {
        $errors[] = "Extension not allowed, please choose a TXT or LOG file.";
    }
    //ERROR size
    if ($file_size > 2097152) {
        $errors[] = 'File size must be less than 2 MB';
    }

    //if no errors occurred
    if (empty($errors) == true) {
        $dest = '/var/www/faildomain.com/src/login_register/mainPage/logs/';
        move_uploaded_file($file_tmp, $dest . normalizeString($file_name));
        echo "<script>alert('You have successfully uploaded the file!');</script>";
    } else {
        print_r($errors);
        print_r($_FILES);
    }


}
function normalizeString ($str = '')
{
    $str = strip_tags($str);
    $str = preg_replace('/[\r\n\t ]+/', ' ', $str);
    $str = preg_replace('/[\"\*\/\:\<\>\?\'\|]+/', ' ', $str);
    $str = html_entity_decode( $str, ENT_QUOTES, "utf-8" );
    $str = htmlentities($str, ENT_QUOTES, "utf-8");
    $str = preg_replace("/(&)([a-z])([a-z]+;)/i", '$2', $str);
    $str = str_replace(' ', '_', $str);
    $str = rawurlencode($str);
    $str = str_replace('%', '-', $str);
    $str = strtolower($str);
    return $str;
}

require_once('adminIndex.php');