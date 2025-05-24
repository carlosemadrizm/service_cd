<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    //require_once '/vendor/autoload.php';
    //comentario de prueba xyz
    require_once __DIR__ . '/../vendor/autoload.php';

    require_once 'config_login.php';

    session_start();

    $client = new Google_Client();
    $client->setClientId('432882886420-uvdm69kl8nb2b19b2es2o7a3ttct5on4.apps.googleusercontent.com');
    $client->setClientSecret('0KSoCti3JgsmtmNq6VbSyr5g');

                                           // $client->setRedirectUri('http://localhost/login_google/callback.php');
    $client->setRedirectUri($uricallback); //viene de config_login.php

    $client->addScope('email');
    $client->addScope('profile');

    $login_url = $client->createAuthUrl();

?>


<!DOCTYPE html>
<html>
<head><title>Login con Google</title></head>
<body>
    <h2>Iniciar sesión con Google</h2>
    <a href="<?php echo htmlspecialchars($login_url) ?>">
        <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png" />
    </a>
</body>
</html>
