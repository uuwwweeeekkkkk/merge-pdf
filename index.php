<?php
date_default_timezone_set("Asia\Jakarta");
require_once('PDFMerger/PDFMerger.php');

use PDFMerger\PDFMerger;

if (isset($_POST['merge'])) {
    $pdf = new PDFMerger;
    $folder_temp = date("YmdHis");
    mkdir("temp_merge/" . $folder_temp);
    copy("temp_merge/index.php", "temp_merge/" . $folder_temp . "/index.php");

    $file_count = count($_FILES['file_merge']['name']);

    for ($i = 0; $i < $file_count; $i++) {
        $cek_file_merge = $_FILES['file_merge']['error'][$i];

        if ($cek_file_merge == 0) {
            $nm_file_merge = $_FILES['file_merge']['name'][$i];
            $temp_file_merge = $_FILES['file_merge']['tmp_name'][$i];

            move_uploaded_file($temp_file_merge, "temp_merge/" . $folder_temp . "/" . $nm_file_merge);
            $pdf->addPDF("temp_merge/" . $folder_temp . "/" . $nm_file_merge);
        }
    }

    $pdf->merge('download', 'merged-' . $file_count . '-file.pdf');
    // $pdf->merge('output', 'merged-' . $file_count . '-file.pdf');

    header("Location: .");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merged PDF</title>

    <link href='http://fonts.googleapis.com/css?family=Ubuntu&subset=cyrillic,latin' rel='stylesheet' type='text/css' />

    <link rel="stylesheet" href="gaya.css">
    <style>
        body {
            font-family: 'Ubuntu', sans-serif;
        }
    </style>
</head>

<body>
    <br><br><br><br><br>
    <center>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="file_merge" class="drop-container " id="dropcontainer">
                <span class="drop-title">Drop files here, for Merge PDF</span>
                or
                <input type="file" name="file_merge[]" id="file_merge" accept="application/pdf" multiple required>
                <div style="font-size: 12px;">Maximum upload <?= ini_get("upload_max_filesize"); ?>iB/files | Maximum All files <?= ini_get('post_max_size'); ?>iB
                </div>
            </label>
            <br>
            <button type="submit" name="merge" id="merge" class="button-36">Merge</button>
        </form>
    </center>
</body>

<script src="alat.js"></script>

</html>