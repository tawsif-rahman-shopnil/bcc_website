<?php
include('dbcon.php');

// Custom word-wrapping function for multibyte support
function custom_wordwrap($string, $width, $break = "\n", $cut = false) {
    $lines = explode($break, $string);
    $wrapped_lines = array();

    foreach ($lines as $line) {
        // Split the line into words
        $words = explode(' ', $line);
        $current_line = '';

        foreach ($words as $word) {
            // Check if adding the current word will exceed the width
            if (mb_strlen($current_line . $word) <= $width) {
                $current_line .= $word . ' ';
            } else {
                // Add the current line to the wrapped lines array
                $wrapped_lines[] = rtrim($current_line);

                // Start a new line with the current word
                $current_line = $word . ' ';
            }
        }

        // Add the remaining words in the current line
        if (!empty($current_line)) {
            $wrapped_lines[] = rtrim($current_line);
        }
    }

    return implode($break, $wrapped_lines);
}


// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate the form data
    if (empty($_POST['name']) || empty($_POST['paragraph']) || empty($_POST['category'])) {
        die('Please fill in all required fields');
    }

    // Handle the file upload
    $newCertificateFile = $_FILES['certificate_file'];

    if ($newCertificateFile['error'] === UPLOAD_ERR_OK) {
        $tempFilePath = $newCertificateFile['tmp_name'];

        // Remove the old certificate file if it exists
        $oldCertificateFilePath = "certificate.png";
        if (file_exists($oldCertificateFilePath)) {
            unlink($oldCertificateFilePath);
        }

        // Define the desired dimensions for the resized image
        $desiredWidth = 1330;
        $desiredHeight = 998;

        // Load the original image
        $originalImage = imagecreatefrompng($tempFilePath);

        // Check if the image was loaded successfully
        if ($originalImage === false) {
            die('Error loading the certificate image');
        }

        // Get the original dimensions
        $originalWidth = imagesx($originalImage);
        $originalHeight = imagesy($originalImage);

        // Calculate the aspect ratio of the original image
        $originalAspectRatio = $originalWidth / $originalHeight;

        // Calculate the target dimensions while maintaining the aspect ratio
        if ($desiredWidth / $desiredHeight > $originalAspectRatio) {
            $targetWidth = $desiredHeight * $originalAspectRatio;
            $targetHeight = $desiredHeight;
        } else {
            $targetWidth = $desiredWidth;
            $targetHeight = $desiredWidth / $originalAspectRatio;
        }

        // Create a new image with the target dimensions
        $resizedImage = imagecreatetruecolor($targetWidth, $targetHeight);

        // Resize the original image to the target dimensions
        imagecopyresampled(
            $resizedImage,
            $originalImage,
            0, 0, 0, 0,
            $targetWidth, $targetHeight,
            $originalWidth, $originalHeight
        );

        // Save the resized image as the new certificate image
        $oldCertificateFilePath = "resized_certificate.png";
        if (!imagepng($resizedImage, $oldCertificateFilePath)) {
            die('Error saving the resized certificate image');
        }

        // Clean up the memory used by the images
        imagedestroy($originalImage);
        imagedestroy($resizedImage);
    }

    $name = $_POST['name'];
    $paragraph = $_POST['paragraph'];
    $category = $_POST['category'];

    // Generate a unique certificate ID
    $certificate_id = uniqid('BCC');

    // Insert the form data into the database using prepared statements
    $insert_query = "INSERT INTO certificates (certificate_id, name, appreciation, category) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insert_query);
    mysqli_stmt_bind_param($stmt, 'ssss', $certificate_id, $name, $paragraph, $category);

    if (mysqli_stmt_execute($stmt)) {
        // Generate the JPEG image
        $font = dirname(__FILE__) . "/Consolas.ttf";
        $image = imagecreatefrompng($oldCertificateFilePath);
        $color = imagecolorallocate($image, 19, 21, 22);

        // Check if the image was loaded successfully
        if ($image === false) {
            die('Error loading the certificate image');
        }

        // Calculate the x-coordinate for the name to be centered
        $nameFontSize = 35;
        $nameBox = imagettfbbox($nameFontSize, 0, $font, $name);
        $nameWidth = $nameBox[2] - $nameBox[0];
        $nameStartX = (imagesx($image) - $nameWidth) / 2;

        imagettftext($image, $nameFontSize, 0, $nameStartX, 485, $color, $font, $name);

        // Split the appreciation text into lines that fit within a specific width
        $fontSize = 25;
        $lineSpacingFactor = 1.5;
        $textWidth = imagesx($image) * 0.6;
        $maxLines = 3; // Maximum number of lines for the appreciation paragraph

        // Wrap the text using wordwrap() to preserve word boundaries
        $lines = explode("\n", wordwrap($paragraph, ($textWidth / $fontSize) * 2, "\n", true));

        // Limit the lines to the maximum number of lines
        $lines = array_slice($lines, 0, $maxLines);

        // Determine the y position for the first line of text (centered vertically for the number of lines)
        $nameHeight = $nameFontSize;
        $nameGap = $nameHeight * 3;
        $textHeight = count($lines) * $fontSize;
        $startY = (imagesy($image) - $textHeight) / 2 + $nameGap;

        // Calculate the center-aligned start x position for each line
        $startXPositions = array();
        foreach ($lines as $line) {
            $lineBox = imagettfbbox($fontSize, 0, $font, $line);
            $lineWidth = $lineBox[2] - $lineBox[0];
            $startXPositions[] = (imagesx($image) - $lineWidth) / 2;
        }

        foreach ($lines as $index => $line) {
            $startX = $startXPositions[$index];

            // Add the text to the image
            imagettftext($image, $fontSize, 0, $startX, $startY + $index * ($fontSize * $lineSpacingFactor), $color, $font, $line);
        }

        $file = time();
        $imageFilePath = "certificates/" . $certificate_id . ".png";
        if (!imagepng($image, $imageFilePath)) {
            die('Error saving the certificate image');
        }
        imagedestroy($image);

        // Generate the PDF certificate
        require('fpdf/fpdf.php');

        // Get the dimensions of the image
        list($imageWidth, $imageHeight) = getimagesize($imageFilePath);

        // Calculate the PDF dimensions based on the image dimensions
        $pdfWidth = $imageWidth * 0.264583;  // Convert pixels to mm (1 px = 0.264583 mm)
        $pdfHeight = $imageHeight * 0.264583;

        // Create the PDF with the calculated dimensions and landscape orientation
        $pdf = new FPDF('L', 'mm', array($pdfWidth, $pdfHeight));
        $pdf->AddPage();

        // Add the image to the PDF
        $pdf->Image($imageFilePath, 0, 0, $pdfWidth, $pdfHeight);

        $pdfFilePath = "certificates/" . $certificate_id . ".pdf";
        $pdf->Output($pdfFilePath, 'F');

        // Update the database with the file names
        $update_query = "UPDATE certificates SET pdf_file=?, image_file=? WHERE certificate_id=?";
        $stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($stmt, 'sss', $pdfFilePath, $imageFilePath, $certificate_id);
        mysqli_stmt_execute($stmt);

        // Redirect the user to a success page to avoid resubmission
        header("Location: certgen.php");
        exit();
    } else {
        die('Error inserting data into the database');
    }
}

mysqli_close($conn);
?>