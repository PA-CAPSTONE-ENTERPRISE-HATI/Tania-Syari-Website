<?php

function generateUniqueCode($length = 8) {
    // Characters used for generating the unique code
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    // Get current date
    $currentDate = getCurrentDate();

    // Generate a random string with specified length
    $randomString = '';

    // Generate the random characters
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    // Concatenate random string with current date
    $randomString .= $currentDate;

    return $randomString;
}

function getCurrentDate() {
    return date('Ymd');
}

?>
