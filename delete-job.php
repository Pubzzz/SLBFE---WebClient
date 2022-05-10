<?php

if (isset($_COOKIE['access_token']) && $_COOKIE['role'] == "company") {
    if (!isset($_GET['jobId'])) {
        header("Location: post-job.php");
        die();
    }

    $jobId = $_GET['jobId'];
    $access_token = $_COOKIE['access_token'];

    // Headers
    $headers = [
        "Authorization: Bearer " . $access_token . "",
        ""
    ];
    
    $url = "http://127.0.0.1:8000/api/v1/job/".$jobId;

    // CURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    header("Location: company.php");
    die();
}else{
    header("Location: login.php");
    die();
}
