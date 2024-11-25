<?php
if (isset($_POST['submit'])) {
    // Define temporary directory for compressed images
    $tempDir = 'compressed_images/';
    if (!is_dir($tempDir)) {
        mkdir($tempDir, 0777, true);
    }

    // Create a new Zip archive
    $zip = new ZipArchive();
    $zipFile = 'compressed_images.zip';
    
    if ($zip->open($zipFile, ZipArchive::CREATE) !== TRUE) {
        die("Unable to create ZIP file.");
    }

    // Handle uploaded images
    $images = $_FILES['images'];
    $outputFormat = $_POST['output_format'];

    // Set compression parameters based on selected format
    $jpegQuality = isset($_POST['jpeg_quality']) ? $_POST['jpeg_quality'] : 70;
    $pngCompression = isset($_POST['png_compression']) ? $_POST['png_compression'] : 6;
    $webpQuality = isset($_POST['webp_quality']) ? $_POST['webp_quality'] : 80;

    for ($i = 0; $i < count($images['name']); $i++) {
        // Get the file info
        $fileTmpName = $images['tmp_name'][$i];
        $fileName = basename($images['name'][$i]);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Ensure the uploaded file is a valid image
        if (!in_array($fileExt, ['jpg', 'jpeg', 'png', 'webp'])) {
            continue; // Skip invalid files
        }

        // Generate a new file path for the compressed image
        $newFilePath = $tempDir . 'compressed_' . $fileName;

        // Compress the image based on selected format
        switch ($outputFormat) {
            case 'jpg':
                // Compress as JPG
                $img = imagecreatefromstring(file_get_contents($fileTmpName));
                imagejpeg($img, $newFilePath, $jpegQuality); // Set quality (1-100)
                imagedestroy($img);
                break;
            case 'png':
                // Compress as PNG
                $img = imagecreatefromstring(file_get_contents($fileTmpName));
                imagepng($img, $newFilePath, $pngCompression); // Set compression level (0-9)
                imagedestroy($img);
                break;
            case 'webp':
                // Compress as WebP
                $img = imagecreatefromstring(file_get_contents($fileTmpName));
                imagewebp($img, $newFilePath, $webpQuality); // Set quality (1-100)
                imagedestroy($img);
                break;
        }

        // Add the compressed image to the ZIP file
        $zip->addFile($newFilePath, basename($newFilePath));
    }

    // Close the ZIP archive
    $zip->close();

    // Clean up the temporary directory (optional)
    foreach (glob($tempDir . '*') as $file) {
        unlink($file);
    }
    rmdir($tempDir); // Remove the directory after the files are added to the zip

    // Provide the ZIP file for download
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . $zipFile . '"');
    header('Content-Length: ' . filesize($zipFile));
    readfile($zipFile);

    // Delete the ZIP file after downloading
    unlink($zipFile);
    exit();
}
?>
