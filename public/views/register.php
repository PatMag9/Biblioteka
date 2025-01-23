<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="public/css/style.css"/>
        <script type="text/javascript" src="public/js/validation.js" defer></script>
        <title>BiblioSolis</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <div class="container">
            <div class="logo-container">
                <div class="logo">
                    <img src="public/img/logo.svg">
                    <div class="banner">BiblioSolis</div>
                </div>
            </div>
            <form class="actions" action="register" method="POST">
                <input class="input-button" name="email" type="email" placeholder="e-mail">
                <input class="input-button" name="password" type="password" placeholder="hasło">
                <input class="input-button" name="confirmedPassword" type="password" placeholder="potwiedź hasło">
                <button class="action-button">Register</button>
            </form>
            <div class="messages">
                <?php
                if(isset($messages)) {
                    foreach($messages as $message) {
                        echo $message;
                    }
                } ?>
            </div>
        </div>
    </body>
</html>