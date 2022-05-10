<?php

if (isset($_COOKIE['access_token'])) {
    $userRole = $_COOKIE['role'];
    $access_token = $_COOKIE['access_token'];

    // Headers
    $headers = [
        "Authorization: Bearer " . $access_token . ""
    ];

    if ($userRole == "company") {
        setcookie("company_id", "", time() - 3600);
    }

    if ($userRole == "citizen") {
        setcookie("nic", "", time() - 3600);
    }


    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "http://127.0.0.1:8000/api/v1/logout");
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_exec($curl);
    curl_close($curl);

    setcookie("user_id", "", time() - 3600);
    setcookie("role", "", time() - 3600);
    setcookie("access_token", "", time() - 3600);

    header("Location: index.php");
} else {
    header("Location: index.php");
    die();
}

?>
