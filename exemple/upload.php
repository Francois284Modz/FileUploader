<?php
require "../../autoload.php";

$uploader = new FileUploader();
$uploader->setAllowedMimeTypes(['image/gif', 'image/jpeg', 'image/png']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Check if a single file or multiple files are uploaded
        if (isset($_FILES['files']['name']) && is_array($_FILES['files']['name'])) {
            // Multiple files
            $filePaths = $uploader->uploadMultiple($_FILES['files']);
            foreach ($_FILES['files']['name'] as $index => $name) {
                echo "File uploaded successfully to: " . $filePaths[$index] . "<br>";
                echo "Original file name: " . $name . "<br>";
                echo "File size: " . $_FILES['files']['size'][$index] . " bytes<br><br>";
            }
        } elseif(isset($_FILES['files']['name'])) {
            // Single file
            $filePath = $uploader->upload($_FILES['files']);
            echo "File uploaded successfully to: $filePath<br>";
            echo "Original file name: " . $_FILES['files']['name'] . "<br>";
            echo "File size: " . $_FILES['files']['size'] . " bytes<br>";
        } else {
            throw new Exception("No file uploaded.");
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
