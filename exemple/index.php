<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bootstrap File Upload</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Upload File(s)</h2>
    <form action="upload.php" method="post" enctype="multipart/form-data" class="mb-3">
        <div class="mb-3">
            <label for="fileToUpload" class="form-label">Select file(s) to upload:</label>
            <input type="file" name="files[]" id="fileToUpload" class="form-control" multiple>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
