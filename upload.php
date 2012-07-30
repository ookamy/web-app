<?php
session_start();
// Check for errors

if($_FILES['file_upload']['error'] > 0){
    $_SESSION['upload-report'] = 'An error ocurred when uploading.';
	header("Location: index.php");
}

// Check filetype
if($_FILES['file_upload']['type'] != 'text/plain'){
    $_SESSION['upload-report'] = 'Unsupported filetype uploaded.';
	header("Location: index.php");
}

// Check filesize
if($_FILES['file_upload']['size'] > 500000){
    $_SESSION['upload-report'] = 'File uploaded exceeds maximum upload size (500kb).';
	header("Location: index.php");
}

// Check if the file exists
if(file_exists('upload/' . $_FILES['file_upload']['name'])){
    $_SESSION['upload-report'] = 'File with that name already exists.';
	header("Location: index.php");
}

// Upload file
if(!move_uploaded_file($_FILES['file_upload']['tmp_name'], 'upload/' . $_FILES['file_upload']['name'])){
    $_SESSION['upload-report'] = 'Error uploading file - check destination is writeable.';
	header("Location: index.php");;
}

$_SESSION['upload-report'] = 'File uploaded successfully.';
header("Location: index.php");
?>