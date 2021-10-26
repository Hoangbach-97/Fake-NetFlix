<?php 
require_once("PayPal-PHP-SDK/autoload.php");

$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'Af_b4_O2L5K-z2UVZ6Y7CiBpUVnxcF-WwIa8h4LyzhwVX8ofO-goxS6eJx2FnS9d_kxrDseIqeDhgRn4',     // ClientID
        'EG3diJg-ND02WEl_Fz9OhH0aXM1Zxa_5Y1IquYUaDfA0pzL79aoNbBcYBEIs9eXLKEFGz6mfBDuYUWC2'      // ClientSecret
    )
);

?>