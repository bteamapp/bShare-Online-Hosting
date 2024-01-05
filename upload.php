<?php

// Function to generate a random file name
function generate_random_filename() {
    // Create an array of 5 random numbers
    $numbers = array();
    for ($i = 0; $i < 5; $i++) {
        $numbers[] = rand(0, 9);
    }

    // Create an array of 3 random lowercase letters
    $letters = array();
    for ($i = 0; $i < 3; $i++) {
        $letters[] = chr(rand(97, 122));
    }

    // Create a random file name
    $filename = implode('', $numbers) . implode('', $letters) . date('mdY');

    return $filename;
}

// Function to check if a file already exists
function file_exists_with_random_filename($filename) {
    // Create an array of 5 random numbers
    $numbers = array();
    for ($i = 0; $i < 5; $i++) {
        $numbers[] = rand(0, 9);
    }

    // Create an array of 3 random lowercase letters
    $letters = array();
    for ($i = 0; $i < 3; $i++) {
        $letters[] = chr(rand(97, 122));
    }

    // Create a random file name
    $new_filename = implode('', $numbers) . implode('', $letters) . date('mdY');

    // Check if the file name already exists on the server
    return file_exists($filename . $new_filename);
}

// Start processing file uploads
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fileupload'])) {

    // List of allowed file types for upload
    $allowed_types = array('image/jpeg', 'image/png', 'image/gif', 'video/mp4');

    // Get file information
    $files = $_FILES['fileupload'];

    $names      = $files['name'];
    $types      = $files['type'];
    $tmp_names  = $files['tmp_name'];
    $errors     = $files['error'];
    $sizes      = $files['size'];

    // Number of files to be uploaded
    $numitems = count($names);
    $numfiles = 0;

    // Process each file
    for ($i = 0; $i < $numitems; $i++) {
        // Check if the $i-th file in the file array was uploaded successfully and is of the correct format
        if ($errors[$i] == 0 && in_array($types[$i], $allowed_types)) {
            $numfiles++;

            // Generate a random file name
            $new_filename = "";
            do {
                $new_filename = generate_random_filename() . $names[$i];
            } while (file_exists_with_random_filename($new_filename));

            // Move the file to the server
            move_uploaded_file($tmp_names[$i], 'uploads-cdn/' . $new_filename);

            // Display file information
            echo "You uploaded file number $numfiles:<br>";
            echo "File name: $names[$i] <br>";
            echo "Saved at: 𝐘𝐨𝐮𝐫 𝐩𝐫𝐞-𝐝𝐢𝐫𝐞𝐜𝐭𝐨𝐫𝐲/$new_filename <br>";
            echo "File size: $sizes[$i] <br><hr>";
        } else {
            echo "Upload failed: $names[$i] is not a valid image or video file<br>";
        }
    }

    // Display the total number of successfully uploaded files
    echo "Total number of uploaded files: " . $numfiles;
}

?>

<form method="post" enctype="multipart/form-data">
    <p>Select files to upload:
      (The maximum size allowed by PHP is <?= ini_get('upload_max_filesize') ?>)</p>

    <input name="fileupload[]" type="file" multiple="multiple" />
    <input type="submit" value="Upload Images" name="submit">
</form>
