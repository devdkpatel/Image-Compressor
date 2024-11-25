<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bulk Image Compression</title>
<style>
body {
    font-family: Arial, sans-serif;
    margin: 20px;
    padding: 20px;
}
label {
    display: block;
    margin-top: 10px;
}
input[type="file"] {
    padding: 5px;
}
input[type="number"], select {
    padding: 5px;
}
button {
    margin-top: 15px;
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}
button:hover {
    background-color: #45a049;
}
.compression-settings {
    display: none;
}
</style>
</head>
<body>
<h2>Bulk Image Compression</h2>
<form action="compress_image.php" method="post" enctype="multipart/form-data">
  <label for="image">Upload Images:</label>
  <input type="file" name="images[]" id="image" multiple required>
  <br>
  <br>
  <label for="output_format">Choose Output Format:</label>
  <select name="output_format" id="output_format" onchange="toggleCompressionSettings()" required>
    <option value="jpg">JPG</option>
    <option value="png">PNG</option>
    <option value="webp">WebP</option>
  </select>
  <br>
  <br>
  
  <!-- JPEG Settings -->
  <div id="jpeg_settings" class="compression-settings">
    <label for="jpeg_quality">JPEG Quality (1-100):</label>
    <input type="number" name="jpeg_quality" id="jpeg_quality" min="1" max="100" value="70">
    <br>
    <br>
  </div>
  
  <!-- PNG Settings -->
  <div id="png_settings" class="compression-settings">
    <label for="png_compression">PNG Compression Level (0-9):</label>
    <input type="number" name="png_compression" id="png_compression" min="0" max="9" value="6">
    <br>
    <br>
  </div>
  
  <!-- WebP Settings -->
  <div id="webp_settings" class="compression-settings">
    <label for="webp_quality">WebP Quality (1-100):</label>
    <input type="number" name="webp_quality" id="webp_quality" min="1" max="100" value="80">
    <br>
    <br>
  </div>
  <button type="submit" name="submit">Compress Images</button>
</form>
<script>
        function toggleCompressionSettings() {
            const format = document.getElementById("output_format").value;
            
            // Hide all quality settings initially
            document.getElementById("jpeg_settings").style.display = "none";
            document.getElementById("png_settings").style.display = "none";
            document.getElementById("webp_settings").style.display = "none";

            // Show the appropriate settings based on the selected format
            if (format === "jpg") {
                document.getElementById("jpeg_settings").style.display = "block";
            } else if (format === "png") {
                document.getElementById("png_settings").style.display = "block";
            } else if (format === "webp") {
                document.getElementById("webp_settings").style.display = "block";
            }
        }

        // Call the function to show settings based on the default selected format when page loads
        window.onload = function() {
            toggleCompressionSettings();
        };
    </script>
</body>
</html>
