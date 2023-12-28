# FileUploader Class

## Description
A PHP class for handling both single and multiple file uploads, with support for custom upload directories, file size limits, and allowed MIME types.

## Installation
Include `FileUploader.php` in your PHP script.

## Usage
### Single File Upload
```php
$uploader = new FileUploader();
$filePath = $uploader->upload($_FILES['file']);
echo "File uploaded successfully to: $filePath";
```

### Multiple File Uploads
```php
$uploader = new FileUploader();
$filePaths = $uploader->uploadMultiple($_FILES['files']);
foreach ($filePaths as $path) {
    echo "File uploaded successfully to: $path<br>";
}
```

## Features
*   Easy to use for both single and multiple file uploads.
*   Customizable upload directory, file size limit, and allowed MIME types.
*   Basic security checks to prevent common upload vulnerabilities.

## License
MIT
This README outlines the basic use of the `FileUploader` class, along with a description and installation instructions. You can expand it with more details specific to your project, such as requirements, advanced configuration, and contribution guidelines.
