
<?php
    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
   
    
    //require_once 'vendor/autoload.php';
    require_once __DIR__ . '/../vendor/autoload.php';

    require_once 'config_db.php';
    require_once 'config_login.php';
   

    session_start();

    $client = new Google_Client();

    $client->setClientId('432882886420-uvdm69kl8nb2b19b2es2o7a3ttct5on4.apps.googleusercontent.com');
    $client->setClientSecret('0KSoCti3JgsmtmNq6VbSyr5g');

    //$client->setRedirectUri('http://localhost/login_google/callback.php');

    $client->setRedirectUri($uricallback); //viene de config_login.php

    if (isset($_GET['code'])) {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

        if (! isset($token['error'])) {
            $client->setAccessToken($token['access_token']);

            $oauth    = new Google_Service_Oauth2($client);
            $userData = $oauth->userinfo->get();

            $googleId = $userData->id;
            $name     = $userData->name;
            $email    = $userData->email;
            $picture  = $userData->picture;

            $stmt = $pdo->prepare("SELECT * FROM users WHERE google_id = ?");
            $stmt->execute([$googleId]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (! $user) {
                $stmt = $pdo->prepare("INSERT INTO users (google_id, name, email, picture) VALUES (?, ?, ?, ?)");
                $stmt->execute([$googleId, $name, $email, $picture]);

                $user = [
                    'google_id' => $googleId,
                    'name'      => $name,
                    'email'     => $email,
                    'picture'   => $picture,
                ];
            }

            $_SESSION['user'] = $user;

            header('Location: welcome.php');
            exit;
        } else {
            echo "Error al autenticar con Google.";
        }
    } else {
        echo "Código de autenticación no encontrado.";
}
