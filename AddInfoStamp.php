<?php

function imageStamp($image_file){
    
    // Gather information
    $exif = exif_read_data($image_file, 0, true);

    $date = $exif["EXIF"]["DateTimeOriginal"];

    $lat_info = $exif["GPS"]["GPSLatitude"];
    $lat_ref = $exif["GPS"]["GPSLatitudeRef"];

    $lon_info = $exif["GPS"]["GPSLongitude"];
    $lon_ref = $exif["GPS"]["GPSLongitudeRef"];

    // Latitude Math Calculations
    $lat_d_array = explode('/',$lat_info[0]);
    $lat_d = (intval($lat_d_array[0])/intval($lat_d_array[1]));

    $lat_m_array = explode('/',$lat_info[1]);
    $lat_m = (intval($lat_m_array[0])/intval($lat_m_array[1]))/60;

    $lat_s_array = explode('/',$lat_info[2]);
    $lat_s = (intval($lat_s_array[0])/intval($lat_s_array[1]))/3600;

    $lat = $lat_d + $lat_m + $lat_s;

    // Longitude Math Calculations
    $lon_d_array = explode('/',$lon_info[0]);
    $lon_d = (intval($lon_d_array[0])/intval($lon_d_array[1]));

    $lon_m_array = explode('/',$lon_info[1]);
    $lon_m = (intval($lon_m_array[0])/intval($lon_m_array[1]))/60;

    $lon_s_array = explode('/',$lon_info[2]);
    $lon_s = (intval($lon_s_array[0])/intval($lon_s_array[1]))/3600;

    $lon = $lon_d + $lon_m + $lon_s;

    //Check if positive or negative lat/lon
    if ($lat_ref != "N") {
        $lat = 0 - $lat;
    }

    if ($lon_ref != "E") {
        $lon = 0 - $lon;
    }

    // Image and Text
    $Text = "Latitude: ".$lat."\nLongitude: ".$lon."\n".$date;

    $img = imagecreatefromjpeg($image_file);
    $filePathSplit = explode('/', $image_file); // For non UNIX-Based devices, you may need to replace '/' with '\\' depending on how you write your directory path
    $fileName = $filePathSplit[sizeof($filePathSplit)-1];
    $black = imagecolorallocate($img, 0, 0, 0);
    $white = imagecolorallocate($img, 255, 255, 255);
    $font = "./Font/arial.ttf";
    $img_size = getimagesize($image_file);
    
    // The calculations for the font size, x-position, and y-position are based on the image's resolution
    imagettftext($img, $img_size[1]/24.32, 0, $img_size[0]/54.72, $img_size[1]/17.37, $black, $font, $Text);
    imagettftext($img, $img_size[1]/24.32, 0, $img_size[0]/60.8, $img_size[1]/18.24, $white, $font, $Text);
    imagejpeg($img, "./Uploads/exif-".$fileName, 100);
}

$stdin = fopen('php://stdin', 'r');

echo "Enter folder path or file path: ";
$directory = rtrim(fgets($stdin));
print_r("Processing... Please wait.\n");
if (!is_dir($directory)) {
    imageStamp($directory);
    print_r($directory." has been processed.\n");
} else {
    foreach (scandir($directory) as $file) {
        if ($file !== '.' && $file !== '..') {
            print_r($directory.'/'.$file." has been processed.\n"); // For non UNIX-Based devices, you may need to replace '/' with '\\' depending on how you write your directory path
            imageStamp($directory.'/'.$file); // For non UNIX-Based devices, you may need to replace '/' with '\\' depending on how you write your directory path
        }
    }
}
?>
