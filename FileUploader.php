<?php

/**
 * Made By Francois284Modz
 * Class FileUploader
 * Handles single and multiple file uploads, performing basic checks and saving files to a specified directory.
 */
class FileUploader {

    protected $uploadDir;
    protected $maxFileSize;
    protected $allowedMimeTypes;

    /**
     * FileUploader constructor.
     * @param string $uploadDir Directory where files will be uploaded.
     * @param int $maxFileSize Maximum file size in bytes.
     * @param array $allowedMimeTypes Array of allowed MIME types for the files.
     */
    public function __construct($uploadDir = 'uploads/', $maxFileSize = 1048576, $allowedMimeTypes = ['image/jpeg', 'image/png']) {
        $this->uploadDir = rtrim($uploadDir, '/') . '/';
        $this->maxFileSize = $maxFileSize;
        $this->allowedMimeTypes = $allowedMimeTypes;

        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
    }

    /**
     * Set allowed MIME types for file upload.
     * @param array $mimeTypes Array of allowed MIME types.
     */
    public function setAllowedMimeTypes(array $mimeTypes) {
        $this->allowedMimeTypes = $mimeTypes;
    }

    /**
     * Upload a single file.
     * @param array $file File array from $_FILES.
     * @return string Uploaded file path.
     * @throws Exception If an error occurs during file upload.
     */
    public function upload($file) {
        if ($file['error'] != UPLOAD_ERR_OK) {
            throw new Exception('Error during file upload.');
        }

        $this->checkFile($file);

        $safeName = $this->sanitizeFileName($file['name']);
        $destination = $this->uploadDir . $safeName;

        if ($this->fileExists($destination, $file['size'])) {
            throw new Exception("File {$file['name']} already exists on the server.");
        }

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new Exception('Error moving uploaded file.');
        }

        return $destination;
    }

    /**
     * Upload multiple files.
     * @param array $files Files array from $_FILES.
     * @return array Array of uploaded file paths.
     * @throws Exception If an error occurs during file uploads.
     */
    public function uploadMultiple($files) {
        $uploadedFiles = [];

        foreach ($files['name'] as $index => $name) {
            $fileArray = [
                'name' => $files['name'][$index],
                'type' => $files['type'][$index],
                'tmp_name' => $files['tmp_name'][$index],
                'error' => $files['error'][$index],
                'size' => $files['size'][$index]
            ];

            $this->checkFile($fileArray);

            $safeName = $this->sanitizeFileName($name);
            $destination = $this->uploadDir . $safeName;

            if ($this->fileExists($destination, $files['size'][$index])) {
                throw new Exception("File $name already exists on the server.");
            }

            if (!move_uploaded_file($files['tmp_name'][$index], $destination)) {
                throw new Exception("Error moving uploaded file $name.");
            }

            $uploadedFiles[] = $destination;
        }

        return $uploadedFiles;
    }

    /**
     * Check file for size and MIME type.
     * @param array $file File array.
     * @throws Exception If file does not meet criteria.
     */
    protected function checkFile($file) {
        if ($file['size'] > $this->maxFileSize) {
            throw new Exception('File is too large. Maximum size is ' . $this->maxFileSize . ' bytes.');
        }

        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $fileMimeType = finfo_file($fileInfo, $file['tmp_name']);
        finfo_close($fileInfo);

        if (!in_array($fileMimeType, $this->allowedMimeTypes)) {
            throw new Exception('File type not allowed.');
        }
    }

    /**
     * Check if a file with the same name and size exists.
     * @param string $filePath File path.
     * @param int $fileSize File size.
     * @return bool True if file exists, false otherwise.
     */
    protected function fileExists($filePath, $fileSize) {
        return file_exists($filePath) && filesize($filePath) == $fileSize;
    }

    /**
     * Sanitize file name to remove unwanted characters.
     * @param string $fileName File name.
     * @return string Sanitized file name.
     */
    protected function sanitizeFileName($fileName) {
        return preg_replace('/[^a-zA-Z0-9_\-\.]/', '', $fileName);
    }
}

?>
