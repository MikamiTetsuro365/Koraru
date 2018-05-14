<?php

// Load this library.
require 'TwistOAuth.php';

// Start session.
@session_start();
$_SESSION['img'] = $_POST['tweetImgLink'];
function redirect_to_main_page() {
    $url = 'http://sima-tetteke.sakura.ne.jp/generator/KoraruSample/php/main.php';
    header("Location: $url");
    header('Content-Type: text/plain; charset=utf-8');
    exit("Redirecting to $url ...");
}

unset($_SESSION['to']);

try {

   

        // Initialize a TwistOAuth object, then reinitialize with request_token.
        $_SESSION['to'] = new TwistOAuth('M2UnAJ2zg9LjEaDJKJIeQfDzc', 'jcOFwMlOTlA21wRfclyMPSnVDsO9KWtzKURu9fadMNzKDTwO7k');
        $_SESSION['to'] = $_SESSION['to']->renewWithRequestToken('http://sima-tetteke.sakura.ne.jp/generator/KoraruSample/php/access.php');

        // Redirect to Twitter.
        header("Location: {$_SESSION['to']->getAuthenticateUrl()}");
        header('Content-Type: text/plain; charset=utf-8');
        exit("Redirecting to {$_SESSION['to']->getAuthenticateUrl()} ...");

    

} catch (TwistException $e) { /* Error */

    // Clear session.
    $_SESSION = array();

    // Send HTTP status code and display error message as text. (not HTML)
    // The exception code will be zero when it thrown before accessing Twitter, we need to change it into 500.
    header('Content-Type: text/plain; charset=utf-8', true, $e->getCode() ?: 500);
    exit($e->getMessage());

}

?>